<?php
require_once(dirname(__FILE__) . "/config/config.inc.php");
require_once(dirname(__FILE__) . "/database.class.php");
require_once(dirname(__FILE__) . "/base.interface.php");

class Base
{
    /**
     * @var array campurile bazei de date, in format camp => tip ('id' => 'int', 'nume' => 'string')
     */
    protected $_fields = array();

    /**
     * @var string tabela de baza pentru clasa
     */

    protected $_table = '';

    /**
     * get($only_total, $search, $sort, $limit) - returneaza inregistrari din tabela
     *
     * Parametrii:    $only_total - boolean - daca e true returneaza doar numarul de inregistrari gasite
     *                $search - array - lista de parametrii de cautati, field => value
     *                $sort - array - criteriul de sortare, [field], [dir] sau array de [field], [dir]
     *                $limit - array - limitare de afisare, [amount], [page]
     *
     * Returneaza:    array
     */
    function get($only_total = false, $search = array(), $sort = array(), $limit = array())
    {
        $db = Database::getInstance();

        if ($only_total) {
            $sql = "SELECT COUNT(1) AS cnt FROM " . $this->_table;
        } else {
            $sql = "SELECT * FROM " . $this->_table;
        }

        $array_where = array();
        foreach ($search as $field => $value) {
            if (isset($m)) {
                unset($m);
            }
            if ((((!array_key_exists($field, $this->_fields)) && (preg_match('/^(.*)_(.*)$/', $field, $m)) && (array_key_exists($m[1], $this->_fields)))
                    || (array_key_exists($field, $this->_fields)))
                && ((($this->_fields[(!empty($m[1]) ? $m[1] : $field)] == 'int') && (is_numeric($value) || is_array($value))) ||
                    (($this->_fields[(!empty($m[1]) ? $m[1] : $field)] == 'string') && (is_array($value) || (strlen($value) > 0))))
            ) {
                if (!empty($m[2])) {
                    if (strtolower($m[2]) == 'like') {
                        $tmp = $db->quote('%' . $value . '%');
                    } else if (strtolower($m[2]) == 'likeeq') {
                        $tmp = $db->quote($value);
                        $m[2] = 'like';
                    } else if (strtolower($m[2]) == 'likeleft') {
                        $tmp = $db->quote('%' . $value);
                        $m[2] = 'like';
                    } else if (strtolower($m[2]) == 'likeright') {
                        $tmp = $db->quote($value . '%');
                        $m[2] = 'like';
                    } else if (strtolower($m[2]) == 'in') {
                        $t = array();
                        if (is_array($value)) {
                            for ($i = 0; $i < count($value); $i++) {
                                $t[] = $db->quote($value[$i], ($this->_fields[(!empty($m[1]) ? $m[1] : $field)] == 'int') ? 'number' : 'text');
                            }
                        }
                        $tmp = sprintf('(%s)', join(',', $t));
                    } else if ($this->_fields[(!empty($m[1]) ? $m[1] : $field)] == 'int') {
                        $tmp = $db->quote($value, 'number');
                    } else {
                        $tmp = $db->quote($value);
                    }

                    $array_where[] = (!empty($m[1]) ? $m[1] : $field) . ' ' . (!empty($m[2]) ? strtoupper($m[2]) : '=') . ' ' . $tmp;
                } else {
                    $array_where[] = $field . ' = ' . ($this->_fields[$field] == 'int' ? $db->quote($value, 'number') : $db->quote($value));
                }
            }
        }

        if (count($array_where) > 0) {
            $sql .= " WHERE " . join(' AND ', $array_where);
        }


        /**
         * sortarea campurilor din rezultat pe baza array-ului $sort
         *
         * Exemple:
         *
         * sortare pe un singur camp: $sort = array('field' => 'id', 'dir' => 'asc');
         *
         * sortare pe mai multe campuri: $sort = array(
         *                                                array('field' => 'id', 'dir' => 'asc')
         *                                                array('field' => 'nume', 'dir' => 'desc')
         *                                      )
         */
        $array_order = array();
        if (isset($sort['field'])) {
// sortare pe baza unui singur camp. array-ul trebuie sa fie de forma 'field' => '', 'dir' => ''. dir este optional
            if (array_key_exists($sort['field'], $this->_fields)) {
                $tmp = $sort['field'];
                if (!isset($sort['dir'])) {
                    $sort['dir'] = 'ASC';
                }

                if ((strtolower($sort['dir']) == 'asc') || (strtolower($sort['dir']) == 'desc')) {
                    $tmp .= ' ' . $sort['dir'];
                }
                $array_order[] = $this->_table . "." . $tmp;
            }
        } else {
// sortare pe baza mai multor campuri. array-ul trebuie sa fie de forma [] = array('field' => '', 'dir' => ''). dir este optional
            for ($i = 0; $i < count($sort); $i++) {
                if (array_key_exists($sort[$i]['field'], $this->_fields)) {
                    $tmp = $sort[$i]['field'];
                    if (!isset($sort[$i]['dir'])) {
                        $sort[$i]['dir'] = 'ASC';
                    }

                    if ((strtolower($sort[$i]['dir']) == 'asc')
                        || (strtolower($sort[$i]['dir']) == 'desc')
                    ) {
                        $tmp .= ' ' . $sort[$i]['dir'];
                    }
                    $array_order[] = $this->_table . "." . $tmp;
                }
            }
        }

        if (count($array_order) > 0) {
            $sql .= " ORDER BY " . join(', ', $array_order);
        }

        if (!empty($limit['page']) && !empty($limit['amount']) && is_numeric($limit['page']) && is_numeric($limit['amount'])) {
            $sql .= " LIMIT " . ($limit['amount'] * ($limit['page'] - 1)) . ", " . $limit['amount'];
        }
        $res = $db->query($sql);

        if ($only_total) {
            $row = mysql_fetch_assoc($res);
            return $row['cnt'];
        } else {
            $result = array();
            while ($row = mysql_fetch_assoc($res)) {
                $result[] = $row;
            }
            return $result;
        }
    }

