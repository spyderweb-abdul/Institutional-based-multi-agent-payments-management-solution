<?php
session_start();
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));


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

  <table width="1038" height="381" border="0" align="center" cellpadding="7" cellspacing="7" >
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
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg2">
          <tr>
            <td width="100%" height="313" align="center" valign="top">
            <br/>
            <p id="value"> </p>
            <form id="form1" name="form1" method="post" action="">
            <table width="88%" border="0" cellspacing="5" cellpadding="5" class="img-thumbnail styleTb">
              <tr>
                <td height="30" style="text-align:left"><strong>FETCH ALL WHERE PAYMENT IS:</strong></td>
                <td style="text-align:left"><strong>AND PAYMENT STATUS IS:</strong></td>
                <td><strong>AND SESSION IS:</strong></td>
              </tr>
              <tr>
                <td width="37%" height="30" style="text-align:left">
                  <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="paymentType" id="paymentType" data-toggle="tooltip" data-placement="bottom" title="PAYMENT TYPE" />
                    <option value="">-SELECT PAYMENT TYPE- </option>
                    <?php
		   $drp = $paydb->query("SELECT DISTINCT(paymentType) FROM ".TBL_PAYMENTS_RECORD." ORDER BY paymentType ASC");
		   
		   while($r = mysqli_fetch_array($drp)){
			   
			   echo '<option value="'.$r['paymentType'].'">'.$r['paymentType'].'</option>';
		   }
		   
		        $ug = "UG REGISTRATION FEE";
				$pg = "PG REGISTRATION FEE (EduERP)";
				//$ugAcc = "UG ACCEPTANCE";
				
			  // echo '<option value="'.$ugAcc.'">'.$ugAcc.'</option>';
		       echo '<option value="'.$ug.'">'.$ug.'</option>';
			   echo '<option value="'.$pg.'">'.$pg.'</option>';

		   
		?>
                    
                    </select>
                    </div>
                  
                </td>
                <td width="37%" style="text-align:left">
                  
                  <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-close"></b></span>
                    <select class="form-control styleTb" name="status" id="status" data-toggle="tooltip" data-placement="bottom" title="PAYMENT STATUS" />
                    <option value="">-SELECT PAYMENT STATUS- </option>
                    <option value="PENDING"> PENDING </option>
                    <option value="PAID"> PAID </option>
                    </select>
                    </div>
                  
                  
                  
                </td>
                <td width="26%">
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-time"></b></span>
        <select class="form-control styleTb" name="session" id="session" data-toggle="tooltip" data-placement="bottom" title="SESSION" />
        <option value="">-SELECT SESSION- </option>
          <?php
		   $drp = $paydb->query("SELECT DISTINCT(session) FROM ".TBL_PAYMENTS_RECORD." ORDER BY session ASC");
		   
		   while($r = mysqli_fetch_array($drp)){
			   
			   echo '<option value="'.$r['session'].'">'.$r['session'].'</option>';
		   }
		   
		?>
        </select>
        </div>
                
                </td>
              </tr>
              <tr>
                <td height="47" colspan="3" valign="bottom" style="text-align:center"><input type="button" name="btn-fetch" id="btn-fetch" value="Fetch Report" class="btn-success" /></td>
                </tr>
            </table>
            </form>
           <br/>
           
           <p class="feedback"> </p>
           
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

 $("#btn-fetch").click(function(){
	 
	   if(($("#paymentType").val() == '') || ($("#status").val() == '') || ($("#session").val() == ''))
	   {
		   $("#value").html('*Fields cannot be empty');
		   
	   }
	   else
	   {
		   $("#value").empty();
		   $(".feedback").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#form1").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxFetchPaymentStatus.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feedback").empty();
						$(".feedback").html(msg);
						
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