<?php
/*define("MERCHANTID", "2547916");
define("SERVICETYPEID", "4430731");
define("APIKEY", "1946");
define("CHECKSTATUSURL", "http://www.remitademo.net/remita/ecomm");
define("GATEWAYURL", "http://www.remitademo.net/remita/ecomm/init.reg");
*/


//define("MERCHANTID", "573566089");
//define("SERVICETYPEID", "574141886");
//define("APIKEY", "695470");
define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");
define("GATEWAYURL", "https://login.remita.net/remita/ecomm/init.reg");
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
define("GATEWAYRRRPAYMENTURL", "http://www.remitademo.net/remita/ecomm/finalize.reg");


?>