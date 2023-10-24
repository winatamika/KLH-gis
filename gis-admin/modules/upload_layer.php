<?php 
//require_once("../../config.php");
//require_once("../".LIBPATH."function.php");

$layer_upload_directory='layer';

$filename="";

if(isset($_POST["submit-form"]) && $_POST["submit-form"]=="Submit"){
//echo "ANJINGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG" ;
/////////Upload File nya dulu
$allowedExts = "geojson";
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
$filename=""; //file untuk menyimpan nama file layer
if ($extension==$allowedExts) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    if (file_exists($layer_upload_directory. $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
     $namafile=str_replace(".".$extension,"",$_FILES['file']['name']);
	 
	 $filename=$layer_upload_directory."/".$namafile.time().".".$extension;
	 
                // copy the file to the specified dir 
      //copy($_FILES['icon']['tmp_name'][$i],'../'.$upload_dir.'/'.$namafile.".".$extension.time());
	  move_uploaded_file($_FILES["file"]["tmp_name"],'../'.$filename);//append unixtimestamp agar setiap file namanya pasti berbeda, untuk mencegak multiple deletion
    }
  }
}


/////////Upload File nya dulu
		
if($_POST["tipe"]=='polygon'){
		$legend=implode(";",$_POST[legend]);
		$color=implode(";",$_POST[color]);
		
mysql_query("INSERT INTO `polygon`(`title`,`category`,`file`,`tahun`,`legend`,`color`,`tipe`,`legendfield`,id_user) VALUES('$_POST[title]','$_POST[kategori]','".$filename."','$_POST[tahun]','$legend','$color','$_POST[tipe]','$_POST[legend_field]',$_SESSION[id])")or die(mysql_error());
	}
else if($_POST["tipe"]=='polyline'){
		$legend=implode(";",$_POST[legend]);
		$color=implode(";",$_POST[color]);
mysql_query("INSERT INTO `polyline`(`title`,`category`,`file`,`tahun`,`legend`,`color`,`tipe`,`legendfield`,id_user) VALUES('$_POST[title]','$_POST[kategori]','".$filename."','$_POST[tahun]','$legend','$color','$_POST[tipe]','$_POST[legend_field]',$_SESSION[id])")or die(mysql_error());
	}
	
	else if($_POST["tipe"]=='marker'){
		
	
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$upload_dir="images/marker";

    /*** check if a file has been submitted ***/
    if(isset($_FILES['icon']['tmp_name']))
    {
        /** loop through the array of files ***/
        for($i=0; $i < count($_FILES['icon']['tmp_name']);$i++)
        {
			$temp = explode(".", $_FILES["icon"]["name"][$i]);
			$extension = end($temp);
            // check if there is a file in the array
            if(!is_uploaded_file($_FILES['icon']['tmp_name'][$i]))
            {
                $article_warning="
		<div class=\"alert alert-warning\" role=\"alert\">Semua data harus di isi</div>";
            }

			elseif(!in_array($extension, $allowedExts)){
				$messages[] = "File extension not allowed, image file only";
				}
            else
            {
				$namafile=str_replace(".".$extension,"",$_FILES['icon']['name'][$i]); //extension harus ditambahkan titik
                // copy the file to the specified dir 
               copy($_FILES['icon']['tmp_name'][$i],'../'.$upload_dir.'/'.$namafile.time().".".$extension);
			   //upload file dengan nama yg acak dengan mengappend unixtimestamp agar tidak terjadi kesamaan nama file
      			$icon[]=$upload_dir.'/'.$namafile.time().".".$extension;
            }
        }
    }
		
		
		
		$legend="";
		if(!empty($_POST[legend])){//only supported by PHP 5.3
		$legend=implode(";",$_POST[legend]);
		}
		//$icon= new ArrayObject;
/*		foreach($_FILES['icon']['name'] as $result){ 
			$icon[] = $upload_dir.'/'.$result;  
		} */
		
		mysql_query("INSERT INTO `marker`(`title`,`category`,`file`,`tahun`,`legend`,`icon`,`tipe`,`legendfield`,id_user) VALUES('$_POST[title]','$_POST[kategori]','".$filename."','$_POST[tahun]','$legend','".implode(";",$icon)."','$_POST[tipe]','$_POST[legend_field]',$_SESSION[id])")or die(mysql_error());
		//$icon=implode(";",$upload_dir.'/'.);
	/*	
		echo"INSERT INTO `marker`(`title`,`category`,`file`,`tahun`,`legend`,`icon`,`tipe`,`legendfield`,id_user) VALUES('$_POST[title]','$_POST[kategori]','".$layer_upload_directory.'/'.$_FILES['file']['name']."','$_POST[tahun]','$legend','".implode(";",$icon)."','$_POST[tipe]','$_POST[legend_field]',".$_SESSION[id].")";*/

	}
	
	}
?>

<script type="text/javascript" src="js/jquery.js"></script>
<script>
var legend_no=1;

