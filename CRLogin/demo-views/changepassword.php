<?php
if (count(get_included_files()) == 1) {
    header("location: /index.php?s=changepassword");
    die();
}

$base = realpath($_SERVER["DOCUMENT_ROOT"]);
require $base . '/CRLogin/inc/members_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['CHANGE_PASS_LINK'] ?></title>
        <link href="/CRLogin/demo-views/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
        <?php require $base . '/CRLogin/inc/head.inc.php'; ?>
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
                                <label for="oldpass"><?php echo $l['OLD_PASS'] ?>:</label> 
                            </td>
                            <td> 
                                <input type="password" name="oldpass"  id="oldpass"/>
                            </td>
                            <td id="oldpasserror" class="error">

                            </td>
                        </tr>
                        <tr>
                            <td> 
                                <label for="newpass"><?php echo $l['NEW_PASS'] ?>:</label> 
                            </td>
                            <td>
                                <input type="password" name="newpass"  id="newpass"/>
                            </td>
                            <td>
                                <span id="newpasserror"  class="error">
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
                                <label for="newpass2"><?php echo $l['NEW_PASS_2'] ?>:</label> 
                            </td>
                            <td>
                                <input type="password" name="newpass2"  id="newpass2"/>
                            </td>
                            <td id="newpasserror2"  class="error">

                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <input type="hidden" name="username" class="nkod" id="username" value="<?php echo $_SESSION['username'] ?>"/>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="hidden" name="token" class="nkod" id="token" value="<?php echo getToken($dic) ?>"/>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="changesubmit"></label>	
                            </td>
                            <td>
                                <input type="submit" name="changesubmit" value="<?php echo $l['CHANGE_PASS'] ?>" class="changesubmit" id="changesubmit"/>
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
