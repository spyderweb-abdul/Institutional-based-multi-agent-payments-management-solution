<?php
//define("MERCHANTID", "2547916");//demo
//define("SERVICETYPEID", "4430731");//demo
//define("APIKEY", "1946");//demo
/*define("CHECKSTATUSURL", "http://www.remitademo.net/remita/ecomm");//demo
define("GATEWAYURL", "http://www.remitademo.net/remita/ecomm/init.reg");//demo
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
*/

define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm/merchantId/OrderId/hash/orderstatus.reg");
define("GATEWAYURL", "https://login.remita.net/remita/ecomm/init.reg");
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));

?>
