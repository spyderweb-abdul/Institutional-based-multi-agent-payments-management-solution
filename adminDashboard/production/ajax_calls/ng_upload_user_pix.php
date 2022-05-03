<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

     $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $data = file_get_contents("php://input");
    $postData = json_decode($data);
    
    $userId = $_SESSION['userId'];
    $file_path = '../user_pics/'; //Pics folder


if(isset($_FILES["pix_upload"]) && $_FILES["pix_upload"]["error"]== UPLOAD_ERR_OK)
{
    
        
    //Is file size is less than allowed size.
    if ($_FILES["pix_upload"]["size"] > 5242880) 
    {
        die("File size is too big!");
    }    
    //allowed file type Server side check
    switch(strtolower($_FILES['pix_upload']['type']))
        {
            //allowed file types
            case 'image/png': 
            case 'image/gif': 
            case 'image/jpeg': 
            case 'image/pjpeg':
            //case 'text/plain':
            //case 'text/html': //html file
            //case 'application/x-zip-compressed':
            //case 'application/pdf':
            //case 'application/msword':
            //case 'application/vnd.ms-excel':
            //case 'video/mp4':
                break;
            default:
                die('Unsupported File!'); //output error
    }
              
    
    $File_Name          = strtolower($_FILES['pix_upload']['name']);
    $File_Ext           = substr(strrchr($File_Name, '.'), 1); //get file extention
    $NewFileName        = $userId.'-'.$merchantId.'.'.$File_Ext;        //new file name
    $filesize           = $_FILES["pix_upload"]["size"]; //File Size
    $filemime           = $_FILES["pix_upload"]["type"]; //File Type
    
    
    if(move_uploaded_file($_FILES['pix_upload']['tmp_name'], $file_path.$NewFileName ))//If file uploaded successfully into the upload/photos folder
    {
            $update_pics = $paydb->query("UPDATE ".USERS. " SET pics = '$NewFileName' WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die(mysqli_error($paydb));
    
    
            if($update_pics == true)//If not filled, do this:
            {
                $data = 'Picture Updated Successfully';
            }
            
            else //else, if filled, do this:
            {       
                
                $data =  'DB Operation Failed. Please try again.';
            }
        
    }    
    else
    {
              $data =  'Error Uploading File';
    }
    
}
else
{
    $data = 'Something wrong with upload! Is "upload_max_filesize" set correctly?';
}

          
  echo json_encode($data);
            


?>