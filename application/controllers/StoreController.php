<?php
require_once 'Zend/Controller/Action.php';
require_once '../application/models/File.php';
require_once '../application/models/User.php';

class StoreController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $request = $this->getRequest();

        if(! $request->isPost()) {
            $this->getHelper('Redirector')->goto('index', 'index'); // action, controller
        }

        $c = Zend_Registry::get('config');


        $apiKey = Zend_Filter::get($request->getPost('apikey'), 'Alnum');

        try {
            $user = User::findByApiKey($apiKey);
            $user->setIp($request->getServer('REMOTE_ADDR'));
        } catch (Exception $e) {
            $this->view->assign('response', "Invalid API key.");
        }

        if ($user) {
            if ($_FILES['file']['error'] === 0) {
                $file = new File();
                $file->setFileName($_FILES['file']['name']);
                $file->setFileSize($_FILES['file']['size']);
                $file->setTmpName($_FILES['file']['tmp_name']);
                $file->setUploadedBy($user);

                $url = $file->save();
                $this->view->assign('response', $url . "\n");
            } else {
                switch ($_FILES['file']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_INI_SIZE:
                        throw new Exception('The uploaded file exceeds the upload_max_filesize directive ('
                        . ini_get('upload_max_filesize').') in php.ini.');
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new Exception('The uploaded file exceeds the MAX_FILE_SIZE directive'
                        . 'that was specified in the HTML form.');
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        throw new Exception('The uploaded file was only partially uploaded.');
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new Exception('No file was uploaded.');
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        throw new Exception('Missing a temporary folder.');
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        throw new Exception('Failed to write file to disk.');
                        break;
                    default:
                        throw new Exception('Unknown File Error.');
                }
            }
        }
    }
}
