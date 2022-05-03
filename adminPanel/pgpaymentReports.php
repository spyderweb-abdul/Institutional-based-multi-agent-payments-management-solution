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
  <li class="active"><a data-toggle="pill" href="#menu2">FEES ITEM BREAKDOWN</a></li>
  <li><a data-toggle="pill" href="#menu3">PAYMENT BY FACULTY</a></li>
 <!-- <li><a data-toggle="pill" href="#menu4">PAYMENT BY DEPARTMENT</a></li>-->
  <li><a data-toggle="pill" href="#menu5">PAYMENT BY PROGRAMME</a></li>
</ul>

<div class="tab-content">
  
  
  <!-- 1st TAB PILLS -->
  <div id="menu2" class="tab-pane fade in active">
  <br/>
  <hr noshade="noshade" />
    <h5>PG Fees Item Breakdown </h5>
    <p>
    
    <div id="val"> </div>
   <form name="pg" id="pg">
     <table border="0" cellspacing="5" cellpadding="5">
     <tr>
    <td>            <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="session2" id="session2" />
                    <option value="">-SELECT SESSION-</option>
                      <?php
						 				   
							  for($i=2011; $i<= date('Y'); $i++)
							  {
								$y = $i + 1;
								$s = $i."/".$y;
							echo '<option value="'.$s.'">'.$s.'</option>';	  
							  }
							   
							  ?>
                    
                    </select>
                    
        <span class="input-group-btn"><input type="button" name="breakdown" id="breakdown" value="Fetch Breakdown Summary" class="btn btn-success" /></span>
        </div>
    
    </td>
     </tr>
    </table>
    </form>
    
    <hr noshade="noshade"  />
    
    <p class="pgbreakdown"> </p>
    
    
    </p>
  </div>

<!-- 2nd TAB PILLS -->
 <div id="menu3" class="tab-pane fade">
     <br/>
  <hr noshade="noshade" />
    <h5>PG Payment By Faculty </h5>
    <p>
    
    <div id="val4"> </div>
   <form name="pg_fac" id="pg_fac">
     <table border="0" cellspacing="5" cellpadding="5">
     <tr>
    <td>            <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="session3" id="session3" />
                    <option value="">-SELECT SESSION-</option>
                      <?php
						 				   
							  for($i=2011; $i<= date('Y'); $i++)
							  {
								$y = $i + 1;
								$s = $i."/".$y;
							echo '<option value="'.$s.'">'.$s.'</option>';	  
							  }
							   
							  ?>
                    
                    </select>
                    
        <span class="input-group-btn"><input type="button" name="faculty" id="faculty" value="Fetch Faculty Summary" class="btn btn-success" /></span>
        </div>
    
    </td>
     </tr>
    </table>
    </form>
    
    <hr noshade="noshade"  />
    
    <p class="pgfac"> </p>
    
    </p>
  </div>


<!-- 3rd TAB PILLS -->
 <!--<div id="menu4" class="tab-pane fade">
     <br/>
  <hr noshade="noshade" />
    <h5>PG Payment By Department </h5>
    <p>
    
    <div id="val6"> </div>
   <form name="pg_dept" id="pg_dept">
     <table border="0" cellspacing="5" cellpadding="5">
     <tr>
    <td>            <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="session5" id="session5" disabled="disabled"/>
                    <option value="">-SELECT SESSION-</option>
                      <?php
						 				   
							 /* for($i=2011; $i<= date('Y'); $i++)
							  {
								$y = $i + 1;
								$s = $i."/".$y;
							echo '<option value="'.$s.'">'.$s.'</option>';	  
							  }
							   */
							  ?>
                    
                    </select>
                    
        <span class="input-group-btn"><input type="button" name="dept" id="dept" value="Fetch Department Summary" class="btn btn-success" /></span>
        </div>
    
    </td>
     </tr>
    </table>
    </form>
    
    <hr noshade="noshade"  />
    
    <p class="pgdept"> </p>
    
    </p>
  </div>
-->


<!-- 4th TAB PILLS -->
 <div id="menu5" class="tab-pane fade">
 <br/>
 <hr noshade="noshade"  />
    <h5>PG Payment Breakdown by Programmes</h5>
    <p>
    
     <div id="val5"> </div>
   <form name="pg_prog" id="pg_prog">
     <table border="0" cellspacing="5" cellpadding="5">
     <tr>
    <td>            <div class="input-group">
                    <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                    <select class="form-control styleTb" name="session4" id="session4" />
                    <option value="">-SELECT SESSION-</option>
                      <?php
						 				   
							  for($i=2011; $i<= date('Y'); $i++)
							  {
								$y = $i + 1;
								$s = $i."/".$y;
							echo '<option value="'.$s.'">'.$s.'</option>';	  
							  }
							   
							  ?>
                    
                    </select>
                    
        <span class="input-group-btn"><input type="button" name="programme" id="programme" value="Fetch Programme Summary" class="btn btn-success" /></span>
        </div>
    
    </td>
     </tr>
    </table>
    </form>
    
    <hr noshade="noshade"  />
    
    <p class="pgprog"> </p>

    </p>
 </div>
  
  
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

<script src="../js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">

//UG Fees Item Breakdown	
	 $("#breakdown").click(function(){
	 
	   if(($("#session2").val() == ''))
	   {
		   $("#val").html('*You must select a session');
		   
	   }
	   else
	   {
		   $("#val").empty();
		   $(".pgbreakdown").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#pg").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxPgBreakdown.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".pgbreakdown").empty();
						$(".pgbreakdown").html(msg);
						
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});
	
	
	//Payment By Faculty	
	 $("#faculty").click(function(){
	 
	   if(($("#session3").val() == ''))
	   {
		   $("#val4").html('*You must select a session');
		   
	   }
	   else
	   {
		   $("#val4").empty();
		   $(".pgfac").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#pg_fac").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxPgFacultyBreakdown.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".pgfac").empty();
						$(".pgfac").html(msg);
						
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});
	
	//Payment By Programme	
	 $("#programme").click(function(){
	 
	   if(($("#session4").val() == ''))
	   {
		   $("#val5").html('*You must select a session');
		   
	   }
	   else
	   {
		   $("#val5").empty();
		   $(".pgprog").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#pg_prog").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxPgProgBreakdown.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".pgprog").empty();
						$(".pgprog").html(msg);
						
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});	
	
	//Payment By Dpartment
	 $("#dept").click(function(){
	 
	   if(($("#session5").val() == ''))
	   {
		   $("#val6").html('*You must select a session');
		   
	   }
	   else
	   {
		   $("#val6").empty();
		   $(".pgdept").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#pg_dept").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxPgDeptBreakdown.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".pgdept").empty();
						$(".pgdept").html(msg);
						
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