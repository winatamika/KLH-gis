<article class="module width_full">
<?php
$article_warning='';
if (isset($_GET[id])){
	$query="SELECT `username`,`id` AS id, hak_akses, password FROM `user` WHERE `id`=\"$_GET[id]\"";

$admin=mysql_fetch_array(mysql_query($query) /*or die(mysql_error()."with query $query")*/);
	}
	
if (isset($_POST[update])){
if($_POST[nama]!=''){
$password="";
if($_POST[password_lama]!=''){
if(md5($_POST[password_lama])==$admin[password]){
$password= ",`password`=MD5(\"$_POST[password_baru]\")";
	}
else{
	$article_warning="<h4 class=\"alert_error\">Password lama anda salah.</h4>";
	}
}

$query="UPDATE `user` SET `username`=\"$_POST[nama]\" $password WHERE `id`=\"$_GET[id]\"";

mysql_query($query) or die(mysql_error()."with query $query");
if($article_warning==''){
$article_warning="<h4 class=\"alert_success\">Admin berhasil di update.</h4>";
}
}
else{
	$article_warning="<h4 class=\"alert_error\">Nama harus Diisi.</h4>";
	}
}


/*echo"<script type='text/javascript'>location.href=\"$_POST[redirect]&action=add&msg=Successfully added the links!\"</script>";*/

/*
echo 'Here is some more debugging info:';
print_r($_FILES);*/
?>
<header><h3 class="tabs_involved">Edit Admin</h3></header>
<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<table class="tablesorter" cellspacing="0"> 
<tr><td>Nama: </td><td><input type="text" name="nama" required value="<?php echo $admin[username];?>" class="form-control"/></td></tr>
<tr><td>ID: </td><td><input type="text" name="id" required disabled="disabled" value="<?php echo $admin[id]; ?>" class="form-control"/></td></tr>
<tr><td>Hak Akses </td><td><select name="hak_akses" required class="form-control"/>
<?='<option>'.$admin[hak_akses].'</option>'; echo($admin[hak_akses]=='super admin' ? '<option value="region admin">Region Admin</option>' : '<option value="super admin">Super Admin</option>'); ?>
</select></td></tr>
<tr><td>password sebelumnya: </td><td><input type="password" name="password_lama"  class="form-control"/></td>
</tr>
<tr><td>password baru: </td><td><input type="password" name="password_baru" class="form-control"/></td></tr>
<tr><td></td><td><input type="submit" name="update" class="btn btn-sm btn-success" /></td></tr>
</table>
</form>
<script type="text/javascript">

function checkForm(form)
  {
    if(form.nama.value == "") {
      alert("Error: Nama cannot be blank!");
      form.nama.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.nama.value)) {
      alert("Error: Nama must contain only letters, numbers and underscores!");
      form.nama.focus();
      return false;
    }
	if(form.password_lama.value== "") {
      alert("Error: Please fill your old password!");
      form.password_lama.focus();
      return false;
    }
    if(form.password_baru.value== "") {
      alert("Error: Please fill your new password!");
      form.password_baru.focus();
      return false;
    }
    return true;
  }
</script>
</article>

<?php echo "$article_warning"; ?>