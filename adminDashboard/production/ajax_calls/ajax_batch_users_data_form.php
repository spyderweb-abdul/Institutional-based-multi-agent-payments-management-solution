<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $merchant_name = $getDetails['merchant_name'];
    //$current_session = $getDetails['current_session'];


$upload_file = $_FILES['batch_user_upload']['tmp_name'];

$myFile = fopen($upload_file, "r");

	 function throw_ex($err)
    {
        throw new Exception($err);
        
    }
    try
    {
        if($myFile == true)//If file opens
        {
		$num_row_inserted = 0; //Initialize the num of rows in file inserted
		$num_row_exist = 0;   //Initialize the num of existing User Id rows found when uploading the file

				while(($fileop = fgetcsv($myFile, 1000, ",")) !== false) //While each row is read
				{
					$userId = $fileop[0];
					$user_name = $fileop[1];
					$user_email = $fileop[2];
					$user_phone = $fileop[3];
					$roleId = 6;

					  //First of all check the existence of each inserted user in the dbase
					   $check_user = $paydb->query("SELECT userId FROM ".USERS." WHERE userId = '$userId' AND merchantId = '$merchantId'") or throw_ex(mysqli_error($paydb));
					   $num_row = mysqli_num_rows($check_user);

					   if($num_row == 0)
					   {
					
						$ins_file = $paydb->query("INSERT INTO ".USERS." (userId, user_name, user_email, user_phone, merchantId, roleId) VALUES ('$userId', '$user_name', '$user_email', '$user_phone', '$merchantId', '$roleId') ") or throw_ex(mysqli_error($paydb));
					   }
					   else
					   {
				            $num_row_exist++; //Increament
					   }
					
						//send_notification($name, $faculty, $dept, $prog, $session, $phone, $email, $min_dur, $max_dur);
				         $num_row_inserted++; //Increament
					
				 }
                   
                   //Check to see if file has been uploaded before: By comparing the no. of rows and the number of existing User IDs.
				   if($num_row_inserted == $num_row_exist){ echo '<p style="color:red"> *It seems you have uploaded this file before. </p>'; }

				  fclose($myFile);//Close file

				                echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF; margin-top: 15px;"> 
							          <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
							          <i class="fa fa-warning"></i> File Uploaded Successfully. No. of rows uploaded: '.$num_row_inserted. '</div>';


							    echo '<p style="color:red"> <i class="fa fa-angle-double-right"></i> No. of Existing IDs: '.$num_row_exist. '</p>';


				      mysqli_close($paydb);
			      }
			      else //If file doesn't open
			      {
			      	 echo '<p style="color: red;"> File could not open. Operation Failed </p>';
			      }
			}
			catch(Exception $e){
                 
                 echo 'Error: '.$e;
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