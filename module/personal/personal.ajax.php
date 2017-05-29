<?php
require_once('../../core/classes/user.class.php');
require_once('../../core/classes/commite.class.php');
require_once('../../core/classes/role.class.php');
require_once("../../core/classes/session.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'add':
        $response = new stdClass();
        $response->status = 'fail';

        $data = fetchAddData();
        $errors = verifyData($data);

        if (empty($errors)) {
            $user = new User();

            if (isset($data['is_edit'])) {
                $id = $data['id'];
                $ok = $user->save($data);
                $response->message = 'Datele au fost salvate cu succes!';
            } else {
                $ok = $user->save($data, true);
                $response->message = 'Personal adaugata cu succes!';
            }

            if ($ok) {
                $response->status = 'ok';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;

    case 'getUsers':
        $userObj = new User();
        $response = new stdClass();

        $response->status = 'ok';
        $session = new Session();
        $user = $session->get('user');

        $userRole = $user->data['rank'];
        $userId = $user->data['id'];

        $users = array();

        switch ($userRole) {
            case 1:
            case 2:
            case 3:
                $users = $userObj->getUsers(array('user_id' => $userId));
                break;
            case 4:
                $users = $userObj->getUsers();
                break;


        }
        $data = getUsersData($users);

        $response->data = $data;

        echo json_encode($response);
        break;
    case 'assignChair':
        $commite = new Commite();
        $response = new stdClass();

        $response->status = 'fail';
        $response->message = 'Erroare la salvare!';

        $conf_id = $_POST['conf_id'];
        $chair_id = $_POST['user_id'];

        $commiteData = $commite->get(false,array('conf_id' => $conf_id));
        $data = array(
            'conf_id' => $conf_id,
            'chair' => $chair_id
        );
        if (!empty($commiteData)) {
            $data['id'] = $commiteData['id'];
        }

        if (!empty($commiteData[0]['chair'])) {
            $response->message = 'Exista deja un chair asignat la conferinta!';
        } else {
            $ok = $commite->save($data);

            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Assignat cu succes!';
            }
        }

        echo json_encode($response);
        break;
    case 'assignCoChair':
        $commite = new Commite();
        $response = new stdClass();

        $response->status = 'fail';
        $response->message = 'Erroare la salvare!';

        $conf_id = $_POST['conf_id'];
        $co_chair_id = $_POST['user_id'];

        $commiteData = $commite->get(false,array('conf_id' => $conf_id));
        $data = array(
            'conf_id' => $conf_id,
            'co_chair' => $co_chair_id
        );
        if (!empty($commiteData)) {
            $data['id'] = $commiteData[0]['id'];
        }

        if (!empty($commiteData[0]['co_chair'])) {
            $response->message = 'Exista deja un co-chair asignat la conferinta!';
        } else {
            $ok = $commite->save($data);

            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Assignat cu succes!';
            }
        }
        echo json_encode($response);
        break;
    case 'delete':
        break;
    default:
        $response = new stdClass();
        $response->status = 'fail';
        $response->message = 'Unkown AJAX request!';

        echo json_encode($response);
        break;
}

function fetchAddData()
{
    $data = array();
    $requestData = array();

    if (isset($_REQUEST['formData'])) {
        parse_str($_REQUEST['formData'], $requestData);
    }

    if (isset($requestData['is_edit']) && strlen($requestData['is_edit']) !== 0 && $requestData['is_edit'] != 0) {
        $data['is_edit'] = $requestData['is_edit'];
    }

    if (isset($requestData['user_id']) && strlen($requestData['user_id']) !== 0 && $requestData['user_id'] != 0) {
        $data['id'] = $requestData['user_id'];
    }

    if (isset($requestData['nume']) && strlen($requestData['nume']) !== 0) {
        $data['nume'] = $requestData['nume'];
    }

    if (isset($requestData['email']) && strlen($requestData['email']) !== 0) {
        $data['email'] = $requestData['email'];
    }

    if (isset($requestData['rank']) && strlen($requestData['rank']) !== 0 && $requestData['rank'] != 0) {
        $data['rank'] = $requestData['rank'];
    }

    if (isset($requestData['password']) && strlen($requestData['password']) !== 0) {
        $data['password'] = $requestData['password'];
    }

    if (isset($requestData['stare']) && strlen($requestData['stare']) !== 0 && $requestData['stare'] != 0) {
        $data['stare'] = $requestData['stare'];
    } else {
        $data['stare'] = 1;
    }

    if (isset($requestData['afiliere']) && strlen($requestData['afiliere']) !== 0) {
        $data['afiliere'] = $requestData['afiliere'];
    }

    if (isset($requestData['observatii']) && strlen($requestData['observatii']) !== 0) {
        $data['observatii'] = $requestData['observatii'];
    }

    return $data;
}

function verifyData(array $data)
{
    $user = new User();
    $errors = array();

    $isAdmin = true;
    if (isset($data['id'])) {
        $isAdmin = $user->isSuperAdmin($data['id']);
    }

    if (isset($data['is_edit']) && !isset($data['id'])) {
        $errors[] = 'Identificatorul utilizatorului nu este setat!';
    }

    if (!isset($data['nume'])) {
        $errors[] = 'Trebuie sa introduceti un nume!';
    }

    if (!isset($data['email'])) {
        $errors[] = 'Trebuie sa introduceti adresa de email!';
    }
    if (isset($data['is_edit']) && isset($data['email']) && !User::isEmailUniq($data['email'], $data['id'])) {
        $errors[] = 'Adresa de email introdusa este deja utilizat!';
    }

    if (!isset($data['password'])) {
        $errors[] = 'Trebuie sa introduceti parola!';
    }

    if (!isset($data['is_edit']) && $isAdmin && !isset($data['rank'])) {
        $errors[] = 'Trebuie sa selectati rolul!';
    }

    if (!isset($data['afiliere'])) {
        $errors[] = 'Trebuie sa introduceti afilierea!';
    }

    return $errors;
}

function getUsersData(array $usersData)
{
    $data = array();

    foreach ($usersData as $userItem) {
        $viewProfile = '<div class="personal-action"><a href="profil.php?profile_user_id='. $userItem['id'] . '">' . $userItem['nume'] . '</a></div>';

        $data[] = array(
            $viewProfile,
            $userItem['role'],
            $userItem['afiliere'],
            $userItem['email'],
            !empty($userItem['webpage']) ? $userItem['webpage'] : ''
        );
    }

    return $data;
}