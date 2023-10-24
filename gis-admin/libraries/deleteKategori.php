<?php 
require_once "../../config.php";
require_once "../../".LIBPATH."koneksi.php";
// harus tersisa minimal 1 admin

mysql_query("DELETE FROM `categories` WHERE `category`=\"$_POST[id]\"") or die(mysql_error());
echo"Kategori berhasil di delete.";


?>