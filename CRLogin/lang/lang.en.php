<?php

/**
 *
 * lang.en.php
 * English language file
 * 
 * 
 * @package CRLogin
 * @subpackage lang
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013 Nikos Koutelidis 
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

$lang = array(
    'HELLO' =>  'Hello',
    'USERNAME' =>  'Username',
    'PASSWORD' =>  'Password',
    'PASSWORD2' =>  'Re-enter Password',
    'LOGIN' =>  'Login',
    'REGISTER' =>  'Register',
    'OLD_PASS' =>  'Old Password',
    'NEW_PASS' =>  'New Password',
    'NEW_PASS_2' =>  'Re-enter new Password',
    'CHANGE_PASS' =>  'Change',
    'LOGIN_CONFIRM_FAIL' =>  'Invalid password',
    'CHANGE_PASS_SUCCESS' =>  'Password changed Successfully',
    'REGISTER_SUCCESS' =>  'User created Successfully - <a href="index.php?s=login">Login</a>',
    'USER_EXISTS' =>  'This User already exists',
    'WRONG_USERNAME_FORM' =>  'allowed chars: a-z A-Z 0-9 -', // FIXME
    'PASS_FORMAT_MSG' =>  'Ο κωδικός πρόσβασης πρέπει να είναι μεγαλύτερος από 6 χαρακτήρες και να περιέχει γράμματα, αριθμούς και σύμβολα 	',
    'NO_SCRIPT' =>  'Please enable JavaScript to login',
    'EMPTY_USERNAME' =>  'Enter your username',
    'EMPTY_PASSWORD' =>  'Enter Password',
    'PASSWORDS_NOT_MATCH' =>  'Passwords do not match',
    'PASSWORD_TO_SHORT' =>  'Must be at least 6 charakters long',
    'LOGIN_FAIL' =>  'Invalid username or password',
    'FIREBUG_DELAY' => 'It seems that you are using Firebug. This will slow down the process. <br />
        If the process fails, increase the <i>challengeTimedelay</i> value in config.php.' ,
    // Demo specific
    'DEMO_MAIN_H1' => 'This is main',
    'DEMO_MAIN_TXT' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore',
    'DEMO_MEMBERS_H1' => 'Welcome to the members section.',
    'DEMO_MEMBERS_TXT' => 'Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat',
    'LOGIN_LINK' => 'Login',
    'LOGOUT_LINK' => 'Logout',
    'CHANGE_PASS_LINK' => 'Change Password',
    'MEMBERS_LINK' => 'Members area',
    'MAIN_LINK' => 'Main',
    'REGISTER_LINK' => 'Register new user',
);
return $lang;
?>
