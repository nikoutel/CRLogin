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
    'PASSWORD2' =>  'Re-enter password',
    'LOGIN' =>  'Login',
    'REGISTER' =>  'Register',
    'OLD_PASS' =>  'Old password',
    'NEW_PASS' =>  'New password',
    'NEW_PASS_2' =>  'Re-enter new password',
    'CHANGE_PASS' =>  'Change',
    'LOGIN_CONFIRM_FAIL' =>  'Invalid password',
    'CHANGE_PASS_SUCCESS' =>  'The password has been changed Successfully',
    'REGISTER_SUCCESS' =>  'User was successfully created - <a href="index.php?s=login">Login</a>', // FIXME
    'USER_EXISTS' =>  'This user already exists',
    'WRONG_USERNAME_FORM' =>  'Only letters, numbers and underscores are allowed', // FIXME
    'PASS_FORMAT_MSG' =>  'The password must be at least 6 characters long ',
    'NO_SCRIPT' =>  'Please enable JavaScript to login',
    'EMPTY_USERNAME' =>  'Enter your username',
    'EMPTY_PASSWORD' =>  'Enter password',
    'PASSWORDS_NOT_MATCH' =>  'Passwords do not match',
    'PASSWORD_TO_SHORT' =>  'Must be at least 6 charakters long',
    'LOGIN_FAIL' =>  'Invalid username or password',
    'FIREBUG_DELAY' => 'It seems that you are using Firebug. This will slow down the process. <br />If the process fails, increase the <i>challengeTimedelay</i> value in config.php.' ,
    // Demo specific
    'DEMO_MAIN_H1' => 'Welcome to CRLogin',
    'DEMO_MAIN_TXT' => 'A challenge-response authentication system for web applications',
    'DEMO_MEMBERS_H1' => 'Welcome to the members section.',
    'DEMO_MEMBERS_TXT' => 'This is an example of the member section. <br />Only authenticated users can access this area of the website/web application.',
    'LOGIN_LINK' => 'Login',
    'LOGOUT_LINK' => 'Logout',
    'CHANGE_PASS_LINK' => 'Change Password',
    'MEMBERS_LINK' => 'Members area',
    'MAIN_LINK' => 'Main',
    'REGISTER_LINK' => 'Register new user',
);
return $lang;
?>
