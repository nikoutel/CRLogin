<?php

session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
} else {
    $error = '';
}
$str = <<<ERROR
    An error has occurred <br />\n
    Guru meditation:<br />\n<br />\n
    $error
    <br />\n<br />\n
ERROR;
echo $str;
if (isset($_SESSION['reinstall']) && ($_SESSION['reinstall'] === TRUE)){
    echo 'Please try to re-<a href = "install/index.php">install</a>';
        
}
session_destroy();
