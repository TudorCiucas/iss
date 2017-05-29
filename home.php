<?php

$_header_page_title = "CONF Manager | Dashboard";

$_header_js_extra = array(
    'core/js/core/news.js',
    'core/js/core/personal_note.js',
    'module/dashboard/dashboard.js'
);


require_once("_header.php");

$userRole = $user->role;
// check if user is admin
$userObj = new User();
$isAdmin = $userObj->isSuperAdmin($user->data['id']);
//check if user is super agent
?>

<body>

<?php
require "./core/page_header.php";
?>
<div id="page-wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading dark-blue">
                            <i class="fa fa-users fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content dark-blue">
                        <div class="circle-tile-description text-faded">
                            Conferinte
                        </div>
                        <div class="circle-tile-number text-faded">
                            1
                            <span id="sparklineA"></span>
                        </div>
                        <a href="#" class="circle-tile-footer">Detalii <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading green">
                            <i class="fa fa-tasks fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content green">
                        <div class="circle-tile-description text-faded">
                            PROPUNERI
                        </div>
                        <div class="circle-tile-number text-faded">
                            12
                        </div>
                        <a href="#" class="circle-tile-footer">Detalii <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading orange">
                            <i class="fa fa-bell fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content orange">
                        <div class="circle-tile-description text-faded">
                            Alerte / Mesaje
                        </div>
                        <div class="circle-tile-number text-faded">
                            4 Noi
                        </div>
                        <a href="#" class="circle-tile-footer">Detalii <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="circle-tile">
                    <a href="#">
                        <div class="circle-tile-heading blue">
                            <i class="fa fa-comments fa-fw fa-3x"></i>
                        </div>
                    </a>
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            Nota
                        </div>
                        <div class="circle-tile-number text-faded">
                            10
                            <span id="sparklineB"></span>
                        </div>
                        <a href="#" class="circle-tile-footer">Detalii <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Alerte și informații
                        <?php if($isAdmin) :?>
                        <div class="pull-right add">
                            <a href="javascript:void(0);" title="Adaugă alertă" data-toggle="modal" id="btnShowNewsModal"><i
                                    class="fa fa-plus-circle text-success"></i></a>
                        </div>
                        <?php endif;?>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group" id="newsList"></div>
                    </div>
                    <div class="panel-footer text-right">
                        <?php if ($isAdmin) :?>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnEmptyNewsList">Golește lista</a>
                        <?php endif;?>
                        <a href="/module/alerte/alerte.php" class="btn btn-default btn-sm" id="viewAllNews">Vezi toate alertele</a>
                    </div>

                </div>

            </div>


            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-sticky-note"></i> Notițe personale
                        <div class="pull-right add">
                            <a href="javascript:void(0);" data-toggle="modal" id="btnShowPersonalNoteModal"><i
                                        class="fa fa-plus-circle text-white"></i></a>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <div class="btn-group btn-group-justified">
                            <a href="#generalNotesTab" aria-controls="active" role="tab" data-toggle="tab"
                               class="btn btn-default">Notițe</a>
                            <a href="#favouriteNotesTab" aria-controls="active" role="tab" data-toggle="tab"
                               class="btn btn-default">Favorite</a>
                            <a href="#memoNotesTab" aria-controls="memento" role="tab" data-toggle="tab"
                               class="btn btn-default">Memento <span class="label label-danger"
                                                                     id="nrMemento">4</span></a>
                        </div>

                        <hr>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="generalNotesTab"></div>

                            <div role="tabpanel" class="tab-pane" id="favouriteNotesTab"></div>

                            <div role="tabpanel" class="tab-pane" id="memoNotesTab"></div>

                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="btnEmptyPersonalNoteList">Șterge toate
                            notițele</a>
                        <!--                                <a href="javascript:void(0);" class="btn btn-default btn-sm" id="viewAllNotes">Vezi toate notițele</a>-->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
        <?php include("_footer.php"); ?>
        <?php include("_modal.php"); ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.exp-sday').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
        $('#personalNoteMemoDate').datepicker({
            autoclose: true,
            toggleActive: true
        });
    });
</script>

</body>
</html>