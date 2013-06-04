$(document).ready(function() {
    function cr(passw){
        passcr = passw;
        return passcr
    }
    function cryptpass(password, usersalt) {
        if (window.console && (window.console.firebug || window.console.exception)) {
            var mesg = msg.FIREBUG_DELAY;
            $('#msg').html('<img src="images/firebug.gif" width="128" height="64" alt="firebug"/><br />' + mesg);
        }
        bcrypt = new bCrypt();
        bcrypt.hashpw(password, usersalt, getresponse);

    }

    function getresponse(cpass) {
        $('#msg').html('');
        $str = cpass + challenge;
        var shaObj = new jsSHA($str);
        response = shaObj.getHash("SHA-256", "HEX");
        send(response);
    }
    function send(response) {
        $.post(
                'request.php',
                {
                    action: 'login',
                    username: username,
                    response: response,
                    newpassword:newpasswordcr
                },
        function(data) {
            if (data.error) {
                $('#lgerror').html(data.errorMsg);
            }
            if (data.redirect) {
                $(location).attr('href', data.redirectURL);
            }
            if (data.msg){
                $('#changemsg').html(data.msgtxt);
            }
        }, "json");

    }
    formaction = 'request.php';
    $('#noscript').hide();
    $('#lgsubmit').removeAttr('disabled');
    $.getJSON('languageArrayToJSON.php', function(data) {
        msg = data;
        $('#lgsubmit').click(function() {
            $('#lgerror').html('');
            username = $('#username').val();
            password = $('#password').val();
            if ($.trim(username) === '') {
                $('#lgerror').html(msg.EMPTY_USERNAME);
                return false;
            }
            $.post(
                    formaction,
                    {
                        action: 'getchallenge',
                        username: username
                    },
            function(data) {

                if (!data.error) {
                    challenge = data.challenge;
                    newpasswordcr = false;
                    cryptpass(password, data.usersalt);
                } else {
                    $('#lgerror').html(data.errorMsg);
                    return false;
                }
            }, "json");

            return false;
        });
        /*
         * debug mode
         */
        $('#oldpass').val('123');
        $('#newpass').val('123123');
        $('#newpass2').val('123123');
        /*
         * 
         */

        $("#changesubmit").click(function() {
            $(".error").html('');
            $('#lgerror').html('');
            $("#changemsg").html('');

            username = $('#username').val();
            newpassword = $('#newpass').val();
            newpassword2 = $('#newpass2').val();
            oldpassword = $('#oldpass').val();
            var hasError = false;

            if (newpassword !== newpassword2) {
                $("#newpasserror2").html('Οι κωδικοί δεν ταυτίζονται');
                hasError = true;
            }
            if (newpassword.length < 6) {
                $("#newpasserror").html('Τουλάχιστον 6 χαρακτήρες');
                hasError = true;
            }
            if ($.trim(newpassword) === '') {
                $("#newpasserror").html('Πληκτρολογήστε τον κωδικό');
                hasError = true;
            }
            if ($.trim(newpassword2) === '') {
                $("#newpasserror2").html('Πληκτρολογήστε τον κωδικό');
                hasError = true;
            }

            if ($.trim(oldpassword) === '') {
                $("#oldpasserror").html('Πληκτρολογήστε τον κωδικό');
                hasError = true;
            }
            if (hasError === false) {
                $.post(
                        formaction,
                        {
                            action: 'getchallenge',
                            username: username
                        },
                function(data) {
                    if (!data.error) {
                        challenge = data.challenge;
                        newpasswordcr = cr(newpassword);
                        cryptpass(oldpassword, data.usersalt);
                    } else {
                        $('#lgerror').html(data.errorMsg);
                        return false;
                    }
                }, "json");
            }

            return false;
        });
    });
});
