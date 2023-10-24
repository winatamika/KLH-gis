<?php

$link = mysql_connect($server, $username, $password);
if (!$link) {
    die('Could not connect ' . mysql_error());
}
mysql_select_db($database, $link);
?>