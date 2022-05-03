<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

   /* $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $merchant_name = $getDetails['merchant_name'];
    //$current_session = $getDetails['current_session'];
    */

define("UPLOAD_DIR", "../../../logos/");

$merchant_name = trim_input(ucfirst($_POST['merchant_name']));
$merchant_email = trim_input($_POST['merchant_email']);
$merchant_type = trim_input($_POST['merchant_type']);
$session = trim_input($_POST['session']);

//Pass merchant_name into a session
//$_SESSION['merchant_name'] = $merchant_name;

$merchant_logo = $_FILES['merchant_logo']['name'];
$filetype = exif_imagetype($_FILES['merchant_logo']['tmp_name']); //Make sure to activate php_exif in ur php.ini
$filesize = $_FILES['merchant_logo']['size'];
$fileError = $_FILES['merchant_logo']['error'];
$file_ext = pathinfo($merchant_logo, PATHINFO_EXTENSION); //Get the file extension

//Ensure the right file type is uploaded
$allowedType = array(IMAGETYPE_GIF, IMAGETYPE_PNG, IMAGETYPE_JPEG);
if(!in_array($filetype, $allowedType))
{
  echo '<p style="color:red"> Logo Image Type Not Permitted </p>';
  exit();
}
//Handle File Size - Only 5MB allowed
if($filesize > 5 * 1048576) //That's 5MG
{
  echo '<p style="color:red"> Logo Image Size Exceeded Maximum Allowed </p>';
  exit();
}

//Handle any upload error
if($fileError !== UPLOAD_ERR_OK)
{
    echo '<p style="color:red"> Oops! An error occured while uploading the logo </p>';
    exit();
}

//Replace all spaces in the merchant name string with undesrscore
$newFileName = str_ireplace(" ", "_", $merchant_name).'_Logo.'.$file_ext;

$successful = move_uploaded_file($_FILES['merchant_logo']['tmp_name'], UPLOAD_DIR.$newFileName);

if(!$successful)
{
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-ban"></i> Operation Failed Permanently. Please, Try again. 
                 </div>';
}
else
{
    chmod(UPLOAD_DIR.$newFileName, 0644); //Give the folder the necessary permission

    //Throw exception
    function throw_ex($err)
    {
        throw new Exception($err);
        
    }

    try
    {

      //Check availability first

      $check = $paydb->query("SELECT merchant_name FROM ".MERCHANTS." WHERE merchant_name = '$merchant_name'") or throw_ex(mysqli_error($paydb));
      if(mysqli_num_rows($check) > 0)
      {
         echo '<div class="alert alert-warning alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-ban"></i> This Merchant Name already exist. 
                 </div>';
      }
      else
      {      
        //Insert new merchant details into the database
      $insert_merchant = $paydb->query("INSERT INTO ".MERCHANTS." (merchant_name, merchantTypeId, current_session, merchant_email, logo) VALUES ('$merchant_name', '$merchant_type', '$session', '$merchant_email', '$newFileName')" ) or throw_ex(mysqli_error($paydb));

            if($insert_merchant)
            {
            echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-ok"></i> New Merchant Created Successfully. 
                 </div>';
            }
      }
			
    }
		catch(Exception $e)
    {                 
        echo 'Error: '.$e;
		}

}


/*function send_notification($name, $faculty, $dept, $prog, $session, $phone, $email, $min_dur, $max_dur)
{
				  //Mailer Script
		
                require_once("../PhpMailer/PHPMailerAutoload.php");


                 $message = file_get_contents('include/html_notification_pg_admissions.php');  
     	         $message = str_replace('%name%', $name, $message); //replaces the string in the html page with the correct variable
				 $message = str_replace('%faculty%', $faculty, $message);
				 $message = str_replace('%dept%', $dept, $message);
                 $message = str_replace('%progr%', $prog, $message);
                 $message = str_replace('%session%', $session, $message);
				 $message = str_replace('%min_dur%', $min_dur, $message);
				 $message = str_replace('%max_dur%', $max_dur, $message);
				 
				 
                 $mail = new PHPMailer();

                //Enable SMTP debugging. 
               $mail->SMTPDebug = 0; 

               $mail->IsSMTP();    // set mailer to use SMTP
               $mail->Host = "smtp-relay.gmail.com";  // specify main and backup server
               $mail->SMTPAuth = true;     // turn on SMTP authentication
               $mail->Username = "pgs.notification@udusok.edu.ng";  // SMTP username
               $mail->Password = "Admin@udu123"; // SMTP password
                //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "tls";                           
               //Set TCP port to connect to 
               $mail->Port = 587;     

               $mail->From = "pgs.notification@udusok.edu.ng";
               $mail->FromName = "UDUS POSTGRADUATE SCHOOL";
               $mail->AddAddress($email, $name);
               $mail->AddReplyTo("no-reply@udusok.edu.ng", "No-Reply");

                //$mail->addCC("user.3@ymail.com","User 3");
                //$mail->addBCC("user.4@in.com","User 4");

                //$mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
               // $mail->AddAttachment("PGMANUAL.pdf", "Application-Form-User-Guide");    // optional name
				
				$mail->IsHTML(true);                                  // set email format to HTML

                $mail->CharSet="utf-8";
                $mail->Subject = "ADMISSIONS NOTIFICATION";
                $mail->Body = $message;
                 //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                if(!$mail->Send())
                  {
                echo "Message could not be sent. <p>";
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit;
                  }
                
				 
           //echo "Message has been sent";

		      //SMS API starts here		   
		   
           $owneremail="mitsafe@yahoo.com";
           $subacct="PGPORTAL";
           $subacctpwd="pgportal";
           $sendto= $phone;     /* destination number */
          // $sender="UDUSPG"; /* sender id */
		   
/*$msg = 'Hi '. $name .' You have been admitted into: '.$prog.' at Usmanu Danfodiyo University Sokoto. Registration commences immediately. Congratulations! ';
$url="http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=".$owneremail."&subacct=".$subacct."&subacctpwd=".$subacctpwd."&message=".urlencode($msg)."&sender=".urlencode($sender)."&sendto=".urlencode($phone)."&msgtype=0";	
@fopen($url, "r");
}*/


?>