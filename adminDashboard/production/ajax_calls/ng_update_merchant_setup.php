<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';



 if(isset($_FILES["merchant_logo"]) && ($_FILES["merchant_logo"]["error"]== UPLOAD_ERR_OK))
{    
      $merchant_logo = $_FILES['merchant_logo']['name'];
      $merchant_name = trim_input($_POST['merchantName']);
      $session = trim_input($_POST['currentSess']);
      $merchant_email = trim_input($_POST['merchantEmail']);
      $merchant_type_id = trim_input($_POST['merchantType']);
      $merchantId = trim_input($_POST['merchId']);


    define("UPLOAD_DIR", "../../../logos/");

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
                       <i class="fa fa-ban"></i> Logo Upload Operation Failed. Please, Try again. 
                       </div>';

                       exit();
      }

      chmod(UPLOAD_DIR.$newFileName, 0644); //Give the file the necessary permission
}
else
{
     $data = file_get_contents("php://input");
     $postData = json_decode($data);

      $merchant_name = $postData->merchantName;
      $session = $postData->currentSess;
      $merchant_email = $postData->merchantEmail;
      $merchant_type_id = $postData->merchantType;
      $merchantId = $postData->merchId;

     //Get current logo name
     $logo_name = $paydb->query("SELECT logo FROM ".MERCHANTS." WHERE merchantId = '$merchantId'") or die(mysqli_error($paydb));
     $logo_res = $logo_name->fetch_array();

     $newFileName = $logo_res[0];
}


    //Throw exception
    function throw_ex($err)
    {
        throw new Exception($err);
        
    }

    try
    {

      //Check availability first

      $update = $paydb->query("UPDATE ".MERCHANTS." SET merchant_name = '$merchant_name', merchantTypeId = '$merchant_type_id', merchant_email ='$merchant_email', current_session = '$session', logo = '$newFileName' WHERE merchantId = '$merchantId'") or throw_ex(mysqli_error($paydb));

      if($update == true)
      {
         $data = 'Merchant Details Edited Successfully.';
      }
      else
      {      
         $data = 'Edit Operation Failed.';
      }
			
    }
		catch(Exception $e)
    {                 
        $data = 'Error: '.$e;
		}

  echo json_encode($data);
?>