<?php
session_start();
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
<link href="../font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
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


.nav-pills> li.active > a {
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
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg2">
          <tr>
            <td width="100%" height="282" align="center">
            <p class="payMode"> PAYMENT REPORTS</p>
            
            <table width="99%" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td height="201" valign="top">
                
<ul class="nav nav-pills">
  <li class="active"><a data-toggle="pill" href="#menu">PAYMENT CODES</a></li>
  <li><a data-toggle="pill" href="#menu1">PAYMENT SUMMARY</a></li>
</ul>

<!-- 1st TAB PILLS -->
<div class="tab-content">
  <div id="menu" class="tab-pane fade in active">
  <br/>
  <hr noshade="noshade" />
    <h5>Available Payments Code</h5>
    <hr noshade="noshade" />
    <p>
    <?php
	  $ft = $paydb->query("SELECT * FROM payment_code ORDER BY code ASC");
	  
	  
	  $i = 1;
	  
		echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb"><tr>';
		echo '<th> S/No </th>';
		echo '<th> PAYMENT TYPE </th>';
		echo '<th> CODE </th>';
		echo '</tr><tr>';  
	     while($r = mysqli_fetch_array($ft))
	  {
		  echo '<td>'.$i.'</td>';
		  echo '<td>'. $r['paymentType'].'</td>';
		  echo '<td>'.$r['code'].'</td>';
		  echo '</tr>';
		  $i++;
	  }
	     echo '</table>';
		  

    
    ?>
    </p>
  </div>
  
  <!-- 2nd TAB PILLS -->
  <div id="menu1" class="tab-pane fade">
  <br/>
  <hr noshade="noshade" />
    <h5>Payments Summary</h5>
    <p>
    
    <div id="value"> </div>
     <form name="rep" id="rep">
     <table border="0" cellspacing="5" cellpadding="5">
     <tr>
    <td>            <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="session" id="session" />
                    <option value="">-SELECT SESSION-</option>
                    <?php
					  $ses = $paydb->query("SELECT session FROM ".TBL_PAYMENTS_RECORD." GROUP BY session");
					  
					  while($s = mysqli_fetch_array($ses))
					  {
						  echo '<option value="'.$s['session'].'">'.$s['session'].'</option>';
					  }
					?>
                    
                    </select>
                    
        <span class="input-group-btn"><input type="button" name="report" id="report" value="Fetch Payment Summary" class="btn btn-success" /></span>
        </div>
    
    </td>
     </tr>
    </table>
    </form>
    <hr noshade="noshade" />

          <br/>
          <p class="feedback"> </p>
    
    </p>
  </div>

</div>
          
                
                
                </td>
              </tr>
            </table>
            <p>&nbsp;</p></td>
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

<script src="../js/jquery-1.10.2.min.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">

//General Payment Report Breakdown
 $("#report").click(function(){
	 
	   if(($("#session").val() == ''))
	   {
		   $("#value").html('*You must select a session');
		   
	   }
	   else
	   {
		   $("#value").empty();
		   $(".feedback").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#rep").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxSummaryReport.php",
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