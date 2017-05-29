<?php
require_once('databaseconnection.class.php');

/**
 * Database object
 *
 * Clasa responsabila cu returnarea unei conexiuni la baza de date
 *
 */
class Database {

    /**
     * Instanta ce va fi returnata intotdeuna
     */
    private static $_instance = null;

    /**
     * Returneaza instanta
     * @return DatabaseConnection
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new DatabaseConnection();
        }

        return self::$_instance;
    }

    /**
     * Previne clonarea metodei
     */
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

}
