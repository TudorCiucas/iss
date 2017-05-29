<?php
require_once('../../core/classes/user.class.php');
require_once('../../core/classes/conferinta.class.php');
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
            $conf = new Conferinta();

            if (isset($data['is_edit'])) {
                $id = $data['id'];
                $ok = $conf->save($data);
                $response->message = 'Datele au fost salvate cu succes!';
            } else {
                $ok = $conf->save($data, true);
                $response->message = 'Conferinta adaugata cu succes!';
            }

            if ($ok) {
                $response->status = 'ok';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;

    case 'getConf':
        $conf = new Conferinta();
        $response = new stdClass();

        $response->status = 'ok';

        $confsData = $conf->get();
        $data = getConfsData($confsData);

        $response->data = $data;

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

    if (isset($requestData['conf_id']) && strlen($requestData['conf_id']) !== 0 && $requestData['conf_id'] != 0) {
        $data['id'] = $requestData['conf_id'];
    }

    if (isset($requestData['nume']) && strlen($requestData['nume']) !== 0) {
        $data['nume'] = $requestData['nume'];
    }

    if (isset($requestData['data']) && strlen($requestData['data']) !== 0) {
        $data['data'] = $requestData['data'];
    }

    if (isset($requestData['deadline']) && strlen($requestData['deadline']) !== 0) {
        $data['deadline'] = $requestData['deadline'];
    }

    if (!empty($requestData['acceptance_date'])) {
        $data['acceptance_date'] = $requestData['acceptance_date'];
    }

    if (!empty($requestData['ext_deadline'])) {
        $data['ext_deadline'] = $requestData['ext_deadline'];
    }

    if (!empty($requestData['ext_acceptance_date'])) {
        $data['ext_acceptance_date'] = $requestData['ext_acceptance_date'];
    }

    if (!empty($requestData['topic'])) {
        $data['topic'] = $requestData['topic'];
    }

    if (isset($requestData['fee']) && strlen($requestData['fee']) !== 0) {
        $data['fee'] = $requestData['fee'];
    }

    if (isset($requestData['stare']) && strlen($requestData['stare']) !== 0 && $requestData['stare'] != 0) {
        $data['stare'] = $requestData['stare'];
    } else {
        $data['stare'] = 1;
    }

    if (isset($requestData['obs']) && strlen($requestData['obs']) !== 0) {
        $data['obs'] = $requestData['obs'];
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

    if (!isset($data['data'])) {
        $errors[] = 'Trebuie sa selectati data conferinteti!';
    }

    if (!isset($data['deadline'])) {
        $errors[] = 'Trebuie sa selectati deadlinul pentru propuneri!';
    }

    if (!isset($data['acceptance_date'])) {
        $errors[] = 'Trebuie sa selectati data de acceptare a propunerilor depuse!';
    }

    if (!isset($data['topic'])) {
        $errors[] = 'Trebuie sa introduceti un topic!';
    }

    if (!isset($data['fee'])) {
        $errors[] = 'Trebuie sa introduceti taxa!';
    }

    return $errors;
}

function getConfsData(array $confsData)
{
    $data = array();

    foreach ($confsData as $confItem) {
        $viewConfProfile = '<div class="view-action"><a href="view.php?conf_id='. $confItem['id'] . '">' . $confItem['nume'] . '</a></div>';

        $data[] = array(
            $viewConfProfile,
            $confItem['data'],
            $confItem['deadline'],
            $confItem['acceptance_date'],
            !empty($confItem['ext_deadline']) ? $confItem['ext_deadline'] : '',
            !empty($confItem['ext_acceptance_date']) ? $confItem['ext_acceptance_date'] : '',
            $confItem['topic'],
            $confItem['fee'],
            $confItem['obs'] ? $confItem['obs'] : '',
        );
    }

    return $data;
}