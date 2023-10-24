<?php 
$allowedExts = "geojson";
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ($extension==$allowedExts) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    if (file_exists($layer_upload_directory. $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      
	  move_uploaded_file($_FILES["file"]["tmp_name"],'../'.$layer_upload_directory."/".$_FILES["file"]["name"]);
    }
  }
}

?>