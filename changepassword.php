<?php
require 'members_area.inc.php';
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
                                <input type="hidden" name="user" class="nkod" id="user" value="<?php echo $_SESSION['user'] ?>"/>
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
