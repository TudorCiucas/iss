<?php
$_header_page_title = "CONF Manager | Alerte";

$_header_js_extra = array(
    'core/js/core/news.js',
    'module/alerte/alerte.js'
);

require_once("../../_header.php");

$user = new User();
$userData = $user->getUsers();

?>

<body>

<?php
require "../../core/page_header.php";
?>

<div id="page-wrapper">

    <div class="container-fluid">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Alerte și informații
                    <div class="pull-right add">
                        <a href="javascript:void(0);" title="Adaugă alertă" id="btnShowNewsModal"><i
                                class="fa fa-plus-circle text-success"></i></a>
                        <a href="javascript:void(0);" title="Golește lista" id="btnEmptyNewsList"><i class="fa fa-times-circle text-danger"></i></a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body all-news">
                    <div class="list-group" id="newsList"></div>
                </div>
                <div class="panel-footer text-right">
                    <a href="/" class="btn btn-default btn-sm">Înapoi</a>
                </div>
                <!-- /.panel-body -->
            </div>

        </div>
        <?php include("../../_footer.php"); ?>
        <?php include("../../_modal.php"); ?>
    </div>
</div>

</body>
</html>