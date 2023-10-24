<?php
//require_once('config.php');

switch ($link){
	/*case NULL:
	  $dest=MODULPATH."home.php";
	  break;*/
	  //controler anggota menu
	  	  
	   
	  case "view_admin":
	  $dest=MODULPATH."view_admin.php";
	  break;
	  
	  case "front_slide":
	  $dest=MODULPATH."front_slide.php";
	  break;
	  case "upload":
	  $dest=MODULPATH."upload_layer.php";
	  break;
	  case "category":
	  $dest=MODULPATH."view_kategori.php";
	  break;
	  case "view_layer":
	  $dest=MODULPATH."view_layer.php";
	  break;
	  
	  case "edit_admin":
	  $dest=MODULPATH."edit_admin.php";
	  break;
	  case "edit_category":
	  $dest=MODULPATH."editKategory.php";
	  break;
	  case "edit_layer":
	  $dest=MODULPATH."edit_layer.php";
	  break;
}
?>