<?php
require 'public_area.inc.php';
if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
    echo '<a href="index.php?s=login">Login</a>';
} else {
    echo '<a href="index.php?s=logout">Logout</a>';
}
?>
<br />
This is main