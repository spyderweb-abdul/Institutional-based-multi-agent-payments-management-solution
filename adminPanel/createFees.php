<?php
session_start();
include_once('../include/constant_connection.php');

	  $md2 = md5(rand(0, 100000));

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

   function faculty()
			  {
				  $facs = array("-Select-", "Agriculture", "Arts and Islamic Studies", "Basic Medical Science", "Clinical Sciences", "Education and Extension Services", "Law", "Pharmaceutical Sciences", "Science", "Medical Laboratory Science", "Social Sciences", "Management Sciences","Veterinary Medicine");
				  
				  foreach ($facs as $fac)
				   {
		          echo '<option value="'.$fac.'">'.$fac.'</option>';
	               }	
			  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="myApp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/udus-logo.png" />
<title>UDUS |  Integrated Payment System - UDUPay</title>

<script src="../pgcourselist.js" type="text/javascript"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/angular.min.js"> </script>
<script src="../js/pgcourselist.js" type="text/javascript"></script>

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

<script type="text/javascript">

function showMe()
   {
document.getElementById('add').style.display = 'inline';
   }
   


//Function that recognizes # after the url and show the content of the menu tab 
 $(document).ready(function(e){
    $(function () {
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');
});
 
});


</script>

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
            <p class="payMode"> FEES CREATION MODULE </p>
            
            <table width="99%" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td height="201" valign="top">
                
<ul class="nav nav-pills">
   <li class="active" ><a data-toggle="pill" href="#menu2">CREATE FEE ITEMS </a></li>
   <li ><a data-toggle="pill" href="#menu3">DELETE/EDIT FEE ITEMS </a></li>
   <li ><a data-toggle="pill" href="#menu4">BUILD FEE STRUCTURE </a></li>
   <li ><a data-toggle="pill" href="#menu5"> FEE SCHEDULES </a></li>
</ul>

<div class="tab-content">
  
  
  <!-- 1st TAB PILLS -->
  <div id="menu2" class="tab-pane fade in active">
  <br/>
  <hr noshade="noshade" />
   <!-- <h5>Create Fee Items</h5> -->
    <form name="frm-createFee" id="frm-createFee" >
      <div class="row" style="padding:15px;">
      
      
      <div class="col-lg-4">
      <label class="styleTb"> <strong>Fee Item Name</strong></label>
      <div class="form-group has-feedback styleTb">
      <input type="text" class="form-control styleTb" name="feeItem" id="feeItem" required="required" placeholder="Insert Fee Item Name"  />
      <i class="glyphicon glyphicon-folder-open form-control-feedback"></i>
      </div>
      </div>
      
      <div class="col-lg-3">
      <label class="styleTb"> <strong>Amount</strong> </label>
      <div class="form-group has-feedback styleTb">
      <input type="text" class="form-control styleTb" name="amount" id="amount" required="required" placeholder="e.g 4000"  />
      <i class="glyphicon glyphicon-asterisk form-control-feedback"></i>
      </div>
      </div>
   
      <div class="col-lg-2">
      <br/>
      <input type="button" name="btn-createFee" id="btn-createFee" class="btn btn-success btn-sm" value="Create Fee Item" />
       </div>

      </div>
      </form>
        
      <p id="val" style="color:#FF9900;"> </p>
    
    </div>

<!-- 2nd TAB PILLS -->
 <div id="menu3" class="tab-pane fade">
     <br/>
  <hr noshade="noshade" />
    
  <p id="val2"> </p>
  
 <div ng-controller="myFilter">
   <table width="70%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped styleTb2">
   <tr>
   <td colspan="5">
   <form name="myForm" ng-init="">
   <div class="form-group has-feedback">
   <input type="text" name="filt" ng-model="filters" class="form-control styleTb2" placeholder="Insert Item Name to Filter"  />
   <i class="glyphicon glyphicon-ok form-control-feedback"></i>
   </div>
   </form>
   
  <!-- <span ng-show="!items.length"> No Match Found </span> -->
   </td>
   </tr>
   
   <tr>
   <th> </th>
   <th> Fee Items </th>
   <th> Amount </th>
   <th> Edit </th>
   <th> Delete </th>
   </tr>
   
   <tr ng-repeat="x in items | filter:filters">
   <td > <i class="glyphicon glyphicon-chevron-right"> </i></td>
   <td> {{ x.feeItem }} </td>
   <td> {{ x.amount | number }} </td>
   <td> <a href ='#' ng-click="editFee(x.feeID)" id="btn-editFee" > <i class="fa fa-edit"> </i> </a>   </td>
   <td> <a href ='#' ng-click="feeNum(x.feeID)" ><i class="fa fa-trash"> </i> </a> </td>
   </tr>
    
   </table>
   
 </div>
  
  </div>


<!-- 3rd TAB PILLS -->
<div id="menu4" class="tab-pane fade">
     <br/>
  <hr noshade="noshade" />
  <p id="val3" style="font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif; color:#FF0000; font-weight:bold; font-size:12px;"> </p>
  <p id="val_error" style="color:#F60; font-weight:bolder;"></p>
  
  <form name="create_form" id="create_form" >
   <div ng-controller="myFilter">
   <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped styleTb2">
   <tr>
   <td colspan="5">
   
  
   <div class="col-xs-5">
        <label> Choose Faculty: </label>
        <div class="form-group has-feedback">
        <select name="facName" id="facName" class="form-control styleTb2" onchange="SelectSubCat()">
         <?php faculty(); ?>        
        </select>
        </div>
   </div>
   <div class="col-xs-7">
         <label> Choose Department: </label>
        <div class="form-group has-feedback">
        <select name="deptName" id="deptName" class="form-control styleTb2" onchange="SelectSubCat2()">       
        </select>
        </div>
   </div>
   <br/>
    <div class="col-xs-7">
        <label> Choose Programme: </label>
        <div class="form-group has-feedback">
        <select name="prog" id="prog" class="form-control styleTb2">       
        </select>
        </div>
   </div>
  
   <div class="col-xs-3">
     <label> Choose Level: </label>
        <div class="form-group has-feedback">
        <select name="level" id="level" class="form-control styleTb2" > 
        <option value=""> -</option>
        <option value="Fresh"> Fresh </option>
        <option value="Returning"> Returning </option>      
        </select>
        </div>
   </div>
   
   <div class="col-xs-3">
     <label> Choose Nationality: </label>
        <div class="form-group has-feedback">
        <select name="nationality" id="nationality" class="form-control styleTb2" > 
        <option value=""> -</option>
        <option value="Local"> Local </option>
        <option value="Foreign"> Foreign </option>      
        </select>
        </div>
   </div>
   
   
  
   </td>
   </tr>
   
   <tr>
   <td colspan="5">  
   <form name="myForm" ng-init="">
   <div class="form-group has-feedback">
   <input type="text" name="filt" ng-model="filters" class="form-control styleTb2" placeholder="Type Fee Item to Filter"  />
   <i class="glyphicon glyphicon-ok form-control-feedback"></i>
   </div>
   </form>
   </td>   
   </tr>
   
   
   <tr>
   <th> </th>
   <th> Fee Items </th>
   <th> Amount </th>
   </tr>
   
   <tr ng-repeat="x in items | filter:filters">
   <td align="right">
  
    <input type="checkbox" name="feeID[]" id="feeID" value="{{ x.feeID }}" style=" height:auto; box-shadow:none; border:#CCC thin" ng-model="x.check" />
 
   </td>
   <td> <input type="text" name="feeItem" id="feeItem" value="{{ x.feeItem }}" class="input-sm" style="border:thin #CCC; box-shadow:none;" readonly="readonly"  /> </td>
   <td>  <input type="text" name="amount" id="amount" value="{{ x.amount }}" class="input-sm" style="border:thin #CCC; box-shadow:none;" readonly="readonly"  /></td>
   </tr>
    <tr>
    <td colspan="5"> <input type="button" name="btn-addFee" id="btn-addFee" value="Build Fee Now" class="btn btn-sm btn-success" /></td>
    </tr>
   </table>
   
    
  </div>
  </form>
  </div>

<!-- 4th TAB PILLS -->
 <div id="menu5" class="tab-pane fade">
 <br/>
 <hr noshade="noshade"  />
 <div ng-controller="myFeeStructure">
 <p id="val4"> </p>
   <table width="90%" class="table-bordered table-condensed table-hover table-responsive table-striped styleTb2" align="center">
     <tr>
   <td colspan="7">
   <form name="myForm" ng-init="">
   <div class="form-group has-feedback">
   <input type="text" name="filt" ng-model="feeStructFilters" class="form-control styleTb2" placeholder="Insert Item Name to Filter"  />
   <i class="glyphicon glyphicon-ok form-control-feedback"></i>
   </div>
   </form>
   
     Search Parameter: <strong> {{ feeStructFilters }} </strong>
     </td>

     
     <tr>
     <th> </th>
     <th ng-click="orders('prog')"> Programmes </th>
     <th ng-click="orders('level')"> Level </th>
     <th> Amount (=N=) </th>
     <th ng-click="orders('nationality')"> Nationality </th>
     <th> Edit </th>
     <th> Delete </th>     
     </tr>
     
     <tr ng-repeat="x in feeStructure | filter : feeStructFilters | orderBy: feeOrders ">
     <td>  {{ $index + 1 }}</td>
     <td> {{ x.prog }} </td>
     <td> {{ x.level }} </td>
     <td><strong> {{ x.amount }} </strong> </td>
     <td> {{ x.nationality }} </td>
     <td> <a href="#" ng-click="editStructure(x.prog, x.nationality, x.level)"> <i class="fa fa-edit"> </i> </a></td>
     <td> <a href="#" ng-click="delStructure(x.prog, x.nationality, x.level)" > <i class="fa fa-trash"> </i> </a> </td>
     </tr>
     
     </table>
     </div>
 </div>
          
                
                
                </td>
              </tr>
            </table>
            
            <p>&nbsp; </p>
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
Concept Designed and Developed By: UDUS WEB Team
</div>

<link href="../fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
<script src="../fancybox/jquery.mousewheel-3.0.6.pack.js" ></script>
<script src="../fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">

//To Create Fee Items
	$("#btn-createFee").click( function(){
		
		if(isNaN($("#amount").val())){ $("#val").html('*Amount must be a number'); }
		
		else if($("#feeItem").val() == '' || $("#amount").val() == '') { $("#val").html('*Fields must not be empty'); }
		else
		{   
		    $("#val").empty();
			$("#val").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
			dataString = $("#frm-createFee").serialize();
		
		    $.ajax({
			         type: 'POST',
					 url: 'ajaxCalls/ajaxCreateFees.php',
					 data: dataString,
					 dataType: 'html',
					 success: function(msg)
					 {
						$("#val").empty();
						$("#val").html(msg); 
						$(".alert").fadeOut(1200, function(){
						   window.location.href = "createFees.php#menu2";
						   window.location.reload();
						});
					 },
					 error: function()
					 {
						 alert('Operation failed permanently. Please re-try');
					 }
				
			});
		
		}
	});
	
// ---------- AngularJS filter script ---------------------------------//
var app = angular.module("myApp",[]);

app.controller("myFilter", function($scope, $http){

$http.get("ajaxCalls/json_feeItems_calls.php").then(function(response){	$scope.items = response.data.records; });

//The ng-click function here to delete fees Item
$scope.feeNum = function(feeID)
{
	var r = confirm('Are you sure you want to delete?');
	if(r == true)
	{
		//Start Ajax call here
		 $.ajax({
		        
				type: 'GET',
				url:  'ajaxCalls/ajaxDeleteFeeItem.php',
				data:  'cmdelete=' + feeID,
				dataType: 'html',
				success: function(msg)
				{
					 $("#val2").html(msg);
					 $("body").animate({scrollTop:0}, 'fast');	
				     $("html").animate({scrollTop:0}, 'fast');
					 $(".alert").fadeOut(3200, function(){ 				
				         window.location.href = 'createFees.php#menu3';				
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

//Fancybox to edit fee item
$scope.editFee = function(id)
{
		           
				 $.fancybox.open({
						
				    //type: 'GET',
					href : 'editFeeItem.php?cmd='+id,
					type : 'iframe',
					padding : 10,
					height: 270,
					width: 300,
					openEffect: 'fade',
					closeEffect: 'fade',
					//closeClick: false,
					
				'afterClose': function(){ window.location.href = "createFees.php#menu3"; window.location.reload(); }	

				});		
	
}

//Scope to hold only the checked fee Items even after filter operation
$scope.check = function() { value : true }

});

//----------- AngularJS for fee structure ----------------//
app.controller("myFeeStructure", function($scope, $http){

$http.get("ajaxCalls/json_feeStructures_calls.php").then(function(response){ $scope.feeStructure = response.data.records; });
$scope.orders = function(x){ $scope.feeOrders = x; }
//The ng-click function here to delete fees structure
$scope.delStructure = function(prog, nat, lev)
{
	var r = confirm('Are you sure you want to delete?');
	if(r == true)
	{
		//Start Ajax call here
		 $.ajax({
		        
				type: 'GET',
				url:  'ajaxCalls/ajaxDeleteFeeStructure.php',
				data:  'prog=' + prog + '&nat=' + nat + '&lev=' + lev,
				dataType: 'html',
				success: function(msg)
				{
					 $("#val4").html(msg);
					 $("body").animate({scrollTop:0}, 'fast');	
				     $("html").animate({scrollTop:0}, 'fast');
					 $(".alert").fadeOut(3200, function(){ 				
				         window.location.href = 'createFees.php#menu5';				
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

//Fancybox to edit fee structure
$scope.editStructure = function(prog, nat, lev)
{
		           
				 $.fancybox.open({
						
				    //type: 'GET',
					href : 'editFeeStructure.php?prog='+ prog + '&nat=' + nat + '&lev=' + lev,
					type : 'iframe',
					padding : 10,
					height: 700,
					width: 900,
					openEffect: 'fade',
					closeEffect: 'fade',
					//closeClick: false,
					
				'afterClose': function(){ window.location.href = "createFees.php#menu5"; window.location.reload(); }	

				});
	
}

});



//----------------- To Build Fee Structire --------------------------

$("#btn-addFee").click( function(){
	
		if($("#facName").val() == '' || $("#deptName").val() == '' || $("#prog").val() == '' || $("#level").val() == '' || $("#nationality").val() == '')
		{
			$("html, body").animate({scrollTop:0}, 'fast');
			$("#val_error").html('*All fields must be filled!');
		}
		else
		{
		     $("#val3").empty();
			//$("#val3").html('<img src="../images/pleaseWait3.gif" /> Please Wait...');
			var dataString = $("#create_form").serialize();
		
		    $.ajax({
			         type: 'POST',
					 url: 'ajaxCalls/ajaxBuildFee.php',
					 data: dataString,
					 dataType: 'json',			 
					 success: function(msg)
					 {
						 var r = confirm(msg.args1)
						 if( r == true )
						 {
					      
						     $("#val3").empty();
							 
							 var facName = $("#facName").val();
							 var deptName = $("#deptName").val();
							 var prog = $("#prog").val();
							 var level = $("#level").val();
							 var nationality = $("#nationality").val();
							    
							            var feeID = [];
                                         $.each($("input[id='feeID']:checked"), function(){            
                                         feeID.push($(this).val());
                                         });
										// alert(feeID);
                                     
			
						      $("#val3").load("ajaxCalls/ajaxBuildFee2.php", {"feeID[]":feeID, "facName":facName, "deptName":deptName, "prog":prog, "level":level, "nationality":nationality} );
							  $("#val3").html(msg);
						      $("html, body").animate({scrollTop:0}, 'fast'); 
							   
						       
						    
					     }
						 else { return false; }
					 },
					 error: function()
					 {
						 alert('Operation failed permanently. Please re-try');
					 }
				
			});
		}
	
});
	
	
</script>
</body>
</html>