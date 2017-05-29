<?php
require_once(dirname(__FILE__) . "/base.class.php");

class Reviewer extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id' => 'int',
        'propunere_id' => 'int', // ID propunere
        'user_id' => 'int' // ID evaluator
    );

    protected $_table = 'reviewers';


    public function getReviewers($search = array())
    {
        $db = Database::getInstance();
        $data = array();

        $sql = "SELECT 
                    $this->_table.id,
                    $this->_table.propunere_id,
                    $this->_table.user_id,
                    utilizatori.nume
                FROM $this->_table
                INNER JOIN utilizatori ON utilizatori.id = $this->_table.user_id
                    ";

        $sql .= $this->filterToSql($search);
        $sql .= ' ORDER BY `utilizatori`.`nume`';

        $result = $db->query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;

    }

    private function filterToSql(array $search) {
        $db = Database::getInstance();
        $sql = '';
        $hasWhere = false;


        if (isset($search['propunere_id'])) {
            $sql .= $hasWhere === false ? " WHERE " : " AND ";
            $sql .= "`$this->_table`.`propunere_id` = " . $db->quote($search['propunere_id'], 'number');
            $hasWhere = true;
        }

        if (isset($search['user_id'])) {
            $sql .= $hasWhere === false ? " WHERE " : " AND ";
            $sql .= "`utilizatori`.`id` = " . $db->quote($search['user_id'], 'number');
            $hasWhere = true;
        }

        return $sql;
    }
}