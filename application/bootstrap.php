<?php
set_include_path('../library' . PATH_SEPARATOR . get_include_path());

/**
 * Require necessary files from the Zend Framework
 */
require_once 'Zend/Config.php';
require_once 'Zend/Db.php';
require_once 'Zend/Debug.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Controller/Front.php';

$c = new Zend_Config(require '../config.php');
$db = Zend_Db::factory($c->db);
$db->setFetchMode(Zend_Db::FETCH_OBJ); // Wraps returned data in StdObject by default

Zend_Registry::set('config', $c);
Zend_Registry::set('db', $db);

$front = Zend_Controller_Front::getInstance();
$front->throwExceptions(true); // dev only

/**
 * Custom routes
 */
$front->getRouter()->addRoute('fetch',
    new Zend_Controller_Router_Route('fetch/:accessCode',
    array('controller' => 'fetch', 'action' => 'index')
));

$front->run('../application/controllers');
