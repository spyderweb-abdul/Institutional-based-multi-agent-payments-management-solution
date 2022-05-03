<?php
define("PAYMENT_DB", "db_name");
define("DB_USER", "db_user_name");
define("DB_PASS", "db_paswword");
define("DB_HOST", "db_host");

$paydb = new MySQLi(DB_HOST, DB_USER, DB_PASS, PAYMENT_DB);
if ($paydb->connect_error) { die('Connection Error (' . $paydb->connect_errno . ') ' . $paydb->connect_error); }


?>
