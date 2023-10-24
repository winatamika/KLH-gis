<script type="text/javascript">
function delete_item(elem){
		var data = $(elem).parent().parent().attr("id").split("_");	
		var admin_id=data[0];
		var layer_tipe=data[1];

//var res = $(elem).parent().parent().attr("id").split(" ");		
//alert('id='+ admin_id+"&tipe="+layer_tipe);
if(confirm("Anda yakin ingin mendelete layer ini ?")==true){

var dataString = 'id='+ admin_id+"&tipe="+layer_tipe;  
//alert (dataString);return false;  
$.ajax({  
  type: "POST",  
  url: "libraries/deleteLayer.php",  
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
if (msg!="Harus tersisa minimal 1 admin."){
$($(elem).parent().parent()).fadeOut('normal', function() {$(this).remove();}); //, function() {$(this).remove();}
}
  }  
}); 

}

}

</script>

<article class="module width_full">
<h3>View/edit Layer</h3>
<hr/>
<div id="pager">
            <form>
		<img src="js/pager-icons/first.png" class="first">
		<img src="js/pager-icons/prev.png" class="prev">
		<input type="text" class="pagedisplay">
		<img src="js/pager-icons/next.png" class="next">
		<img src="js/pager-icons/last.png" class="last">
		<select class="pagesize">
			<option selected="selected" value="10">10</option>
			<option value="7">7</option>
			<option value="5">5</option>
		</select>
	</form>
            </div>

<table class="tablesorter table table-striped" cellspacing="0"> 
			<thead> 
				<tr> 
    					<th>Title</th>
                    <th>Tipe</th>
                    <th>Tahun</th>
    				 <th>Id</th>
                     <th>Category</th>
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 

<?php 
if($_SESSION[user_role]=="region admin"){
$query=mysql_query("(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `marker` WHERE id_user=$_SESSION[id])
					UNION
					(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `polygon` WHERE id_user=$_SESSION[id])
					UNION
					(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `polyline` WHERE id_user=$_SESSION[id])");
					
					}
else if($_SESSION[user_role]=="super admin"){
	$query=mysql_query("(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `marker`)
					UNION
					(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `polygon`)
					UNION
					(SELECT `title`,`tipe`,`id`,`category`,`tahun` FROM `polyline`)");
	}
while ($admin=mysql_fetch_array($query)){
echo"
<tr id=\"$admin[id]_$admin[tipe]\">
<td id=\"$admin[id]_title\">$admin[title]</td>
<td id=\"$admin[id]_tipe\">$admin[tipe]</td>
<td id=\"\">$admin[tahun]</td>
<td>$admin[id]</td>
<td id=\"$admin[id]_category\">$admin[category]</td>
<td><a style=\" margin-right: 0.5em;\" href=\"index.php?link=edit_layer&tipe=$admin[tipe]&id=$admin[id]\">
<span class=\"glyphicon glyphicon-pencil\"></span></a><input class=\"deleteAdmin\" type=\"image\" title=\"Delete\" onclick=\"javascript:delete_item(this)\" src=\"images/icn_trash.png\" title=\"Trash\"></td> 
</tr>";
}
?>
</tbody>
</table>

</article>