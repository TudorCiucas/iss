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
?>

<body>
<?php
require "../../core/page_header.php";
?>
<input type="hidden" name="act" id="act" value="evaluate">
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
    <?php include("../../_footer.php"); ?>
</div>
<div id="evaluateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Evalueaza propunere</h4>
            </div>
            <form method="post" id="evaluateForm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert alert-danger" id="errorDiv" style="display: none">
                            <a href="javascript:void(0);" class="close" data-dismiss="alert"
                               aria-label="close">&times;</a>
                            <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                            <div id="failText"></div>
                        </div>
                        <input type="hidden" name="propunere_id" id="propunere_id" value="">
                        <div class="form-group">
                            <label>Calificative: </label>
                            <select name="calificativ" id="calificativ" class="selectpicker"
                                    data-width="100%" data-size="10" required>
                                <?php foreach (CALIFICATIVE as $key => $value) {
                                    echo "<option value='" . $key . "'>" . $value . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="from-group">
                            <label>Observatii</label>
                            <textarea class="form-control" name="obs" id="obs" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnEvaluate">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal Vizualizare evaluare-->
<div id="viewReviewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalii evaluare</h4>
            </div>
            <form method="post" id="evaluateForm">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="propunere_id" id="propunere_id" value="">
                        <div class="form-group">
                            <label>Calificative: </label>
                            <span class="calificativ"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Observatii</label>
                            <span class="obs"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Data:</label>
                            <span class="created_date"></span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
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