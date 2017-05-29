<?php
require_once("../../core/classes/arhiva.class.php");
require_once("../../core/classes/session.class.php");
require_once("../../core/classes/user.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'get':
        $arhiva = new Arhiva();
        $response = new stdClass();
        $response->status = 'ok';
        $data = array();

        $session = new Session();

        $arhivaData = $arhiva->get();

        $data = getDetailsData($arhivaData);
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

function getDetailsData(array $arhivaData)
{
    $data = array();
    $user = new User();

    foreach ($arhivaData as $item) {

        $path = !empty($item['path']) ? $item['path'] : '';
        $doc = "<a href='$path' target='_blank' style='color: #1ca8dd;'>Vizualizare doc</a>";
        $userData = $user->get(false, array('id' => $item['user_id']));
        $userName = $userData['0']['nume'];
        $data[] = array(
            $item['denumire'],
            $userName,
            $item['created_date'],
            $doc
        );
    }

    return $data;
}