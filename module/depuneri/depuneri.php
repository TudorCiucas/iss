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
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="btn-group btn-group-justified btn-inverse-new" role="tablist">
            <a href="#view_depuneri" aria-controls="view_depuneri" role="tab" data-toggle="tab"
               class="btn btn-inverse">Vizualizare propuneri</a>
            <?php if (User::isSpeaker()) : ?>
                <a href="#adaugare_depuneri" id="add_depuneri_link" aria-controls="adaugare_depuneri" role="tab" data-toggle="tab"
                   class="btn btn-inverse">Creeaza propuneri</a>
            <?php endif; ?>
        </div>

        <?php if (User::isSpeaker()) : ?>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane " id="adaugare_depuneri">
                <div class="panel panel-default">
                    <div class="panel-heading">Adauga propunere
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <form action="" role="form" autocomplete="off" method="post" id="depuneriForm"
                              name="depuneriForm">
                            <div class="alert alert-danger" id="errorDiv" style="display: none">
                                <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                                <div id="failText"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titlu</label>
                                        <input name="title" id="title" type="text" maxlength="100" autocomplete="off"
                                               class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Conference</label>
                                        <select class='form-control selectpicker' id='conf_id' name='conf_id'>";
                                            <?php foreach ($confs as $confItem) {
                                            echo "<option value='" . $confItem['id'] . "'>" . $confItem['nume'] . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Abstract</label>
                                        <input type="text" name="abstract" id="abstract" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keywords</label>
                                        <input type="text" name="keywords" id="keywords" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="comment">Incarca propunere</label>
                                <textarea class="form-control" name="observatii" id="observatii " rows="5"></textarea>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="btn" id="addDepunere" style="width: 100%;" type="submit"
                                           value="Adauga"/>
                                </div>
                                <div class="col-md-6">
                                    <a id="cancelDepunere" style="width: 100%;"
                                       class="btn btn-danger">Renunta</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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