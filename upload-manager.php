<?php
require_once("core/classes/session.class.php");
require_once("core/classes/user.class.php");
require_once("core/classes/arhiva.class.php");

$arhiva = new Arhiva();
$response = new stdClass();
$response->status = 'fail';

if (isset($_FILES['file']['name'])) {
    if (0 < $_FILES['file']['error']) {
        $response->message =  'Error during file upload' . $_FILES['file']['error'];
    } else {
        if (file_exists('uploads/' . $_FILES['file']['name'])) {
            echo 'File already exists : resources/' . $_FILES['file']['name'];
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'resources/' . $_FILES['file']['name']);
            $response->message = 'File successfully uploaded : resources/' . $_FILES['file']['name'] . ".  ";
            // save to database
            $data = array();
            $requestData = array();

            if (isset($_REQUEST['formData'])) {
                parse_str($_REQUEST['formData'], $requestData);
            }

            $data['path'] = 'resources/' . $_FILES['file']['name'];
            $data['created_by'] = User::getUserID();
            $data['created_date'] = date('Y-m-d H:i:s');

            if (!empty($requestData['denumire'])) {
                $data['denumire'] = $requestData['denumire'];
            }

            if (!empty($requestData['user'])) {
                $data['user_id'] = $requestData['user'];
            }
            $errors = verifyData($data);

            if (empty($errors)) {
                $ok = $arhiva->save($data);
                $response->message .= 'Documentul adaugata cu succes!';

                if ($ok) {
                    $response->status = 'ok';
                }
            } else {
                $response->message = $errors[0];
            }

            echo json_encode($response);

        }
    }
} else {
    $response->message = 'Selecteaza un fisier';
}

function verifyData(array $data)
{
    $errors = array();

    if (!isset($data['denumire'])) {
        $errors[] = 'Trebuie sa introduceti denumirea documentului!';
    }

    return $errors;
}