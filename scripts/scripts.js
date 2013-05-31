$(document).ready(function() {
    $.getJSON('languageArrayToJSON.php', function(data) {
        msg = data;
        $('#noscript').hide();
        $('#lgsubmit').click(function() {
            $('#lgerror').html('');
            var username = $('#username').val();
            var password = $('#password').val();
            if ($.trim(username) === '') {
                $('#lgerror').html(msg.EMPTY_USERNAME);
                return false;
            }
            $.post(
                    'request.php',
                    {action: 'getchallenge',
                        username: username},
            function(data) {

                if (!data.error) {
                    cryptpass();
                } else {
                    $('#lgerror').html(data.errorMsg);
                    return false;
                }

                function cryptpass() {
                    if (window.console && (window.console.firebug || window.console.exception)) {
                        var mesg = msg.FIREBUG_DELAY;
                        $('#msg').html('<img src="_info/firebug.gif" width="128" height="64" alt="firebug"/><br />' + mesg);
                    }
                    bcrypt = new bCrypt();
                    bcrypt.hashpw(password, data.usersalt, getresponse);

                }

                function getresponse(cpass) {
                    $('#msg').html('');
                    $str = cpass + data.challenge;
                    var shaObj = new jsSHA($str);
                    response = shaObj.getHash("SHA-256", "HEX");
                    send(response);
                }

            }, "json");
            function send(response) {
                $.post(
                        'request.php',
                        {action: 'login',
                            username: username,
                            response: response},
                function(data) {
                    if (data.error) {
                        $('#lgerror').html(data.errorMsg);
                    }
                    if (data.redirect) {
                        $(location).attr('href', data.redirectURL);
                    }
                }, "json");

            }
            return false;
        });
    });
});
