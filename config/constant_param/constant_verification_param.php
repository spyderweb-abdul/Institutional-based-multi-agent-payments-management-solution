<?php
/*define("MERCHANTID", "000000");
define("SERVICETYPEID", "000000");
define("APIKEY", "0000");
define("CHECKSTATUSURL", "http://www.remitademo.net/remita/ecomm");
define("GATEWAYURL", "http://www.remitademo.net/remita/ecomm/init.reg");
*/


//define("MERCHANTID", "000000000");
//define("SERVICETYPEID", "0000000");
//define("APIKEY", "0000");
define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");
define("GATEWAYURL", "https://login.remita.net/remita/ecomm/init.reg");
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
define("GATEWAYRRRPAYMENTURL", "http://www.remitademo.net/remita/ecomm/finalize.reg");


?>
