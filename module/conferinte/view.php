<?php
$_header_page_title = 'CONF Manager | Conferinta';

$_header_js_extra = array(
    'module/conferinte/view.js'
);

require_once("../../_header.php");

if (isset($_REQUEST['conf_id']) && strlen($_REQUEST['conf_id']) !== 0 && $_REQUEST['conf_id'] != 0) {
    $confId = $_REQUEST['conf_id'];
} else {
    header('Location: ' . BASE_URL . 'error.php');
}

// check if user is admin
$userObj = new User();
$userId = $user->data['id'];
$isAdmin = $userObj->isSuperAdmin($userId);

?>

<body>
<?php
require "../../core/page_header.php";
?>
<div id="page-wrapper">
    <input type="hidden" id="confId" name="confId" value="<?php echo $confId;?>">
    <div class="container-fluid">
        <div class="btn-group btn-group-justified btn-inverse-new" role="tablist">
            <a href="#detalii_profil" aria-controls="detalii_profil" role="tab" data-toggle="tab" class="btn btn-inverse">Detalii</a>
        </div>

        <!-- ------- -->
        <!-- Detalii -->
        <!-- ------- -->

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="detalii_profil">
                <div class="panel panel-default">
                    <div class="panel-heading">Detalii</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form action="" role="form" method="post" id="editConferintaForm" name="editConferintaForm">
                            <div class="alert alert-danger" id="errorDiv" style="display: none">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>
                                <div id="failText"></div>
                            </div>
                            <input type="hidden" id="conf_id" name="conf_id" value="<?php echo $confId;?>">
                            <input type="hidden" id="is_edit" name="is_edit" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nume</label>
                                        <input name="nume" id="nume" type="text" maxlength="100" autocomplete="off"
                                               class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Conference date</label>
                                        <input type="text" name="data" id="data" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Deadline</label>
                                        <input type="text" name="deadline" id="deadline" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Acceptance date</label>
                                        <input type="text" name="acceptance_date" id="acceptance_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Extanded dedline</label>
                                        <input type="text" name="ext_deadline" id="ext_deadline" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Extanded acceptance date</label>
                                        <input type="text" name="ext_acceptance_date" id="ext_acceptance_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Topic</label>
                                        <input name="topic" id="topic" type="text" maxlength="100"
                                               autocomplete="off" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Taxa</label>
                                        <input name="fee" id="fee" type="text" maxlength="100"
                                               autocomplete="off" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="comment">Detalii/Observatii:</label>
                                <textarea class="form-control" name="observatii" id="observatii " rows="5"></textarea>
                            </div>
                            <hr>
                            <!-- break line -->
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="editConferinta" class="btn btn-success" style="width: 100%;" type="submit" value="Salveaza"/>
                                </div>
                                <?php if ($isAdmin) :?>
                                <div class="col-md-6">
                                    <input id="confirmDeleteConferinta" class="btn btn-danger" style="width: 100%;" type="submit" value="Sterge"/>
                                </div>
                                <?php else :?>
                                    <div class="col-md-6">
                                        <input id="cancelConferinta" class="btn btn-danger" style="width: 100%;" type="button" value="Renunta"/>
                                    </div>
                                <?php endif;?>
                            </div>
                            <!-- row -->
                        </form>
                    </div>
                    <!-- panel-body -->
                </div>
                <!-- panel panel-default -->
            </div>
            <!-- tabpanel -->
</body>
</html>