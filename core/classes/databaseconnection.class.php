<?php
error_reporting(0);

require_once __DIR__ . "/exceptions/exception.class.php";

/**
 * Obiectul de conexiune la baza de date
 *
 * Clasa responsabila cu crearea unei conexiuni la baza de date
 *
 */
class DatabaseConnection {

    /**
     * Obiectul conexiune
     */
    private $_connection;

    public function __construct()
    {
        $this->_connection = mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD);

        if (false === $this->_connection) {
            throw new DatabaseException(mysql_error());
        }

        $selectDb = mysql_select_db(DATABASE_NAME, $this->_connection);
        if (false === $selectDb) {
            throw new DatabaseException("Could not select database");
        }
    }

    /**
     * Executa un query
     * @param string Sql query
     * @return mixed Rezultatul interogarii
     */
    public function query($sql)
    {
        $res = mysql_query($sql, $this->_connection);

        if(!$res) {
            throw new DatabaseException(mysql_error() . ": ". $sql);
        }
        return $res;
    }

    /**
     * sanitizeaza datele trimise catre db
     * @param string $value valoarea de sanitizat
     * @param string $type text / number
     */
    function quote($value, $type = 'text')
    {
        switch (strtolower($type)) {
            case "number":
                if (is_numeric($value)) {
                    return mysql_real_escape_string(trim($value));
                } else {
                    return 0;
                }
                break;
            default:
                return "'".mysql_real_escape_string(trim($value))."'";
        }
    }

    public function beginTransaction() {
        mysql_query("START TRANSACTION", $this->_connection);
    }

    public function rollBack() {
        mysql_query("ROLLBACK", $this->_connection);
    }

    public function commit() {
        mysql_query("COMMIT", $this->_connection);
    }
}
