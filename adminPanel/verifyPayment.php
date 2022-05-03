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
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg2">
          <tr>
            <td width="100%" height="282" align="center">
            <p class="payMode"> PAYMENTS VERIFICATION</p>
            <table width="802" border="0" align="center" cellpadding="5" cellspacing="5">
              <tr>
                <td width="782" height="327" valign="top">
                <ul class="nav nav-pills">
                  <li class="active"><a data-toggle="pill" href="#menu2">VERIFY PAYMENT</a></li>
                  <li><a data-toggle="pill" href="#menu3">ISSUE CLEARANCE</a></li>
                  <li><a data-toggle="pill" href="#menu4">AUTO VERIFY</a></li>
                  <li><a data-toggle="pill" href="#menu5"> DELETE INVOICE </a></li>

                </ul>
                
                <div class="tab-content">
  
  
           <!-- 1st TAB PILLS -->
            <div id="menu2" class="tab-pane fade in active">
              <br/>
                <h5>Verify a Payment </h5>
                  <hr noshade="noshade" />
                
                  
                   <div id="value"> </div>
            <form id="form1" name="form1" method="post" action="">
            <table width="277" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td width="257">
        
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-ok"></b></span>
        <input name="orderID" type="text" autofocus="autofocus" required="required" class="form-control styleTb" id="orderID" placeholder="INSERT ORDER ID" title="ORDER ID"  size="30" data-toggle="tooltip" data-placement="bottom" />
        </div>
        <br/>
                </td>
              </tr>
          
              <tr>
                <td>
                  <input type="button" name="btn-verify" id="btn-verify" class="btn btn-success styleTb2" value="VERIFY PAYMENT" />
               </td>
              </tr>
            </table>
            </form>
            <br/>
            
            <br/><div class="feedback"> </div><br/><br/>
                              
            </div>
            
            
            
            <!-- 2nd Tab -->
            
           <div id="menu3" class="tab-pane fade in">
            <br/>
            <h5>Clear a Student </h5>
                  <hr noshade="noshade" />
                  
             <div id="value2"> </div>
            <form id="form2" name="form2" method="post" action="">
            <table width="277" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td width="257">
                
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
        <select class="form-control styleTb" name="category" id="category" />
                    <option value="">-SELECT CATEGORY-</option>
                    <option value="UNDERGRADUATE">UNDERGRADUATE</option>
                    <option value="POSTGRADUATE">POSTGRADUATE</option>
                    
         </select>           
                     
        </div>        
        <br/>
         
                <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-ok"></b></span>
        <input name="userId" type="text" required="required" class="form-control styleTb" id="userId" placeholder="INSERT ADMISSION NO." title="ADMISSION NO."  size="30" data-toggle="tooltip" data-placement="bottom" />
        </div>
        <br/>
                </td>
              </tr>
          
              <tr>
                <td>
                  <input type="button" name="btn-clear" id="btn-clear" class="btn btn-success styleTb2" value="FETCH PAYMENTS" />
               </td>
              </tr>
            </table>
            </form>
            <br/>
            
            <br/><div class="clearance"> </div><br/><br/>
            
           </div>
           
           
           <!-- 3rd Tab -->
    
            <div id="menu4" class="tab-pane fade in">
              <br/>
                <h5>Auto Verify Payments </h5>
                  <hr noshade="noshade" />
                  
                  <div class="value3"> </div>
                  <form name="form3" id="form3" method="post" action="" >
                  <table width="" border="0" cellspacing="5" cellpadding="5">
                   <tr>
                     <td>
                      <div class="input-group">
                      <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-folder-open"></b></span>
                      <select class="form-control styleTb" name="auto-cat" id="auto-cat" />
                      <option value="">-SELECT CATEGORY-</option>
                              <?php
		                      $drp = $paydb->query("SELECT DISTINCT(paymentType) FROM ".TBL_PAYMENTS_RECORD." ORDER BY paymentType ASC");
		   
		                        while($r = mysqli_fetch_array($drp)){
			   
			                    echo '<option value="'.$r['paymentType'].'">'.$r['paymentType'].'</option>';
		                       }
		   
		                      ?>
                      </select>           
                      </div> 
                      <br/>  
                           
                     </td>
                     </tr>
                     
                     <tr>
                     <td>
                     <div class="input-group">
                     <span class="input-group-addon"><b class="glyphicon glyphicon-arrow-down"></b></span>
                     <select class="form-control styleTb" name="item_no" id="item_no" />
                     <option value="">-SELECT NO of ITERATION-</option>
                     <?php
					   for ($i = 0; $i <= 100;)
					   {
						   
						   echo '<option value="'.$i.'">'.$i.'</option>';
						   $i = $i + 10;
					   }
					 
					 
                      ?>
                     
                     </select>
                     
                     </div>
                     <br/>
                     </td>
                     </tr>
                     
                     <tr>
                     <td>
                    <input type="button" name="btn-auto" id="btn-auto" class="btn btn-success styleTb2" value="AUTO VERIFY NOW" />
                    
                      <p class="auto-feedback"> </p>
                     </td>
                   </tr>
                 </table>
                  </form>
              </div>  
            
             <!-- 4th Tab -->
            
           <div id="menu5" class="tab-pane fade in">
            <br/>
            <h5>Delete Invoice(s) </h5>
                  <hr noshade="noshade" />
                  
            <form id="form_delete" name="form_delete" method="post" action="">
            <table width="277" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td width="257">
         
                <div class="input-group">
                <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-ok"></b></span>
                <input name="payer_id" type="text" required="required" class="form-control styleTb" id="payer_id" placeholder="INSERT PAYER ID." size="30" />
                </div>
                <br/>
                
                </td>
              </tr>
          
              <tr>
                <td>
                  <input type="button" name="btn-del" id="btn-del" class="btn btn-success styleTb2" value="FETCH INVOICE RECORDS" />
               </td>
              </tr>
            </table>
          </form>
            <br/>
            <br/><div class="invoices"> </div><br/><br/>
            
            
            
           </div>
            
            
            </div>
            

                
                </td>
              </tr>
            </table>
         
            
            
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

