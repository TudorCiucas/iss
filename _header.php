<?php
require_once(dirname(__FILE__) . "/core/classes/config/config.inc.php");
require_once(dirname(__FILE__) . "/core/classes/database.class.php");
require_once(dirname(__FILE__) . "/config/global.php");
require_once(dirname(__FILE__) . "/core/classes/user.class.php");
@session_start();

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']){
    $_SESSION['time'] = time();
}

// obiectul $user, avem nevoie de el peste tot
$user = new User();

$urlName = getUrlName($_SERVER['REQUEST_URI']);

if (!isset($_no_auth)) {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    }

    if (isset($_SESSION['time']) && (time() - $_SESSION['time'] >= 5*60*60)){
        session_write_close();
        header('Location: ' . BASE_DIR . 'login.php');
        die();
    }

    if (!$user->logged_in) {
        session_write_close();
        header('Location: ' . BASE_DIR . 'login.php');
        die();
    } else {
        // permite trimiterea param prin GET pentru pagina respectiva
        $urlGet = parse_url($urlName, PHP_URL_PATH);
        if (in_array(basename($urlGet), $pageAllowGetRequest)) {
            $urlName = $urlGet;
        }
//        //daca suntem in pagina din meniu(unde se verifica permisiuni)
//        if ((!in_array(basename($urlName), $tabitaNoPerm))
//            && (!$user->hasMenuPermission($urlName))) {
//            header('Location: ' . BASE_DIR . "error");
//            exit(0);
//        }
    }
}

//verifica daca are permisiune de acces pe pagina
function getUrlName($string) {
    $pattern = '/(\/.+)(\/.+)(\/.+)(\/.+)(\/.+)/i';
    $replacement = '${2}${3}${4}';
    $menuUrlName = ltrim(preg_replace($pattern, $replacement, $string), "/");

    return $menuUrlName;
}

//adauga fiserele css generale
if (!isset($_header_css)) {
    $_header_css = array(
        'core/css/bootstrap.css',
        'core/css/animate.css',
        'core/css/dataTables-bootstrap.css',
        'core/css/bootstrap-select.css',
        "core/css/bootstrap-datepicker3.css",
        'core/css/font-awesome.css',
        'core/css/dataTables-fontAwesome.css',
        'core/js/jquery.typeahead.min.css'
    );
}

if (!isset($_header_css_extra)) {
    $_header_css_extra = array();
}

if (!isset($_header_js)) {
    $_header_js = array(
        'core/js/third_party/jQuery/jquery-3.2.1.min.js',
        'core/js/bootstrap.js',
        'core/js/moment.min.js',
        'core/js/jquery-dataTables.js',
        'core/js/dataTables-bootstrap.js',
        'core/js/bootstrap-filestyle.js',
        'core/js/bootstrap-select.js',
        'core/js/bootstrap-datepicker.js',
        'core/js/bootstrap-datepicker.js',
        'core/js/third_party/jQuery/jquery.validate.min.js',
        'core/js/core/global.js',
        'core/js/jquery.typeahead.min.js'
    );
}

if (!isset($_header_js_extra)) {
    $_header_js_extra = array();
}

if (!isset($_header_page_title)) {
    $_header_page_title = "CONF Manager";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Conference management system">
    <meta name="author" content="wideart">

    <title><?php echo $_header_page_title ?></title>

<!--    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
<!--    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>-->
<!--    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <script type="text/javascript">
        <?php require_once(dirname(__FILE__) . "/js/core/global.js.php"); ?>
    </script>
    <?php foreach($_header_css as $css): ?>
        <link href="<?php echo BASE_URL . $css ?>" type="text/css" rel="stylesheet" />
    <?php endforeach; ?>

    <?php foreach($_header_css_extra as $css): ?>
        <link href="<?php echo BASE_URL . $css ?>" type="text/css" rel="stylesheet" />
    <?php endforeach; ?>

    <?php foreach($_header_js as $js):?>
        <script type="text/javascript" src="<?php echo BASE_URL . $js ?>"></script>
    <?php endforeach; ?>

    <?php foreach($_header_js_extra as $js): ?>
        <script type="text/javascript" src="<?php echo BASE_URL . $js ?>"></script>
    <?php endforeach; ?>

</head>