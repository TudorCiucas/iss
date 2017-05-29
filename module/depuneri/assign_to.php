<?php

$_header_page_title = 'CONF Manager | Depuneri';

$_header_js_extra = array(
    'module/depuneri/depuneri.js'
);
require_once("../../_header.php");
require_once("../../core/classes/conferinta.class.php");

$userObj = new User();
$userId = $user->data['id'];

$confObj = new Conferinta();
$confs = $confObj->get();


$users = $userObj->get();
$reviewers = array();
// TODO: nu afisa evaluatori care au fost deja asigati pe o propunere
foreach ($users as $userItem) {
    if (($userItem['rank'] == USER_CO_CHAIR || $userItem['rank'] == USER_REVIEWER)) {
        $reviewers[] = array(
            'id' => $userItem['id'],
            'nume' => $userItem['nume']
        );
    }
}
?>

<body>
<?php
require "../../core/page_header.php";
?>
<input type="hidden" name="act" id="act" value="assign">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="btn-group btn-group-justified btn-inverse-new" role="tablist">
            <a href="#view_depuneri" aria-controls="view_depuneri" role="tab" data-toggle="tab"
               class="btn btn-inverse">Lista propuneri</a>
        </div>
        <div role="tabpanel" class="tab-pane active" id="view_depuneri">
            <div class="panel panel-default">
                <div class="panel-heading">Lista propuneri
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper" id="depuneriTable"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="assignToModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Asigneaza evaluatori</h4>
                </div>
                <form method="post" id="assignToForm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="alert alert-danger" id="errorDiv" style="display: none">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert"
                                   aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                                <div id="failText"></div>
                            </div>
                            <input type="hidden" name="depunere_id" id="depunere_id">
                            <div class="form-group">
                                <label>Evaluatori: </label>
                                <select name="reviewer" id="reviewer" class="selectpicker"
                                        data-width="100%" data-size="10" required>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAssignReviewers">Asigneaza</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <?php include("../../_footer.php"); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#depuneri').dataTable({
            responsive: true
        });
    })
</script>
</body>

</html>