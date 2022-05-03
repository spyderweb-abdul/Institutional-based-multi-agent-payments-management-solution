<?php
session_start();

?>

<html>
<head>
<script type="text/javascript">
  $(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });
});
</script>
</head>
<body>

<?php

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';



    $gatewayId = $_POST['gatewayId'];

//Select all available options for each of the gateways
   $sel_options = $paydb->query("SELECT * FROM ".PAY_OPTIONS." WHERE gatewayId = '$gatewayId' ");

    while($options = $sel_options->fetch_array())
         {
          echo '<div class="checkbox">
                <label> <input type="checkbox" name="optionId[]" id="optionId" value="'.$options['optionId'].'" class="flat"> &nbsp;&nbsp;' .$options['option_name']. '</label>
                 </div>';
          }

      echo '<br/><div class="form-group pull-left">
            <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
            <button type="button" class="btn btn-success" id="btn_save_gateway_options"><i class="fa fa-save"></i> Save Selection(s) </button>
            </div>
            </div>';
  ?>

  </body>
  </html>