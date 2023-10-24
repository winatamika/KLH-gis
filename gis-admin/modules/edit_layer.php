
<article class="module width_full">
<?php
if (isset($_POST[update])){
	$article_warning='';
	
	if(isset($_FILES['file']['tmp_name']))
    {
     
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
            // check if there is a file in the array
            if(!is_uploaded_file($_FILES['file']['tmp_name']))
            {
                $messages[] = 'No file uploaded';
            }

			elseif($extension=="json"){
				$messages[] = "File extension not allowed, image file only";
				}
            else
            {
                // copy the file to the specified dir 
               	$namafile=$_POST["nama-file-lama"];
                // copy the file to the specified dir 
               move_uploaded_file($_FILES['file']['tmp_name'],'../'.$namafile);
			   //upload file dengan nama yg acak dengan mengappend unixtimestamp agar tidak terjadi kesamaan nama file
      			
      
            }
        
    }
	
	
	if($_GET[tipe]=="polygon"){	
	
	$legend_update=implode(";",$_POST["legend"]);
	$legend_color=implode(";",$_POST["color"]);
	
	$query="UPDATE `polygon` SET `title`='$_POST[title]',`category`='$_POST[category]',`legend`='$legend_update',`color`='$legend_color',`legendfield`='$_POST[legend_field]',`tahun`='$_POST[tahun]' WHERE `id`=\"$_GET[id]\"";
	
	mysql_query($query) or die(mysql_error()."with query $query");
	if($article_warning==''){
	$article_warning="
	
	<div class=\"alert alert-success\" role=\"alert\">Layer berhasil di update</div>";
	
	

	}
	else{
		$article_warning="
		<div class=\"alert alert-warning\" role=\"alert\">Semua data harus di isi</div>";
		}
	}
	
	else if($_GET[tipe]=="polyline"){
	$legend_update=implode(";",$_POST["legend"]);
	$legend_color=implode(";",$_POST["color"]);
	
$query="UPDATE `polyline` SET `title`='$_POST[title]',`category`='$_POST[category]',`legend`='$legend_update',`color`='$legend_color',`legendfield`='$_POST[legend_field]',`tahun`='$_POST[tahun]' WHERE `id`=\"$_GET[id]\"";
	
	mysql_query($query) or die(mysql_error()."with query $query");
	if($article_warning==''){
	$article_warning="<h4 class=\"alert_success\">Layer berhasil di update.</h4>";
	}
	else{
		$article_warning="<h4 class=\"alert_error\">Semua data harus di isi.</h4>";
		}
	
	}
	else if($_GET[tipe]=="marker"){
/*$query="SELECT `icon`,`legend` WHERE `id`=\"$_GET[id]\"";

$select_icon=mysql_fetch_array(mysql_query($query) or die(mysql_error()."with query $query"));
$delete_icon=explode(";",$select_icon);
foreach($delete_icon as $delete_icon_item){
unlink('../../'.$delete_icon_item);
}*/

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
                $messages[] = 'No file uploaded';
            }

			elseif(!in_array($extension, $allowedExts)){
				$messages[] = "File extension not allowed, image file only";
				}
            else
            {
                // copy the file to the specified dir 
               	$namafile=str_replace(".".$extension,"",$_FILES['icon']['name'][$i]); //extension harus ditambahkan titik
                // copy the file to the specified dir 
               copy($_FILES['icon']['tmp_name'][$i],'../'.$upload_dir.'/'.$namafile.time().".".$extension);
			   //upload file dengan nama yg acak dengan mengappend unixtimestamp agar tidak terjadi kesamaan nama file
      			$icon[]=$upload_dir.'/'.$namafile.time().".".$extension;
      
            }
        }
    }

$legend_update=implode(";",$_POST["legend"]);
//$legend_icon=implode(";",$_FILES['icon']['name']);
$legend_icon_lama=implode(";",$_POST["icon_lama"]);
if(isset($_FILES['icon']['name'])){
	
	$icon_update=';'.implode(";",$icon);
	}

