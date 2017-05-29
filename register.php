<?php
$_header_js_extra = array(
    'auth.js'
);

$_no_auth = true;

require_once("_header.php");

?>
<body class="full-background">
<?php
require "core/page_header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Creaza cont</h3>
                </div> <!-- panel-heading -->
                <div class="panel-body">
                    <form method="post" action="#" id="register" role="form"><br>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Nume" name="nume" type="text" id="nume" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Afiliere" name="afiliere" type="text" id="afiliere" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Pagina web" name="webpage" type="text" id="webpage" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" id="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Parola" name="password" type="password" id="password" value="">
                            </div>
                            <hr>
                            <!-- Change this to a button or input when using this as a form -->
                            <button id="btn_register" class="btn btn-md btn-success btn-block" >Creaza</button>
                        </fieldset>
                    </form>
                    <hr> <!-- break -->
                    <h4 class="text-center dark m-size">Daca ai deja cont <a href="/login.php">Login</a></h4>
                </div> <!-- panel-body -->
            </div> <!-- login-panel panel panel-default -->
        </div> <!-- col-md-4 col-md-offset-4 -->
    </div> <!-- row -->
</div> <!-- container -->
</body>
