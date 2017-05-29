<?php
require_once( dirname(__FILE__) . "/base.class.php");
class News extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id'            => 'int',
        'title'         => 'string',
        'message'       => 'string',
        'user_id'       => 'int',
        'icon'          => 'string',
        'status'        => 'int',
        'created_by'    => 'int',
        'created_date'  => 'string'
    );

    protected $_table = 'anunturi';

    public function getNewsData($id)
    {
        $db = Database::getInstance();

        $sql = "
            SELECT
                `anunturi`.`id`,
                `anunturi`.`title`,
                `anunturi`.`message`,
                `anunturi`.`user_id`,
                `anunturi`.`icon`,
                `anunturi`.`created_by`,
                `anunturi`.`created_date`,
                `anunturi`.`status`,
                `utilizatori`.`nume`
            FROM `anunturi`
            LEFT JOIN `utilizatori` ON (`anunturi`.`created_by` = `utilizatori`.`id`)
            WHERE `anunturi`.`id` = " . $db->quote($id, 'number');

        $result = $db->query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $data = $row;
        }

        return $data;
    }
}