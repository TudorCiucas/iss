<?php
require_once(dirname(__FILE__) . "/base.class.php");

class Commite extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id' => 'int',
        'conf_id' => 'int', // ID conferintei
        'chair' => 'int', // Presedinte comitete de desfasurare - ID utilizator
        'co_chair' => 'int' // Vice-presedinte - ID utilizator
    );

    protected $_table = 'commites';

}