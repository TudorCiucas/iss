<?php
require_once("../../core/classes/user.class.php");
require_once("../../core/classes/session.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'getDetails':
        $user = new User();
        $response = new stdClass();
        $response->status = 'ok';
        $data = array();

        $id = $_POST['id'];
        $userData = $user->get(false, array('id' => $id));
        $data = getDetailsData($userData[0]);
        $response->data = $data;

        echo json_encode($response);
        break;
    default:
        $response = new stdClass();
        $response->status = 'fail';
        $response->message = 'Unkown AJAX request.';

        echo json_encode($response);
        break;
}

function getDetailsData(array $userData)
{
    $data = array(
        'id'   => $userData['id'],
        'nume' => $userData['nume'],
        'email' => $userData['email'],
        'password' => $userData['password'],
        'rank' => $userData['rank'],
        'afiliere' => $userData['afiliere'],
        'webpage' => $userData['webpage']
    );


    return $data;
}