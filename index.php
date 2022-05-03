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
<div class="se-pre-con"> <!-- Pre loader in here --> </div>
<?php include_once 'config/includes/navbar.php'; ?>

<div class="container">

<!-- Section One -->
<section class="row section-one">

<div class="col-md-3"> &nbsp; </div>

<div class="col-md-6"> 

<div class="inner-form-div"> 
<p class="pay-note"> Who are you paying? </p>



  <form name="create_form" id="create_form" method="" action="" >
         
         <div id="merchant_ref">         
         <div class="input-group">
                    <span class="input-group-addon"><b class="glyphicon glyphicon-shopping-cart"></b></span>
                      <select class="form-control merchant-form" name="merchant_id" id="merchant_id" onchange="load_choice()">
                 
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
         <br/>
         
         <p id="merchant_pay_choice"> </p>
         <p id="merchant_pay_type"> </p>
         </form>
         


</div>
</div>

<div class="col-md-3"> &nbsp;</div>

    <div class="row" id="synopsis">
        <div class="col-md-12">   ...because businesses move farther beyond when we move together! </div>
    </div>

</section>

<!--Section Two-->
<section class="row section-two">

<div class="col-md-4" id="anim"> <img src="images/Paytonify-all.png" /> </div> 

<div class="col-md-6">
  
  <div id="intro-writeup">
      <h4> <p> <i class="fa fa-2x fa-shopping-bag"></i> </p>

      All Your Payments and Collections Convenience in One Basket

      </h4>
      <hr noshade="noshade" />

      <p> Looking for the best solution for your collections and payments? Look further no more. </p>
      <p> Paytonify has everything you need to electronically manage your collections. </p>
      <p> In just few configuration steps; your clients, customers or payers can begin to pay you. It's that simple to get on board. </p>
      <p> Why not let Paytonify handle your payment hassle? We've got you! </p>

      <p> <button class="btn btn-warning"> Get Started </button> </p>

  </div>

</div>

<div class="col-md-2"> &nbsp; </div>

</section>

<!-- Section Three -->
<section class="row section-three arrow_box_three" >


    
    <div class="col-md-3" id="three-enc">
          <span class="three-head"> <p> <i class="fa fa-3x fa-database"> </i><i class="fa fa-2x  fa-key"> </i> </p> Data Encryption </span><br/>
          <p class="three-content">
              
              All transactions and financial information on Paytonify<sup><i class="fa fa-trademark"></i></sup> goes through an encrypted channel; well-secured against thrid-party or unauthorized access.

          </p>
    </div>

    <div class="col-md-3" id="three-proc">

        <span class="three-head"> <p> <i class="fa fa-3x fa-shield"> </i> </p> Advanced Fraud Protection </span><br/>
        <p class="three-content">
            
            In addition to fraud protection mechanism on all Payment gateways available on our platform, Paytonify<sup><i class="fa fa-trademark"></i></sup> also provide a strong fraud detection mechanisms. Protection is Guaranteed.

        </p>
   </div>

    <div class="col-md-3" id="three-tim">
        <span class="three-head"> <p> <i class="fa fa-3x fa-clock-o"> </i> </p> Timely &amp; Responsive </span><br/>
        <p class="three-content">
            
            There's nothing as seamless and fast to use as Paytonify<sup><i class="fa fa-trademark"></i></sup>. The request and response to calls is plausible. Resolution of issues and supports is just a click away.

        </p>
    
    </div>

    <div class="col-md-3" id="three-chart">
        <span class="three-head"> <p> <i class="fa fa-3x fa-pie-chart"> </i> </p> Meaningful Statistical Reports </span><br/>
            <p class="three-content">
            
            And when you need finacial reports that is comprehensible and concise, Paytonify<sup><i class="fa fa-trademark"></i></sup> will be right there all step on the way to help you make that growth decisions.

        </p>

    </div>

</section>

