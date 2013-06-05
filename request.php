<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$l = $dic->getLanguage();
$session = $dic->startSession();
if (isset($_POST['action']) && $_POST['action'] == 'get_challenge') {
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
                $crypt = new Crypt($dic);
                $dummySalt = $crypt->getNewSalt();
                $challenge = new Challenge($dic);
                if ($challenge->createChallenge()) {
                    $challengeId = $challenge->getChallenge();
                }
                echo json_encode(array(
                    'error' => FALSE,
                    'usersalt' => $dummySalt,
                    'challenge' => $challengeId));
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
    if ($_POST['newpassword'] == 'false') {
        $newpassword = FALSE;
    } else {
        $newpassword = $_POST['newpassword'];
    }

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
                if (!$newpassword) {
                    isLoggedIn($username);
                } else {
                    changePassword($newpassword, $dic, $user, $l);
                }
            } else {
                if (!$newpassword) {
                    isNotLoggedIn($l);
                } else {
                    isNotLoggedIn($l, $newpassword);
                }
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
    if (!isset($newpassword)) {
        echo json_encode(array(
            'error' => TRUE,
            'errorMsg' => $l['LOGIN_FAIL']
        ));
    } else {
        echo json_encode(array(
            'error' => TRUE,
            'errorMsg' => $l['LOGIN_CONFIRM_FAIL']
        ));
    }
}

function changePassword($newPassword, $dic, $user, $l) {
    $crypt = new Crypt($dic);
    $newSalt = $crypt->getNewSalt();
    $spass = $crypt->encrypt($newPassword, $newSalt);
    $update = $user->updateUserPass($spass, $newSalt);
    session_regenerate_id(true);
    $_SESSION['logged'] = TRUE;
    $_SESSION['username'] = $user->getUsername();
    if ($update !== FALSE) {
        echo json_encode(array(
            'msg' => TRUE,
            'msgtxt' => $l['CHANGE_PASS_SUCCESS']
        ));
    } else {
        echo json_encode(array(
            'error' => TRUE
        ));
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'get_Salt') {
    if ($_POST['token'] == $_SESSION['token']) {// universal 
        $crypt = new Crypt($dic);
        $newSalt = $crypt->getNewSalt();
        $_SESSION['newsalt'] = $newSalt;
        echo json_encode(array(
            'newsalt' => $newSalt
        ));
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    //@todo validate?
    $saltedPassword = $_POST['cpass'];
    $salt = $_SESSION['newsalt'];
    $user = new User($dic);
    $create = $user->createUser($username, $saltedPassword, $salt);
    if ($create !== FALSE){
        echo json_encode(array(
            'msg' => TRUE,
            'msgtxt' => $l['REGISTER_SUCCESS']
        ));
    //login ?
    }
}
?>
