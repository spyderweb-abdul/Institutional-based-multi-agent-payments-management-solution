<?php
session_start();

include_once 'config/connections/constant_connection.php';
include_once 'config/constant_define/constants.php';

//$myRand = rand(0,1000);
//$mdHash = hash('sha512', $myRand);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/paytonify-logo-mini.png" />
<title>Paytonify</title>

<link href="plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/animate/animate.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/custom_css/style.css" rel="stylesheet" type="text/css" />



</head>

<body>

<?php include_once 'config/includes/navbar.php'; ?>

<div class="container">

<!-- Section One -->
<section class="section-sign">

<div style="margin-top: 80px; border-top: 4px solid #FC0; box-shadow: 2px 1px #999; "> </div>

<div class="cent-div">

   <h3> <span> <img src="images/paytonify-logo-mini.png" /><br/><br/> Signing up takes just a minute! </span></h3>

 <form name="signup-form" id="signup-form" >

  <div id="signup-result" style="padding: 10px; color: #FFF;"> </div>

  <div class="row">

   <div class="col-sm-12 col-md-12 col-xs-12"> 
     <div class="input-group has-feedback">    
          <select name="merchantId" id="merchantId" >
                 
                <option selected="selected" value="">-SELECT MERCHANT-</option>
                    <?php
                
                     $merchant_id = $paydb->query("SELECT DISTINCT merchantId, merchant_name FROM ".MERCHANTS);
                      while($merchantList = $merchant_id->fetch_array())
                      {
                        echo '<option value="'.$merchantList[0].'">'.$merchantList[1].'</option>';
                      }
                      
                      ?>

          </select>
    </div>
   </div>
 </div>

  <div class="row">

      <div class="col-sm-6 col-md-6 col-xs-12">
        <div class="input-group has-feedback"> 
          <input name="userId" id="userId" placeholder="User ID" >
        </div>
      </div>

      <div class="col-sm-6 col-md-6 col-xs-12">
        <div class="input-group has-feedback">
          <input name="user_name" id="user_name" placeholder="Full Name" style="text-transform: uppercase;" >
        </div>
      </div>

  </div>

  <div class="row">

    <div class="col-sm-6 col-md-6 col-xs-12"> 
       <div class="input-group has-feedback">
        <input type="email" name="user_email" id="user_email" placeholder="Email Address" >
      </div>
    </div>

    <div class="col-sm-6 col-md-6 col-xs-12">
       <div class="input-group has-feedback">
        <input name="user_phone" id="user_phone" placeholder="Phone No." >
        </div>
    </div>

  </div>

  <div class="row">

    <div class="col-sm-6 col-md-6 col-xs-12">
      <div class="input-group has-feedback">
        <input type="password" name="passcode" id="pass" placeholder="Password" >
      </div>
    </div>

   <div class="col-sm-6 col-md-6 col-xs-12">
        <div class="input-group has-feedback">
        <input type="password" name="conf_passcode" id="confirm" placeholder="Confirm Password" >
      </div>
   </div>

  </div><br/>

</form>


 <button class="btn btn-lg btn-success" id="btn-signup"> <i class="fa fa-sign-in"> </i> Sign Up Now </button>

 </div>

</section>


<?php include_once 'config/includes/footer.php'; ?>

<!-- Modal Process Transaction -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
    <!-- Modal Header -->
     <div class="modal-header">
        <h5 class="modal-title pull-left" id="modalLabel">Payment Details:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <!--  -->
      
      <div class="modal-body">      
      <?php include 'operations/core/processChoicePayment.php'; ?>
      </div>
      
     <!-- Modal Footer -->
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="process-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" id="process" >Process Payment</button>
      </div>
    <!-- -->

    </div>
  </div>
</div>

<!-- Modal Transaction Ends -->


<!-- Modal Reprocess -->
<div class="modal fade" id="modal-reprocess" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
    <!-- Modal Header -->
     <div class="modal-header">
        <h5 class="modal-title pull-left" id="modalLabel">Reprocess Payment:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <!--  -->
      
      <div class="modal-body">      
      <?php include 'operations/core/reprocessPayment.php'; ?>
      </div>
      
     <!-- Modal Footer -->
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="reprocess-close" data-dismiss="modal">Discard</button>
        <button type="button" class="btn btn-warning" id="btn-reprocess" >Re-process Payment Now</button>
      </div>
    <!-- -->

    </div>
  </div>
</div>

<!-- Modal Reprocess Ends -->

<!-- Modal Verify -->
<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
    <!-- Modal Header -->
     <div class="modal-header">
        <h5 class="modal-title pull-left" id="modalLabel">Verify Payment:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <!--  -->
      
      <div class="modal-body">      
      <?php include 'operations/core/verifyPayment.php'; ?>
      </div>
      
     <!-- Modal Footer -->
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="verify-close" data-dismiss="modal">Discard</button>
        <button type="button" class="btn btn-warning" id="btn-verify" > Verify Payment Now </button>
      </div>
    <!-- -->

    </div>
  </div>
</div>

<!-- Modal verify Ends -->


<!-- Modal Login -->
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
           
      <?php include 'operations/core/userLoginPage.php'; ?>
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

<!-- Modal Sign Up -->
<div class="modal fade" id="modal-signup" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
      
      <div class="modal-body grad" style="height: 1000px !important;"> 
           
          <?php include 'operations/main/user-signup.php'; ?>
          
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


<script src="plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>
<script src="plugins/viewportchecker/dist/jquery.viewportchecker.min.js" type="text/javascript"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script><!-- Preloader Library | Credit: smallenvelope.com/display-loading-icon-page-loads-completely/ -->
<script src="plugins/custom_js/animatedScriptJs.js" type="text/javascript"></script>

<script src="plugins/custom_js/scriptsJs.js" text="text/javascript"></script>

<script type="text/javascript">

  function readOnlyCheckBox() 
   {
   return false;
   }

   function logAdminOut()
   {
    var logout = 'adminDashboard/production/logOut';
    window.location.href = logout;
   }
</script>

</body>
</html>