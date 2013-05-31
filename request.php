<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
if (isset($_POST['action']) && $_POST['action'] == 'getchallenge') {
    if (isset($_POST['username'])) {

        $username = $_POST['username'];
        //@todo validate?
        $username = trim($username);
        if (!empty($username)) {

            $user = new User($dic);
            $user->setUserName($username);
            $userSalt = $user->getUserSalt();
            if ($userSalt !== FALSE) {
                $challenge = new Challenge($dic);
                if ($challenge->createChallenge()) {
                    $challengeId = $challenge->getChallenge();
                } else {
                    //@todo else
                    echo json_encode(array(
                        'error' => TRUE));
                }
                echo json_encode(array(
                    'error' => FALSE,
                    'usersalt' => $userSalt,
                    'challenge' => $challengeId));
            } else {
                //@todo unknown username
                // send dummy challenge ?
            }
        } else {
            echo json_encode(array(
                'error' => TRUE,
                'errorMsg' => 'Empty Username'
            ));
        }
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $response = $_POST['response'];
    if ((!empty($username)) && (!empty($response))) {

        $user = new User($dic);
        $user->setUserName($username);
        $saltedPassword = $user->getSaltedPass();


        $challenge = new Challenge($dic);
        if ($challenge->fechChallenge()) {
            $challengeId = $challenge->getChallenge();

            $clientResponse = new Response();
            $clientResponse->setResponse($response);

            $serverResponse = new Response();
            $serverResponse->calculateResponse($saltedPassword, $challengeId);

            $cr = $clientResponse->getResponse(); // @todo rename vars

            $sr = $serverResponse->getResponse();
            $authentication = new Authentication($cr, $sr);
            if ($authentication->isAuthenticated()) {
                isLoggedIn($username);
            } else {
                //@todo else
                isNotLoggedIn($l);
            }
        } else {
            //@todo else
        }
    }
}

function isLoggedIn($username) {
    if (isset($_SESSION['redirectURL'])) {
        $redirectUrl = $_SESSION['redirectURL'];
        unset($_SESSION['redirectURL']);
    } else {
        $redirectUrl = 'index.php';
    }
    session_regenerate_id(true);
    $_SESSION['logged'] = TRUE;
    $_SESSION['username'] = $username;
    echo json_encode(array(
        'redirect' => TRUE,
        'redirectURL' => $redirectUrl));
}

function isNotLoggedIn($l) {
    $_SESSION['logged'] = FALSE;
    $_SESSION['username'] = FALSE;
    echo json_encode(array(
        'error' => TRUE,
        'errorMsg' => $l['LOGIN_FAIL']
    ));
}

?>
