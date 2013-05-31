<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
//session_start();
$_SESSION['redirectUrl'] = 'index.php?s=members';


//$_POST['username'] = 'nikos'; // ugly debug mode
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
            //@todo else
            echo json_encode(array(
                'error' => TRUE));
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
                loggedIn($username);
            } else {
                //@todo else
                notLoggedIn();
            }
        } else {
            //@todo else
        }
    }
}

function loggedIn($username) {
    $redirectUrl = $_SESSION['redirectUrl'];
    unset($_SESSION['redirectUrl']);
    session_regenerate_id(true);
    $_SESSION['logged'] = TRUE;
    $_SESSION['username'] = $username;
    echo json_encode(array(
        'redirect' => TRUE,
        'redirectURL' => $redirectUrl));
}

function notLoggedIn() {
    $_SESSION['logged'] = FALSE;
    $_SESSION['username'] = FALSE;
    echo json_encode(array(
        'error' => TRUE,
        'erroMsg' => 'wrong'));
}
?>
