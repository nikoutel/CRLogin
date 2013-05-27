<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$_POST['username'] = 'nikos'; // ugly debug mode
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    //validate?
    $dic = new DIC;
    $user = new User($dic);
    $user->setUserName($username);
    $userSalt = $user->getUserSalt();
    if ($userSalt) {
        $challenge = new Challenge($dic);
        $challengeId = $challenge->getChallenge(); 
        //if else error
        echo json_encode(array(
            'error' => FALSE,
            'usersalt' => $userSalt,
            'challenge' => $challengeId));
    } else {
        // unknown username
        // send dummy challenge ?
    }
//    Debugr::edbg($user->getUserSalt(), '$user->getUserSalt()');
}
?>
