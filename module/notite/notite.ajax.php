<?php
require_once("../../core/classes/user.class.php");
require_once("../../core/classes/session.class.php");
require_once("../../core/classes/personal_notes.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'addPersonalNote':
        $response = new stdClass();
        $response->status = 'fail';

        $data = fetchAddPersonalNoteData();
        $errors = verifyPersonalNoteData($data);

        if (empty($errors)) {
            $personalNote = new PersonalNote();
            $ok = $personalNote->save($data);
            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Notita personala a fost salvata cu succes!';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;
    case 'getPersonalNotes';
        $personalNote = new PersonalNote();
        $userObj = new User();
        $session = new Session();
        $response = new stdClass();
        $response->status = 'ok';
        $data = array();

        $numberOfRows = (int)$_POST['number'];

        $user = $session->get('user');
        $userId = $user->data['id']; // User from the current session

        $response->generalNotes = $personalNote->get(false,array('created_by' => $userId, 'is_memento' => 0),array('field' => 'created_date', 'dir' => 'desc'),array('page' => 1, 'amount' => $numberOfRows));
        $response->favouriteNotes = $personalNote->get(false,array('created_by' => $userId, 'is_favourite' => 1, 'is_memento' => 0),array('field' => 'created_date', 'dir' => 'desc'),array('page' => 1, 'amount' => $numberOfRows));
        $response->memoNotes = $personalNote->get(false,array('created_by' => $userId, 'is_memento' => 1),array('field' => 'created_date', 'dir' => 'desc'),array('page' => 1, 'amount' => $numberOfRows));

        echo json_encode($response);
        break;
    case "getPersonalNoteInfo":
        $personalNote = new PersonalNote();
        $response = new stdClass();
        $response->status = 'fail';
        $id = $_POST['id'];

        if (!empty($id) && is_numeric($id)) {
            $personalNoteInfo = $personalNote->getPersonalNoteData($id);
            if (!empty($personalNoteInfo)) {
                $response->status = 'ok';
                $response->data = $personalNoteInfo;
            } else {
                $response->message = 'Eroare la aducerea datelor!';
            }
        } else {
            $response->message = 'Identificatorul notitei personale nu este setat!';
        }

        echo json_encode($response);
        break;
    case "deletePersonalNote":
        $personalNote = new PersonalNote();
        $response = new stdClass();
        $response->status = 'fail';
        $id = $_POST['id'];

        if (!empty($id) && is_numeric($id)) {
            $ok = $personalNote->delete($id);
            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Anunt sters cu success!';
            } else {
                $response->message = 'Eroare la stergere!';
            }
        } else {
            $response->message = 'Identificatorul notitei personale nu este setat!';
        }

        echo json_encode($response);
        break;
    case "emptyPersonalNotes":
        $personalNote = new PersonalNote();
        $response = new stdClass();
        $response->status = 'fail';

        $ok = $personalNote->truncate();
        if ($ok) {
            $response->status = 'ok';
            $response->message = 'Lista a fost golita cu success!';
        } else {
            $response->message = 'Eroare la stergere!';
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

function fetchAddPersonalNoteData()
{
    $data = array();
    $requestData = array();

    if (isset($_REQUEST['formData'])) {
        parse_str($_REQUEST['formData'], $requestData);
    }

    if (!empty($requestData['personalNoteId']) && is_numeric($requestData['personalNoteId'])) {
        $data['id'] = $requestData['personalNoteId'];
    } else {
        $session = new Session();
        $user = $session->get('user');
        $data['created_by'] = $user->data['id'];
        $data['created_date'] = date('Y-m-d H:i:s');
    }

    $data['icon'] = $requestData['personalNoteIcon'];

    if (!empty($requestData['personalNoteTitle'])) {
        $data['title'] = $requestData['personalNoteTitle'];
    }

    if (!empty($requestData['personalNoteContent'])) {
        $data['content'] = $requestData['personalNoteContent'];
    }

    if (isset($requestData['is_favourite'])) {
        $data['is_favourite'] = 1;
    }

    if (isset($requestData['is_memento'])) {
        $data['is_memento'] = 1;
    }

    if (!empty($requestData['personalNoteMemoDate'])) {
        $data['memo_date'] = $requestData['personalNoteMemoDate'];
    }

    return $data;
}

function verifyPersonalNoteData($data)
{
    $errors = array();

    if (!isset($data['title'])) {
        $errors[] = 'Trebuie sa introduceti un titlu!';
    }

    if (!isset($data['content'])) {
        $errors[] = 'Trebuie sa introduceti continutul!';
    }

    if (isset($data['is_memento']) && !isset($data['memo_date'])) {
        $errors[] = 'Trebuie sa selectati data pentru memento!';
    }

    return $errors;
}