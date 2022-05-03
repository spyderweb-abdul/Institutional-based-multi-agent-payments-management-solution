<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>
<body>

<?php
  if(isset($_GET['merch']))
  {
	  $merchant_id = $_GET['merch'];
	  $choice_id = $_GET['payChoice'];
	  $type_id = $_GET['payType'];
  
	  
  include_once '../../config/connections/constant_connection.php';
  include_once '../../config/constant_define/constants.php';
  include_once '../../config/functions/control_functions.php';
  
  //Get the payment options and payment types for a specific merchants
  $get_details = $paydb->query("SELECT * FROM ".MERCHANTS." a
                               INNER JOIN ".PAYMENT_CHOICE." b ON b.merchantId = a.merchantId 
              							   INNER JOIN ".PAYMENT_TYPE." c ON  c.choiceId = b.choiceId
              							   INNER JOIN ".SETUP." d ON d.typeId = c.typeId
              							   WHERE a.merchantId = '$merchant_id' AND b.choiceId = '$choice_id' AND c.typeId = '$type_id' ");
  
  $pay_details = $get_details->fetch_array();
  
  if(mysqli_num_rows($get_details) > 0)
  {
  
  $institution = $pay_details['merchant_name'];
  $choice = $pay_details['payment_choice_name'];
  $type = $pay_details['payment_type_name'];
  $setup = $pay_details['setup_name'];
  $setupId = $pay_details['setupId'];
  $session = $pay_details['current_session'];
  

?>
      
         <div id="display-content"><!-- The form content is displayed here -->
         
         
         <!-- Modal Content -->
         <form name="payment-details-form" id="payment-details-form" method="" action="">
         <div class="row pay-analysis"> 
         <div class="col-md-12">
        <?php echo '<span class="btn btn-sm btn-link">  <i class="fa fa-credit-card"> </i> ' .$institution.' <i class="fa fa-angle-double-right"></i> '.$choice.' <i class="fa fa-angle-double-right"></i> '.$type.'</span>' ?>  
         </div>
         </div>
         
         <br/>
         
         <div class="row">
           <div class="col-md-6">
          	<div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                <input class="form-control pay-detail-form" name="userId" id="userId" placeholder="User ID" onKeyUp="payers_details()" >
            </div>
           </div>
          </div> <br/> 

          <input type="hidden" class="form-control" name="setup" id="setup" value="<?php echo $setup; ?>" >
          <input type="hidden" class="form-control" name="merchantId" id="merchantId" value="<?php echo $merchant_id; ?>" >
          <input type="hidden" class="form-control" name="setupId" id="setupId" value="<?php echo $setupId; ?>" >
          <input type="hidden" class="form-control" name="session" id="session" value="<?php echo $session; ?>" >
          <input type="hidden" class="form-control" name="choice" id="choice" value="<?php echo $choice; ?>" >

          
          
          <p id="spinner"> </p>
          <div id="merchant_user_details"> <!-- Hide Div -->


          
      
          </div><!-- End Hide Div -->
          
         
         </form>
         <!-- Modal Content Ends -->
         
         </div><!-- display content ends -->
         
         <!-- Displays resut of the submission onclick of the button -->
         <p id="display-spinner"> </p>   
         <p id="display-result"> </p> 
         
         <!-- <p id="process-payment-result"> </p> -->
 
<?php } else { echo '<span class="btn btn-warning"> <i class="fa fa-warning"> </i> SETUP NOT PROVISIONED YET! </span>'; } } ?>    


</body>
</html>
