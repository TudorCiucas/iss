<?php
require_once(dirname(__FILE__) . "/base.class.php");
class Arhiva extends Base
{

    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id'            => 'int',
        'denumire'      => 'string',
        'path'          => 'string',
        'user_id'       => 'int',
        'created_date'  => 'string',
        'created_by'    => 'int'
    );

    protected $_table = 'arhiva';
}