//Ajax For Verification
 $("#btn-verify").click(function(){
	 
	   if(($("#orderID").val() == ''))
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
					url: "ajaxCalls/ajaxVerifyPayment.php",
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
	
//Ajax For Clearance	
	 $("#btn-clear").click(function(){
	 
	   if(($("#userId").val() == '') || $('#category').val() == '')
	   {
		   $("#value2").html('*Field(s) cannot be empty');
		   
	   }
	   else
	   {
		   $("#value2").empty();
		   $(".clearance").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#form2").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxClearPayment.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".clearance").empty();
						$(".clearance").html(msg);
						
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});

//Ajax For Auto-Verification	
	 $("#btn-auto").click(function(){
	 
	   if(($("#auto-cat").val() == '') || $('#item_no').val() == '')
	   {
		   $(".value3").html('*Field(s) cannot be empty');
		   
	   }
	   else
	   {
		   $(".value3").empty();
		   $(".auto-feedback").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#form3").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/ajaxAutoVerify.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".auto-feedback").empty();
						$(".auto-feedback").html(msg);
						
					},
					error: function()
					{
						alert("failure");
					}
      		});
	   }
	});
	

//Ajax For Invoice fetching
$("#btn-del").click(function(){
	 
	   if($("#payer_id").val() == '')
	   {
		   alert('*Field Payer ID cannot be empty');	   
	   }
	   else
	   {
		   $(".invoices").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
		dataString = $("#form_delete").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/fetchInvoiceRecords.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".invoices").empty();
						$(".invoices").html(msg);
						
					},
					error: function()
					{
						alert("failed!");
					}
      		});
	   }
});

//Ajax For Invoice deleting	
//deprecated: $("#delete-invoice").live('click', function(){});
$(document).on('click', "#delete-invoice", function(){
	
  if($("input[name='id[]'").is(':checked')){
	 
		
		var payid = [];
		$.each($("input[type=checkbox]:checked"), function(){            
		payid.push($(this).val());
		});
	  
	      var r =  confirm('Are you sure you want to delete?');
	  
		  if(r == true)
		  {	  
				$(".invoices").html('<img src="../images/pleaseWait3.gif" /> deleting record(s)...');
				
				$.ajax({
    				type: "POST",
					url: "ajaxCalls/deleteInvoiceRecords.php",
					data: 'id='+payid,
					//dataType: 'html',
        			success: function(msg)
					{
						$(".invoices").empty();
						$(".invoices").html(msg);		
					},
					error: function()
					{
						alert("failed!");
					}
      		    });
		  }
			
	}
	else
	{
		alert('You must select at least one of the checkbox(es)');
	}

});

</script>
</body>
</html>