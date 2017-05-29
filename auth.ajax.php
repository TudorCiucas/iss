<?php
require_once("core/classes/user.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case "login":
        $username = (isset($_REQUEST['email'])) ? trim($_REQUEST['email']) : '';
        $password = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : '';

        @session_start();

        $user = new User();

        $failed_logins = (isset($_SESSION['failed_logins'])) ? $_SESSION['failed_logins'] : 0;

        if (strlen($username) == 0) die(json_encode(array('status' => 'fail','message' => 'Nu ati specificat adresa de email.')));
        if (strlen($password) == 0) die(json_encode(array('status' => 'fail','message' => 'Nu ati introdus parola.')));

        $search = array();
        $search['email_likeeq'] = $username;
        $result = $user->get(false, $search);

        if ((count($result) == 0) || ($result[0]['password'] != $password)) {
            $_SESSION['failed_logins'] = $failed_logins + 1;
            die(json_encode(array('status' => 'fail', 'message' => 'Datele de acces introduse sunt incorecte.')));
        }

        if ($result[0]['stare'] != 1) {
            $_SESSION['failed_logins'] = 0;
            die(json_encode(array('status' => 'fail', 'message' => 'Utilizatorul dvs. nu mai este activ.')));
        }

        $user->data = $result[0];
        $user->role = $result[0]['rank'];

        if (empty($user->role)) {
            echo json_encode(array('status' => 'fail','message' => 'Nu exista rol specificate pentru utilizatorul curent.'));
            exit(0);
        }

        if ('4' == $user->role) {
            $_SESSION['is_admin'] = 1;
            $_SESSION['time'] = time();
        } else {
            $_SESSION['is_admin'] = 0;
            $_SESSION['time'] = time();
        }

        $user->logged_in = true;

        $_SESSION['user'] = $user;
        unset($_SESSION['failed_logins']);

        echo json_encode(array('status' => 'ok'));

        break;

    case "register":
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
                $response->message = 'Utilizatorul a fost creat cu succes!';
            }

            if ($ok) {
                $response->status = 'ok';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;
    default:
        $response = new stdClass();
        $response->status = 'fail';
        $response->message = 'Unkown AJAX request.';

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

    if (isset($requestData['afiliere']) && strlen($requestData['afiliere']) !== 0) {
        $data['afiliere'] = $requestData['afiliere'];
    }

    if (isset($requestData['webpage']) && strlen($requestData['webpage']) !== 0) {
        $data['webpage'] = $requestData['webpage'];
    }

    if (isset($requestData['email']) && strlen($requestData['email']) !== 0) {
        $data['email'] = $requestData['email'];
    }

    $data['rank'] = 1; // fiecare utilizator incepe ca si speaker(autor)

    if (isset($requestData['password']) && strlen($requestData['password']) !== 0) {
        $data['password'] = $requestData['password'];
    }

    if (isset($requestData['stare']) && strlen($requestData['stare']) !== 0 && $requestData['stare'] != 0) {
        $data['stare'] = $requestData['stare'];
    } else {
        $data['stare'] = 1;
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