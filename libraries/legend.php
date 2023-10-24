<?php
require_once '../config.php';
require_once "koneksi.php";
//$tahun=$_POST['tahun'];
$kategori=$_POST['kategori'];
$id=$_POST['id'];
//$hasil = array($kategori,$tahun,'1','1');

unset($hasil);
$hasil = array();

if($kategori=='polygon'){

$query=mysql_query("SELECT title,`legend`,`color`,tipe FROM `polygon` WHERE`id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=explode(';',$layer['legend']);
$hasil[1]=explode(';',$layer['color']);
$hasil[2]=$layer['title'];
$hasil[3]=$layer['tipe'];
}

else if($kategori=='polyline'){

$query=mysql_query("SELECT title,`legend`,`color`,tipe FROM `polyline` WHERE `id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=explode(';',$layer['legend']);
$hasil[1]=explode(';',$layer['color']);
$hasil[2]=$layer['title'];
$hasil[3]=$layer['tipe'];
}

else if($kategori=='marker'){

$query=mysql_query("SELECT title,`legend`,`icon`,tipe FROM `marker` WHERE `id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=explode(';',$layer['legend']);//file_get_contents("$layer[file]");
$hasil[1]=explode(';',$layer['icon']);
$hasil[2]=$layer['title'];
$hasil[3]=$layer['tipe'];
}


/*file_get_contents("$layer[file]");*/
echo json_encode($hasil);
?>