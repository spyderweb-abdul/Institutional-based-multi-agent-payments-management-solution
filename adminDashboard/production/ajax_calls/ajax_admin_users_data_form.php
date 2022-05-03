<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

   // $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
   // $merchantId = $getDetails['merchantId'];
    //$merchant_name = $getDetails['merchant_name'];
    //$current_session = $getDetails['current_session'];

    $userId = trim_input($_POST['userId']);
    $user_name = trim_input(strtoupper($_POST['user_name']));
    $passcode = trim_input($_POST['passcode']);
    $user_email = trim_input($_POST['user_email']);
    $user_phone = trim_input($_POST['user_phone']);
    $roleId = $_POST['sel_role'];
    $merchant = $_POST['merchantId'];

    $securecode = hash('sha256', $passcode);

    //call to function get-user_merchant
    $userMerch = get_user_merchant($userId);

    $merchant_name = $userMerch['merchant_name'];
    


    //get_role_name
    $get_role_name = $paydb->query("SELECT roles FROM ".USERS_ROLES." WHERE roleId = '$roleId' ");
    $fetch_role = $get_role_name->fetch_array();

    $role_name = $fetch_role[0];

    //check if userId exist before
    function throw_ex($err)
    {
        throw new Exception($err);        
    }
    try
    {
      $check_usr = $paydb->query("SELECT userId FROM ".USERS." WHERE userId = '$userId' ") or throw_ex(mysqli_error($paydb));
      	   
	    if(mysqli_num_rows($check_usr) > 0)
	    {
	       echo '<div class="alert alert-warning alert-dismissible fade in" role="alert style="color:#FFF"> 
	         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
	         <i class="fa fa-warning"></i> User with ID: '.$userId.' already exist for '.$merchant_name.'. Kindly change the User ID. </div>';
	    }
	    else
	    {
		    //Insert into database
		   $insert_usr = $paydb->query("INSERT INTO ".USERS." (userId, secure_code, user_name, user_email, user_phone, merchantId, roleId) VALUES ('$userId', '$securecode', '$user_name', '$user_email', '$user_phone', '$merchant', '$roleId')" ) or throw_ex(mysqli_error($paydb));

		    if($insert_usr == true)
		    {
		    	echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
			          <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
			          <i class="fa fa-ok"></i> User with ID: '.$userId.' has been created. 
			          </div>';
		    	//call send mail function
		    	send_email($userId, $user_name, $passcode, $user_email, $role_name, $merchant_name);
		    }
		    else
		    {
		    	 echo '<div class="alert alert-warning alert-dismissible fade in" role="alert style="color:#FFF"> 
		          <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
		          <i class="fa fa-times"></i> User Could not be created. 
		          </div>';

		    }
		    
        } 
    }
    catch(Exception $e)
    {
    	echo 'Error: '.$e;
    }

  
  function send_email($a, $b, $c, $d, $e, $f)
  {

    //Mailer Script
		
                require_once("../../../PhpMailer/PHPMailerAutoload.php");

                 $message = file_get_contents('../includes/html_notification_paytonify_admin_user.php'); 
                 $message = str_replace('%userId%', $a, $message);  //replaces the string in the html page with the correct variable
                 $message = str_replace('%user_name%', $b, $message);
                 $message = str_replace('%no_hash_pass%', $c, $message);
                 $message = str_replace('%user_email%', $d, $message);
                 $message = str_replace('%role_name%', $e, $message);
                 $message = str_replace('%smerchant_name%', $f, $message);

                 $mail = new PHPMailer();

                //Enable SMTP debugging. 
               $mail->SMTPDebug = 0; 

               $mail->IsSMTP();    // set mailer to use SMTP
               $mail->Host = "smtp-relay.gmail.com";  // specify main and backup server
               $mail->SMTPAuth = true;     // turn on SMTP authentication
               $mail->Username = "users.notification@paytonify.com";  // SMTP username
               $mail->Password = "asdf;lkj@2pixreku"; // SMTP password
                //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "tls";                           
               //Set TCP port to connect to 
               $mail->Port = 587;     

               $mail->From = "users.notification@paytonify.com";
               $mail->FromName = "Paytonify";
               $mail->AddAddress($d, $b);
               $mail->AddReplyTo("no-reply@paytonify.com", "No-Reply");

                //$mail->addCC("user.3@ymail.com","User 3");
                //$mail->addBCC("user.4@in.com","User 4");

                //$mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
               // $mail->AddAttachment("PGMANUAL.pdf", "Application-Form-User-Guide");    // optional name
				
				$mail->IsHTML(true);                                  // set email format to HTML

                $mail->CharSet="utf-8";
                $mail->Subject = "ADMIN USER CREATION NOTIFICATION";
                $mail->Body = $message;
                 //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                if(!$mail->Send())
                  {
                echo "<div> Message could not be sent. <br/>";
                echo "Mailer Error: " . $mail->ErrorInfo. "</div>";
               // exit;
                  }
}

?>

