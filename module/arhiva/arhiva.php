<?php
$_header_page_title = 'CONF Manager | Arhiva';

$_header_js_extra = array(
    'module/arhiva/arhiva.js'
);
require_once("../../_header.php");

// check if user is admin
$userObj = new User();
$userId = $user->data['id'];
$users = $userObj->get(false,array(),array('field' => 'nume', 'dir' => 'asc'));

?>

<body>
<?php
require "../../core/page_header.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">Lista arhiva
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#attachModal">
                        Adauga document
                    </button>
                    <!-- Modal -->
                </div>
            </div>
            <!-- /.panel-heading -->

            <div class="panel-body">
                <div class="dataTable_wrapper" id="arhivaTable">
                    <table class="table table-striped table-bordered table-hover" id="arhiva">
                        <thead>
                        <tr>
                            <th>Denumire docoument</th>
                            <th>Nume</th>
                            <th>Data</th>
                            <th>Vizualizare</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Cerere concediu</td>
                            <td>John Doe</td>
                            <td>06-05-2017</td>
                            <td><a href="javascript:void(0);"><i class="fa fa-file"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include("../../_footer.php"); ?>
    </div>
</div>
<div id="attachModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Atasare document</h4>
            </div>
            <form action="../../upload-manager.php" id="attachForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert alert-danger" id="errorDiv" style="display: none">
                            <a href="javascript:void(0);" class="close" data-dismiss="alert"
                               aria-label="close">&times;</a>
                            <i class="fa fa-exclamation-circle"></i><strong> Error list:</strong>

                            <div id="failText"></div>
                        </div>
                        <div class="form-group">
                            <label>Incarca document</label>
                            <input type="file" class="form-control" name="file_upload" id="file_upload">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" data-dismiss="modal" id="addCerere" value="Save">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
