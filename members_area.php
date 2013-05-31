<?php
require 'members_area.inc.php';
echo 'hello member ';
echo $_SESSION['username'];
?>
<br />
<a href="index.php?s=logout">Logout</a><br />
<a href="index.php?s=changepassword">Change Password</a><br />
