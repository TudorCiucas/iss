<?php
/**
 * Calea catre root-ul site-ului pe disc
 */
define('REAL_DIR', realpath(dirname(__FILE__) . '/../') . '/');

/**
 * Calea catre root-ul site-ului relativ la domeniul pe care rulam
 */
define('BASE_DIR', str_replace('\\', '/', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), "", REAL_DIR)));

/**
 * URL-ul exact catre root-ul site-ului
 */
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . BASE_DIR );

define('CORE_DIR', BASE_DIR . 'core/');
define('REPO_DIR', BASE_DIR . 'core/repository/');
define('CSS_URL', BASE_URL . 'core/css/');

//pagini excluse de la verificarea permisiunii de accesare
$pageNoPerm = array('index.php', 'home.php', 'error.php', 'login.php', 'logout.php',);

$pageAllowGetRequest = array('view.php', 'profile.php');

// User types
define('USER_ADMIN', 4);
define('USER_CHAIR', 3);
define('USER_CO_CHAIR', 5);
define('USER_REVIEWER', 2);
define('USER_SPEAKER', 1);


// Propuneri states
define('PENDING_STATE', 1);
define('APPROVED_STATE', 2);
define('REJECTED_STATE', 3);

// calificative propuneri
define('STRONG_ACCEPT', 1);
define('ACCEPT', 2);
define('WEAK_ACCEPT', 3);
define('BORDERLINE_PAPER', 4);
define('WEAK_REJECT', 5);
define('REJECT', 6);
define('STRONG_REJECT', 7);

const CALIFICATIVE = array(
    STRONG_ACCEPT => 'Strong accept',
    ACCEPT => 'Accept',
    WEAK_ACCEPT => 'Weak accept',
    BORDERLINE_PAPER => 'Borderline paper',
    WEAK_REJECT => 'Weak reject',
    REJECT => 'Reject',
    STRONG_REJECT => 'Strong reject'
);

define('NR_MAXIM_DE_EVALUATORI', 4);
