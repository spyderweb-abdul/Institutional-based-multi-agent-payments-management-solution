<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paytonify Invoice Notification</title>

<link href="../../plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style="width:auto; height:40px; background:#022; padding:10px; margin-bottom:0; ">
<div style="display:block; text-align:left; color:#FFFFFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:30px; font-weight:bold;">Paytonify&trade;</div>
</div>

<div style="width:auto; background:#FFF; padding:10px; height:auto">

<p style="font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; font-weight:bold; color:#2E5C5C; text-align:justify">Dear, %user_name%<br/>

<p style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:14px; font-weight:500"> This is your successful payment details notification for: %setup_name%
<br/>
<br/>

<strong style="color:#900"> PAYER ID: %userId%  </strong><br/><br/>
<strong style="color:#900"> INVOICE NO: %invoice% </strong><br/><br/>
<strong style="color:#900"> TRANSACTION ID: %transactionId% </strong>
  
<div style="font-family:Tahoma, Geneva, sans-serif; font-size:12px; text-height:auto;"> 
 <ul>
  <p><i class="fa fa-toggle-right"></i> EMAIL: %user_email% </p>
  <p><i class="fa fa-toggle-right"></i> PHONE NO: %user_phone%</p>
  <p><i class="fa fa-toggle-right"></i> AMOUNT: %amount%</p>
  <p><i class="fa fa-toggle-right"></i> SESSION: %session%  </p>
  <p><i class="fa fa-toggle-right"></i> CHANNEL: %gateway_name%  </p>
  <p><i class="fa fa-toggle-right"></i> STATUS: %status%  </p>
  <p><i class="fa fa-toggle-right"></i> PAID TO: %merchant_name%  </p>

  <br/>
  <br/>
</ul>
 </div>
 <p style="color:#FF0000"> NB: This is an auto-response message. Please, <strong>DO NOT</strong> reply to this email. </p>

<strong>Thank you.</strong>

</p>


</div>
<div style="width:auto; height:auto; background:#022; padding:20px; margin-bottom:0; color:#FFF; font-family:Tahoma, Geneva, sans-serif; font-size: 13px; ">
<p> Why not let Paytonify handle your payment troubles? Your clients, customers and payers can have it as seamless and simple as you never could imagine. </p>
<p> Holla at us today: </p>
<p> <i class="fa fa-phone"> </i> +234-8055109695 &nbsp; &nbsp; <i class="fa fa-envelope"> </i> inquiries@paytonify.com &nbsp; &nbsp; <i class="fa fa-firefox"> </i> https://www.paytonify.com </p>

<div style="display:block; text-align:center; color:#FFFFFF; font-family:Tahoma, Geneva, sans-serif; font-size:11px; font-weight:500;">
<div> <i class="fa fa-2x fa-facebook-f"> </i> &nbsp; <i class="fa fa-2x fa-twitter"> </i> &nbsp; <i class="fa fa-2x fa-instagram"> </i> </div><br/>
All rights reserved &copy; <?php echo date('Y'); ?> Paytonify&trade;</div>
</div>


</body>
</html>