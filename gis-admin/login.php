<!DOCTYPE html>
<?php error_reporting(0); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GIS</title><!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="custom.css" rel="stylesheet" type="text/css"><!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'><!-- Favicons -->
    <link rel="icon" href="images/faveicon.png">
</head>

<body>
    <header>
        <div class="container">
            <div class="row">
                <!--  <div class="col-md-3 logo"><img src="images/logo-gis.png" alt="logo-gis" width="141" height="142"></div> -->

                <div>
                    <div class="row">
                        <div>
                            <center>
                                <h1>Login dulu - PPE Bali Nusra</h1>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div>
        <div class="container">
            <div class="mainCont backend">
                <div class="row">
                    <div class="col-md-12 login-wrapper">
                        <div class="logo-login"><img src="images/logo-gis.png" alt="logo-gis" width="141" height="142"></div>

                        <div class="mainContent-backend login-screen ">
                            <!-- alerts -->
<?php if($_GET[logout]=='success'){ ?>
	<div class="alert alert-danger" role="alert">
                                <strong>Log out Berhasil!</strong> Silahkan Login kembali untuk masuk ke halaman Admin.
                            </div>
	<?php } ?>
                            

                            <form role="form" action="proses_login.php" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label> <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label> <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                
                                <span><button type="submit" class="btn btn-sm btn-success">Submit</button></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container"></div>

    <div class="footer">
        <div class="container footer-note">
             <p>Copyright &copy; 2014 Pusat Pengelolaan Ekoregion(PPE) Bali Dan Nusa Tenggara Kementerian Lingkungan Hidup</p>
        </div>
    </div><!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.7.1.min.js" type="text/javascript">
</script><!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js" type="text/javascript">
</script>
</body>
</html>
