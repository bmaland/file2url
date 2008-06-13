<?php
require_once 'Zend/Controller/Action.php';
require_once '../application/models/File.php';

class FetchController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $c = Zend_Registry::get('config');

        $ip = $request->getServer('REMOTE_ADDR');
        $accessCode = Zend_Filter::get($request->getParam('accessCode'), 'Alnum');

        try {
            $file = File::findByAccessCode($accessCode);

            if (strlen($accessCode) !== (int) $c->file->accessCodeLength) {
                $this->view->assign('error', 'Erroneous input.');
            } else if ($file === null) {
                $this->view->assign('error', 'Invalid access code.');
            } else {
                $this->getHelper('ViewRenderer')->setNoRender();

                $response = $this->getResponse();

                if ($file->isAttachment()) {
										// fix for IE catching or PHP bug issue
										header("Pragma: public");
										header("Expires: 0"); // set expiration time
										header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
										// browser must download file from server instead of cache

                    // force download dialog
                  	header("Content-Type: application/force-download");
										header("Content-Type: application/octet-stream");
										header("Content-Type: application/download");
									  header("Content-Disposition: attachment; filename=" . $file->getName() . ";");

										header("Content-Transfer-Encoding: binary");
										header("Content-Length: " . filesize($c->fileDir . $file->getName()));
                } else {
                    $response->setHeader('Content-Type', $file->getType());
                }

                if ($file->getExtension() === 'phps' || $file->getExtension() === 'php') {
                    highlight_file($c->fileDir . $file->getName());
                } else {
                    readfile($c->fileDir . $file->getName());
                }
            }
        } catch (Zend_Db_Adapter_Exception $e) {
            $this->view->assign('error', $e->getMessage());
        }
    }
}
