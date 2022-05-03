<?php
include_once('../include/constant_connection.php');

$userId = $_POST['id'];
$payType = $_POST['paymenttype'];
$session = $_POST['session'];

$sql = $paydb->query("SELECT orderID FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId' AND paymentType = '$payType' AND session = '$session' ");
$r =   $sql->fetch_array();

if(mysqli_num_rows($sql) > 0)
{
        echo'
	    <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$r['orderID'].'" name="orderID" id="orderID" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S ORDER ID" />
        </div><br/>';	
}
else
{
	echo '<div class="alert alert-danger styleTb"> There is no match for this ID. </div>';
}


?>