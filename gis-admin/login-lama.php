<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<script type="text/javascript">
</script>
<title>Admin Login</title>
<link rel="shortcut icon" href="../images/logo.jpg"> 
</head>
<body>
<center>
<div id="batas-luar">
    <div id="login">
    	<div id="login-kiri">
        	<font class="head1">Login</font>
            <form action="proses_login.php" enctype="multipart/form-data" method="post">
            <table cellpadding="0" cellspacing="12" id="tabel">
            	<tr>
                	<td>username:</td>
                    <td><input type="text" id="user_panel" class="text_login" name="username" value=""></td>
                </tr>
                <tr>
                	<td>password:</td>
                    <td><input type="password" id="pass_panel" class="text_login" name="password" value=""></td>
                </tr>
                <tr>
                	<td></td>
                    <td align="right"><input type="submit" id="button" class="login_btn" value=""></td>
                </tr>
                <tr>
                	<td colspan="2"><?php
                    	if(isset($_REQUEST['password'])){ ?>
							<img src="images/icn_alert_error.png" style="vertical-align: middle"> <font class="info">Username is required!</font>
						<?php }if(isset($_REQUEST['password'])){ ?>
							<img src="images/icn_alert_error.png" style="vertical-align: middle"> <font class="info">Password is required!</font>
						<?php }if($_GET['error']==1){ ?>
							<img src="images/icn_alert_error.png" style="vertical-align: middle"> <font class="info">Username and/or password incorrect!</font>
						<?php }
					?></td>
                </tr>
            </table>
            </form>
        </div>
        <div id="login-kanan">
        	<font class="head1">Kenapa login?</font><br/>
            <font class="info">Keamanan dan kerahasiaan sistem anda adalah yang nomor satu!</font>
            <br/><br/>
            Dengan login memungkinkan kerahasiaan data anda tersimpan dengan aman, sehingga tidak semua orang dapat membukanya.
            <br/><br/>
        </div>
        <div class="normal"></div>
    </div>
</div>
</center>
</body>
</html>