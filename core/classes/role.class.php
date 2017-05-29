<?php
class Role extends Base
{

    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id'    => 'int',
        'role'  => 'string'
    );

    protected $_table = 'roles';
}