<?php
require_once(dirname(__FILE__) . "/base.class.php");
require_once(dirname(__FILE__) . "/session.class.php");

class Conferinta extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id' => 'int',
        'nume' => 'string',
        'data' => 'string', // Conference days
        'deadline' => 'string', // Deadline for abstract submission
        'acceptance_date' => 'string', // Notification of acceptance
        'ext_deadline' => 'string', // Extended dedline for abstract submission
        'ext_acceptance_date' => 'string', // Extended deadlin for notification of acceptance
        'commitee' => 'int',
        'topic' => 'string',
        'fee' => 'int',
        'stare' => 'int',
        'obs'   => 'string'
    );

    protected $_table = 'conferinte';

}