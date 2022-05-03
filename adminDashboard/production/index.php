<?php
session_start(); 

   if(!isset($_SESSION['userId']))
    { $url_denied = 'page_403?error_log=NO';  header("Refresh:5; url=$url_denied", true, 303); }

   else
   {

    require_once '../../config/connections/constant_connection.php';
    require_once '../../config/constant_define/constants.php';
    require_once 'functions/admin_control_functions.php'; 
  
    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $_SESSION['merchID'] = $merchantId; //Pass merchant ID into a session

    $merchant_email = $getDetails['merchant_email'];
    $merchant_type = $getDetails['merchant_type_name'];
    $merchant_name = $getDetails['merchant_name'];

     $logo_path = '../../logos/'; 
     $logo = $logo_path.$getDetails['logo'];

     if($_SESSION['merchID'] == 0)
     {
       $merchant_email = 'helpdesk@paytonify.ng';
       $current_session = date('Y');
       $merchant_type = 'Payment Gateway';
       $logo  = $logo_path.'paytonify-logo.png';
       $merchant_name = 'Paytonify Administration';
     }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Dashboad | Paytonify </title>
    <link rel="shortcut icon" href="../../images/paytonify-logo-mini.png" />


    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- JQUery Smart Wizard -->
    <link href="../vendors/jQuery-Smart-Wizard/styles/smart_wizard.css" rel="stylesheet" type="text/css">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

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

  </head>

  <body class="nav-md" onload="load_landing_page()">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="../../" class="site_title"> <span> <img src="../../images/paytonify-logo-mini.png" /> Paytonify </span></a>
            </div>

            <div class="clearfix"></div>

            
          <!-- Side Bar Nav -->
           <?php include_once ('includes/sidebar-nav.php') ?>

          </div>
        </div>
         
         <!-- Top Bar Nav -->
         <?php include_once ('includes/topbar-nav.php') ?>

        <!-- Page Top Content -->
        <div class="right_col" role="main">          
          <div class="row tile_count">
             <?php include_once ('includes/pagetop-content.php') ?>
          </div>
        </div>


          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-8">
                    <span> <h3>
                     <?php 
                        
                          echo '<img src="'.$logo.'" width="60px" height="60px" class="img-circle" />';
                          echo  $merchant_name; 
                      ?> 
                    <small><i class="fa fa-angle-double-right"></i> Dashboard </small></h3> 
                   </span>
                  </div>
                
                <div class="col-md-4">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
               </div>
              </div>

             <h4> <i class="fa fa-toggle-on"> </i> SETUP INFO: </h4>

              <div class="x_title_cont">

                  <span> <i class="fa fa-university"> </i> Merchant Type: <small> <?php  echo $merchant_type; ?></small> </span> <i class="fa fa-angle-double-right"></i> 
                  <span> <i class="fa fa-envelope"> </i> Merchant Official Email: <small> <?php  echo $merchant_email; ?></small>  </span> <i class="fa fa-angle-double-right"></i> 
                  <span> <i class="fa fa-calendar"> </i> Merchant Current Financial Year: <small> <?php  echo $current_session; ?></small> 
                  </span>

              </div> <br/>
                        
                        <p id="main_operation_canvas"></p>

                       <div class="clearfix"></div>
              
          </div>
       </div>
    </div>
  <br />         
              
              
        
      </div>
    </div>

 <!-- Footer -->
        <?php include_once ('includes/footer.php'); ?>



<!-- Modal Profile -->
<div class="modal fade" id="modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
    <!-- Modal Header 
     <div class="modal-header">
        <h5 class="modal-title pull-left" id="modalLabel">User Login:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       -->
      
      <div class="modal-body"> 
           
      <?php include 'ajax_main/admin_users_profile_edit.php'; ?>
      </div>
      
     <!-- Modal Footer
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="verify-close" data-dismiss="modal">Discard</button>
        <button type="button" class="btn btn-warning" id="btn-verify" > Login Now </button>
      </div>
      -->

    </div>
  </div>
</div>
<!-- Modal Login Ends -->

    <!-- jQuery -->

    <script src="https://www.gstatic.com/charts/loader.js"></script>   

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Jquery Validate -->
    <script src="../vendors/jquery-validate/dist/jquery.validate.min.js"></script>

    <!-- jQuery Smart Wizard -->
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>


<script type="text/javascript">    
 
    function load_landing_page(){
       
      $('#main_operation_canvas').load('ajax_main/ajax_home_page');
    } 

    $(document).ready(function(){ load_landing_page();  });


function logAdminOut()
{
   var logout = 'logOut';
    window.location.href = logout;
}



</script>
	
  </body>
</html>
<?php } ?>