$query="UPDATE `marker` SET `title`='$_POST[title]',`icon`='$legend_icon_lama$icon_update',`legend`='$legend_update',`category`='$_POST[category]',`legendfield`='$_POST[legend_field]',`tahun`='$_POST[tahun]' WHERE `id`=\"$_GET[id]\";";

mysql_query($query) or die(mysql_error()."with query $query");
if($article_warning==''){
$article_warning="<h4 class=\"alert_success\">Layer berhasil di update.</h4>";
}
else{
	$article_warning="<h4 class=\"alert_error\">Semua data harus di isi.</h4>";
	}

}
	
}

if (isset($_GET[id])){
	if($_GET[tipe]=="polygon"){
	$query="SELECT `title`, `category`,`file`,`legend`,`color`,`legendfield`,`tipe`,`tahun` FROM $_GET[tipe] WHERE `id`=\"$_GET[id]\"";
	}
	if($_GET[tipe]=="polyline"){
	$query="SELECT `title`, `category`,`file`,`legend`,`color`,`legendfield`,`tipe`,`tahun` FROM $_GET[tipe] WHERE `id`=\"$_GET[id]\"";
	}
	elseif($_GET[tipe]=="marker"){
	$query="SELECT `title`, `category`,`file`,`legend`,`tipe`,`icon`,`legendfield`,`tahun` FROM $_GET[tipe] WHERE `id`=\"$_GET[id]\"";
	}
$admin=mysql_fetch_array(mysql_query($query) /*or die(mysql_error()."with query $query")*/);
	}
	



/*echo"<script type='text/javascript'>location.href=\"$_POST[redirect]&action=add&msg=Successfully added the links!\"</script>";*/

/*
echo 'Here is some more debugging info:';
print_r($_FILES);*/
?>

<h2 class="tabs_involved">Edit Layer</h2>
<hr />

<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this);" role="form">


<table id="edit-layer-table" class="table table-striped" cellspacing="0"> 
<tr><td>Title: </td><td><input type="text" name="title" value="<?=$admin[title];?>" class="form-control"/></td></tr>
<tr><td>Legend Field: </td><td><input type="text" name="legend_field" value="<?=$admin[legendfield];?>" class="form-control"/></td></tr>
<tr><td>Tahun: </td><td>
<input class="valid form-control" name="tahun" size="16" type="number" value="<?=$admin[tahun];?>" min="1998" max="2099"  placeholder="Tahun" ></td></tr>
<tr><td>Category </td><td><select name="category" class="form-control">
<?php echo'<option>'.$admin[category].'</option>'; 
$q=mysql_query("SELECT `category` FROM `categories` WHERE `category`!='$admin[category]'");
while ($category=mysql_fetch_array($q)){
	echo'<option>'.$category[category].'</option>'; 
	} 
?>
</select></td></tr>

<tr><td>Layer Terupload: </td><td><input type="text" value="<?=$admin["file"];?>" name="nama-file-lama" /></td></tr>

<tr><td>Layer Baru: </td><td><input type="file" id="file" name="file"></td></tr>

<?php if($_GET[tipe]=="polygon" || $_GET[tipe]=="polyline"){?>

<tr>

<td valign="middle"><h4>Legend</h4></td>

<td nowrap="nowrap">

	<span><input type="button" onclick="remove_legend()" value="remove legend terakhir" id="remove-legend" class="btn btn-danger btn-sm" /></span>

	<span><input type="button" onclick="add_legend()" value="tambah legend" id="add-legend" class="btn btn-warning btn-sm" /></span>

</td></tr>

<?php }else if($_GET[tipe]=="marker"){?>


<tr><td><h4>Legend</h4></td>

<td nowrap="nowrap">
	<span><input type="button" onclick="remove_legend()" value="remove legend terakhir" id="remove-legend" class="btn btn-danger btn-sm" /></span>
<span><input type="button" onclick="add_legend_marker()" value="tambah legend" id="add-legend-marker" class="btn btn-warning btn-sm"/></span></td></tr>

<?php }?>

