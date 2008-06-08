<?php
class User
{
    private $_id = '';
    private $_ip = '';

    public static function findByApiKey($apiKey)
    {
        $user = new User();

        $db = Zend_Registry::get('db');

        $id = $db->fetchCol('SELECT id FROM users WHERE api_key = ?', $apiKey);

        if ($id === false) return null;

        $user->setId($id);

        return $user;
    }

    public function __construct() {
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getIp()
    {
        return $this->_ip;
    }

    public function setId($id)
    {
        $this->_id = (int) $id;
    }

    public function setIp($ip)
    {
        $this->_ip = $ip;
    }
}