<!-- Section Four -->
<section class="row section-four">
  
      <p class="four-head"> About Paytonify<sup><i class="fa fa-trademark"></i></sup></p>
     
     <div class="row">
        <div class="col-md-7">
          
          <p> Paytonify<sup><i class="fa fa-trademark"></i></sup> is a robust, all-in-one payment collection system developed to ease the process of payment collections. Fully-integrated with all Nigerian Payment Gateway providers; which ever gateway you may choose, Paytonify will help you customize so that your clients and customers can begin to pay you from anywhere and anytime. </p>

          <p> Because we believe setting up fees for schools and institution could be a difficult task sometimes, Paytonify helps you address all the bottlenecks - from ceation of fees, setting-up fee items, updating fees and so many more have just gotten simpler. In just few minutes, your fees schedule are up and running and your customers can begin to pay just immediately.</p>

          <p> You have a legacy system? No worries! Let Paytonify handle the payment part of your system. Our team works 24/7 just to make sure you are up and running in relatively no time. You don't have to go through the hassle of payment system integrations: we have done that for you already and we will offer you support on the system for life.   </p>

          <p> Governments looking for an electronic platform for tax collections, SMEs looking to integrate e-Commerce and e-Payment, Schools, Colleges and Institutions looking for the best online solution to manage their fees and application form sales, look no elsewhere, Paytonify<sup><i class="fa fa-trademark"></i></sup> is your partner all steps on the way.    </p>

        </div>

        <div class="col-md-5 four-lap" id="four-laptop"> <img src="images/paytonify-laptop.png" /> </div>
      </div>

      <br/> <hr noshade="noshade" /><br/>
        
        <p class="four-head"> Features </p>
        
  <div class="four-inner">
         
      <div class="row">
          <div class="col-md-3"> <img src="images/feature1.png" id="tax"  /> </div>
          <div class="col-md-9"> 
            <p class="feature-head"> Tax Payments and Collections Administration </p>
              <p class="feature-content"> Paytonify offers a unique feature to help collect, build and manage your Tax Administration Structure. Tax payers can pay with ease and get their payment receipts or clearance. </p>
          </div>
      </div><br/>

      <hr noshade="noshade" />

      <div class="row">
        <div class="col-md-3"> <img src="images/feature2.png" id="gateway"  /> </div>
          <div class="col-md-9"> 
            <p class="feature-head" > Full-Integration with Major Nigerian Payment Gateways </p>
              <p class="feature-content"> Paytonify is fully integrated with major Nigerian payment gateway providers; whether you have one provisioned already for your business or services, or you are looking to integrate payment systems for your services with any gateway, we have you covered. Setup is just in few minutes, and, Viola! You are ready to recieve your payments in your Bank Accounts. </p>
        </div>
          
      </div><br/>
       
       <hr noshade="noshade" />

      <div class="row">
          <div class="col-md-3"> <img src="images/feature3.png" id="e-Commerce" /> </div>
          <div class="col-md-9"> 
            <p class="feature-head"> Enhanced for e-Commerce </p>
              <p class="feature-content"> Paytonify offers a unique feature to help collect, build and manage your Tax Administration Structure. Tax payers can pay with ease and get their payment receipts or clearance. </p>
          </div>
      </div><br/>

        <hr noshade="noshade" />

        <div class="row">
          <div class="col-md-3"> <img src="images/feature4.png" id="chart"  /> </div>
          <div class="col-md-9"> 
            <p class="feature-head" > Meaningful Chart-based Reporting </p>
              <p class="feature-content"> Paytonify is fully integrated with major Nigerian payment gateway providers; whether you have one provisioned already for your business or services, or you are looking to integrate payment systems for your services with any gateway, we have you covered. Setup is just in few minutes, and, Viola! You are ready to recieve your payments in your Bank Accounts. </p>
        </div>
          
      </div><br/>

      <hr noshade="noshade" />

      <div class="row">
          <div class="col-md-3"> <img src="images/feature5.png" id="dashboard"  /> </div>
          <div class="col-md-9"> 
            <p class="feature-head"> Compact and Robust Administrative Dashboard </p>
              <p class="feature-content"> Paytonify offers a unique feature to help collect, build and manage your Tax Administration Structure. Tax payers can pay with ease and get their payment receipts or clearance. </p>
          </div>
      </div><br/>

      </div>

</section>

<!-- Section Five -->
<section class="row section-five">
  
  <p class="five-head"> Featured Payment Gateways </p><br/>
  
  <div class="col-md-12">
  
      <span> 
          <div class="five-content"> <img src="images/etranzact-logo2.png"  /> </div>
          <div class="five-content"> <img src="images/interswitch-logo2.png" /> </div>
          <div class="five-content"> <img src="images/remita-logo2.png" /> </div>
          <div class="five-content"> <img src="images/gtpay-logo2.png" /> </div>
      </span>
 </div>

</section>

<!-- Section Six -->
<section class="row section-six arrow_box_six">
  
  <p id="developer"> &lt;/&gt; Do you need a developer to help you with your e-Commerce website, or you are a developer and you need support integrating online payment? <br/>
  You want to know how online payment can help grow your business? Why not hit us now, and let's help you with something really fast. </p> 
  <p> <button class="btn btn-warning"> Request Consultation </button> &nbsp; <button class="btn btn-warning"> Contact Us </button> </p>

</section>

<!-- Section Seven -->
<section class="row section-seven">
  
  <p class="seven-head"> "What People Say About Paytonify<sup><i class="fa fa-trademark"></i></sup>" </p>

  <p> <?php include_once('config/includes/carousel-witness.php');  ?> </p>


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