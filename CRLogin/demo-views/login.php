<?php
if (count(get_included_files()) == 1) {
    header("location: /index.php?s=login");
    die();
}
$base = realpath($_SERVER["DOCUMENT_ROOT"]);
require $base . '/CRLogin/inc/public_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['LOGIN_LINK'] ?></title>
        <link href="/CRLogin/demo-views/login.css" rel="stylesheet" type="text/css" />
        <?php require $base . '/CRLogin/inc/head.inc.php'; ?>
    </head>
    <body>
        <div id="top">

            <div id="noscript">
                <?php echo $l['NO_SCRIPT'] ?> 
            </div>

            <div id="lgerror"></div> 
            <form action="" method="post" id="lg">
                <fieldset ><br /><br />
                    <label for="username"><?php echo $l['USERNAME'] ?>:</label> 
                    <input type="text" name="username" class="txt" id="username"/><br />
                    <label for="password"><?php echo $l['PASSWORD'] ?>:</label> 
                    <input type="password" name="password" class="txt" id="password"/><br />	
                    <input type="hidden" name="token" id="token" value="<?php echo getToken($dic) ?>"/><br />
                    <label for="lgsubmit"></label>	
                    <input type="submit" name="submit" value="<?php echo $l['LOGIN'] ?>" class="subm" id="lgsubmit" disabled="disabled"/>
                </fieldset>	
            </form>
            <div id="msg" ></div>
        </div>
    </body>
</html>
