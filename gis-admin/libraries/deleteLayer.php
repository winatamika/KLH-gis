<?php 
require_once "../../config.php";
require_once "../../".LIBPATH."koneksi.php";
 //echo"$_POST[tipe] WHERE `id`=\"$_POST[id]\"";
//$_POST[tipe]==
$selectImage=mysql_query("SELECT `file` FROM `$_POST[tipe]` WHERE `id`=\"$_POST[id]\"") or die("cannot select because of". mysql_error());
$image=mysql_fetch_array($selectImage);
if ($image['file']!=''){
unlink('../../'.$image['file']);
}

if($_POST[tipe]=='marker'){
$selectImage=mysql_query("SELECT `icon` FROM `$_POST[tipe]` WHERE `id`=\"$_POST[id]\"") or die("cannot select because of". mysql_error());
$image=mysql_fetch_array($selectImage);
if ($image['icon'][0]!=''){
foreach(explode(";",$image['icon']) as $icon){
unlink('../../'.$icon);}
}
	}

mysql_query("DELETE FROM `$_POST[tipe]` WHERE id=\"$_POST[id]\"") or die("cannot delete because of". mysql_error());

echo" layer berhasil di delete.";
?>