<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

if(isset($_GET['choiceid']))
{

	function throw_ex($err)
	{
		throw new Exception($err);
	}
	
try{		//$merchantId = trim_input($_GET['merchantid']);
			$choiceId = trim_input($_GET['choiceid']);
			$typeId = trim_input($_GET['typeid']);

			//$pay_code = 0;
			//$payment_code = 0;

			$sel_param = $paydb->query("SELECT * FROM ".SETUP." WHERE choiceId = '$choiceId' AND typeId = '$typeId' ") or throw_ex(mysqli_error($paydb));
			
			if(mysqli_num_rows($sel_param) > 0)
			{
				$fetch_param = $sel_param->fetch_array();

				$setup_name = $fetch_param['setup_name'];
				$service_type_id = $fetch_param['service_type_id'];
				$payment_code = $fetch_param['payment_code'];
				$gatewayId = $fetch_param['gatewayId'];

			}
			else
			{  
			    //Get max payment code				
				$get_max = $paydb->query("SELECT MAX(a.payment_code) AS paycode FROM ".SETUP." a WHERE a.merchantId = '$merchantId' ") or throw_ex(mysqli_error($paydb));

			      $max_code = $get_max->fetch_array();

				if($max_code['paycode'] == null) //If no payment code for the selected merchants
				{
					$pay_code = '01';           
					$payment_code = $merchantId.$pay_code;

				}
				else //if there are payment code values for payments for the selected merchants
				{				    

					$pay_code = $max_code['paycode']; //Then pick the highest value
					$payment_code = $pay_code + 1; //Increment the highest value

                }

                    $setup_name = '';
                    $service_type_id = '';

			}
   }
   catch (Exception $e)
   {
   	  echo 'Error: '.$e;
   }


			   echo '<div class="row">
			           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			            <select name="active_gateway_id" id="active_gateway_id" class="form-control has-feedback-left">
			             <option value=""> -Select Preferred Gateway- </option>';
			                      
			          		$active_id = $paydb->query("SELECT * FROM ".CHANNEL." a INNER JOIN ".ACTIVE_CHANNEL." b ON b.gatewayId = a.gatewayId WHERE b.merchantId = '$merchantId'");
			                      while($status = $active_id->fetch_array())
			                       {
			                         echo '<option value="'.$status['gatewayId'].'">'.$status['gateway_name'].'</option>';
			                       }

			  echo  '</select>
			         <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
			         </div>
			        </div>
			   
			        <div class="row">
			           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			            <select name="reprocessible" id="reprocessible" class="form-control has-feedback-left">
			             <option value=""> - Reprocessible? - </option>
			             <option value="YES"> YES </option>
			             <option value="NO"> NO </option>
			            </select>
			           <span class="fa fa-refresh form-control-feedback left" aria-hidden="true"></span>
			           </div>
			       </div>

			   <div class="row">
			           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			              <input type="text" class="form-control has-feedback-left" placeholder="Payment Setup Name" name="setup_name" id="setup_name" value="'.$setup_name.'">
			              <span class="fa fa-wrench form-control-feedback left" aria-hidden="true"></span>
			            </div>
			         </div>


			         <div class="row">
			           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			              <input type="text" class="form-control has-feedback-left" placeholder="Payment Service Type ID" name="service_type_id" id="service_type_id" value="'.$service_type_id.'">
			              <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
			            </div>
			         </div>


			          <div class="row">
			           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			              <input type="text" class="form-control has-feedback-left" placeholder="Payment Code" name="payment_code" id="payment_code" value="'.$payment_code.'" readonly >
			              <span class="fa fa-code form-control-feedback left" aria-hidden="true"></span>
			            </div>
			         </div>

			         </form>

			                   <div class="form-group">
			                     <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">';
			                      //<button class="btn btn-primary" type="reset" id="btn_payment_fee_reset"><i class="fa fa-times"></i> Reset</button>
			                      echo '<button type="button" class="btn btn-success" id="btn_save_payment_fee"><i class="fa fa-save"></i> Save Payment Parameters </button>
			                     </div>
			                   </div>';

	}

?>
