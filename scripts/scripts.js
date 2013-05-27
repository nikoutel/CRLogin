$(document).ready(function() {
    $("#lgsubmit").click(function() {
        var username = $('#username').val();
        var password = $('#password').val();
        console.log(username); //delme
        console.log(password); //delme
        //validate
        $.post(
                'request.php',
                {username: username},
        function(data) {
            console.log('dat:' + data); //delme
            console.log('dat.us:' + data.usersalt); //delme

            if (!data.error) {
                cryptpass();

            }

            function cryptpass() {
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
                    {username: username,
                     response: response},
            function(data) {
                
            }, "json");

        }
        return false;
    });
});

