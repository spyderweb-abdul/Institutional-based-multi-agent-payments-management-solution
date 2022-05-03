<?php
session_start();
include_once('../include/constant_connection.php');


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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/udus-logo.png" />
<title>UDUS |  Integrated Payment System - UDUPay</title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>

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
	color:#000;
	font-size:12px;

}
.row
{
	min-width: 100% !important;
	padding:0;
	margin: 0;
}

</style>

<script type="text/javascript">

</script>

</head>

<body>
<?php
if (isset($_GET['cmd']))//this edits the fee_items_table
		 {
			 
			 $UID = $_GET['cmd'];
	 
			 $fetch = $paydb->query("SELECT  * FROM ".TBL_FEE_ITEMS." WHERE feeID ='$UID' ");
			 $fetchMe = mysqli_fetch_array($fetch);
			 
			 if($fetchMe == TRUE)
			 {
				 
				 $feeItem = $fetchMe['feeItem'];
				 $amount = $fetchMe['amount'];
 ?>
                 

 <form name="frm-editFeeItem" id="frm-editFeeItem" >
      <div class="row" style="display:block;">
      
      
      <div class="col-lg-4">
      <label class="styleTb"> <strong>Fee Item Name</strong></label>
      <div class="form-group has-feedback styleTb">
      <input type="text" class="form-control styleTb" name="feeItem" id="feeItem" required="required" placeholder="Insert Fee Item Name" value="<?php  echo $feeItem; ?>"  />
      <i class="glyphicon glyphicon-folder-open form-control-feedback"></i>
      </div>
      </div>
      
      <div class="col-lg-3">
      <label class="styleTb"> <strong>Amount</strong> </label>
      <div class="form-group has-feedback styleTb">
      <input type="text" class="form-control styleTb" name="amount" id="amount" required="required" placeholder="e.g 4000" value="<?php echo $amount; ?>" />
      <i class="glyphicon glyphicon-asterisk form-control-feedback"></i>
      </div>
      </div>
   
      <div class="col-lg-2">
     
      <input type="hidden" name="feeID" id="feeID" value="<?php echo $UID; ?>" />
      <input type="button" name="btn-editFeeItem" id="btn-editFeeItem" class="btn btn-success btn-sm" value="Save Update" />
       </div>
       <div class="col-lg-3"></div>

      </div>
      </form>
      
      <p id="val"> </p>
      <?php } } ?>
      
<script type="text/javascript">

//To Create Fee Items
	$("#btn-editFeeItem").click( function(){
		
		    $("#val").empty();
			$("#val").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
			dataString = $("#frm-editFeeItem").serialize();
		
		    $.ajax({
			         type: 'POST',
					 url: 'ajaxCalls/ajaxEditFeeItem.php',
					 data: dataString,
					 dataType: 'html',
					 success: function(msg)
					 {
						$("#val").empty();
						$("#val").html(msg); 
						//$(".alert").fadeOut(3200, function(){
							
						//window.location.href="createFees.php#menu3";
						//window.location.reload();
							
						//});
					 },
					 error: function()
					 {
						 alert('Operation failed permanently. Please re-try');
					 }
				
			});

	});
	

</script>
</body>
</html>