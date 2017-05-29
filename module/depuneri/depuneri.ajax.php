<?php
require_once('../../core/classes/depuneri.class.php');
require_once('../../core/classes/review.class.php');
require_once('../../core/classes/conferinta.class.php');
require_once('../../core/classes/reviewer.class.php');
require_once('../../core/classes/user.class.php');
require_once('../../core/classes/role.class.php');
require_once("../../core/classes/session.class.php");
require_once("../../config/global.php");

$operation = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : '';

switch ($operation) {
    case 'add':
        $response = new stdClass();
        $response->status = 'fail';

        $data = fetchAddData();
        $errors = verifyData($data);

        if (empty($errors)) {
            $propunere = new Depuneri();

            if (isset($data['is_edit'])) {
                $id = $data['id'];
                $ok = $propunere->save($data);
                $response->message = 'Datele au fost salvate cu succes!';
            } else {
                $ok = $propunere->save($data, true);
                $response->message = 'Depunere adaugata cu succes!';
            }

            if ($ok) {
                $response->status = 'ok';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;

    case 'getDepuneri':
        $propunere = new Depuneri();
        $response = new stdClass();

        $response->status = 'ok';

        $action = $_POST['act'];

        $filterData = array();
        if ($action == 'approve') {
            $filterData['stare'] = PENDING_STATE;
        } else if ($action == 'assign') {
            $filterData['stare'] = APPROVED_STATE;
        } else if ($action == 'evaluate') {
            $filterData['stare'] = APPROVED_STATE;
            // cauta propunerile care sunt asignate la userul logat
        }

        if (User::isSpeaker()) {
            $filterData['author_id'] = User::getUserID();
        }

        $propunereData = $propunere->get(false, $filterData);
        if (!empty($propunereData)) {
            $data = getDepuneriData($propunereData, $action);
            $response->data = $data;
        }

        echo json_encode($response);
        break;
    case 'delete':
        break;
    case 'approveReject':
        $response = new stdClass();
        $response->status = 'fail';

        $data = array();
        $data['id'] = $_POST['propunere_id'];
        $data['stare'] = $_POST['isApproved'] ? APPROVED_STATE : REJECTED_STATE;

        $propunere = new Depuneri();
        $ok = $propunere->save($data);

        if ($ok) {
            $response->status = 'ok';
            $response->message = 'Datele au fost salvate cu succes!';
        } else {
            $response->message = "Erroare la salvarea datelor!";
        }

        echo json_encode($response);
        break;
    case 'assignReviewers':
        $response = new stdClass();
        $response->status = 'fail';

        $data = fetchAssignData();
        $errors = verifyAssignData($data);

        if (!$errors) {
            $reviewer = new Reviewer();
            $ok = $reviewer->save($data);

            if ($ok) {
                $response->status = 'ok';
                $response->message = 'Datele au fost salvate cu succes!';
            }
        } else {
            $response->message = $errors[0];
        }

        echo json_encode($response);
        break;
    case 'evaluate':
        $response = new stdClass();
        $response->status = 'fail';

        if (isset($_POST['formData'])) {
            parse_str($_POST['formData'], $data);
        }

        $data['created_date'] = date('Y-m-d H:i:s');
        $data['reviewer_id'] = User::getUserID();

        $review = new Review();

        $ok = $review->save($data);

        if ($ok) {
            $response->status = 'ok';
            $response->message = 'Datele au fost salvate cu succes!';
        } else {
            $response->message = "Erroare la salvarea datelor!";
        }

        echo json_encode($response);
        break;
    case 'getAvailableReviewers':
        $user = new User();
        $reviewer = new Reviewer();
        $response = new stdClass();
        $response->status = 'fail';

        $propunere_id = $_POST['propunere_id'];
        $excludedReviewers = array();
        $reviewers = $reviewer->get(false, array('propunere_id' => $propunere_id));

        foreach ($reviewers as $reviewerItem) {
            $excludedReviewers[] = $reviewerItem['user_id'];
        }

        $data = $user->getAvailableReviewers(implode(',', $excludedReviewers));

        $response->status = 'ok';
        $response->data = $data;

        echo json_encode($response);
        break;
    case 'getReview':
        $review = new Review();
        $response = new stdClass();
        $response->status = 'fail';

        $reviewId = $_POST['review_id'];
        $reviewData = $review->get(false, array('id' => $reviewId));

        if (!empty($reviewData)) {
            $response->status = 'ok';
            $reviewData[0]['calificativ'] = CALIFICATIVE[$reviewData[0]['calificativ']];
            $response->data = $reviewData[0];
        } else {
            $response->message = 'Erroare la aducerea datelor!';
        }

        echo json_encode($response);
        break;
    default:
        $response = new stdClass();
        $response->status = 'fail';
        $response->message = 'Unkown AJAX request!';

        echo json_encode($response);
        break;
}

function fetchAssignData() {
    $data = array();
    $requestData = array();

    if (isset($_REQUEST['formData'])) {
        parse_str($_REQUEST['formData'], $requestData);
    }

    if (!empty($requestData['depunere_id'])) {
        $data['propunere_id'] = $requestData['depunere_id'];
    }

    if (!empty($requestData['reviewer'])) {
        $data['user_id'] = $requestData['reviewer'];
    }

    return $data;
}

function verifyAssignData(array $data) {
    $errors = array();

    if (!isset($data['propunere_id'])) {
        $errors[] = 'Identificatorul propunerii nu este setat!';
    }

    if (!isset($data['user_id'])) {
        $errors[] = "Trebuie sa selectati un evaluator!";
    }

    if (!empty($errors)) {
        // Verifica cate reviewers au fost asignati la propunere
        $reviewer = new Reviewer();
        $reviewers = $reviewer->get(true);

        if (count($reviewers) == NR_MAXIM_DE_EVALUATORI) {
            $errors[] = "Sunt deja " . NR_MAXIM_DE_EVALUATORI . " evaluatori asignati";
        }

    }

    return $errors;
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

    if (isset($requestData['depunere_id']) && strlen($requestData['depunere_id']) !== 0 && $requestData['depunere_id'] != 0) {
        $data['id'] = $requestData['depunere_id'];
    }

    if (isset($requestData['title']) && strlen($requestData['title']) !== 0) {
        $data['title'] = $requestData['title'];
    }

    if (isset($requestData['conf_id']) && strlen($requestData['conf_id']) !== 0) {
        $data['conf_id'] = $requestData['conf_id'];
    }

    $data['created_date'] = date('Y-m-d H:i:s');
    $data['author_id'] = User::getUserID();

    if (!empty($requestData['abstract'])) {
        $data['abstract'] = $requestData['abstract'];
    }

    if (!empty($requestData['keywords'])) {
        $data['keywords'] = $requestData['keywords'];
    }

    if (!empty($requestData['file_path'])) {
        $data['file_path'] = $requestData['file_path'];
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
    $conf = new Conferinta();
    $errors = array();

    if (isset($data['is_edit']) && !isset($data['id'])) {
        $errors[] = 'Identificatorul utilizatorului nu este setat!';
    }

    if (!isset($data['conf_id'])) {
        $errors[] = 'Trebuie sa selecati conferinta!';
    } else {
        $confData = $conf->get(false, array('conf_id' => $data['conf_id']));
        $deadline = $confData[0]['deadline'];
        if (strtotime($deadline) < strtotime($data['created_date'])) {
            $errors[] = "Nu se mai pot depune propuneri deadlinul a expirat!";
        }
    }

    if (!isset($data['title'])) {
        $errors[] = 'Trebuie sa introduceti un nume!';
    }

    if (!isset($data['abstract'])) {
        $errors[] = 'Trebuie sa completati campul abstract!';
    }

    if (!isset($data['keywords'])) {
        $errors[] = 'Trebuie sa completati campul keywords!';
    }


    return $errors;
}

function getDepuneriData(array $propunereData, $action)
{
    $data = array();
    $user = new User();
    $conf = new Conferinta();

    if ($action == 'assign') {
        $users = $user->get();
        foreach ($users as $userItem) {
            if ($userItem['rank'] == USER_SPEAKER || $userItem['rank'] == USER_REVIEWER) {

            }
        }
    }
    foreach ($propunereData as $propunereItem) {
        $viewConfProfile = '<div class="view-action"><a href="view.php?depunere_id='. $propunereItem['id'] . '">' . $propunereItem['title'] . '</a></div>';

        $operatiuni = "";
        if ($action == 'approve') {
            $operatiuni = "<a class='btn btn-sm btn-success' href='javascript:Depuneri.approve(". $propunereItem['id'] .")'>Approve</a> <a class='btn btn-sm btn-danger' href='javascript:Depuneri.reject(". $propunereItem['id'] .")'>Reject</a>";
        } else if ($action == 'assign') {
            $reviewer = new Reviewer();
            $reviewers = $reviewer->getReviewers( array('propunere_id' => $propunereItem['id']));
            if (count($reviewers) < NR_MAXIM_DE_EVALUATORI) {
                $operatiuni = "<a class='btn btn-sm btn-primary' href='javascript:Depuneri.openAssignReviewersModal(" . $propunereItem['id'] . ")'>Asigneaza evaluatori</a>";
            }
        } else if ($action == 'evaluate') {
            $review = new Review();
            $reviews = $review->get(false, array('propunere_id' => $propunereItem['id'], 'reviewer_id' => User::getUserID()));

            if (empty($reviews)) {
                $operatiuni = "<a class='btn btn-sm btn-primary' href='javascript:Depuneri.openEvaluateModal(" . $propunereItem['id'] . ")'>Evalueaza</a>";
            } else {
                $operatiuni = "<a href='javascript:Depuneri.openViewEvaluateModal(" . $reviews[0]['id'] . ")'>Vizualizare evaluare</a>";
            }
        }

        $evaluatori = "";
        foreach ($reviewers as $reviewerItem) {
            $evaluatori .= $reviewerItem['nume'] . '<br>';
        }

        $userData = $user->get(false, array('id' => $propunereItem['author_id']));
        $author = $userData[0]['nume'];
        $confData = $conf->get(false,array('id' => $propunereItem['conf_id']));
        $conferinta = $confData[0]['nume'];
        $data[] = array(
            $viewConfProfile,
            $conferinta,
            $author,
            $evaluatori,
            $propunereItem['abstract'],
            $propunereItem['keywords'],
            '', //document
            $propunereItem['created_date'] ? $propunereItem['created_date'] : '',
            $operatiuni
        );
    }

    return $data;
}