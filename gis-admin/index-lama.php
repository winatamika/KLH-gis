<?php require_once "../config.php";
require_once "../".LIBPATH."koneksi.php";
session_start();
if ( !isset($_SESSION[id]) || !isset($_SESSION[username])){
	header("location: login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Admin Panel</title>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.pager.js" type="text/javascript"></script>    
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
	if ($(".tablesorter").find("tr").size() > 1)
    {	
   		$(".tablesorter").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager"), size: 10});
	}
	
	$(".tablesorter2").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager2"), size: 10});

	});
    </script>
 
</head>
<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.php">Website Admin</a></h1>
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="../index.php" target="_blank">View Site</a></div>
           
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo "Welcome ".$_SESSION[username] ?> </p>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="index.php">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
		</div>
	</section><!-- end of secondary bar -->
	
	<div id="sidebar" class="column">
		<h3>Content</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="index.php?link=upload">Upload Layer</a></li>
            <li class="icn_new_article"><a href="index.php?link=view_layer">View Layer</a></li>
            <!--<li class="icn_new_article"><a href="index.php?link=kontak">Contact</a></li>-->
		</ul>
       <h3>Admin</h3>
       	<ul class="toggle">
			<li class="icn_add_user"><a href="index.php?link=view_admin">Edit/Add New Admin</a></li> <!--icn_view_users-->
<!--			<li class="icn_profile"><a href="#">Your Profile</a></li>-->
		</ul>
        
		<h3>Accsess</h3>
		<ul class="toggle">
<!--			<li class="icn_settings"><a href="#">Options</a></li>
			<li class="icn_security"><a href="#">Security</a></li>-->
			<li class="icn_jump_back"><a href="proses_logout.php">Logout</a></li>
		</ul>
		
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2013 Smoked Garage Bali Web Admin</strong></p>
			<p>Handcrafted Code by <a target="_blank" href="http://81designstudios.com">81designstudios.com</a></p>
		</footer>
     <!-- <div class="spacer"></div>-->
	</div><!-- end of sidebar -->
	
	<section id="main" class="column">
	
            
        <?php 
	if (!empty($_GET['link']))
	{
		$link=$_GET['link']; 
		require_once("controller.php");
		require_once($dest); 
	}
	else
	{
		//require_once("modules/article_manager.php");  
	}
	?> 
		<div class="spacer"></div>
	</section>


</body>

</html>