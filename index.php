<?php

$_no_auth = true;

require_once("_header.php");
require_once("core/classes/conferinta.class.php");

$userId = User::getUserID();
$conf = new Conferinta();
$confsData = $conf->get();

?>
<body class="full-background">
<?php
require "core/page_header.php";
?>
<div class="container" style="margin-top: 10%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Conferinte curente</div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper" id="confListTable">
                        <table class="table table-striped table-bordered table-hover" id="confList">
                            <thead>
                            <tr>
                                <th>Denumire conferinta</th>
                                <th>Data</th>
                                <th>Apel pentru depunerea de propuneri</th>
                                <th>Termene limita</th>
                                <th>Mai multe..</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($confsData as $confItem) { ?>
                                <tr>
                                    <td><?php echo $confItem['nume'];?></td>
                                    <td><?php echo $confItem['data'];?></td>
                                    <td><a href="/login.php">Depune propunere</a></td>
                                    <td><?php echo $confItem['deadline'];?></td>
                                    <td><a href="<?php echo $confItem['id'];?>">Detalii</a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- col-md-4 col-md-offset-4 -->
    </div> <!-- row -->
</div>
</body>