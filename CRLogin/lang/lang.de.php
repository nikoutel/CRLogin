<?php

/**
 *
 * lang.de.php
 * German language file
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
    'HELLO' =>  'Hallo',
    'USERNAME' =>  'Benutzername',
    'PASSWORD' =>  'Password',
    'PASSWORD2' =>  'Passwort erneut eingeben',
    'LOGIN' =>  'Anmelden',
    'REGISTER' =>  'Registrieren',
    'OLD_PASS' =>  'Altes password',
    'NEW_PASS' =>  'Neues password',
    'NEW_PASS_2' =>  'Neues password erneut eingeben',
    'CHANGE_PASS' =>  'Ändern',
    'LOGIN_CONFIRM_FAIL' =>  'Ungültiges Passwort',
    'CHANGE_PASS_SUCCESS' =>  'Das Passwort wurde erfolgreich geändert',
    'REGISTER_SUCCESS' =>  'Benutzer wurde erfolgreich erstellt - <a href="index.php?s=login">Anmelden</a>', // FIXME
    'USER_EXISTS' =>  'Dieser Benutzer existiert bereits',
    'WRONG_USERNAME_FORM' =>  'Nur Buchstaben, Zahlen, und Unterstriche sind zulässig', // FIXME
    'PASS_FORMAT_MSG' =>  'Das Passwort muss mindestens 6 Zeichen lang sein',
    'NO_SCRIPT' =>  'Bitte aktivieren Sie JavaScript, um sich anmelden zu können',
    'EMPTY_USERNAME' =>  'Benutzernamen eingeben',
    'EMPTY_PASSWORD' =>  'Passwort eingeben',
    'PASSWORDS_NOT_MATCH' =>  'Die Passwörter stimmen nicht überein',
    'PASSWORD_TO_SHORT' =>  'Muss mindestens 6 Zeichen lang sein',
    'LOGIN_FAIL' =>  'Benutzername oder Passwort ungültig',
    'FIREBUG_DELAY' => 'Es scheint, Sie benutzen Firebug.Dies wird den Prozess verlangsamen. <br />Wenn der Vorgang fehlschlägt, erhöhen Sie den Wert <i>challengeTimedelay</i> in config.php.' ,
    // Demo specific
    'DEMO_MAIN_H1' => 'Willkommen auf CRLogin',
    'DEMO_MAIN_TXT' => 'Ein Challenge-Response Authentifizierungs-System für Web-Anwendungen',
    'DEMO_MEMBERS_H1' => 'Willkommen im Mitgliederbereich.',
    'DEMO_MEMBERS_TXT' => 'Das ist ein Beispiel des Mitgliederbereichs. <br />Nur authentifizierte Benutzer können auf diesen Bereich der Website/Web-Anwendung zugreifen.',
    'LOGIN_LINK' => 'Anmelden',
    'LOGOUT_LINK' => 'Abmelden',
    'CHANGE_PASS_LINK' => 'Password ändern',
    'MEMBERS_LINK' => 'Mitgliederbereich',
    'MAIN_LINK' => 'Main',
    'REGISTER_LINK' => 'Neuen Benutzer Registrieren',
);
return $lang;
?>
