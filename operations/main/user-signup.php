<?php
session_start();

include_once '../../config/connections/constant_connection.php';
include_once '../../config/constant_define/constants.php';

//$myRand = rand(0,1000);
//$mdHash = hash('sha512', $myRand);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/paytonify-logo-mini.png" />
<title>Paytonify</title>

<link href="../../plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/animate/animate.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/custom_css/style.css" rel="stylesheet" type="text/css" />



</head>

<body>

<?php include_once '../../config/includes/navbar.php'; ?>

<div class="container">

<!-- Section One -->
<section class="row section-sign">

<div style="margin-top: 90px; border-top: 3px solid #F90; box-shadow: 1px 1px #999; "> </div>

<div class="cent-div">

   <h3> <span> <img src="../../images/paytonify-logo-mini.png" /><br/><br/> Signing up takes just a minute! </span></h3>

 <form name="signup-form" id="signup-form" >

  <div id="signup-result" style="padding: 10px; color: #FFF;"> </div>

  <div class="row">

   <div class="col-sm-12 col-md-12 col-xs-12"> 
     <div class="input-group">    
          <select name="merchantId" id="merchantId" required="required">
                 
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
        <div class="input-group"> 
          <input name="userId" id="userId" placeholder="User ID" required="" >
        </div>
      </div>

      <div class="col-sm-6 col-md-6 col-xs-12">
        <div class="input-group">
          <input name="user_name" id="user_name" required="required" placeholder="Full Name" style="text-transform: uppercase;" >
        </div>
      </div>

  </div>

  <div class="row">

    <div class="col-sm-6 col-md-6 col-xs-12"> 
       <div class="input-group">
        <input type="email" name="user_email" id="user_email" required="required" placeholder="Email Address" >
      </div>
    </div>

    <div class="col-sm-6 col-md-6 col-xs-12">
       <div class="input-group">
        <input name="user_phone" id="user_phone" required="required" placeholder="Phone No." >
        </div>
    </div>

  </div>

  <div class="row">

    <div class="col-sm-6 col-md-6 col-xs-12">
      <div class="input-group">
        <input type="password" name="passcode" id="passcode" required="required" placeholder="Password" >
      </div>
    </div>

   <div class="col-sm-6 col-md-6 col-xs-12">
        <div class="input-group">
        <input type="password" name="passcode" id="passcode" required="required" placeholder="Confirm Password" >
      </div>
   </div>

  </div><br/>

</form>


 <button class="btn btn-lg btn-success" id="btn-signup"> <i class="fa fa-sign-in"> </i> Sign Up Now </button>

 </div>




</section>


<?php include_once '../../config/includes/footer.php'; ?>









    </div>
  </div>
</div>

<script src="../../plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../../plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../plugins/viewportchecker/dist/jquery.viewportchecker.min.js" type="text/javascript"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script><!-- Preloader Library | Credit: smallenvelope.com/display-loading-icon-page-loads-completely/ -->
<script src="../../plugins/custom_js/animatedScriptJs.js" type="text/javascript"></script>

<script src="../../plugins/custom_js/scriptsJs.js" text="text/javascript"></script>

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