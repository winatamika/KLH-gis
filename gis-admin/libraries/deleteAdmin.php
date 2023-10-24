<?php 
require_once "../../config.php";
require_once "../../".LIBPATH."koneksi.php";
// harus tersisa minimal 1 admin
$jumlah=mysql_fetch_array(mysql_query("select count(id) as jumlah , username from user"));

if ($jumlah[jumlah]!="1"){
mysql_query("DELETE  FROM `user` WHERE `id`=\"$_POST[id]\"");
echo" User berhasil di delete.";
}
else{
	echo"Harus tersisa minimal 1 admin.";
	}

?>