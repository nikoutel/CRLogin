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
                    $('#msg').html('firebug');
                }
                bcrypt = new bCrypt();
                bcrypt.hashpw(password, data.usersalt, getresponse);

            }

            function getresponse(cpass) {
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
                alert(data.end);
            }, "json");

        }
        return false;
    });
});

