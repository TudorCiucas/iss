<?php
/**
 * Interfata de baza pentru toate clasele
 */
interface iBase
{
    public function get( $only_total = false, $search = array(), $sort = array(), $limit = array() );
    public function delete( $id = null );
    public function save( $date = array() );
}