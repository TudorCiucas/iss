<?php
require_once(dirname(__FILE__) . "/base.class.php");

class Depuneri extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id' => 'int',
        'title' => 'string',
        'conf_id' => 'int', // ID conferintei
        'author_id' => 'int', // practic speaker ID
        'abstract' => 'string',
        'keywords' => 'string',
        'file_path' => 'string',
        'stare' => 'int',
        'created_date' => 'string'
    );

    protected $_table = 'propuneri';

}