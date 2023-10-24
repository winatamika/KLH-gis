<?php 
if (isset($_POST[submit_kategori])){

	mysql_query("INSERT INTO `categories` VALUES(\"$_POST[kategori]\");") or die(mysql_error());
	$article_warning="<h4 class=\"alert_success\">Kategori berhasil ditambahkan.</h4>";
}
?>

<script type="text/javascript">

function checkForm(form)
  {
    if(form.kategori.value == "") {
      alert("Error: kategori cannot be blank!");
      form.kategori.focus();
      return false;
    }
    return true;
  }

function delete_item(elem){
var admin_id=$(elem).parent().parent().attr("id");
		var admin_category=$("#"+admin_id+"_category").text();
		
		//alert(id);
if(confirm("Anda yakin ingin mendelete item ini ?")==true){

var dataString = 'id='+ admin_id;  
//alert (dataString);return false;  
$.ajax({  
  type: "POST",  
  url: "libraries/deleteKategori.php",  
  data: dataString,  
  success: function(msg) {  
//    $('#contact_form').html("<div id='message'></div>");  
//    $('#message').html("<h2>Contact Form Submitted!</h2>")  
//    .append("<p>We will be in touch soon.</p>")  
//    .hide()  
//    .fadeIn(1500, function() {  
//      $('#message').append("<img id='checkmark' src='images/check.png' />");  
//    });
alert(msg);
//.fadeOut('normal')

$($(elem).parent().parent()).fadeOut('normal', function() {$(this).remove();}); //, function() {$(this).remove();}

  }  
}); 

}

}



$(document).ready(function(){ 
/*function delete_tenant(){
	alert("mejuu");
	}*/
//$('.deleteTenant').click(function(e) { 
										
			//});
});
</script>

<article class="module width_full">

<h3>View/edit Kategori</h3>
<hr />

<!-- pager 
*----------------------------* -->
<div id="pager">


<form role="form">
		<img src="js/pager-icons/first.png" class="first">
		<img src="js/pager-icons/prev.png" class="prev">
		<input type="text" class="pagedisplay">
		<img src="js/pager-icons/next.png" class="next">
		<img src="js/pager-icons/last.png" class="last">
		<select class="pagesize">
			<option selected="selected" value="10">10</option>
			<option value="7">7</option>
			<option value="9">9</option>
		</select>
</form>


</div>
<!-- eof pager -->



<br />
<hr />

<!-- table user
*----------------------------* -->

<div>
	<table class="tablesorter table table-striped"> 
			<thead> 
				<tr> 
    				<th>Kategori</th>
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 

<?php 
$query=mysql_query("SELECT `category` FROM `categories`");
for($i=1;$admin=mysql_fetch_array($query);$i++){
echo"
<tr id=\"$admin[category]\">
<td id=\"$admin[category]_category\"><strong>$admin[category]</strong></td>
<td><a style=\" margin-right: 0.5em;\" href=\"index.php?link=edit_category&id=$admin[category]\">
<span class=\"glyphicon glyphicon-pencil\"></span></a>

<input class=\"deleteAdmin\" type=\"image\" title=\"Delete\" onclick=\"javascript:delete_item(this)\" src=\"images/icn_trash.png\" title=\"Trash\">

</td> 
</tr>";
}
?>
</tbody>
</table>
</div>
<!-- eof table -->

<!-- table user
*----------------------------* -->

<div>
    
            <h4 class="tabs_involved">Tambahkan Kategori Baru</h4>
            <hr />
      
        
        <article>
       
			
				<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="return checkForm(this);">
			
				<table class="table table-striped"> 
				<tr><td>Kategori: </td><td><input type="text" name="kategori" required class="form-control"/></td></tr>
				<tr><td></td><td><input type="submit" name="submit_kategori" class="btn btn-success btn-sm"/></td></tr>
				</table>
				
				</form>

</article>
        
</div>

<br />

<?php echo $article_warning; ?>