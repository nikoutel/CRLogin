<?php 
require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
$l=$dic->getLanguage();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <link href="login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
        <script type="text/javascript">
            if (typeof jQuery === 'undefined') {
                document.write(unescape("%3Cscript src='/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
<!--        <script src="/scripts/jBCrypt/isaac.js" type="text/javascript"></script>-->
        <script src="/scripts/jBCrypt/bCrypt.js" type="text/javascript"></script>
        <script type="text/javascript" src="/scripts/sha256.js"></script>
        <script type="text/javascript" src="scripts/scripts.js"></script>
    </head>
    <body>
        <div id="top" align="center" >

                <div id="noscript">
                <?php echo $l['NO_SCRIPT'] ?> 
                </div>

            <div id="lgerror"></div> 
            <form action="login.php" method="post" id="lg">
                <fieldset ><br /><br />
                    <label for="username"><?php echo $l['USERNAME'] ?>:</label> 
                    <input type="text" name="username" class="txt" id="username"/><br />
                    <label for="password"><?php echo $l['PASSWORD'] ?>:</label> 
                    <input type="password" name="password" class="txt" id="password"/><br />	
                    <input type="hidden" name="redirect" id="redirect" value="<? echo $_SERVER['HTTP_REFERER'] ?>" /><br />
                    <label for="lgsubmit"></label>	
                    <input type="submit" name="submit" value="Login" class="subm" id="lgsubmit"/>
                </fieldset>	
            </form>
            <div id="msg" ></div>
        </div>
    </body>
</html>
