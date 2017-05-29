<?php
require_once(dirname(__FILE__) . "/base.class.php");

class Review extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id' => 'int',
        'propunere_id' => 'int',
        'reviewer_id' => 'int',
        'calificativ' => 'int',
        'obs' => 'string',
        'created_date' => 'string'
    );

    protected $_table = 'reviews';

}