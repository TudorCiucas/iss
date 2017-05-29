<?php

//seteaza baza de date a deploymentului
if (!isset($dbDeployment)) {
    $dbDeployment = 'local';
}

switch ($dbDeployment) {
    case 'local':
        if (!defined('DATABASE_NAME')) {
            define('DATABASE_NAME','sgc');
        }

        if (!defined('DATABASE_USER')) {
            define('DATABASE_USER','root');
        }

        if (!defined('DATABASE_PASSWORD')) {
            define('DATABASE_PASSWORD','');
        }

        if (!defined('DATABASE_HOST')) {
            define('DATABASE_HOST','localhost');
        }

        //calea catre aplicatie pe disk
        define('CMS_REAL_DIR', 'C:/wamp64/www/sgc/');
        define('CMS_CORE_DIR', CMS_REAL_DIR . 'core/');
        define('CMS_REPO_DIR', CMS_REAL_DIR . 'core/repository/');

        break;

    default:
        die('Invalid deployment specified.');
        break;
}
