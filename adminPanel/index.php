<?php
session_start();

$myRand = rand(0,1000);
$mdHash = hash('sha512', $myRand);
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/udus-logo.png" />
<title>UDUS | Integrated Payment System - UDUPay</title>



<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../pgcourselist.js" type="text/javascript"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.page .table_bg tr td .form_content.gradient table tr td table tr td .style4 {
	text-align: justify;
}
.page .table_bg tr td .form_content.gradient table tr td table tr td .style4 {
	font-weight: bold;
	
}
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
	color:#FFF;
	font-size:11.5px;
}
</style>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="386" border="0" align="center" cellpadding="9" cellspacing="9">
    <tr>
      <td width="342" height="295"><p id="err" class="styleTb" style="text-align:center; color:#F00;"> </p>
        <p class="feed"></p>
        <form name="login" id="login" method="get" action="">
          <table width="246" border="0" align="center" cellpadding="5" cellspacing="5">
            <tr>
              <td width="226"><div class="input-group"> <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
                <input name="userID" type="text" autofocus="autofocus" required="required" class="form-control styleTb" id="userID" placeholder="USERNAME" title="USER ID" size="30" maxlength="10" data-toggle="tooltip" data-placement="bottom" />
              </div>
                <br/></td>
            </tr>
            <tr>
              <td><div class="input-group"> <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-lock"></b></span>
                <input name="passCode" type="password" required="required" class="form-control styleTb" id="passCode" placeholder="PASSWORD (Not more tha 8 xters)" title="PASSWORD" size="30" maxlength="10" data-toggle="tooltip" data-placement="bottom" />
              </div></td>
            </tr>
            <tr>
              <td height="51"><input type="button" name="btn-login" id="btn-login" value="LOGIN" class="btn btn-success styleTb2"  /></td>
            </tr>
          </table>
          <br/>
        </form></td>
    </tr>
  </table>



<script src="../js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<link href="../fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
<script src="../fancybox/jquery.mousewheel-3.0.6.pack.js" ></script>
<script src="../fancybox/jquery.fancybox.js"></script><script type="text/javascript">
	 $("#btn-login").click(function(){
		 
		 if(($("#userID").val() == '') && ($("#passCode").val() == ''))
		 {
			  $("#err").html('*All fields must be filled!');
		 }
		 else
		 {
		   $(".feed").html('<img src="../images/fancybox_loading.gif" /> Please Wait...');
		dataString = $("#login").serialize();	
		$.ajax({
    				type: "POST",
					url: "logMeIn.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feed").empty();
						$("#err").empty();
						$(".feed").html(msg);		
					},
					error: function()
					{
						alert("failure");
					}
      		});
		 }
		 
	});
	$("#redir").live("click", function()
	{
	parent.location = "reportArena.php";
   });
</script>
</body>
</html>