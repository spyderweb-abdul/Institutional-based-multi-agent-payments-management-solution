<?php
session_start();
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));

include_once('../include/constant_connection.php');


/*$timeout = 20 * 60;

if(isset($_SESSION['timeout']))
{
$dur = time() - (int)$_SESSION['timeout'];

if($dur > $timeout)
{
	session_destroy();
	session_start();
	header('Location: sessionLog.php');
}
}
*/
$_SESSION['timeout'] = time();

 if(isset($_GET['token']))
  {
	  $token = md5($_GET['token']);
	  $_SESSION['userID'] = $token;
  }

 if((!isset($_SESSION['userID'])) )
  {
	 header('Location: sessionLog.php');
  }

  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/udus-logo.png" />
<title>UDUS |  Integrated Payment System - UDUPay</title>

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../pgcourselist.js" type="text/javascript"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.styleTb
{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight:500;
	color:#000000;
	font-size:11px;

}
.styleTb2
{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight:500;
	color:#FFFFFF;
	font-size:11px;

}

.nav-sidebar > li > a {
	color:#060;
	
}
.nav-sidebar > li > a:hover {
	color:#060;
	background-color:#F2F2F2;
 }
.nav-sidebar > li > a:focus {
	color:#FFF;
	background-color: #FC6;
}


.nav-pills > li.active > a {
	color:#FFF;
	background-color: #090;
	
}
.nav-pills > li.active> a:hover {
	color:#060;
	background-color: #F2F2F2;
	
}
.nav-pills > li.active > a:focus {
	color:#FFF;
	background-color: #FC6;
	
}
</style>
</head>

<body>
<div class="page">
  
  <table width="554" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="62" height="119" align="right" valign="middle"><img src="../images/udus-logo.png" width="71" height="73" /></td>
      <td width="457" align="center" valign="middle"><span class="bannerStyle">USMANU DANFODIYO UNIVERSITY SOKOTO</span>
      <span class="uduPay">Integrated Payment Systems Platform (UDUPay)</span></td>
    </tr>
  </table>
  <br/>
  
   <table width="1008" height="381" border="0" align="center" cellpadding="7" cellspacing="7" >
        <tr>
        <td width="144" height="367" valign="top">
          <?php include ('../include/menu.php'); ?>
         </td>
         
        <td width="815" valign="top">
             <?php   
						
			$sql = $paydb->query("SELECT * FROM ".TBL_ADMIN." WHERE userID = '$_SESSION[userID]'");
			$chk = mysqli_fetch_array($sql);
			
			if($chk['active'] == 'YES')
			{
				include('userSessionLog.php');
				$readonly = 'readonly';	
			
			?>
        <table width="100%" border="0" cellpadding="5" cellspacing="5" class="table_bg2">
          <tr>
            <td width="100%" height="313" align="center">
            <p class="payMode"> CREATE USERS </p>
             
            <div class="feedback"> </div><br/><br/>
            <div id="value"> </div>
            <form id="form1" name="form1" method="post" action="">
            <table width="248" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td width="228">
         
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
        <input <?php if(isset($_GET['edit'])){ echo 'value='.$_GET['edit']; echo ' readonly='.$readonly;} ?> name="userID" type="text" autofocus="autofocus" required="required" class="form-control styleTb" id="userID" placeholder="USERNAME (not more than 8-xters)" title="USER ID"  size="30" maxlength="10" data-toggle="tooltip" data-placement="bottom" />
        </div>
       
                      
                
                </td>
              </tr>
              <tr>
                <td>
           
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-lock"></b></span>
        <input <?php if(isset($_GET['edit'])){ echo 'value='.$_GET['edit'];} ?> name="passCode" type="password" required="required" class="form-control styleTb" id="passCode" placeholder="PASSWORD (not more than 8-xters)" title="USER PASSWORD" size="30" maxlength="10" data-toggle="tooltip" data-placement="bottom" />
        </div>
        <br/>
       
                                       
                
                </td>
              </tr>
              <tr>
                <td>
                
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
        <select class="form-control styleTb" name="accessLevel" id="accessLevel" data-toggle="tooltip" data-placement="bottom" title="ACCESS LEVEL" />
        <option value="">-SELECT ACCESS LEVEL- </option>
        <option value="1"> Admin Level </option>
        <option value="2"> Report Level </option>
        <option value="3"> Verifier Level </option>
        </select>
        </div>
        <br/>
         <div id="chk" class="styleTb"></div> 
                    
          
                
                </td>
              </tr>
              <tr>
                <td>
                  <input type="button" name="btn-create" id="btn-create" class="btn btn-success styleTb2" value="CREATE NEW USER" />
               </td>
              </tr>
            </table>
            </form>
            <br/>
            
            <?php  
			   if($chk['accessLevel'] == 1)
			   {
				   			$sql1 = $paydb->query("SELECT * FROM ".TBL_ADMIN);

				   echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				   echo '<td> <strong>USER ID</strong> </td>';
				   echo '<td> <strong>ACCESS LEVEL</strong> </td>';
				   echo '<td><strong> ACTIVE</strong> </td>';
				   echo '<td> <strong>DELETE USER</strong> </td>';
				   echo '<td> <strong>RESET USER</strong> </td>';
				   echo '</tr>';
				   while($r= mysqli_fetch_array($sql1))
				   {
					   $userID = $r['userID'];
					   $pcd = $r['passcode'];
					   if($r['active'] == 'YES')
					   {
						   $active = 'ACTIVE';
					   }
					   else
					   {
						   $active = 'INACTIVE';
					   }
					   echo '<tr>';
					   echo '<td>'.$userID.'</td>';
					   echo '<td>'.$r['accessLevel'].'</td>';
					   echo '<td>'.$active.'</td>';
					   ?>
					  <td> <a href="#" onClick="doThis('<?php echo $userID ?>');"> Delete </a> </td>
                      <?php
					   echo '<td> <a href="'.($_SERVER['PHP_SELF']).'?edit='.$userID.'"> Reset </a></td>';
					   
				   }
				   echo '</tr></table><br/><br/>';
				   
			   }
			
			?>
            
            
            </td>
          </tr>
        </table>
        
        <?php
		}
			else
			{
				echo '<div class="btn btn-danger"> Your account is still inactive. Kindly change your password. </div>';
			}
	  ?>
        
        </td>
      </tr>
  </table>
  <br/>
</div>

<div class="clearf"></div>
<div class="footer">
Copyright &copy; <?php echo date('Y') ?> All rights reserved - UDUS <br/><br/>
Concept Designed and Developed By: UDUS WEB Team</div>
</div>

<script src="../js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">

 $("#btn-create").click(function(){
	 
	   if(($("#userID").val() == '') || ($("#passCode").val() == '') || ($("#accessLevel").val() == ''))
	   {
		   $("#value").html('*Field(s) cannot be empty');
		   
	   }
	   else
	   {
		   $("#value").empty();
		   $(".feedback").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#form1").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCreateUser.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feedback").empty();
						$(".feedback").html(msg);
						$(".feedback").fadeOut(6400, function(){ window.location.reload(); });		
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});
	
	
	 function doThis(userID)
	 {
		$(".feedback").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		$.ajax({
    				type: "GET",
					url: "ajaxDeleteUser.php",
					data: "userid=" + userID,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feedback").empty();
						$(".feedback").html(msg);
						$(".feedback").fadeOut(6400, function(){ window.location.reload(); });		
					},
					error: function()
					{
						alert("failure");
					}
      		});
	return false;
   }
</script>
</body>
</html>