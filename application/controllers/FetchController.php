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

        if (strlen($accessCode) !== (int) $c->file->accessCodeLength) {
            $this->view->assign('error', 'Erroneous input');
        } else {
            $this->getHelper('ViewRenderer')->setNoRender();

            $file = File::findByAccessCode($accessCode);

            $response = $this->getResponse();

            if ($file->isAttachment()) {
                $response->setHeader('Content-Type', 'application/octet-stream');
                $response->setHeader('Content-Disposition', 'attachment; filename="' . $file->getName() . '"');
            } else {
                $response->setHeader('Content-Type', $file->getType());
            }

            if ($file->getExtension() === 'phps' || $file->getExtension() === 'php') {
                highlight_file($c->fileDir . $file->getName());
            } else {
                readfile($c->fileDir . $file->getName());
            }
        }
    }
}
