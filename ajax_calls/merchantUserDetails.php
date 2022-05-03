<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$setup = trim_input($_POST['setup']);
$choice = trim_input($_POST['choice']);
$merchant_id = trim_input($_POST['merchantId']);


$sel_payer = $paydb->query("SELECT * FROM ".USERS." WHERE userId = '$userId' AND merchantId = '$merchant_id' ");

if(mysqli_num_rows($sel_payer) > 0)
{

$get_id = $sel_payer->fetch_array();

$name = $get_id['user_name'];
$email = $get_id['user_email'];
$phone = $get_id['user_phone'];

?>

          <div class="row"> 
           <div class="col-md-6">
           <label class="pay-detail-form-label"> Payer's Name: </label>
          	<div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-male"></i></span>
                <input class="form-control pay-detail-form" name="payerName" id="payerName" placeholder="Payer's Name" value="<?php echo $name; ?>" >
            </div>
           </div>
           
           <div class="col-md-6">
            <label class="pay-detail-form-label"> Payer's Email: </label>
          	<div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control pay-detail-form" name="payerEmail" id="payerEmail" placeholder="Payer's Email Address" value="<?php echo $email; ?>"  >
            </div>
           </div>
          </div> 
          <br/>
          
          <div class="row">

           <div class="col-md-6">
            <label class="pay-detail-form-label"> Payer's Phone No: </label>
          	<div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                <input class="form-control pay-detail-form" name="payerPhone" id="payerPhone" placeholder="Payer's Phone No." value="<?php echo $phone; ?>"  >
            </div>
           </div>        

          </div>
          <br/><br/>

             <?php

              $amt = 0; //Just to initialize and declare $amt;

                //Check if payment choice is tuition and display the fees item
               $check_payment_choice = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE payment_choice_name = '$choice' AND merchantId = '$merchant_id'");
               $choice = $check_payment_choice->fetch_array();

               if($choice['req_fee_items'] == 'YES')
               {
                  //Check up on user's details
                   $get_users_details = $paydb->query("SELECT * FROM ".USER_DETAILS." WHERE userId = '$userId'");
                   $details = $get_users_details->fetch_array();

                     $level = $details['level']; //Level of User
                     $category = $details['category']; //Category of User
                     $nationality = $details['nationality']; //Nationality of user
                     $progId = $details['progId']; //User's Programme
                  
                  //Extract Fee Items for user's programme
                    $get_fee_details = $paydb->query("SELECT * FROM ".PROGRAMME." a INNER JOIN ".TBL_FEE_STRUCTURE." b ON a.progId = b.progId INNER JOIN ".TBL_FULL_FEE_STRUCTURE." c ON c.progId = a.progId WHERE b.progId = '$progId' AND b.level = '$level' AND b.category = '$category' AND b.nationality = '$nationality' AND b.merchantId = '$merchant_id' ") or die (mysqli_error($paydb));

                    if(mysqli_num_rows($get_fee_details) > 0)
                    {

                        $row = $get_fee_details->fetch_array();

                         echo '<strong>'.$setup.' <i class="fa fa-angle-double-right"></i> '.$level.'Level <i class="fa fa-angle-double-right"></i> '.strtoupper($row['programme']).'</strong><br/><br/>';

                         echo '<table width="70%" class="table-bordered table-condensed table-hover table-responsive table-striped"><tr>';
                         echo '<th> </th>';
                         echo '<th> Fee Item </th>';
                         echo '<th> Amount </th></tr>';

                         $get_fee_details->data_seek(0);

                         $amt = 0;  //Initialise sum amount

                        while($item = $get_fee_details->fetch_array()){
                          
                            $feeID = $item['feeID'];

                            //Now get details of fee ID
                            $get_items_details = $paydb->query("SELECT * FROM ".FEE_ITEMS." WHERE feeID = '$feeID' AND merchantId = '$merchant_id'");
                            $fee = $get_items_details->fetch_array();

                               $feeItem = $fee['feeItem'];//Fee Item
                               $amount = $fee['amount']; //Amount
                            
                               echo '<tr>';
                               echo '<td>  <input type="checkbox" checked="checked" name="id[]" id="'.$feeID.'" value="'.$feeID.'" style="height:auto" onClick="return readOnlyCheckBox()"> </td>';
                               echo '<td>'.$feeItem.'</td>';
                               echo '<td>'.number_format($amount, 0).'</td>';
                               echo '</tr>';

                               $amt += $amount; //Increment sum amount

                        }

                        echo '<tr> <td colspan="3" style="padding: 20px; margin: 20px;"> <strong> Total Amount: '.number_format($amt, 2).' </strong> </td> </tr>';
                      
                        echo '</table>';

                        //Other needed params
                        echo '<input type="hidden" class="form-control" name="progId" id="progId" value="'.$progId.'" >';
                        echo '<input type="hidden" class="form-control" name="level" id="level" value="'.$level.'" >';



                    }
                    else
                    {
                       echo '<h5 style="color:red;"><i class="fa fa-ban"></i> Fees breakdown currently not available </h5>';
                    }
                  
               }

                $fee_amount = get_fee_amount($setup);

                if($fee_amount == 0)
                {
                   $fee_amount = $amt;
                }


             ?>
           <br/><br/>

           <div class="row">

                <div class="col-md-6">
                <label class="pay-detail-form-label"> Payable Amount: </label>
                <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                <input class="form-control pay-detail-form" name="amount" id="amount" placeholder="Payable Amount (e.g 10000)" <?php echo 'readonly'; ?> value="<?php echo $fee_amount; ?>"  >
                </div>
                </div>

           </div><br/>


           <div class="row">
            <div class="col-md-8">
             <div class="panel panel-default">
               <div class="panel-body">
                <p> <u> <strong> CHOOSE GATEWAY OF CHOICE: </strong> </u> </p>
                <?php 
                     //Call function to the status and list of merchant's gateway
                     $activeListArray = get_active_merchant($merchant_id);
                     
                     
                     foreach ($activeListArray as $arr)
                     {
                                   
                       if($arr['status'] == "ACTIVE")  { $checked = '';  }
                       else { $checked = 'disabled'; }
                       
                       $argument = "'".$arr['gatewayId']."'";//Note: function argument must be string i.e must be quoted for it to be passed correctly as parameter into the function
                       
                       $merch = "'".$merchant_id."'" ;//MerchantID
                       $setupname = "'".$setup."'"; //Setup Name
                       
                      echo '<label class="radio-inline">
                            <input type="radio" name="gateway" id="gateway" value="'.$arr['gatewayId'].'" '.$checked.' onClick="fetch_payment_options('.$argument.','.$merch.', '.$setupname.'), choose_pay_logo();" >'.$arr['gateway_name'].'</label>';
                    }
                        
                  ?>
              
               </div>
              </div> 
            </div>
            
                  <div class="col-md-4">  <p id="logo"> </p>  </div>
            
          </div>

         
   
         <div class="row"> 
           <div class="col-md-12">
           
             <div id="paymentOption"> </div>
             
           </div>
          </div><br/> 

<?php } else { echo '<button class="btn btn-danger btn-sm">-USER NOT FOUND-</button>'; } ?>