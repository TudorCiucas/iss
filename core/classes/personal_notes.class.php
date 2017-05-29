<?php
require_once( dirname(__FILE__) . "/base.class.php");
class PersonalNote extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id'            => 'int',
        'title'         => 'string',
        'content'       => 'string',
        'icon'          => 'string',
        'is_favourite'  => 'int',
        'is_memento'    => 'int',
        'memo_date'     => 'string',
        'created_by'    => 'int',
        'created_date'  => 'string'
    );

    protected $_table = 'personal_notes';

    public function getPersonalNoteData($id)
    {
        $db = Database::getInstance();
        $data = array();

        $sql = "
            SELECT
                `" . $this->_table . "`.`id`,
                `" . $this->_table . "`.`title`,
                `" . $this->_table . "`.`content`,
                `" . $this->_table . "`.`icon`,
                `" . $this->_table . "`.`created_by`,
                `" . $this->_table . "`.`created_date`,
                `" . $this->_table . "`.`is_favourite`,
                `" . $this->_table . "`.`is_memento`,
                `" . $this->_table . "`.`memo_date`,
                `utilizatori`.`nume` AS `author`
            FROM `" . $this->_table . "`
            LEFT JOIN `utilizatori` ON (`" . $this->_table . "`.`created_by` = `utilizatori`.`id`)
            WHERE `" . $this->_table . "`.`id` = " . $db->quote($id, 'number');

        $result = $db->query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $data = $row;
        }

        return $data;
    }
}