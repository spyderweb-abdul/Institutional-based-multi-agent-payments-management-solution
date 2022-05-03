<?php
define("PAYMENT_DB", "udus_payment_db");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_HOST", "localhost");

$paydb = new MySQLi(DB_HOST, DB_USER, DB_PASS, PAYMENT_DB);
if ($paydb->connect_error) { die('Connection Error (' . $paydb->connect_errno . ') ' . $paydb->connect_error); }


?>