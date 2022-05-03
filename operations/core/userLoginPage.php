<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>
<body>

  
         
 <div class="row" style="padding: 10px;">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

<?php
if(isset($_SESSION['userId']))
{
         echo '<div class="auth-div">';

          $sel_pics = $paydb->query("SELECT pics FROM ".USERS." WHERE userId = '$_SESSION[userId]' AND merchantId = '$_SESSION[merchID]' ") or die(mysqli_error($paydb));

                   $folder = 'adminDashboard/production/user_pics/';

                   $fetch_pics = $sel_pics->fetch_array();

                   $pics = $fetch_pics[0];

                   $path = $folder.$pics;

                   if($pics != NULL)
                   {
                     echo '<img src="'.$path.'" class="img-circle"  />';
                   }
                   else
                   {
                     echo '<img src="images/avatar.png" class="img-circle" />';
                   } 
             

              echo '<h4> You are still logged on, '.$_SESSION['userId'].'! </h4> <br/>';

             $usr = "'".$_SESSION['userId']."'"; 
             $token = "'".$_SESSION['token']."'"; //Token session set at /adminDashboard/production/auth_page.php
       
             echo '<p> <button type="button" class="btn btn-primary button_trans" onclick="log_auth('.$usr.', '.$token.')"> Go Back to Dashboard <i class="fa fa-angle-double-right"></i> </button> </p>

             <br/><br/>

             <a href="#" onclick="logAdminOut()"> [Logout] </a>

       

    </div>';
}
else {
?>
<form name="user_login" id="user_login" method="" action=""> 
    <div class="col-md-3"> </div>

      <div class="col-md-6">
         <div class="login-div">

             <h4> USER LOG IN </h4>
               <img src="images/avatar.png" class="img-circle" />
               <br/>
            
              	<div class="form-group has-feedback">
                	   <input type="text" class="form-control" name="userId" id="userId" placeholder="Username" onKeyUp="check_username()" maxlength="8">
                     <i class="glyphicon glyphicon-user form-control-feedback right" aria-hidden="true"></i>
                </div>

                <div id="password-div"> </div>

                

          </div>
        </div>

      <div class="col-md-3"> </div><br/>
        
  </div><br/>

  </form>

  <div id="login-result" style="display: block; text-align: center;"> </div>

   <h6 style="display: block; text-align: center;" id="footnote">  [<a href=""> Forgot your password? </a>] &nbsp;&nbsp; New to paytonify?  [<a href="#" data-toggle="modal" data-target="#modal-signup"> Sign Up Now? </a>] </h6>

  

</body>
</html>
<?php  } ?>