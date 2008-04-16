<?php
return array(
    'fileDir' => 'files/',
    'urlPrefix' => 'http://file2url/fetch/',
    'logging' => false,

    'file' => array(
        'accessCodeLength' => 5,
        'maxFileSize' => 15728240,
        'deleteAfter' => 14
    ),

    'db' => array(
        'adapter' => 'pdo_mysql',
        'params'  => array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'file2url'
        )
    )
);
