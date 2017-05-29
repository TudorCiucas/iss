<?php
$_header_page_title = 'CONF Manager | Profil';

$_header_js_extra = array(
    'module/personal/profil.js'
);

require_once("../../_header.php");

if (isset($_REQUEST['redirect_user_id']) && strlen($_REQUEST['redirect_user_id']) !== 0 && $_REQUEST['redirect_user_id'] != 0) {
    $personalId = $_REQUEST['redirect_user_id'];
} else if (isset($_REQUEST['profile_user_id']) && strlen($_REQUEST['profile_user_id']) !== 0 && $_REQUEST['profile_user_id'] != 0) {
    $personalId = $_REQUEST['profile_user_id'];
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
    <input type="hidden" id="personalId" name="personalId" value="<?php echo $personalId;?>">
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
                        <form action="" role="form" method="post" id="editPersonalForm" name="editPersonalForm">
                            <div class="alert alert-danger" id="errorDiv" style="display: none">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>
                                <div id="failText"></div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $personalId;?>">
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
                                        <label>Rol</label>
                                        <select name="rank" id="rank" class="selectpicker" data-live-search="true"
                                                data-width="100%" data-size="10" required>
                                            <option value="1">Speaker</option>
                                            <option value="2">Reviewer</option>
                                            <option value="3">Chair</option>
                                            <option value="4">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input name="email" id="email" type="email" maxlength="100" autocomplete="off"
                                               class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Parola</label>
                                        <input name="password" id="password" type="password" maxlength="100"
                                               autocomplete="off" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Afiliere</label>
                                        <input name="afiliere" id="afiliere" type="text" maxlength="100"
                                               autocomplete="off" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Webpage</label>
                                        <input name="webpage" id="webpage" type="text" maxlength="100"
                                               autocomplete="off" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- break line -->
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="editPersonal" class="btn btn-success" style="width: 100%;" type="submit" value="Salveaza"/>
                                </div>
                                <?php if ($isAdmin) :?>
                                <div class="col-md-6">
                                    <input id="confirmDeletePersonal" class="btn btn-danger" style="width: 100%;" type="submit" value="Sterge"/>
                                </div>
                                <?php else :?>
                                    <div class="col-md-6">
                                        <input id="cancelPersonal" class="btn btn-danger" style="width: 100%;" type="button" value="Renunta"/>
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