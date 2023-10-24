<?php 
error_reporting(0); 
require_once "../config.php";
require_once "../".LIBPATH."koneksi.php";
session_start();
if ( !isset($_SESSION[id]) || !isset($_SESSION[username])){
	header("location: login.php");
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GIS Admin</title><!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="custom.css" rel="stylesheet" type="text/css"><!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.pager.js" type="text/javascript"></script>    
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
	//alert($(".tablesorter").find("tr").size());
	if ($(".tablesorter").find("tr").size() > 1)
    {	
   		$(".tablesorter").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager"), size: 10});
	}
	if ($(".tablesorter2").find("tr").size() > 1)
    {
	$(".tablesorter2").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager2"), size: 10});
	}
	});
    </script>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'><!-- Favicons -->
    <link rel="icon" href="images/faveicon.png">
    
    <link rel="stylesheet" media="print">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3 logo-wrapper">
                	<div class="logo"><img src="images/logo-gis.png" alt="logo-gis" width="141" height="142"></div>
                </div>

                <div class="col-md-9 header-kanan">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="headTitle">Dashboard - PPE Bali Nusra</h1>
                        </div>

                        <div class="col-md-4">
                            <div class="view">
	                               <a href="../index.php" class="btn btn-default btn-xs" target="_blank"> <span class="glyphicon glyphicon-eye-open"></span> <span>view site</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <div class="container">
            <div class="mainCont backend">
                <div class="row">
                    <div class="col-md-3">
                        <div class="toolbar toolbar-side-backend">
                            <div class="sidebar-backend-container">
                                <div class="welcome">
                               
                                    <h5> <span class="glyphicon glyphicon-user"></span> <?php echo "<span>Welcome</span> "."<span class=\"username\">".$_SESSION[username]."</span>" ?></h5>
                                </div>

                                <div class="menu-group">
                                    <h2>Content Menu </h2>

                                    <ul class="sidebar-menu">
                                    <li class="icn_new_article"><a href="index.php?link=upload">Upload Layer</a></li>
            						<li class="icn_new_article"><a href="index.php?link=view_layer">View Layer</a></li>
                                    <li class=""><a href="index.php?link=category">View/Add Layer Category</a></li>
                                    </ul>
                                </div>
								<?php if($_SESSION[user_role]=='super admin'){ ?>
								
                                <div class="menu-group">
                                    <h2>Admin </h2>

                                     <ul class="sidebar-menu">
                                        <li class="icn_add_user"><a href="index.php?link=view_admin">Edit/Add New Admin</a></li> <!--icn_view_users-->
                                    </ul>
                                </div>
								<?php }?>
								
                                 <div class="menu-group">
                                    <h2>Access</h2>

                                    <ul class="sidebar-menu">
                                     <li class="icn_jump_back"><a href="proses_logout.php">Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 mainContent-backend">
                    
                   
                    
					     
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
                    </div>
                </div>
            </div>
        </div>
   
        <div class="container"></div>
        <br />
        </div>
    
      <div class="footer">
            <div class="container footer-note">
                <p>Copyright &copy; 2014 Pusat Pengelolaan Ekoregion Bali Dan Nusa Tenggara Kementerian Lingkungan Hidup</p>
            </div>
        </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>
