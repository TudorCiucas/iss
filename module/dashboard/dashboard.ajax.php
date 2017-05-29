<?php
require_once("../../core/classes/user.class.php");
require_once("../../core/classes/session.class.php");
require_once("../../core/classes/news.class.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'addNews':
        $response = new stdClass();
        $response->status = 'fail';

        $data = fetchAddNewsData();
        $errors = verifyNewsData($data);

        if (empty($errors)) {
            $news = new News();
            $ok = $news->save($data);
            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Anuntul a fost salvat cu succes!';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;
    case 'getNews':
        $news = new News();
        $userObj = new User();
        $response = new stdClass();
        $response->status = 'ok';
        $data = array();

        $numberOfRows = (int)$_POST['number'];

        $filterData = array();

        $response->data = $news->get(false, $filterData,array('field' => 'created_date', 'dir' => 'desc'),array('page' => 1, 'amount' => $numberOfRows));

        $session = new Session();
        $user = $session->get('user');

        echo json_encode($response);
        break;
    case 'getNewsInfo':
        $news = new News();
        $response = new stdClass();
        $response->status = 'fail';
        $id = $_POST['id'];

        if (!empty($id) && is_numeric($id)) {
            $newsInfo = $news->getNewsData($id);
            if (!empty($newsInfo)) {
                $response->status = 'ok';
                $response->data = $newsInfo;
            } else {
                $response->message = 'Eroare la aducerea datelor!';
            }
        } else {
            $response->message = 'Identificatorul anuntului nu este setat!';
        }

        echo json_encode($response);
        break;
    case 'deleteNews':
        $news = new News();
        $response = new stdClass();
        $response->status = 'fail';
        $id = $_POST['id'];

        if (!empty($id) && is_numeric($id)) {
            $ok = $news->delete($id);
            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Anunt sters cu success!';
            } else {
                $response->message = 'Eroare la stergere!';
            }
        } else {
            $response->message = 'Identificatorul anuntului nu este setat!';
        }

        echo json_encode($response);
        break;
    case 'emptyNewsList':
        $news = new News();
        $response = new stdClass();
        $response->status = 'fail';

        $ok = $news->truncate();
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

function getFilters()
{
    $filters = array();

    if (isset($_REQUEST['filters'])) {
        parse_str($_REQUEST['filters'], $requestFilterData);
    }

    $filters['date_from'] = date('Y-m-01');
    $filters['date_to'] = date('Y-m-t');


    return $filters;
}


function fetchAddNewsData()
{
    $data = array();
    $requestData = array();

    if (isset($_REQUEST['formData'])) {
        parse_str($_REQUEST['formData'], $requestData);
    }

    $data['status'] = 0;

    if (!empty($requestData['newsId']) && is_numeric($requestData['newsId'])) {
        $data['id'] = $requestData['newsId'];
    } else {
        $data['created_by'] = User::getUserID();
        $data['created_date'] = date('Y-m-d H:i:s');
    }

    if (!empty($requestData['user_id'])) {
        $data['user_id'] = $requestData['user_id'];
    }

    if (!empty($requestData['newsIcon'])) {
        $data['icon'] = $requestData['newsIcon'];
    }

    if (!empty($requestData['newsTitle'])) {
        $data['title'] = $requestData['newsTitle'];
    }

    if (!empty($requestData['newsMessage'])) {
        $data['message'] = $requestData['newsMessage'];
    }

    if (isset($requestData['is_important'])) {
        $data['status'] = 1;
    }

    if (isset($requestData['is_urgent'])) {
        $data['status'] = 2;
    }

    return $data;
}

function verifyNewsData($data)
{
    $errors = array();

    if (!isset($data['icon'])) {
        $errors[] = 'Trebuie sa alegeti o iconita pentru titlu!';
    }

    if (!isset($data['title'])) {
        $errors[] = 'Trebuie sa introduceti un titlu!';
    }

    if (!isset($data['message'])) {
        $errors[] = 'Trebuie sa introduceti continutul!';
    }

    if (!isset($data['status'])) {
        $errors[] = 'Statusul nu este setat!';
    }

    return $errors;
}