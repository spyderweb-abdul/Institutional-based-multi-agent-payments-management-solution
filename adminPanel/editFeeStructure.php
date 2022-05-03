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
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="myApp">
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
<script src="../js/angular.min.js"> </script>


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
if (isset($_GET['prog']))//this edits the fee_items_table
		 {
			 
			 $prog = $_GET['prog'];
			 $nation = $_GET['nat'];
			 $level = $_GET['lev'];
			 
			 $selOthers = $paydb->query("SELECT facName, deptName FROM ".TBL_FEE_STRUCTURE." WHERE prog = '$prog'");
			 $d = mysqli_fetch_array($selOthers);
			 
			 $facName = $d['facName'];
			 $deptName = $d['deptName'];
			 
			 //Pass all variables into a session 
			 
			 $_SESSION['prog'] = $prog;
			 $_SESSION['nat'] = $nation;
			 $_SESSION['lev'] = $level;
			 $_SESSION['facName'] = $facName;
			 $_SESSION['deptName'] = $deptName;
			 
		 }
	 
			
 ?>
   <div ng-controller="myEdit" style="padding-top: 20px;"> 
   
   <?php echo '<div class="styleTb2" style="display:block; text-align:center; color: red; font-weight: bold">'.$prog.' >> '.$level. ' >> '.$nation.'</div><br/>'  ?>             
  
  <p id="val"> </p>
  <table width="60%" class="table-bordered table-condensed table-hover table-responsive table-striped styleTb" align="center">
  <tr>
  <th> </th>
  <th> Fee Item </th>
  <th> Amount </th>
  <th> Delete Item </th>
  </tr>
  
  <tr ng-repeat="x in editStructure">
  <td> {{ $index + 1 }} </td> 
  <td> {{ x.feeItem }} </td>
  <td> {{ x.amount }} </td>
  <td> <a href="#" ng-click="deleteItem(x.feeID)" > <i class="fa fa-trash" > </i> </a></td>
  </tr>
  
  <tr>
  <td colspan="4" ng-repeat="i in tot" style="color:red; font-weight:bold; font-size:13px;" > Total Amount: {{ i.totalSum }} </td>
  </tr>
  
  <tr>
  <td colspan="4"> <a href="#" onclick="openMe()"> ADD NEW ITEM </a><br/>
  
  <div style="display:none" id="openDiv" >
        
        <form name="frm-addNew" id="frm-addNew" >
        <div class="input-group">
        <span class="input-group-addon"> <i class="fa fa-chevron-down"></i></span> 
        <select name="feeID" id="feeID" class="form-control styleTb">
                 <?php
				  $selFee = $paydb->query("SELECT feeID, feeItem, amount FROM ".TBL_FEE_ITEMS." ORDER BY feeItem ASC");
				  while($f = mysqli_fetch_array($selFee))
				  {
					  echo '<option value="'.$f['feeID'].'">'.$f['feeItem'].' - '.number_format($f['amount']).'</option>';
				  }
				 
				 ?>
         </select>
         <span class="input-group-btn"><input type="button" name="btn-add" id="btn-add" value="ADD NOW" class="btn btn-success"  /></span>    
         </div>
         </form>  
  
  </div>
  
  </td>
  </tr>
  
  </table>
 </div>
      
      
<script type="text/javascript">
//To open the hidden 'ADD NEW' div
function openMe()
{
	document.getElementById('openDiv').style.display = 'inline';
}



//
var app = angular.module("myApp", [])

app.controller("myEdit", function($scope, $http){
	
$http.get("ajaxCalls/json_feeStructuresEdit_calls.php").then(function(response){ 
$scope.editStructure = response.data.records;
$scope.tot = response.data.total; });

$scope.deleteItem = function(feeID)
{
	var r = confirm('Are you sure you want to delete?');
	if(r == true)
	{
		//Start Ajax call here
		 $.ajax({
			 
		        type: 'GET',
				url:  'ajaxCalls/ajaxDeleteFeeStructureItem.php',
				data:  'cmdelete=' + feeID,
				dataType: 'html',
				success: function(msg)
				{
					 $("#val").html(msg);
					 $(".alert").fadeOut(6400, function(){ 				
				         window.location.reload();
						 });
				},
				error: function()
				{
					alert('Operation Failed. Please Re-try.');
				}	   
	   });
   }
}
	
});



//To Create Fee Items
	$("#btn-add").click( function(){
		
		    $("#val").empty();
			$("#val").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
			dataString = $("#frm-addNew").serialize();
		
		    $.ajax({
			         type: 'POST',
					 url: 'ajaxCalls/ajaxAddNewItem.php',
					 data: dataString,
					 dataType: 'html',
					 success: function(msg)
					 {
						$("#val").empty();
						$("#val").html(msg); 
						$(".alert").fadeOut(3200, function(){							
						window.location.reload();							
						});
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