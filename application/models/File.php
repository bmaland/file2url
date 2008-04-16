<?php
require_once 'GenerateString.php';

class File
{
    private $_extension = '';
    private $_fileDir = '';
    private $_fileName = '';
    private $_fileType = '';
    private $_fileSize = '';
    private $_tmpName = '';
    private $_uploadedBy = '';

    public static function isAvailableAccessCode($accessCode)
    {
        $db = Zend_Registry::get('db');
        $result = $db->fetchCol('SELECT id FROM files WHERE access_code = ? AND active = 1', $accessCode);
        if ($result) {
            return false;
        } else {
            return true;
        }
    }

    public static function findByAccessCode($accessCode)
    {
        $file = new File();

        $db = Zend_Registry::get('db');

        $fileRow = $db->fetchRow('SELECT id, file_name, file_type FROM files WHERE access_code = ? AND active = 1', $accessCode);

        if (! file_exists("files/" . $fileRow->file_name)) {
            throw new Exception('Sorry, this file has been deleted from the file system.');
        }

        $file->setFileName($fileRow->file_name);

        return $file;
    }

    public function __construct() {
    }

    /**
     * Returns true if the Content-Disposition header has to be set.
     *
     * @return boolean
     */
    public function isAttachment()
    {
        return $this->_fileType == '';
    }

    /**
     * @return String The url to the file
     */
    public function save()
    {
        $c = Zend_Registry::get('config');

        if ($this->_fileSize > (int) $c->file->maxFileSize) {
            throw new Exception('File is too large!');
        }

        $i = 1;
        while (file_exists($c->fileDir . $this->_fileName)) {
            $fileInfo = pathinfo($this->_fileName);
            $this->setFileName(rtrim($fileInfo['filename'], '.' . '0..9') . '.' . $i . '.' . $fileInfo['extension']);
            $i++;
        }

        if (! move_uploaded_file($this->_tmpName, $c->fileDir . $this->_fileName)) {
            throw new Exception('Unable to write the file to the upload dir. Check permissions!');
        }

        $i = false;
        while (! $i) {
            $accessCode = GenerateString::getString((int) $c->file->accessCodeLength);
            $i = self::isAvailableAccessCode($accessCode);
        }

        $db = Zend_Registry::get('db');
        $db->query('INSERT INTO files (user_id, upload_ip, access_code, file_name)'
                 . 'VALUES (?, ?, ?, ?)', array($this->_uploadedBy->getId(), $this->_uploadedBy->getIp(),
                                                $accessCode, $this->_fileName));

        return $c->urlPrefix . $accessCode;
    }

    public function getName()
    {
        return $this->_fileName;
    }

    public function getExtension()
    {
        return $this->_extension;
    }

    public function getType()
    {
        return $this->_fileType;
    }

    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
        $this->_setFileType();
    }

    public function setFileSize($fileSize)
    {
        $this->_fileSize = $fileSize;
    }

    public function setTmpName($tmpName)
    {
        $this->_tmpName = $tmpName;
    }

    public function setUploadedBy($user)
    {
        $this->_uploadedBy = $user;
    }

    /**
     * This is really fragile, but I don't have any better options atm I think.
     * It isn't such a big deal if the file type doesn't get spotted - the worst
     * case scenario is that the user just will get the file download dialog
     * in his browser since the content-disposition header will be sent.
     */
    private function _setFileType()
    {
        $fileInfo = pathinfo($this->_fileName);
        $fileType = "";

        if (! array_key_exists('extension', $fileInfo)) {
            $this->_fileType = 'text/plain';
        } else {
            $this->_extension = $fileInfo['extension'];

            switch ($this->_extension) {
                case 'png':
                    $fileType = 'image/png';
                    break;

                case 'jpg':
                case 'jpeg':
                    $fileType = 'image/jpeg';
                    break;

                case 'html':
                case 'phps':
                case 'php':
                    $fileType = 'text/html';
                    break;

                case 'lisp':
                case 'rb':
                case 'py':
                case 'txt':
                case 'TXT':
                case 'css':
                case 'java':
                case 'sh':
                case 'conf':
                case 'cnf':
                case 'cfg':
                case 'ini':
                    $fileType = 'text/plain';
                    break;
            }

            /*
             * If $fileType was not set, the file is to be treated as an attachment.
             */
            if ($fileType) {
                $this->_fileType = $fileType;
            }
        }
    }
}
