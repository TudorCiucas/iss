<?php
$userId = User::getUserID();
$_html = '<nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="' . BASE_DIR . 'home.php">CONF Manager</a>
                </div>
            <div class="collapse navbar-collapse" id="myNavbar">';
		if ($userId) {
            $_html .= '<ul class="nav navbar-nav">
					';
            $_html .= '<li><a href="' . BASE_DIR . 'home.php">Dashboard</a></li>';
            if (User::isAdmin()) {
                $_html .= '<li><a href="' . BASE_DIR . 'module/personal/personal.php">Utilizatori</a></li>';
            }
            $_html .= '<li><a href="' . BASE_DIR . 'module/conferinte/conferinte.php">Conferinte</a></li>';
            $_html .= '<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Propuneri &nbsp; <i class="fa fa-bars"></i></a>
                    <ul class="dropdown-menu dropdown-menu-margin">';
            if (!User::isReviewer()) {
                $_html .= '<li><a href="' . BASE_DIR . 'module/depuneri/depuneri.php">Vizualizare ' . (User::isSpeaker() ? " / Adaugare" : "") . '</a></li>';
            }
            if (User::isAdmin() || User::isChair()) {
                $_html .= '<li><a href="' . BASE_DIR . 'module/depuneri/assign_to.php">Asignare la evaluator</a></li>
                        <li><a href="' . BASE_DIR . 'module/depuneri/approve_reject.php">Approve / Reject</a></li>';
            }
            if (User::isReviewer()) {
                $_html .= '<li><a href="' . BASE_DIR . 'module/depuneri/evaluate.php">Evaluare</a></li>';
            }
                    $_html .= '</ul>
                </li>
            ';

            if (User::isAdmin()) {
                $_html .= '<li><a href="' . BASE_DIR . 'module/assign_chair/">Atribuie Presedinte</a></li>';
            }
            $_html .= '<li><a href="' . BASE_DIR . 'module/alerte/alerte.php">Alerte / Mesaje</a></li>';
            if (User::isSpeaker()) {
//                $_html .= '<li><a href="' . BASE_DIR . 'module/arhiva/arhiva.php">Fisiere</a></li>';
            }

            $_html .= '</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a onclick="Header.viewProfile(' . $userId . ')" href="javascript:void(0);"><i class="fa fa-user"></i> ' . $user->data['nume'] . '</a></li>
					<li><a href="' . BASE_DIR . 'logout.php"><span class="label label-menu label-danger"><i class="fa fa-sign-out"></i> Deconectare</span></a></li>
				</ul>';
        } else {
                $_html .= '<ul class="nav navbar-nav navbar-right">
                    <li><a href="login.php">Autentificare</a></li>
                    <li><a href="register.php">Creaza cont</a></li>
                </ul>';
        }

			$_html .= '</div>
		</div>
	</nav>
    <form id="redirectProfile" action="' . BASE_DIR . 'module/personal/profil.php?user_id=' . $userId . '" method="post">
        <input type="hidden" id="profile_user_id" name="profile_user_id" value="'. $userId .'"/>
    </form>
';

echo $_html;