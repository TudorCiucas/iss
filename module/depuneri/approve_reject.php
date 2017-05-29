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
<input type="hidden" name="act" id="act" value="approve">
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