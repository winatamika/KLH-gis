<article class="module width_full">
<?php
$article_warning='';

	
if (isset($_POST[update])){

$query="UPDATE `categories` SET `category`=\"$_POST[category]\" WHERE `category`=\"$_GET[id]\"";

mysql_query($query) or die(mysql_error()."with query $query");

$article_warning="<h4 class=\"alert_success\">Berhasil di update.</h4>";

}

if (isset($_GET[id])){
	$query="SELECT `category` FROM `categories` WHERE `category`=\"$_GET[id]\"";

$admin=mysql_fetch_array(mysql_query($query) /*or die(mysql_error()."with query $query")*/);
	}


/*echo"<script type='text/javascript'>location.href=\"$_POST[redirect]&action=add&msg=Successfully added the links!\"</script>";*/

/*
echo 'Here is some more debugging info:';
print_r($_FILES);*/
?>
<header><h3 class="tabs_involved">Edit Kategori</h3></header>
<form method="post" enctype="multipart/form-data" onsubmit="return checkForm(this);">
<table class="tablesorter" cellspacing="0"> 
<tr><td>Nama: </td><td><input type="text" name="category" required value="<?php echo $admin[category];?>" class="form-control"/></td></tr>
<tr><td></td><td><input type="submit" name="update" class="btn btn-sm btn-success" /></td></tr>
</table>
</form>
<script type="text/javascript">

function checkForm(form)
  {
    if(form.category.value == "") {
      alert("Error: Category cannot be blank!");
      form.category.focus();
      return false;
    }
    return true;
  }
</script>
</article>

<?php echo "$article_warning"; ?>