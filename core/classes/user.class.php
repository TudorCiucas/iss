<?php
require_once(dirname(__FILE__) . "/base.class.php");
require_once(dirname(__FILE__) . "/session.class.php");

class User extends Base
{
    /**
     * Campurile corespunzatoare tabelei in baza de date
     */
    protected $_fields = array(
        'id'            => 'int',
        'nume'          => 'string',
        'password'      => 'string',
        'email'         => 'string',
        'afiliere'         => 'string',
        'website'         => 'string',
        'rank'          => 'string',
        'stare'         => 'int',
    );

    protected $_table = 'utilizatori';

    /**
     * @var array stocheaza date din tabela in cazuri speciale
     */
    public $data = array();

    /**
     * @var array $roluri rolurile asociate cu utilizatorul logat
     */
    public $role = '';
    /**
     * @var array $meniuri meniurile asociate cu utilizatorul logat
     */
    public $meniuri = array();

    /**
     * @var boolean true daca utilizatorul este logat, false daca nu
     */
    public $logged_in = false;
    public $key = '';

    function __construct()
    {
        $this->logged_in = false;
        $this->key = $this->get_key();
    }

    /**
     * PRIVAT get_key() - genereaza o cheie random folosita la autentificarea AJAX
     *
     * Returneaza: string
     *
     */
    private function get_key($length = 20)
    {
        $key = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789[]{}";

        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $key .= $tmp;
        }

        return $key;
    }

    public static function getUserID()
    {
        $session = new Session();
        $user = $session->get('user');
        $userId = $user->data['id'];

        return $userId;
    }

    public function isSuperAdmin($userId)
    {
        $db = Database::getInstance();

        $sql = " SELECT rank
                 FROM `utilizatori`
                 WHERE id = " . $db->quote($userId) . "
				 AND rank = 3";

        $res = $db->query($sql);

        $userRoles = array();
        while($result = mysql_fetch_assoc($res)) {
            $userRoles[] = $result;
        }

        if (count($userRoles))
            return true;

        return false;
    }

    public static function isAdmin()
    {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_ADMIN) {
            return true;
        }

        return false;
    }

    public static function isSpeaker()
    {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_SPEAKER) {
            return true;
        }

        return false;
    }

    public static function isReviewer()
    {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_REVIEWER) {
            return true;
        }

        return false;
    }

    public static function isChair()
    {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_CHAIR) {
            return true;
        }

        return false;
    }
    public static function isEmailUniq($email, $userId = null)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `utilizatori` WHERE `utilizatori`.`email` = " . $db->quote($email);

        if ($userId != null) {
            $sql .= " AND `utilizatori`.`id` != " . $db->quote($userId, 'number');
        }

        $res = $db->query($sql);

        $users = array();
        while($result = mysql_fetch_assoc($res)) {
            $users[] = $result;
        }

        if (count($users))
            return false;

        return true;
    }

    public static function hasPermissionToPersonal($userId)
    {
        $db = Database::getInstance();

        $sql = " SELECT rank
                 FROM `utilizatori`
                 WHERE id = " . $db->quote($userId) . "
				 AND rank IN (4)";

        $res = $db->query($sql);

        $userRoles = array();
        while($result = mysql_fetch_assoc($res)) {
            $userRoles[] = $result;
        }

        if (count($userRoles))
            return true;

        return false;
    }

    public static function hasPermissionToCreateConf() {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_ADMIN || $rank == USER_CHAIR) {
            return true;
        }

        return false;
    }

    public static function hasPermissionToDepuneri() {
        $session = new Session();
        $user = $session->get('user');
        $rank = $user->data['rank'];

        if ($rank == USER_SPEAKER || $rank == USER_REVIEWER) {
            return true;
        }

        return false;
    }

    public static function getSuperAdmin()
    {
        return USER_ADMIN;
    }

    public function getAvailableReviewers($excludedReviewers)
    {
        $db = Database::getInstance();
        $data = array();

        $sql = "SELECT * FROM `utilizatori` WHERE rank = 2 ";
        if (!empty($excludedReviewers)) {
            $sql .= "AND id NOT IN ($excludedReviewers)";
        }

        $result = $db->query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getUsers(array $search = array()) {
        $db = Database::getInstance();
        $data = array();

        $sql = 'SELECT
                    `utilizatori`.`id`,
                    `utilizatori`.`nume`,
                    `roles`.`role`,
                    `utilizatori`.`email`,
                    `utilizatori`.`afiliere`,
                    `utilizatori`.`webpage`
                FROM `utilizatori`
                INNER JOIN `roles` ON `utilizatori`.`rank` = `roles`.`id`';

        $sql .= $this->filterToSql($search);
        $sql .= 'ORDER BY `utilizatori`.`nume`';

        $result = $db->query($sql);

        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    private function filterToSql($search)
    {
        $db = Database::getInstance();
        $sql = '';
        $hasWhere = false;

        if (isset($search['user_id'])) {
            $sql .= $hasWhere === false ? " WHERE " : " AND ";
            $sql .= "`utilizatori`.`id` = " . $db->quote($search['user_id'], 'number');
            $hasWhere = true;
        }

        return $sql;
    }

    public function getUserPermission($userId)
    {
        $filters = array();
        $isAdmin = $this->isSuperAdmin($userId);

        if ($isAdmin) {
        }  else {
            $filters['user_id'] = $userId;
        }

        return $filters;
    }
}
