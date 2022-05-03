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
                            <span class="step_descr"> Gateway Profiling </span>
                          </a>
                        </li>

                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr"> Gateway Options Profiling </span>
                          </a>
                        </li>
                      
                      </ul>

                      <!-- Step 1 -->
                      <div id="step-1">                     

                      <div style="padding-left: 250px;">

                      <p id="gateway_profile_result"></p> <!-- ResultOutput -->
                       
                        <form class="form-horizontal form-label-left" name="gateway_profile" id="gateway_profile" >
                       
                          <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" placeholder="Insert Gateway Name" name="gateway_name" id="gateway_name" >
                                <span class="fa fa-plus form-control-feedback left" aria-hidden="true"> </span>
                              </div>
                          </div>
                         
                        </form>

                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                  <button class="btn btn-primary" type="reset" id="btn_gateway_profile_reset"><i class="fa fa-times"></i> Reset </button>
                                  <button type="button" class="btn btn-success" id="btn_save_gateway_profile"><i class="fa fa-save"></i> Profile Gateway </button>
                                </div>
                            </div>

                       </div>
                      </div>


                      <!-- Step 2 -->
                      <div id="step-2">
                         <div style="padding-left: 250px;">

                           <p id="gateway_profile_option_result"></p><!-- result output -->

                            <form class="form-horizontal form-label-left" name="gateway_option_profile" id="gateway_option_profile" >
                              
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <select name="gatewayid" id="gatewayid" class="form-control has-feedback-left">
                                          <option value=""> -Select Gateway - </option>
                                          <?php     

                                            $sel_gateway = $paydb->query("SELECT * FROM ".CHANNEL." ORDER BY gatewayId ASC");
                                            while($channel = $sel_gateway->fetch_array())
                                            {
                                              echo '<option value="'.$channel['gatewayId'].'">'.$channel['gateway_name'].'</option>';
                                            }
                                          ?>
                                         </select>
                                        <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                </div>

                              <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Insert Option Name" name="gateway_option" id="gateway_option" >
                                    <span class="fa fa-plus form-control-feedback left" aria-hidden="true"> </span>
                                  </div>
                              </div>
                          </form>

                           <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                  <button class="btn btn-primary" type="reset" id="btn_gateway_profile_option_reset"><i class="fa fa-times"></i> Reset </button>
                                  <button type="button" class="btn btn-success" id="btn_save_gateway_profile_option"><i class="fa fa-save"></i> Profile Gateway Option </button>
                                </div>
                            </div>


                      </div>                        
                   </div>
                      <!--  -->

                </div>
              <!-- End SmartWizard Content -->
                                       
         </div><!-- X-content -->

      
      </div>
    </div>
  </div>
<script type="text/javascript">

  
//*** Gateway Profile ** JS **///
$(document).on('click', '#btn_gateway_profile_reset', function(){

  $('#gateway_profile')[0].reset();

});

$(document).on('click', '#btn_save_gateway_profile', function(e){

  e.preventDefault();

    $('#gateway_profile').validate({

        rules:   { gateway_name:{ required: true}, },

        messages: { gateway_name: 'Gateway Name Required', },

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

              if($('#gateway_profile').valid())
         {
         
           $("#gateway_profile_result").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');

           dataString = $("#gateway_profile").serialize();
            
           $.ajax({
                        type: 'POST',
                        url: '../production/ajax_calls/ajax_create_gateway_profile',
                        data: dataString,
                        cache: false,
                  success: function(msg)
                  {
                        $('#gateway_profile_result').empty();
                        $('#gateway_profile_result').html(msg);   
                  },
                  error: function()
                  {
                        alert('Gateway Profiling Failed');
                  }
                     });
                
        } 
    });


////////

$(document).on('click', '#btn_gateway_profile_option_reset', function(){

  $('#gateway_option_profile')[0].reset();

});

$(document).on('click', '#btn_save_gateway_profile_option', function(e){

  e.preventDefault();

    $('#gateway_option_profile').validate({

        rules:   { gatewayid:{ required: true}, gateway_option: {required: true} },

        messages: { gatewayid: 'Gateway Name Required', gateway_option: 'Please Insert Gateway Option' },

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

         if($('#gateway_option_profile').valid())
         {
         
           $("#gateway_profile_option_result").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');

           dataForm = $("#gateway_option_profile").serialize();
            
           $.ajax({
                        type: 'POST',
                        url: '../production/ajax_calls/ajax_create_gateway_profile_option',
                        data: dataForm,
                        cache: false,
                  success: function(msg)
                  {
                        $('#gateway_profile_option_result').empty();
                        $('#gateway_profile_option_result').html(msg);   
                  },
                  error: function()
                  {
                        alert('Gateway Option Profiling Failed');
                  }
                     });
                
        } 
    });


</script>

</body></html>