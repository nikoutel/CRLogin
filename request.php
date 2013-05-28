<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
//$_POST['username'] = 'nikos'; // ugly debug mode
if (isset($_POST['action']) && $_POST['action'] == 'getchallenge') {
    if (isset($_POST['username'])) {

        $username = $_POST['username'];
        //@todo validate?
        //@todo if un not empty

        $user = new User($dic);
        $user->setUserName($username);
        $userSalt = $user->getUserSalt();
        if ($userSalt) {
            $challenge = new Challenge($dic);
            if ($challenge->createChallenge()) {
                $challengeId = $challenge->getChallenge();
            } else {
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
//    Debugr::edbg($user->getUserSalt(), '$user->getUserSalt()');
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    //@todo check user
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
                logIn();
            } else {
                //@todo else
                echo json_encode(array(
                    'end' => 'not ok'));
            }
        } else {
            //@todo else
        }
    }
}

function logIn() {
    echo json_encode(array(
        'end' => 'ok'));
}

?>
