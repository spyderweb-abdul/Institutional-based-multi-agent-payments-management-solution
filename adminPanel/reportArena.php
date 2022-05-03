<?php
session_start();

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

include_once('../include/constant_connection.php');

  
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

  <table width="1008" height="367" border="0" align="center" cellpadding="7" cellspacing="7" >
        <tr>
        <td width="144" height="353" valign="top">
          <?php include ('../include/menu.php'); ?>
         </td>
        <td width="815" valign="top">
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg2">
          <tr>
            <td width="100%" height="379" align="center">
            <p class="payMode"> CHANGE PASSWORD </p>
            <?php   
			
			$sql = $paydb->query("SELECT * FROM ".TBL_ADMIN." WHERE userID = '$_SESSION[userID]'");
			$chk = mysqli_fetch_array($sql);
			
			if($chk['active'] == 'YES')
			{
              include('userSessionLog.php');			
			}
			else
			{
				echo '<div class="btn btn-danger btn-sm"> Your account is still inactive. Kindly change your password </div>';
			}
			
			
			
			?>
             
            <div class="feedback"> </div><br/>
            <div id="value"> </div>
            <form id="form1" name="form1" method="post" action="">
            <table width="225" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td width="205">
         
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
        <input name="userID" type="text" autofocus="autofocus" required="required" class="form-control styleTb" id="userID" placeholder="USERNAME" title="USER ID" value="<?php echo $_SESSION['userID'] ?>" size="30" readonly="readonly" data-toggle="tooltip" data-placement="bottom" />
        </div>
        <br/>
                      
                
                </td>
              </tr>
              <tr>
                <td>
           
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-lock"></b></span>
        <input type="password" class="form-control styleTb" size="30" required="required" placeholder="NEW PASSWORD" name="passCode" id="passCode" data-toggle="tooltip" data-placement="bottom" title="NEW PASSWORD" />
        </div>
        <br/>
                                       
                
                </td>
              </tr>
              <tr>
                <td>
                
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-lock"></b></span>
        <input type="password" class="form-control styleTb" size="30" required="required" placeholder="CONFIRM PASSWORD" name="confirm" id="confirm" data-toggle="tooltip" data-placement="bottom" title="CONFIRM NEW PASSWORD" onchange="confMe();" />
        </div>
         <div id="chk" class="styleTb"></div> 
         <br/>             
          
                
                </td>
              </tr>
              <tr>
                <td>
                  <input type="button" name="btn-change" id="btn-change" class="btn btn-success styleTb2" value="CHANGE PASSWORD" />
               </td>
              </tr>
            </table>
            </form>
            </td>
          </tr>
        </table></td>
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

function confMe()
{
	if(($("#confirm").val()) != ($("#passCode").val())){
		
		$("#chk").html('*Password Does Not Match!');
	}
	else
	{
		$("#chk").empty();
	}
}

 $("#btn-change").click(function(){
	 
	   if(($("#userID").val() == '') || ($("#passCode").val() == ''))
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
					url: "ajaxChangePassword.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feedback").empty();
						$(".feedback").html(msg);
						$(".feedback").fadeOut(6400, function(){window.location.reload();})	
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});
</script>
</body>
</html>