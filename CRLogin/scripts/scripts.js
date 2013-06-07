$(document).ready(function() {
    function cr(passw) {
        passcr = passw;
        return passcr;
    }
    function cryptpass(password, usersalt) {
        if (window.console && (window.console.firebug || window.console.exception)) {
            var mesg = msg.FIREBUG_DELAY;
            $('#msg').html('<img src="CRLogin/demo-views/images/firebug.gif" width="128" height="64" alt="firebug"/><br />' + mesg);
        }
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
            $('#password').val('');
            $('#password2').val('');

            if (data !== null) {
                if (data.error) {
                    $('#lgerror').html(data.errorMsg);
                }
                if (data.msg) {
                    $('#changemsg').html(data.msgtxt);
                }
            }
        }, "json");
    }
    function getresponse(cpass) {
        $str = cpass + challenge;
        var shaObj = new jsSHA($str);
        response = shaObj.getHash("SHA-256", "HEX");
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
            $('#password').val('');
            $('#newpass').val('');
            $('#newpass2').val('');
            $('#oldpass').val('');
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
        }, "json");

    }
    formaction = 'CRLogin/controller.php';
    $('#noscript').hide();
    $('#lgsubmit').removeAttr('disabled');
    $.getJSON('CRLogin/languageArrayToJSON.php', function(data) {
        msg = data;
        $('#lgsubmit').click(function() {
            $('#lgerror').html('');
            username = $('#username').val();
            password = $('#password').val();
            token = $('#token').val();
            if ($.trim(username) === '') {
                $('#lgerror').html(msg.EMPTY_USERNAME);
                return false;
            }
            action = 'get_challenge';
            $('#msg').html('<br /><img src="CRLogin/demo-views/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
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
                        return false;
                    }
                }
            }, "json");

            return false;
        });

        $("#changesubmit").click(function() {
            $(".error").html('');
            $('#lgerror').html('');
            $("#changemsg").html('');

            username = $('#username').val();
            newpassword = $('#newpass').val();
            newpassword2 = $('#newpass2').val();
            oldpassword = $('#oldpass').val();
            token = $('#token').val();

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
                $('#msg').html('<br /><img src="CRLogin/demo-views/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
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
                }, "json");
            }

            return false;
        });

        $("#registersubmit").click(function() {

            $(".error").html('');
            $('#lgerror').html('');
            $("#changemsg").html('');

            username = $('#username').val();
            password = $('#password').val();
            password2 = $('#password2').val();
            token = $('#token').val();

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
                $('#msg').html('<br /><img src="CRLogin/demo-views/images/ajax-loader.gif" width="16" height="11" alt="ajax-loader"/>');
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
                            return false;
                        }
                    }
                }, "json");
            }

            return false;
        });
        $('a[href$="logout"]').click(function() {
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
        });

    });
});