<?php
$num=0;
if($admin["tipe"]=='marker'){
$legend=explode(";",$admin["legend"]);
$icon=explode(";",$admin["icon"]);
	
	
	foreach ($legend as &$legend_val) {
	echo"
	<tr class=\"legend_lama\"><td>
	

	 		<div class=\"input-group\">
	 		 <div class=\"input-group-addon\">".($num+1).".</div>
	 		 <input type=\"text\" value=\"$legend_val\" name=\"legend[]\" placeholder=\"Nama Legend\" class=\"form-control input-sm\" /></td><td><img class=\"legend-image\" src=\"../$icon[$num]\">
	 		</div>
	 		<input name=\"icon_lama[]\" type=\"hidden\" value=\"$icon[$num]\"/>
	</td></tr>";
	$num++;
	}
	
	
}
else if($admin["tipe"]=='polygon'){
$legend=explode(";",$admin["legend"]);
$color=explode(";",$admin["color"]);
	foreach ($legend as &$legend_val) {
	echo"
	
	<tr><td>
	
	<div class=\"input-group\">
	      <div class=\"input-group-addon\">".($num+1)."</div>

	      <input type=\"text\" value=\"$legend_val\" name=\"legend[]\" placeholder=\"Nama Legend\" class=\"form-control\" />
	      
      </div>
 
	</td>
	  
	<td><input type=\"color\" name=\"color[]\" value=\"$color[$num]\">
	
	
	</td></tr>";
	$num++;
	}
}
else if($admin["tipe"]=='polyline'){
$legend=explode(";",$admin["legend"]);
$color=explode(";",$admin["color"]);
	foreach ($legend as &$legend_val) {
	echo"<tr><td>
	<div class=\"input-group\">
      <div class=\"input-group-addon\">".($num+1)."</div>
      	<input type=\"text\" value=\"$legend_val\" name=\"legend[]\" placeholder=\"Nama Legend\" class=\"form-control\" />
      </div>
    </td>
	<td>
	<input type=\"color\" name=\"color[]\" value=\"$color[$num]\" class=\"form-control\">
	</td></tr>";
	$num++;
	}

}
?>
</table>
<input type="submit" name="update" class="btn btn-sm btn-success" />
</form>

<script type="text/javascript">
var legend_no=<?=$num?>;
  function add_legend() {
	legend_no++;
	
	$('table#edit-layer-table').append('<tr><td><div class=\"input-group\"><div class=\"input-group-addon\">'+legend_no+'</div><input type="text" class=\"form-control\" name="legend[]" placeholder="Nama Legend" /></div></td><td><input type="color" name="color[]" value=""/></td></tr>');
	}
	
	
	function add_legend_marker() {
	legend_no++;
	
	$('table#edit-layer-table').append('<tr><td><div class=\"input-group\"><div class=\"input-group-addon\">'+legend_no+'.</div><input type="text" name="legend[]" placeholder="Nama Legend"  class=\"form-control\"/></div></td><td><input type="file" name="icon[]" value="" class=\"form-control\"/></td></tr>');
	}
	
	function remove_legend(){
	if(!$('table#edit-layer-table tr:last').hasClass("legend_lama")){ //tidak merupakan legend yang diinput saat insert untuk marker
	$('table#edit-layer-table tr:last').remove();
	legend_no--;
	}
	}
</script>

<script type="text/javascript">

function checkForm(form)
  {
    if(form.title.value == "") {
      alert("Error: title cannot be blank!");
      form.title.focus();
      return false;
    }
    return true;
  }
</script>

</article>

<?php echo "$article_warning"; ?>