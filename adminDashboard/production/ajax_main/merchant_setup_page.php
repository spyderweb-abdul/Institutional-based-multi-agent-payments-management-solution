<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

?>

 <html>
 <head>
 

    <script type="text/javascript">
  $(document).ready(function() {
      // Initialize Smart Wizard
        $('#wizard').smartWizard();
        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-warning');
       //$('.buttonFinish').addClass('btn btn-default');
  }); 


</script>
 </head>
 <body>

  <div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Merchant Setup - <small>General Setup</small></h4>
                    <!--<ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>-->
                    <div class="clearfix"></div>
                 </div>
                  
              <div class="x_content">

              <!-- Smart Wizard -->
                   
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">

                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr"> Merchant Setup </span>
                          </a>
                        </li>

                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr"> Gateway Setup </span>
                          </a>
                        </li>

                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr"> Gateway Options </span>
                          </a>
                        </li>

                       
                      </ul>

                      <!-- Step 1 -->
                      <div id="step-1">

                      <p id="merchant_create_result1"></p>

                      <?php

                      //Check to see if Merchant has been setup. If yes, display the merchant details in the text field. This should display for all activated merchants. Only Paytonify admin should have the fields as empty

                      //The function is called already at the top.

                      $merchant_name = $getDetails['merchant_name'];
                      $merchant_email = $getDetails['merchant_email'];
                      $merchant_type = $getDetails['merchant_type_name'];
                      $logo = $getDetails['logo'];

                      ?>

                      <div style="padding-left: 250px;">
                        <form class="form-horizontal form-label-left" name="merchant_setup" id="merchant_setup" enctype="multipart/form-data">

                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Merchant's Name" name="merchant_name" id="merchant_name" <?php if(!empty($merchant_name)){ echo 'value="'.$merchant_name.'" '; echo 'readonly'; } ?>  >
                                    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>
                          
                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Merchant's Official Email" name="merchant_email" id="merchant_email" <?php if(!empty($merchant_email)){ echo 'value="'.$merchant_email.'" '; echo 'readonly'; } ?> >
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>

                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Current Financial Year (e.g 2016/2017)" name="session" id="session" <?php if(!empty($current_session)){ echo 'value="'.$current_session.'" '; echo 'readonly'; } ?>>
                                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>
                           
                          
                          <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="merchant_type" id="merchant_type" class="form-control has-feedback-left">
                                    
                                    <?php
                                       
                                      if(!empty($merchant_type)){ echo '<option value="'.$merchant_type.'">'.$merchant_type.'</option>'; }
                                      else
                                      {

                                        echo '<option value=""> -Select Merchant Type- </option>';

                                        $sel_pay_type = $paydb->query("SELECT * FROM ".MERCHANT_TYPE);
                                        while($type = $sel_pay_type->fetch_array() )
                                        {
                                          echo '<option value="'.$type['merchantTypeId'].'">'.$type['merchant_type_name'].'</option>';
                                        }

                                     }

                                    ?>
                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                          </div>
                         
                          <div class="row">

                            <?php 

                            if(empty($logo))
                            { 

                               echo '<div class="form-group has-feedback col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" class="form-control has-feedback-left" name="merchant_logo" id="merchant_logo" style="min-height: 45px;"   />
                                   <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>';
                               }
                               else
                               {
                                  echo '';
                               }
                            ?>
                          </div>

                        </form>

                                 <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button class="btn btn-primary" type="reset" id="btn_create_merchant_reset"><i class="fa fa-times"></i> Reset</button>
                                      <button type="button" class="btn btn-success" id="btn_save_create_merchant"><i class="fa fa-save"></i> Create Merchant</button>
                                    </div>
                                  </div>

                       </div>
                      </div>


                      <!-- Step 2 -->
                      <div id="step-2">

                        <?php

                        if($_SESSION['merchID'] == 0)//If MerchantID is that of paytonify, do this:

                        {

                         echo '<div style="padding-left: 250px;">
                              
                                <form class="form-horizontal form-label-left" name="merchant_gateway_profile" id="merchant_gateway_profile" >

                                  <p id="merchant_create_result2"> </p>

                                <p id="merchant_div"></p><!-- Fetch the profile Merchant name through ajax call back -->
                                <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="gatewayId" id="gatewayId" class="form-control has-feedback-left">
                                    <option value=""> -Select Payment Gateway- </option>';
                              
                                      $sel_gateway_id = $paydb->query("SELECT * FROM ".CHANNEL);
                                      while($gateway = $sel_gateway_id->fetch_array() )
                                      {
                                       echo '<option value="'.$gateway['gatewayId'].'">'.$gateway['gateway_name'].'</option>';
                                      }

                                   
                                 echo '</select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left" placeholder="Merchant\'s Gateway ID" name="merchant_gateway_id" id="merchant_gateway_id">
                                    <span class="fa fa-folder form-control-feedback left" aria-hidden="true"></span>
                                </div>
                           </div>

                            <div class="row">
                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                 <input type="text" class="form-control has-feedback-left" placeholder="Merchant\'s API Key" name="merchant_apikey" id="merchant_apikey">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                              </div>
                           </div>

                          </form>

                               <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button class="btn btn-primary" type="reset" id="btn_create_gateway_reset"><i class="fa fa-times"></i> Reset</button>
                                      <button type="button" class="btn btn-success" id="btn_save_create_gateway"><i class="fa fa-save"></i> Profile Merchant Gateway</button>
                                    </div>
                              </div>


                          </div>';
                        }
                        else //Else only show the Merchant's Gateway's API Key and ID
                        {
                           $sel_pay_code = $paydb->query("SELECT * FROM ".SETUP." a
                            INNER JOIN ".MERCHANTS." b ON b.merchantId = a.merchantId INNER JOIN ".CHANNEL." c ON c.gatewayId = a.gatewayId INNER JOIN ".MERCHANT_PROFILE." d ON d.gatewayId = a.gatewayId WHERE a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
                              $num = mysqli_num_rows($sel_pay_code);
                                   
                             if($num > 0)
                             {
                                echo '<table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak style="font-size: 12px;">
                                  <tr>
                                   <th> </th>
                                   <th > Channel </th>
                                   <th > Gateway ID </th>
                                   <th > Api Key </th>
                                  </tr>';

                                  while($row = $sel_pay_code->fetch_array())
                                  {
                                    echo '<tr>';
                                    echo '<td> </td>';
                                    echo '<td>'.$row['gateway_name'].'</td>';
                                    echo '<td>'.$row['merchant_gateway_id'].'</td>';
                                    echo '<td>'.$row['merchant_apikey'].'</td>';
                                    echo '</tr>';
                                  }

                                echo '</table>';
                             }

                        }


                      ?>
                        
                      </div>
                    
                      <!--  -->

                      <!-- Step 3 -->
                      <div id="step-3">
                         
                         <div style="padding-left: 250px;">
                           
                           <span id="merchant_create_result3"></span>

                        <form class="form-horizontal form-label-left" name="gateway_options_form" id="gateway_options_form" >

                          <p id="merchant_div2"></p><!-- Fetch the profile Merchant name through ajax call back -->

                           <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="gatewayId" id="gatewayId" class="form-control has-feedback-left" onchange="fetch_pay_options();">
                                    <option value=""> -Select Payment Gateway- </option>
                                    <?php

                                      $sel_gateway_id = $paydb->query("SELECT * FROM ".CHANNEL);
                                      while($gateway = $sel_gateway_id->fetch_array() )
                                      {
                                       echo '<option value="'.$gateway['gatewayId'].'">'.$gateway['gateway_name'].'</option>';
                                      }

                                    ?>
                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                            </div>

                            <p id="pay_option_div" style="height: 230px;"></p>


                          </form>

                                   

                        </div>

                      </div>
                      <!-- -->
                      

                    </div>
                    <!-- End SmartWizard Content -->
                                       
         </div><!-- X-content -->

      
      </div>
    </div>
  </div>
<script type="text/javascript">
  
//*** Merchant Setup ** JS **///
$(document).on('click', '#btn_create_merchant_reset', function(){

  $('#merchant_setup')[0].reset();

});

$(document).on('click', '#btn_save_create_merchant', function(e){

  e.preventDefault();

    $('#merchant_setup').validate({

      rules:   {
                merchant_name:{ required: true},
                merchant_email: { required: true, email: true},
                merchant_type: {required: true},
                session: {required: true},
                merchant_logo: {required: true}
               },

      messages: {
                merchant_name: 'Merchant Name Required',
                merchant_email: {required: 'Email is Required', email: 'Enter a Valid Email'},
                merchant_type: 'Please select a type',
                session: 'Please enter financial year',
                merchant_logo: 'You must select a logo image'
               },

//This will align the error messages correctly with the form group
    highlight: function(element) 
        {
        $(element).closest('.form-group').addClass('has-error');
        },
    unhighlight: function(element) 
        {
        $(element).closest('.form-group').removeClass('has-error');
        },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
            if(element.parent('.input-group').length)
             {
                error.insertAfter(element.parent());
             } 
             else 
             {
                error.insertAfter(element);
             }
                    }

           });

              if($('#merchant_setup').valid())
        {

                    //var formdata = new FormData($("#merchant_setup")); //This approach doesn't work in Fireworks so I commented it out
                    var formdata = new FormData();
          formdata.append('merchant_logo', $('#merchant_logo')[0].files[0]);
          formdata.append('merchant_name', $('#merchant_name').val());
          formdata.append('merchant_email', $('#merchant_email').val());
          formdata.append('merchant_type', $('#merchant_type').val());
          formdata.append('session', $('#session').val());

          var merchant_name = $('#merchant_name').val();
         
           $("#merchant_create_result1").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');
            
           $.ajax({
                type: 'POST',
            url: '../production/ajax_calls/ajax_create_merchant_data_form',
            data: formdata,
                        mimeType: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        processData: false,
                  success: function(msg)
              {
                $('#merchant_create_result1').empty();
                $('#merchant_create_result1').html(msg);

                //I need to post the merchant name as an input field so that other form wizard tabs can use it
                $('#merchant_div').html('<input type="hidden" name="merch_name" id="merch_name" value="' + merchant_name + '" />');
                $('#merchant_div2').html('<input type="hidden" name="merch_name" id="merch_name" value="' + merchant_name + '" />');    
              },
              error: function()
              {
                alert('Merchant Setup Build Failed');
              }
                     });
                
            } 
    });

