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

$query=mysql_query("SELECT `title`,`category`,`file`,`legend`,`color`,`tipe`,`legendfield` FROM `polygon` WHERE `id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=$layer['file'];//file_get_contents("$layer[file]");
$hasil[1]=$layer['icon'];
$hasil[2]=$layer['title'];
$hasil[3]=explode(';',$layer['legend']);
$hasil[4]=explode(';',$layer['color']);
$hasil[5]=$layer['category'];
$hasil[6]=$layer['tipe'];
$hasil[7]=$layer['legendfield'];
}
 
else if($kategori=='polyline'){

$query=mysql_query("SELECT `title`,`category`,`file`,`legend`,`color`,`tipe`,`legendfield` FROM `polyline` WHERE `id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=$layer['file'];//file_get_contents("$layer[file]");
$hasil[1]=$layer['icon'];
$hasil[2]=$layer['title'];
$hasil[3]=explode(';',$layer['legend']);
$hasil[4]=explode(';',$layer['color']);
$hasil[5]=$layer['category'];
$hasil[6]=$layer['tipe'];
$hasil[7]=$layer['legendfield'];
}

else if($kategori=='marker'){

$query=mysql_query("SELECT `title`,`category`,`file`,`icon`,`legend`,`legendfield`,`tipe` FROM `marker` WHERE`id`='".$id."';") or die(mysql_error());
$layer=mysql_fetch_array($query);
$hasil[0]=$layer['file'];//file_get_contents("$layer[file]");
$hasil[1]=explode(';',$layer['icon']);
$hasil[2]=$layer['title'];
$hasil[3]=explode(';',$layer['legend']);
$hasil[6]=$layer['tipe'];
$hasil[7]=$layer['legendfield'];
}


/*file_get_contents("$layer[file]");*/
/*if(isset($hasil) && $hasil!=NULL){}
else{
	echo"Maaf data tidak tersedia, silahkan kontak admin untuk info yang lebih detail";
	}*/

echo json_encode($hasil);

?>