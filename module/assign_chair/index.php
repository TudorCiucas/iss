<?php
$_header_page_title = 'CONF Manager | Utilizatori';

$_header_js_extra = array(
    'module/personal/personal.js'
);
require_once("../../_header.php");
require_once("../../core/classes/conferinta.class.php");

if (!User::hasPermissionToPersonal($user->data['id'])) {
    header('Location: ' . BASE_URL . 'error');
}

// check if user is admin
$userObj = new User();
$userId = $user->data['id'];
$confObj = new Conferinta();

$users = $userObj->get();
$confs = $confObj->get();

$confSelect = "<select class='form-control selectpicker' id='conf_id' name='conf_id'>";
foreach ($confs as $confItem) {
    $confSelect .= "<option value='" . $confItem['id'] . "'>" . $confItem['nume'] . "</option>";
}
$confSelect .= "</select>";
?>

<body>
<?php
require "../../core/page_header.php";
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div role="tabpanel" class="tab-pane active" id="view_personal">
            <div class="panel panel-default">
                <div class="panel-heading">Lista utilizator
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper" id="usersTable">
                        <table class="table table-striped table-bordered table-hover" id="usersList">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Nume</th>
                                <th>Email</th>
                                <th>Conferinta</th>
                                <th>Operatiune</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $userItem) {
                                if ($userItem['rank'] == USER_SPEAKER || $userItem['rank'] == USER_REVIEWER) { ?>
                                <tr>
                                    <td><?php echo $userItem['id'];?></td>
                                    <td><?php echo $userItem['nume'];?></td>
                                    <td><?php echo $userItem['email'];?></td>
                                    <td><?php echo $confSelect; ?></td>
                                    <td><a href="javascript:Personal.assingChair(<?php echo $userItem['id'];?>);">Assign as Chair</a></td>
                                    <td><a href="javascript:Personal.assingCoChair(<?php echo $userItem['id'];?>);">Assign as Co-chair</a></td>
                                </tr>
                            <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../../_footer.php"); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#usersList').dataTable({
            responsive: true
        });
    })
</script>
</body>

</html>