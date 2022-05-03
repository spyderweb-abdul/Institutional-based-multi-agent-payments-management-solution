<?php
/*
//Payment_db params
define("PAYMENT_DB", "udus_payment_db");
define("MATRIC_DB", "matric_db");
define("SASAKAWA", "sasakawa");
define("PAYMENT_DB_USER", "root");
define("PAYMENT_DB_PASS", "admin@udu123");
define("PAYMENT_DB_HOST", "127.0.0.1");

define("TBL_PAYMENTS_RECORD", "payments_record");
define("TBL_FEE_ITEMS", "fee_items_table");
define("TBL_FULL_FEE_STRUCTURE", "fee_structure_full_table");
define("TBL_FEE_STRUCTURE", "fee_structure_table");
define("TBL_CIS_FEE", "cis_reg_fee");
define("TBL_COUNTER", "counter");
define("TBL_CIS_STUD_RECORD", "cis_stud_record");
define("TBL_ADMIN", "admin_tb");

//Matric_db param

define("TBL_PAYMENTS", "payment");
define("TBL_HOSTEL_PAYMENTS", "hostel_payment");
define("TBL_MATRIC_FORM_PAYMENTS", "matric_form_payment");
define("TBL_BIODATA", "biodata");

define("TBL_SASAKAWA_FORM", "sasakawa_form_payment");

$paydb = new MySQLi(PAYMENT_DB_HOST, PAYMENT_DB_USER, PAYMENT_DB_PASS, PAYMENT_DB);
$matdb = new MySQLi(PAYMENT_DB_HOST, PAYMENT_DB_USER, PAYMENT_DB_PASS, MATRIC_DB);
$matdb2 = new MySQLi(PAYMENT_DB_HOST, PAYMENT_DB_USER, PAYMENT_DB_PASS, SASAKAWA);

if ($paydb->connect_error) { die('Connection Error (' . $paydb->connect_errno . ') ' . $paydb->connect_error); }
if ($matdb->connect_error) { die('Connection Error (' . $matdb->connect_errno . ') ' . $matdb->connect_error); }
if ($matdb->connect_error) { die('Connection Error (' . $matdb->connect_errno . ') ' . $matdb->connect_error); }


//PGPortal_db  and Admsissions Portal params
define("PGPORTAL_DB", "pgportal_db");
define("PG_DB_USER", "payportal");
define("PG_DB_PASS", "2pixreku");
define("PG_DB_HOST", "41.78.224.41");

define("TBL_FORM_PAYMENT", "pg_form_payment");
define("TBL_ACCOUNT", "account_table");
define("TBL_PG_ADM", "admission_table");
//define("TBL_PG_SESSION", "session");

define("ADMISSIONS_DB", "putme_dbase");
define("TBL_UG_ADM", "admission");

$pgdb = new MySQLi(PG_DB_HOST, PG_DB_USER, PG_DB_PASS, PGPORTAL_DB);
$admdb = new MySQLi(PG_DB_HOST, PG_DB_USER, PG_DB_PASS, ADMISSIONS_DB);
if ($pgdb->connect_error) { die('Connection Error (' . $pgdb->connect_errno . ') ' . $pgdb->connect_error); }
if ($admdb->connect_error) { die('Connection Error (' . $admdb->connect_errno . ') ' . $admdb->connect_error); }

//Eduerp_db param
define("EDUERP_DB", "eduerp");
define("EDUERP_DB_USER", "payportal");
define("EDUERP_DB_PASS", "admin@2016");
define("EDUERP_DB_HOST", "41.78.224.39");

define("TBL_FEES_ORDER", "fees_order");
define("TBL_FEES_SUMMARY", "fees_summary");
define("TBL_HOSTEL_APP", "hostel_application");
define("TBL_EDUERP_SESSION", "session");
define("TBL_ORDERS", "uc_orders");
define("TBL_UACCESS", "access_control");

$edudb = new MySQLi(EDUERP_DB_HOST, EDUERP_DB_USER, EDUERP_DB_PASS, EDUERP_DB);
if ($edudb->connect_error) { die('Connection Error (' . $edudb->connect_errno . ') ' . $edudb->connect_error); }

////////////////////////


*/
//Payment_db params
define("PAYMENT_DB", "udus_payment_db");
define("DB_USER", "root");
define("DB_PASS", "@justweb");
define("DB_HOST", "localhost");

define("TBL_PAYMENTS_RECORD", "payments_record");
define("TBL_FEE_ITEMS", "fee_items_table");
define("TBL_FULL_FEE_STRUCTURE", "fee_structure_full_table");
define("TBL_FEE_STRUCTURE", "fee_structure_table");
define("TBL_CIS_FEE", "cis_reg_fee");
define("TBL_COUNTER", "counter");
define("TBL_CIS_STUD_RECORD", "cis_stud_record");
define("TBL_ADMIN", "admin_tb");


$paydb = new MySQLi(DB_HOST, DB_USER, DB_PASS, PAYMENT_DB);
//mysql_select_db(PAYMENT_DB, $paydb);


//PGPortal_db  params
define("PGPORTAL_DB", "pgportal_db");

define("TBL_FORM_PAYMENT", "pg_form_payment");
define("TBL_ACCOUNT", "account_table");
define("TBL_PG_ADM", "admission_table");
define("TBL_PG_SESSION", "session");

$pgdb = new MySQLi(DB_HOST, DB_USER, DB_PASS, PGPORTAL_DB);
//mysql_select_db(PGPORTAL_DB, $pgdb);

//Matric_db param
/*define("MATRIC_DB", "matric_db");
define("SASAKAWA", "sasakawa");
define("MATRIC_DB_USER", "root");
define("MATRIC_DB_PASS", "@justweb");
define("MATRIC_DB_HOST", "localhost");

define("TBL_PAYMENTS", "payment");
define("TBL_HOSTEL_PAYMENTS", "hostel_payment");
define("TBL_MATRIC_FORM_PAYMENTS", "matric_form_payment");
define("TBL_BIODATA", "biodata");

define("TBL_SASAKAWA_FORM", "sasakawa_form_payment");

$matdb = mysql_connect(MATRIC_DB_HOST, MATRIC_DB_USER, MATRIC_DB_PASS);
$matdb2 = mysql_connect(MATRIC_DB_HOST, MATRIC_DB_USER, MATRIC_DB_PASS, true);
mysql_select_db(MATRIC_DB, $matdb);
mysql_select_db(SASAKAWA, $matdb2);

//Eduerp_db param
define("EDUERP_DB", "eduerp");
define("EDUERP_DB_USER", "root");
define("EDUERP_DB_PASS", "@justweb");
define("EDUERP_DB_HOST", "localhost");

define("TBL_FEES_ORDER", "fees_order");
define("TBL_FEES_SUMMARY", "fees_summary");
define("TBL_HOSTEL_APP", "hostel_application");
define("TBL_EDUERP_SESSION", "session");

$edudb = mysql_connect(EDUERP_DB_HOST, EDUERP_DB_USER, EDUERP_DB_PASS);
mysql_select_db(EDUERP_DB, $edudb);

//admissions_db Param
define("ADMISSIONS_DB", "putme_dbase");
define("ADM_DB_USER", "root");
define("ADM_DB_PASS", "@justweb");
define("ADM_DB_HOST", "localhost");

define("TBL_UG_ADM", "admission");

$admdb = mysql_connect(ADM_DB_HOST, ADM_DB_USER, ADM_DB_PASS);
mysql_select_db(ADMISSIONS_DB, $admdb);
*/

?>