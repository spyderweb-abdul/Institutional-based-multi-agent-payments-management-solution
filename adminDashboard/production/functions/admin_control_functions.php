<?php


function trim_input($data)
{
  global $paydb;

	$data = trim($data);
	$data = addslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($paydb, $data);
	return $data;
}

//Function to get details of the logged session Id
function get_session_info($sess_val)
{
 global $paydb;

$get_session = $paydb->query("SELECT * FROM ".USERS." a  
                                  INNER JOIN ".MERCHANTS." b ON b.merchantId = a.merchantId 
                                  INNER JOIN ".MERCHANT_TYPE." c ON c.merchantTypeId = b.merchantTypeId
                                  INNER JOIN ".ACTIVE_CHANNEL." d ON d.merchantId = a.merchantId
                                  INNER JOIN ".CHANNEL." e ON e.gatewayId = d.gatewayId
                                  WHERE a.userId = '$sess_val'                                  
                                ");

$details = $get_session->fetch_array();
return $details;

}

//Function to get payment stats forthe logged session
function get_payments_stats($sess_val)
{
	global $paydb;

	$get_setup_pay_stats = $paydb->query("SELECT f.setupId, f.setup_name, b.merchantId FROM ".USERS." a 
		                          INNER JOIN ".MERCHANTS." b ON b.merchantId = a.merchantId
		                          INNER JOIN ".PAYMENT_CHOICE." c ON b.merchantId = b.merchantId
		                          INNER JOIN ".PAYMENT_TYPE." d ON d.choiceId = c.choiceId
		                          INNER JOIN ".PAYMENT_RECORDS." e ON e.merchantId = b.merchantId
		                          INNER JOIN ".SETUP." f ON f.setupId = e.setupId
		                          WHERE a.userId = '$sess_val' GROUP BY f.setupId ");
	//$pay_stats = $get_payment->fetch_array();
	return $get_setup_pay_stats;
}

//Function to get users and payment stats
function get_users_payment_stats()
{
 global $paydb;
 //global $_SESSION['userId'] = $sess_val;
     
     //get users
      $get_users = $paydb->query("SELECT merchantId FROM ".USERS." WHERE userId = '$_SESSION[userId]' ");
      $f = $get_users->fetch_array();

      $merchantId = $f[0]; //Merchant ID
      
      //get all users associated with merchant
      $get_all_merchant_users = $paydb->query("SELECT * FROM ".USERS." WHERE merchantId = '$merchantId' ");
      $users_num = mysqli_num_rows($get_all_merchant_users);

      //get all users who have transactions associated with merchants 
      $get_all_payment = $paydb->query("SELECT COUNT(userId) FROM ".PAYMENT_RECORDS." WHERE merchantId = '$merchantId' ");
      $all_pay_users = $get_all_payment->fetch_array();

      $all_trans = $all_pay_users['COUNT(userId)'];

      //get all paid transactions associated with merchant
      $get_paid = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." WHERE merchantId = '$merchantId' AND status = 'PAID'");
      $all_paid = mysqli_num_rows($get_paid); //No of Paid

      $fetch_paid = $get_paid->fetch_array();

      //get all pending transactions associated with merchant
      $get_pending = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." WHERE merchantId = '$merchantId' AND status = 'PENDING'");
      $all_pending = mysqli_num_rows($get_pending); //No of Paid

      $fetch_pending = $get_pending->fetch_array();

      //Total amount of paid transactions associated with merchant
      $total_amount = $paydb->query("SELECT SUM(amount) FROM ".PAYMENT_RECORDS." WHERE merchantId = '$merchantId' AND status = 'PAID'");
      $total_sum = $total_amount->fetch_array();

      $total_amount_paid = $total_sum['SUM(amount)'];

      //Total No of payment setups associated with a merchant

      $all_setup = $paydb->query("SELECT * FROM ".PAYMENT_TYPE." a INNER JOIN ".PAYMENT_CHOICE." b ON b.choiceId = a.choiceId WHERE b.merchantId = '$merchantId' ");
      $setup_num = mysqli_num_rows($all_setup);

      $setup_details = $all_setup->fetch_array();


return array($users_num, $merchantId, $all_trans, $all_paid, $fetch_paid, $all_pending, $fetch_pending, $total_amount_paid, $setup_num, $setup_details);

}

function get_users_roles()
{
	global $paydb;

	$roles = $paydb->query("SELECT * FROM ".USERS_ROLES);
	return $roles; 
}

function get_admin_users_details($user)
{
   global $paydb;

   $admin_user = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".USERS_ROLES." b ON b.roleId = a.roleId WHERE a.userId = '$user'") or die(mysqli_error($paydb));

   $fetch_details = $admin_user->fetch_array();

   return $fetch_details;
}

//to get user programmes and others
function get_user_prog($merchid)
{
  global $paydb;

   $get_prog = $paydb->query("SELECT * FROM ".PROGRAMME." WHERE merchantId = '$merchid' ") or die (mysqli_error($paydb));

   return $get_prog;
}


function get_user_merchant($user)
{
  global $paydb;

  $get_details = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".MERCHANTS." b ON b.merchantId = a.merchantId WHERE a.userId = '$user' ") or die (mysqli_error($paydb));

  $fetch = $get_details->fetch_array();

  return $fetch;
}


?>