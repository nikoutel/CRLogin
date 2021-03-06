
/**
 *
 * script.js
 * 
 * 
 * @package CRLogin
 * @subpackage scripts
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013-2019 Nikos Koutelidis
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */
var currentScript = function () {

    var scripts = document.querySelectorAll( 'script[src]' );
    var currentScript = scripts[ scripts.length - 1 ].src;
    var currentScriptChunks = currentScript.split( '/' );
    var currentScriptFile = currentScriptChunks[ currentScriptChunks.length - 1 ];

    return currentScript.replace( currentScriptFile, '' ).replace(/\/$/, "");
}
$(document).ready(function() {
    function cr(passw) {
        passcr = passw;
        return passcr;
    }
    function cryptpass(password, usersalt) {
        
        bcrypt = new bCrypt();
        bcrypt.hashpw(password, usersalt, crossRoad);

    }
    function crossRoad(callBackVar) {

        if (action === 'register') {
            register(callBackVar);
        } else {
            getresponse(callBackVar);
        }
    }
    function register(cpass) {
        // empty inputs
        $.post(
                formaction,
                {
                    action: action,
                    username: username,
                    cpass: cpass,
                    token: token
                },
        function(data) {
            $('#msg').html('');
            $('.crl_password').val('');
            $('.crl_password2').val('');

            if (data !== null) {
                if (data.error) {
                    $('#lgerror').html(data.errorMsg);
                }
                if (data.msg) {
                    $('#changemsg').html(data.msgtxt);
                }
            }
        }, "json")
        .error(
            function(data) { 
                $('#lgerror').html($.parseJSON(data.responseText).errorMsg);
                $('#msg').html(''); 
            });
    }
    function getresponse(cpass) {
        $str = challenge;
        var shaObj = new jsSHA($str);
        response = shaObj.getHMAC(cpass, "ASCII", "SHA-256", "HEX"); // "ASCII -> "TEXT" on updated jsSHA
        send(response);
    }
    function send(response) {
        $.post(
                formaction,
                {
                    action: action,
                    username: username,
                    response: response,
                    newpassword: newpasswordcr,
                    token: token
                },
        function(data) {
            $('.crl_password').val('');
            $('.crl_newpass').val('');
            $('.crl_newpass2').val('');
            $('.crl_oldpass').val('');
            $('#msg').html('');
            if (data !== null) {
                if (data.error) {
                    $('#lgerror').html(data.errorMsg);
                }
                if (data.redirect) {
                    $(location).attr('href', data.redirectURL);
                }
                if (data.msg) {
                    $('#changemsg').html(data.msgtxt);
                }
            }
        }, "json")
        .error(
            function(data) { 
                $('#lgerror').html($.parseJSON(data.responseText).errorMsg);
                $('#msg').html(''); 
            });

    }
    currentScriptBase = currentScript();
    var currentScriptBase = currentScriptBase.split('/');
    currentScriptBase.pop();
    currentScriptBase = currentScriptBase.join('/');

    formaction = currentScriptBase + '/requestController.php';
    $('#noscript').hide();
    $('#lgsubmit').prop("disabled", false);
        msg = l;
        $('body').on('click', '#lgsubmit', function(e) {
            $('#lgerror').html('');
            username = $('.crl_username').val();
            password = $('.crl_password').val();
            token = $('#crl_token').val();
            if ($.trim(username) === '') {
                $('#lgerror').html(msg.EMPTY_USERNAME);
                return false;
            }
            action = 'get_challenge';
            $('#msg').html('<br /><img src="demo/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
            $.post(
                    formaction,
                    {
                        action: action,
                        username: username,
                        token: token
                    },
            function(data) {
                if (data !== null) {
                    if (!data.error) {
                        challenge = data.challenge;
                        newpasswordcr = false;
                        action = 'login';
                        cryptpass(password, data.usersalt);
                    } else {
                        $('#lgerror').html(data.errorMsg);
                        $('#msg').html('');
                        return false;
                    }
                }
            }, "json")
            .error(
                function(data) { 
                    $('#lgerror').html($.parseJSON(data.responseText).errorMsg);
                    $('#msg').html(''); 
                });

            return false;
        });
        $('body').on('click', '#changesubmit', function(e) {
            $(".error").html('');
            $('#lgerror').html('');
            $("#changemsg").html('');

            username = $('.crl_username').val();
            newpassword = $('.crl_newpass').val();
            newpassword2 = $('.crl_newpass2').val();
            oldpassword = $('.crl_oldpass').val();
            token = $('#crl_token').val();

            var hasError = false;

            if (newpassword !== newpassword2) {
                $("#newpasserror2").html(msg.PASSWORDS_NOT_MATCH);
                hasError = true;
            }
            if (newpassword.length < 6) {
                $("#newpasserror").html(msg.PASSWORD_TO_SHORT);
                hasError = true;
            }
            if ($.trim(newpassword) === '') {
                $("#newpasserror").html(msg.EMPTY_PASSWORD);
                hasError = true;
            }
            if ($.trim(newpassword2) === '') {
                $("#newpasserror2").html(msg.EMPTY_PASSWORD);
                hasError = true;
            }

            if ($.trim(oldpassword) === '') {
                $("#oldpasserror").html(msg.EMPTY_PASSWORD);
                hasError = true;
            }
            if (hasError === false) {
                action = 'get_challenge';
                $('#msg').html('<br /><img src="demo/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
                $.post(
                        formaction,
                        {
                            action: action,
                            username: username,
                            token: token
                        },
                function(data) {
                    if (data !== null) {
                        if (!data.error) {
                            challenge = data.challenge;
                            newpasswordcr = cr(newpassword);
                            action = 'change_password';
                            cryptpass(oldpassword, data.usersalt);
                        } else {
                            $('#lgerror').html(data.errorMsg);
                            return false;
                        }
                    }
                }, "json")
                .error(
                    function(data) {
                        $('#lgerror').html($.parseJSON(data.responseText).errorMsg);
                        $('#msg').html('');
                    });
            }

            return false;
        });

        $('body').on('click', '#registersubmit', function(e) {
            $(".error").html('');
            $('#lgerror').html('');
            $("#changemsg").html('');

            username = $('.crl_username').val();
            password = $('.crl_password').val();
            password2 = $('.crl_password2').val();
            token = $('#crl_token').val();

            var hasError = false;

            if ($.trim(username) === '') {
                $('#usernameerror').html(msg.EMPTY_USERNAME);
                hasError = true;
            }
            if ($.trim(password) === '') {
                $("#passworderror").html(msg.EMPTY_PASSWORD);
                hasError = true;
            }
            if ($.trim(password2) === '') {
                $("#passworderror2").html(msg.EMPTY_PASSWORD);
                hasError = true;
            }
            if (password !== password2) {
                $("#passworderror2").html(msg.PASSWORDS_NOT_MATCH);
                hasError = true;
            }
            if (password.length < 6) {
                $("#passworderror").html(msg.PASSWORD_TO_SHORT);
                hasError = true;
            }

            if (hasError === false) {
                action = 'get_salt';
                $('#msg').html('<br /><img src="demo/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
                $.post(
                        formaction,
                        {
                            action: action,
                            token: token

                        },
                function(data) {
                    if (data !== null) {
                        if (!data.error) {
                            action = 'register';
                            cryptpass(password, data.newsalt);
                        } else {
                            $('#lgerror').html(data.errorMsg);
                            $('#msg').html('');
                            return false;
                        }
                    }
                }, "json")
                .error(
                    function(data) { 
                        $('#lgerror').html($.parseJSON(data.responseText).errorMsg);
                        $('#msg').html(''); 
                    });
            }

            return false;
        });
/*        $('body').on('click', 'a[href$="logout', function(e) {
            action = 'logout';
            $.post(
                    formaction,
                    {action: action},
            function(data) {
                if (data !== null) {
                    if (data.redirect) {
                        $(location).attr('href', data.redirectURL);
                    }
                }
            }, "json");
            return false;
        });*/

});
