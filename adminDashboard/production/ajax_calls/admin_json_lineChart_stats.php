<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


//Call to function to get payment_setup details
    $payDetails = get_payments_stats($_SESSION['userId']);

    //$pay_type_array = array();
    //$pay_num_array = array();

    //$output = "";

  /*  while($paystats = $payDetails->fetch_array())
    {
    	//choiceId = $paystats['choiceId'];
    	$setupId = $paystats['setupId'];
    	$setup_name = $paystats['setup_name'];
    	$merchantId = $paystats['merchantId'];

    	//if($output !=""){ $output .= ","; }


         $get_pay_records = $paydb->query("SELECT COUNT(setupId) FROM ".PAYMENT_RECORDS." WHERE setupId = '$setupId' AND merchantId = '$merchantId' ");

         $fetch_rec = $get_pay_records->fetch_array();
         $setCount = $fetch_rec['COUNT(setupId)'];

         $pay_type_array[] = $setup_name;
         $pay_num_array[] = $setCount;


         //$output .= '{"setupname": "'.$setup_name.'", "number": '.$setCount.'}';

    }
       	  // $output = '['.$output.']';

       $msg['args1'] = $pay_type_array;
       $msg['args2'] = $pay_num_array;
       */
       $output = " ";

        while($paystats = $payDetails->fetch_array())
    {
        //choiceId = $paystats['choiceId'];
        $setupId = $paystats['setupId'];
        $setup_name = $paystats['setup_name'];
        $merchantId = $paystats['merchantId'];



         $get_pay_records = $paydb->query("SELECT COUNT(setupId) FROM ".PAYMENT_RECORDS." WHERE setupId = '$setupId' AND merchantId = '$merchantId' ");

         $fetch_rec = $get_pay_records->fetch_array();
         $setCount = $fetch_rec['COUNT(setupId)'];

       

           $output .= '{"c": [{"v" : "'.$setup_name.'"}, {"v" : '.$setCount.'}] } ';

            if($output != ""){ $output .= ", "; }

    }
          $output = '{ "cols":[ {"label" : "setupname", "type" : "string" }, {"label" : "percent", "type": "number" }] ,

                        "rows": ['.$output.'] }';


      echo ($output);


      
 /*$dataSet = '{ "cols":[ {"label" : "setupname", "type" : "string" }, {"label" : "percent", "type": "number" }] ,

                        "rows": [ {"c": [{"v" : "UG REGISTRATION CHARGES"}, {"v" : 8}]}, {"c": [{"v" : "PG REGISTRATION FEES"}, {"v" : 4}]}, {"c":[{"v" : "UDUS MATRIC TUITION FEES"}, {"v" : 1}]}, {"c":[{"v" : "UDUS PG APPLICATION FORM"}, {"v" : 3}]}, {"c":[{"v" : "SCHOOL OF MATRICULATIONS FORM"}, {"v" : 4}]}, {"c":[{"v" : "UG ACCEPTANCE"}, {"v" : 1}]}, {"c":[{"v" : "ACCOUNTING (PART-TIME) FORM"}, {"v" : 2}]}, {"c":[{"v" : "TRANSCRIPT PROCESSING (FOREIGN)"}, {"v" : 1}]} ]}';
                        */


?>