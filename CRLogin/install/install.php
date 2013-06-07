<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=100" />
        <title>CRLogin installation</title>
        <link href="install.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            if (typeof jQuery == 'undefined') {
                document.write(unescape("%3Cscript src='CRLogin/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
        <script type="text/javascript" src="intall_scripts.js"></script>
    </head>
    <body>
        <div id="container" class="">
            <div  id="formdiv">
                <div class="text">
                    <h1>das board installation</h1>
                    <h2>Pre-Installation checks</h2>
                    <p>Checks are done to ensure that you are able to install and run 'Das Board'.</p>
                </div>
                <table id="check">
                    <tbody>
                        <tr>
                            <td><?php echo $phpVersionTxt ?></td>
                            <td>
                                <span class="<?php echo $phpVersionCheck['cssClass'] ?>">
<?php echo $phpVersionCheck['flag'] ?>
                                </span>
                            </td>
                            <td><?php echo $phpVersionCheck['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $configFileTxt ?></td>
                            <td>
                                <span class="<?php echo $configExists['cssClass'] ?>">
<?php echo $configExists['flag'] ?>
                                </span>
                            </td>
                            <td><?php echo $configExists['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $configFileWritableTxt ?></td>
                            <td>
                                <span class="<?php echo $configWritable['cssClass'] ?>">
<?php echo $configWritable['flag'] ?>
                                </span>                    
                            </td>
                            <td><?php echo $configWritable['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $dbExtensionTxt ?></td>
                            <td>
                                <span class="<?php echo $dbAvailable['cssClass'] ?>">
<?php echo $dbAvailable['flag'] ?>
                                </span>                  
                            </td>
                            <td><?php echo $dbAvailable['msg'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="<?php echo $installScriptName ?>?s=form" method="post" id="nexts">
            <br />
            <input type="submit" value="Next"  id="next" <?php echo $isDisabled ?>/>
        </form>
    </body>
</html>