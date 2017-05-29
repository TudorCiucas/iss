<?php
require_once(dirname(__FILE__) . "/config/global.php");

$_header_page_title = 'CONF Manager | Error';

require_once(BASE_DIR . "_header.php");
?>
<body>
<?php
require_once(BASE_DIR ."core/page_header.php");
?>

<section id="content">
    <section class="container_12 clearfix">
        <div style="padding: 0 .7em;text-align: center;" class="ui-state-error ui-corner-all ore-error">
            <p style="font-size: 28px; font-weight: bold;">Permission Denied</p>
            <p>
                <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                <span style="color:#ffffff;"> Nu aveti drepturi de acces la pagina selectata. Daca problemele persista va rugam sa contactati administratorul aplicatiei.</span>
            </p>
        </div>
    </section>
</section>

<!- Begin Footer -->
<?php require_once (BASE_DIR . "_footer.php") ?>
<!- End Footer -->

</body>

</html>