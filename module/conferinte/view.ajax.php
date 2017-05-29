<?php
require_once('../../core/classes/conferinta.class.php');
require_once("../../core/classes/user.class.php");
require_once("../../core/classes/session.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'getDetails':
        $conf = new Conferinta();
        $response = new stdClass();

        $response->status = 'ok';

        $id = $_POST['id'];
        $confsData = $conf->get(false, array('id' => $id));
        $data = getDetailsData($confsData[0]);

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

function getDetailsData(array $confData)
{
    $data = array(
        'id'   => $confData['id'],
        'nume' => $confData['nume'],
        'data' => $confData['data'],
        'deadline' => $confData['deadline'],
        'acceptance_date' => $confData['acceptance_date'],
        'ext_deadline' => !empty($confData['ext_deadline']) ? $confData['ext_deadline'] : '',
        'ext_acceptance_date' => !empty($confData['ext_acceptance_date']) ? $confData['ext_acceptance_date'] : '',
        'topic' => $confData['topic'],
        'fee' => $confData['fee'],
        'obs' => $confData['obs'] ? $confData['obs'] : '',
    );

    return $data;
}