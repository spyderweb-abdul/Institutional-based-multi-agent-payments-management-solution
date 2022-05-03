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
					if(isset($_REQUEST['token']))
					{
					   $token = $_REQUEST['token'];
					   $auth = $_REQUEST['auth'];

						//Check user availability 
						$checkUser = $paydb->query("SELECT userId, secure_code, merchantId FROM ".USERS." WHERE userId = '$auth' AND secure_code = '$token' AND roleId <> '6' ") or throw_ex(mysqli_error($paydb));

						if(mysqli_num_rows($checkUser) == 1)
						{

                           $usr = $checkUser->fetch_array();

						  $_SESSION['userId'] = $auth; //Pass auth as the session ID
						  $_SESSION['token'] = $token; //Pass token as session

						  $merchantId = $usr['merchantId'];


									   echo '<i class="fa fa-spin fa-4x fa-cog fa-fw"> </i> Please Wait...authenticating';

									  header("Refresh:5; url=index", true, 303);
							
						}
						elseif(mysqli_num_rows($checkUser) > 1)
						{
							throw_ex('Multiple Users Identified');
						}
						else
						{
						  throw_ex('User\'s Identification Failed');

						}

					}
					else
					{
						throw_ex('Fatal - Trying to access unathorized page');
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