jQuery(window).load(function() {	
$('select[name=tipe]').on('change', function() {
	legend_no=1;
  console.log( this.value ); // or $(this).val()
  $('table#legend-table').empty();
  if(this.value=='polygon'){
	  $('table#legend-table').append(
	  '<tr><td><h3>Legend</h3></td><td><input type="button" class="btn btn-danger btn-sm" onclick="remove_legend()" value="remove legend terakhir" id="remove-legend-polygon"/><input class="btn btn-warning btn-sm" type="button" onclick="add_legend()" value="tambah legend" id="add-legend-polygon"/></td></tr> <tr><td>1.<input type="text" name="legend[]" placeholder="Nama Legend" /></td><td><input type="color" name="color[]" value=""/></td></tr>'
	  );
  }
  
  else if(this.value=='polyline'){
	  $('table#legend-table').append(
	  '<tr><td><h3>Legend</h3></td><td><input type="button" class="btn btn-danger btn-sm" onclick="remove_legend()" value="remove legend terakhir" id="remove-legend-polyline"/><input class="btn btn-warning btn-sm" type="button" onclick="add_legend()" value="tambah legend" id="add-legend-polyline"/></td></tr><tr><td>1.<input type="text" name="legend[]" placeholder="Nama Legend" /></td><td><input type="color" name="color[]" value=""/></td></tr>'
	  );
  }
  
  else if(this.value=='marker'){
	  $('table#legend-table').append(
	  '<tr><td><h3>Legend</h3> <span style="color:red;font-weight:bold;"> image size(20px X 20px)</span></td><td><input type="button" class="btn btn-danger btn-sm" onclick="remove_legend()" value="remove legend terakhir" id="remove-legend-marker"/><input type="button" class="btn btn-warning btn-sm" onclick="add_legend_marker()" value="tambah legend" id="add-legend-marker"/></td></tr><tr><td>1.<input type="text" name="legend[]" placeholder="Nama Legend" /></td><td><input type="file" name="icon[]" value=""/></td></tr>'
	  );
  }
  
});
});


  function add_legend() {
	legend_no++;
	
	$('table#legend-table').append('<tr><td>'+legend_no+'.<input type="text" name="legend[]" placeholder="Nama Legend" /></td><td><input type="color" name="color[]" value=""/></td></tr>');
	}
	
	  function add_legend_marker() {
	legend_no++;
	
	$('table#legend-table').append('<tr><td>'+legend_no+'.<input type="text" name="legend[]" placeholder="Nama Legend" /></td><td><input type="file" name="icon[]" value=""/></td></tr>');
	}
	
	function remove_legend(){
	$('table#legend-table tr:last').remove();
	legend_no--;
	}
</script>


<h3>Upload Layer</h3>
<hr />
<!-- bootstrap -->
<div>

<form class="form-horizontal" role="form" id="upload-layer" method="POST" enctype="multipart/form-data">

  
  	<div class="form-group layer-title ">
	  <label for="layer-title" class="col-sm-2 control-label">Layer title</label>
		  <div class="col-sm-10">
		  <input type="text" class="form-control" name="title" id="layer-title" placeholder="Layer Title">
		  </div>
	</div>
	 
	<div class="form-group kategori">
	  <label for="kategori" class="col-sm-2 control-label">Kategori</label>
		  <div class="col-sm-10">
			  <select class="form-control" name="kategori" required>
				  <?php 
					$query=mysql_query("SELECT `category` FROM `categories`") or die(mysql_error());
					for($i=1;$cat=mysql_fetch_array($query);$i++){
					echo"<option value=\"$cat[category]\">$cat[category]</option>";
					}
				?>

			</select>
		  </div>
	 </div>
	 
	 <div class="form-group tipe">
	  <label for="tipe" class="col-sm-2 control-label">Tipe</label>
		  <div class="col-sm-10">
			  <select class="form-control" name="tipe" required>
	            <option value="none">Pilih Tipe</option>
	            <option value="polygon">Polygon/Area</option>
				<option value="polyline">Polyline/Garis</option>
	            <option value="marker">Marker/Titik</option>
			</select>
		  </div>
	 </div>
	 
	 <div class="form-group tahun">
	  <label for="tahun" class="col-sm-2 control-label">Tahun</label>
		  <div class="col-sm-10">
			   <input class="valid" name="tahun" size="16" type="number" min="1998" max="2099" placeholder="Tahun">
		  </div>
	 </div>
	 
	 <div class="form-group file">
	  <label for="file" class="col-sm-2 control-label">File (.geojson)</label>
		  <div class="col-sm-10">
			  <input type="file" id="file" name="file">
		</div>
	 </div>
	 
	 <div class="form-group legend-field">
	  <label for="file" class="col-sm-2 control-label">Legend field</label>
		  <div class="col-sm-10">
			 <input type="text" class="form-control" name="legend_field" id="legend-field" placeholder="Nama field dari legend">
		</div>
	 </div>
	 
	 <div class="form-group submit-button">
	  <label for="file" class="col-sm-2 control-label">&nbsp;</label>
		  <div class="col-sm-10">
			 <input type="submit" class="btn btn-success btn-sm" name="submit-form" value="Submit"/>
		</div>
	 </div>
<table id="legend-table">

</table> 
	
	 
	</form>
</div>


<!-- eof bootstrap -->


</div>
