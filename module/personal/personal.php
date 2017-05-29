<?php
$_header_page_title = 'CONF Manager | Utilizatori';

$_header_js_extra = array(
    'module/personal/personal.js'
);
require_once("../../_header.php");

if (!User::hasPermissionToPersonal($user->data['id'])) {
    header('Location: ' . BASE_URL . 'error');
}

// check if user is admin
$userObj = new User();
$userId = $user->data['id'];

?>

<body>
<?php
require "../../core/page_header.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="btn-group btn-group-justified btn-inverse-new" role="tablist">
            <a href="#view_personal" aria-controls="view_personal" role="tab" data-toggle="tab"
               class="btn btn-inverse">Vizualizare utilizatori</a>
            <?php if (User::hasPermissionToPersonal($userId)) : ?>
                <a href="#adaugare_personal" id="add_personal_link" aria-controls="adaugare_personal" role="tab" data-toggle="tab"
                   class="btn btn-inverse">Adaugare utilizator</a>
            <?php endif; ?>
        </div>

        <?php if (User::hasPermissionToPersonal($userId)) : ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane " id="adaugare_personal">
                <div class="panel panel-default">
                    <div class="panel-heading">Adaugare utilizator
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <form action="" role="form" autocomplete="off" method="post" id="personalForm"
                              name="personalForm">
                            <div class="alert alert-danger" id="errorDiv" style="display: none">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                                <div id="failText"></div>
                            </div>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="btn" id="addPersonal" style="width: 100%;" type="submit"
                                           value="Adauga"/>
                                </div>
                                <div class="col-md-6">
                                    <a id="cancelPersonal" id="cancelPersonal" style="width: 100%;"
                                       class="btn btn-danger">Renunta</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div role="tabpanel" class="tab-pane active" id="view_personal">
                <div class="panel panel-default">
                    <div class="panel-heading">Lista utilizator
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div class="dataTable_wrapper" id="personalTable"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../../_footer.php"); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#personal').dataTable({
            responsive: true
        });
    })
</script>
</body>

</html>