    /**
     * Sterge o inregistrare din baza de date
     *
     *
     * @param int $id ID-ul inregistrarii de sters
     * @return bool true daca s-a putut sterge din db
     */
    function delete($id = null)
    {
        $db = Database::getInstance();

        if (!empty($id)) {
            $sql = "DELETE FROM " . $this->_table . " WHERE id = " . $db->quote($id, "number") . " LIMIT 1";
            $db->query($sql);

            return (mysql_affected_rows() > 0);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Goleste tabela din baza de date
     *
     * @return bool
     * @throws DatabaseException
     */
    function truncate()
    {
        $db = Database::getInstance();
        $sql = "DELETE FROM " . $this->_table;
        $db->query($sql);

        return (mysql_affected_rows() > 0);
    }

    /**
     * Salveaza o inregistrare in baza de date. daca unul din campuri e camp unic/primary key se face update
     * @param array $date - datele de salvat
     * @param getId - true daca se doreste sa intoarca id-ul inserat
     * @return bool|int
     */
    function save($date = array(), $getId = false)
    {
        $db = Database::getInstance();

        if (!empty($date) && is_array($date)) {
            $tmp = array();

            foreach ($date as $field => $value) {
                if (array_key_exists($field, $this->_fields)) {
                    $tmp[] = $field . " = " . $db->quote($value, ($this->_fields[$field] == "int") ? "number" : "text");
                }


            }
            if (count($tmp) > 0) {
                $sql = "INSERT INTO " . $this->_table . " SET " . join(", ", $tmp) . " ON DUPLICATE KEY UPDATE " . join(", ", $tmp);
                $db->query($sql);
                if ($getId == true) {
                    return mysql_insert_id();
                }
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Returneaza partea de sql necesara paginarii
     *
     * @param array Paginare
     *      Array-ul are urmatorii parametrii
     *          page_no - numarul paginii
     *          items_per_page - numarul de itemi pe pagina
     *
     * @return string
     *
     */
    protected function _paginationToSql($pagination)
    {
        $db = Database::getInstance();
        $sql = "";

//adauga paginare
        $fromWhere = ($pagination['page_no'] - 1) * $pagination['items_per_page'];
        $sql .= " LIMIT " . $fromWhere . ", " . $db->quote($pagination['items_per_page'], 'number');

        return $sql;
    }

    /**
     * Returneaza parte de sql necesara sortarii
     *
     * @param array Sortarea
     *      Array-ul are ca parametrii un array cu urmatoarele campuri
     *          field - campul dupa care se ordoneaza
     *          dir - ordinea de sortare
     *          array(array('field' => 'nume' , 'id'))
     * @return string
     */
    protected function _sortToSql(array $sort)
    {

        $sql = "";
        $sql .= " ORDER BY ";
        foreach ($sort as $key => $field) {
            $sql .= ($key == 0) ? " " : ", ";
            $sql .= $field['field'] . " " . strtoupper($field['dir']);
        }

        return $sql;
    }

    /**
     * Returneaza parte de sql necesara gruparii
     *
     * @param array Gruparea
     *      Array-ul are ca parametrii un array cu urmatoarele campuri
     *          field - campul dupa care se ordoneaza
     *          array()
     * @return string
     */
    protected function _groupToSql(array $group)
    {

        $sql = "";
        $sql .= " GROUP BY ";
        $sql .= implode(", ", $group);

        return $sql;
    }

}