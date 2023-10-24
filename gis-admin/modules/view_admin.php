<?php 
if (isset($_POST[submit_kategori])){
 if ($_POST[username]!=""){
	 $password=md5($_POST[password1]);
	mysql_query("INSERT INTO `user`(`hak_akses`,`username`,`password`) VALUES(\"$_POST[hak_akses]\",\"$_POST[username]\",\"$password\")") or die(mysql_error());
	$article_warning="<h4 class=\"alert_success\">Admin berhasil ditambahkan.</h4>";
}
else{
$article_warning="<h4 class=\"alert_error\">Nama belum diisi.</h4>";
}
}
?>

<script type="text/javascript">

function checkForm(form)
  {
    if(form.username.value == "") {
      alert("Error: Username cannot be blank!");
      form.nama.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.username.value)) {
      alert("Error: username must contain only letters, numbers and underscores!");
      form.nama.focus();
      return false;
    }
    if(form.password1.value != "" && form.password1.value != form.password2.value) {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password1.focus();
      return false;
    }
    return true;
  }

function delete_admin(elem){
var admin_id=$(elem).parent().parent().attr("id");
		var admin_nama=$("#"+admin_id+"_username").text();
		
		//alert(id);
if(confirm("Anda yakin ingin mendelete admin dengan id: "+ admin_id +" dan Nama: "+admin_nama+" ?")==true){

var dataString = 'id='+ admin_id;  
//alert (dataString);return false;  
$.ajax({  
  type: "POST",  
  url: "libraries/deleteAdmin.php",  
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
$("tr#"+admin_id).fadeOut('normal', function() {$(this).remove();}); //, function() {$(this).remove();}
}
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

<h3>View/edit Admin</h3>
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
    				<th>Nama</th>
                    <th>Hak Akses</th>
    				 <th>Id</th>
    				<th>Actions</th> 
				</tr> 
			</thead> 
			<tbody> 

<?php 
$query=mysql_query("SELECT `username`,`id`,`hak_akses` FROM `user`");
while ($admin=mysql_fetch_array($query)){
echo"
<tr id=\"$admin[id]\">
<td id=\"$admin[id]_username\"><strong>$admin[username]</strong></td>
<td id=\"$admin[id]_hak_akses\">$admin[hak_akses]</td>
<td>$admin[id]</td>
<td><a style=\" margin-right: 0.5em;\" href=\"index.php?link=edit_admin&id=$admin[id]\">
<span class=\"glyphicon glyphicon-pencil\"></span></a>

<input class=\"deleteAdmin\" type=\"image\" title=\"Delete\" onclick=\"javascript:delete_admin(this)\" src=\"images/icn_trash.png\" title=\"Trash\">

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
    
            <h4 class="tabs_involved">Add New Admin</h4>
            <hr />
      
        
        <article>
       
			
				<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="return checkForm(this);">
			
				<table class="table table-striped"> 
				<tr><td>Username: </td><td><input type="text" name="username" required class="form-control"/></td></tr>
				<tr><td>Password: </td><td><input type="password" name="password1" required pattern="\w+" onchange="form.password2.pattern = this.value;"/ class="form-control"></td></tr>
				<tr><td>Repeat password: </td><td><input type="password" name="password2" required pattern="\w+" class="form-control" /></td></tr>
				<tr><td>Hak Akses </td><td><select name="hak_akses" required class="form-control"/>
				<option value="">Pilih Hak Akses</option>
				<option value="region admin">Region Admin</option>
				<option value="super admin">Super Admin</option>
				</select></td></tr>
				<tr><td></td><td><input type="submit" name="submit_kategori" class="btn btn-success btn-sm"/></td></tr>
				</table>
				
				</form>

</article>
        
</div>

<br />

<?php echo $article_warning; ?>