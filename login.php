<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
        <script type="text/javascript">
            if (typeof jQuery === 'undefined') {
                document.write(unescape("%3Cscript src='/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
        <script src="/scripts/jBCrypt/isaac.js" type="text/javascript"></script>
        <script src="/scripts/jBCrypt/bCrypt.js" type="text/javascript"></script>
        <script type="text/javascript" src="/scripts/sha256.js"></script>
        <script type="text/javascript" src="scripts/scripts.js"></script>
    </head>
    <body>
        <div align="center" >
            <?php
            if (isset($_POST['submit'])) {
                ?>  
                <noscript>
                Ενεργοποιήστε την JavaScript για να συνδεθείτε 
                </noscript>
                <?php
            }
            ?>
            <div style="color:red; height:20px" id="lgerror"></div> 
            <form action="login.php" method="post" id="lg">
                <fieldset ><br /><br />
                    <label for="username">User Name:</label> 
                    <input type="text" name="username" class="txt" id="username"/><br />
                    <label for="password">Password:</label> 
                    <input type="password" name="password" class="txt" id="password"/><br />	
                    <input type="hidden" name="redirect" id="redirect" value="<? echo $_SERVER['HTTP_REFERER'] ?>" /><br />
                    <label for="lgsubmit"></label>	
                    <input type="submit" name="submit" value="Login" class="subm" id="lgsubmit"/>
                </fieldset>	
            </form>
        </div>
    </body>
</html>
