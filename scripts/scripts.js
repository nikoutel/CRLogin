$(document).ready(function() {
    $("#lgsubmit").click(function() {
        var username = $('#username').val();
        var password = $('#password').val();
        //validate
        $.post(
                'request.php',
                {action: 'getchallenge',
                    username: username},
        function(data) {

            if (!data.error) {
                cryptpass();
            } else {
                //@todo js else
            }

            function cryptpass() {
                if (window.console && (window.console.firebug || window.console.exception)) {
                    var mesg = 'It seems you have firebug enabled. This will deley things...<br /><br /><br /><br />';
                    $('#msg').html('<img src="_info/firebug.gif" width="128" height="64" alt="firebug"/><br />'+mesg);
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
                if (data.error){
                    $('#msg').html(data.erroMsg);
                }
                if (data.redirect){
                    $(location).attr('href',data.redirectURL);
                }
            }, "json");

        }
        return false;
    });
});