$(document).on('click', '#btn_create_gateway_reset', function(){

  $('#merchant_gateway_profile')[0].reset();

});

$(document).on('click', '#btn_save_create_gateway', function(e){

e.preventDefault();

    $('#merchant_gateway_profile').validate({

      rules:   {
        gatewayId:{ required: true},
        merchant_gateway_id: { required: true},
        merchant_apikey: {required: true}
               },

      messages:{
              gatewayId: 'Please select choice gateway',
        merchant_gateway_id: {required: 'Field is required'},
        merchant_apikey: 'Field is required'
               },
//This will align the error messages correctly with the form group
    highlight: function(element) 
        {
        $(element).closest('.form-group').addClass('has-error');
        },
    unhighlight: function(element) 
        {
        $(element).closest('.form-group').removeClass('has-error');
        },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
            if(element.parent('.input-group').length)
             {
                error.insertAfter(element.parent());
             } 
             else 
             {
                error.insertAfter(element);
             }
                    }

           });

              if($('#merchant_gateway_profile').valid())
        {
          $("#merchant_create_result2").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');

            var formdata = $('#merchant_gateway_profile').serialize();
            
           $.ajax({
                type: 'POST',
            url: '../production/ajax_calls/ajax_create_gateway_data_form',
            data: formdata,
                        dataType: 'html', 
                  success: function(msg)
              {
                      $('#merchant_create_result2').empty();
                $('#merchant_create_result2').html(msg);
              },
                  error: function()
              {
                 alert('Gateway Setup Build Failed');
              }
                     });                

        }

});

function fetch_pay_options()
{
   $("#pay_option_div").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var dataString = $('#gateway_options_form').serialize();

    $.ajax({
             type: 'POST',
             url: '../production/ajax_calls/ajax_fetch_pay_options',
             dataType: 'html',
             data: dataString,
             success: function(msg)
             {
               $('#pay_option_div').empty();
               $('#pay_option_div').html(msg);

             },
             error: function()
             {
                 alert('Payment Options Fetch Failed');
             }

           });  
}

$(document).on('click', '#btn_save_gateway_options', function(e){

  e.preventDefault();
     
    $("#merchant_create_result3").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var dataString = $('#gateway_options_form').serialize();

    $.ajax({
             type: 'POST',
             url: '../production/ajax_calls/ajax_gateway_options_data_form',
             dataType: 'html',
             data: dataString,
             success: function(msg)
             {
               $('#merchant_create_result3').empty();                 
               $('#merchant_create_result3').html(msg);

             },
             error: function()
             {
                 alert('Gateway Option Build Failed');
             }

           });

});


</script>

</body></html>