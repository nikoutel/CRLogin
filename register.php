<?php
require 'members_area.inc.php';
$crypt = new Crypt($dic);
$token = $crypt->getRandom('challenge');
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['REGISTER_LINK'] ?></title>
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

        <div id ="login">
            <a href="index.php?s=main">Main</a> | 
            <?php
            
            if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                echo ' <a href="index.php?s=login">' . $l['LOGIN_LINK'] . '</a>';
            } else {
                echo $l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                echo ' | <a href="index.php?s=logout">' . $l['LOGOUT_LINK'] . '</a>';
            }
            ?>
        </div>
        <div id="top">
            <div id="noscript">
                <?php echo $l['NO_SCRIPT'] ?> 
            </div>

            <div id="lgerror"></div> 
            <div id="changemsg"></div> 

            <form action="" method="post" id="change">
                <fieldset ><br /><br /> 
                    <table>
                        <tr>
                            <td>	 
                                <label for="username"><?php echo $l['USERNAME'] ?>:</label> 
                            </td>
                            <td> 
                                <input type="text" name="username"  id="username"/>
                            </td>
                            <td id="usernameerror" class="error">

                            </td>
                        </tr>
                        <tr>
                            <td> 
                                <label for="password"><?php echo $l['PASSWORD'] ?>:</label> 
                            </td>
                            <td>
                                <input type="password" name="password"  id="password"/>
                            </td>
                            <td>
                                <span id="passworderror"  class="error">
                                    <!--style="margin-top:5px"-->

                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td  >
                                <!--style=" margin-left:40px"-->
                                <span id="passstr"> <?php echo $l['PASS_FORMAT_MSG'] ?> </span>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password2"><?php echo $l['PASSWORD2'] ?>:</label> 
                            </td>
                            <td>
                                <input type="password" name="password2"  id="password2"/>
                            </td>
                            <td id="passworderror2"  class="error">

                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="hidden" name="token" class="nkod" id="token" value="<?php echo $token ?>"/>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="registersubmit"></label>	
                            </td>
                            <td>
                                <input type="submit" name="registersubmit" value="<?php echo $l['REGISTER'] ?>" class="registersubmit" id="registersubmit"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </fieldset>	
            </form>
            <div id="msg" ></div>
        </div>
    </body>
</html>
