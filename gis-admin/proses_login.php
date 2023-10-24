<?php
require_once "../config.php";
require_once "../".LIBPATH."koneksi.php";

$username=$_POST[username];
$password=MD5($_POST[password]);


$result=mysql_query("
	SELECT username,password, id,hak_akses
	FROM user
	WHERE username=\"$username\" 
	AND password=\"$password\"
") or die(mysql_error());
$row=mysql_fetch_array($result);

$numrows=mysql_num_rows($result);
if($numrows==1){
	//die("masuk");
	session_start();
	$_SESSION[username]=$row[username];
	$_SESSION[id]=$row["id"];
	$_SESSION[user_role]=$row["hak_akses"];
	
/*	$_SESSION['KCFINDER'] = array();
	$_SESSION['KCFINDER']['disabled'] = false;
	$_SESSION['KCFINDER']['uploadURL'] ="../../../images/gis_images";
	$_SESSION['KCFINDER']['deniedExts'] = "exe com msi bat php phps phtml php3 php4 cgi pl";
	$_SESSION['KCFINDER']['types'] = array(
   'images'   => "*img",
   'images/vehicle'   => "*img",
   'images/testimony'   => "*img",
   'images/need'   => "*img",
   'images/slides'   => "*img"
	);*/
/*	$_SESSION['KCFINDER']['uploadDir']="";*/
	
	header("location: index.php");
}
else {
	header("location: login.php?error=1");
}
?>