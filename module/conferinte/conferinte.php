<?php
$_header_page_title = 'CONF Manager | Conferinte';

$_header_js_extra = array(
    'module/conferinte/conferinte.js'
);
require_once("../../_header.php");

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
            <a href="#view_conferinte" aria-controls="view_conferinte" role="tab" data-toggle="tab"
               class="btn btn-inverse">Vizualizare conferinte</a>
            <?php if (User::hasPermissionToCreateConf()) : ?>
                <a href="#adaugare_conferinte" id="add_conferinte_link" aria-controls="adaugare_conferinte" role="tab" data-toggle="tab"
                   class="btn btn-inverse">Creeaza conferinta</a>
            <?php endif; ?>
        </div>

        <?php if (User::hasPermissionToCreateConf()) : ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane " id="adaugare_conferinte">
                <div class="panel panel-default">
                    <div class="panel-heading">Creeaza conferinta
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <form action="" role="form" autocomplete="off" method="post" id="conferinteForm"
                              name="conferinteForm">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="btn" id="addConferinta" style="width: 100%;" type="submit"
                                           value="Creeaza"/>
                                </div>
                                <div class="col-md-6">
                                    <a id="cancelConferinta" style="width: 100%;"
                                       class="btn btn-danger">Renunta</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div role="tabpanel" class="tab-pane active" id="view_conferinte">
                <div class="panel panel-default">
                    <div class="panel-heading">Lista conferinte
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">
                        <div class="dataTable_wrapper" id="conferinteTable"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../../_footer.php"); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#data').datepicker();
        $('#deadline').datepicker();
        $('#acceptance_date').datepicker();
        $('#ext_deadline').datepicker();
        $('#ext_acceptance_date').datepicker();
        $('#conferinte').dataTable({
            responsive: true
        });
    })
</script>
</body>

</html>