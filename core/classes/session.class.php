<?php
/**
 * Metode de lucru cu sesiunea
 *
 */

class Session {

    /**
     * Incepe/rezuma sesiunea
     */
    public function __construct()
    {
        @session_start();
    }

    /**
     * Salveaza/face update la o valoare in sesiune
     * @param string Numele variabilei
     * @param mixed Valoarea de salvat
     *
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Returneaza valoarea unei variabile din sesiune
     * @param string Numele variabilei
     * @return string|false
     */
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return false;
    }

    /**
     *
     * Sterge variabila din sesiune
     * Ion Jula <ion.jula@klsolution.com>
     *
     * @param $name
     */
    public function delete($name) {
        unset($_SESSION[$name]);
    }

}
