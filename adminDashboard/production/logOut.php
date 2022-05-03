<?php
session_start();

    require_once '../../config/connections/constant_connection.php';
    require_once '../../config/constant_define/constants.php';
    require_once 'functions/admin_control_functions.php'; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title> Dashboad | Paytonify </title>
    <link rel="shortcut icon" href="../../images/paytonify-logo-mini.png" />

    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

 <script type="text/javascript">   
   // NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
}
 </script>

 <style type="text/css">
 @import url(https://fonts.googleapis.com/css?family=Amiko);
	
 	.logs
  {
    font-family: 'Amiko', serif;
    font-size: 16px;
    color: #999;
    display: block;
    text-align: center;
    margin-top: 230px;
    font-weight: bold;
 }
 </style>

  </head>

<body style="background: #FFF">

  <div class="logs">

				<?php

				function throw_ex($err)
				{
					throw new Exception($err);
				}

				try
				{
						if(isset($_SESSION['userId']))
						{

				         echo '<i class="fa fa-spin fa-4x fa-cog fa-fw"> </i> Please wait...Logging Out ';

							$logoutMsg = 'User session Terminated';

						   session_unset($_SESSION['userId']);
						   session_destroy();
						   session_write_close();

						   $url = 'http://' . $_SERVER['HTTP_HOST'].'/pay2/';
						
							  header("Refresh:5; url=$url?logout=$logoutMsg", true, 303);

						}
						else
						{
							throw_ex('Fatal Error - Logout operation failed');
						}

				}
				catch(Exception $e)
				{
					echo 'Error: '.$e;
				}

				?>

</div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

 </body>
 </html>