<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];


    $sel_merchant_name = $paydb->query("SELECT * FROM ".MERCHANTS." WHERE merchantId = '$merchantId'");
    $merchant = $sel_merchant_name->fetch_array();
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
                            <span class="step_descr"> Payment Choice Setup </span>
                          </a>
                        </li>

                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr"> Payment Type Setup </span>
                          </a>
                        </li>

                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr"> Payment Fee Setup </span>
                          </a>
                        </li>

                       
                      </ul>

                      <!-- Step 1 -->
                      <div id="step-1">                     

                      <div style="padding-left: 250px;">

                      <p id="payment_choice_result"></p> <!-- ResultOutput -->
                      <form class="form-horizontal form-label-left" name="payment_choice_setup" id="payment_choice_setup" >

                       
                          <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="merchantId" id="merchantId" class="form-control has-feedback-left">
                                    <option value="<?php echo $merchant['merchantId']; ?>"> <?php echo $merchant['merchant_name']; ?> </option>
                                    
                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                            </div>


                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Payment Choice Name" name="payment_choice_name" id="payment_choice_name">
                                    <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>


                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="req_fee_items" id="req_fee_items" class="form-control has-feedback-left">
                                    
                                    <option value=""> - Require Fee Items? - </option>
                                    <option value="YES"> YES </option>
                                    <option value="NO"> NO </option>
                                    
                                    </select>
                                  <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>

                                </div>
                            </div>
                          
                         

                       </form>

                                 <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button class="btn btn-primary" type="reset" id="btn_payment_choice_reset"><i class="fa fa-times"></i> Reset</button>
                                      <button type="button" class="btn btn-success" id="btn_save_payment_choice"><i class="fa fa-save"></i> Create Payment Choice </button>
                                    </div>
                                  </div>

                       </div>
                      </div>


                      <!-- Step 2 -->
                      <div id="step-2">

                         <div style="padding-left: 250px;">

                           <p id="payment_type_result"></p><!-- result output -->

                            <form class="form-horizontal form-label-left" name="payment_type_setup" id="payment_type_setup" >
                              
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="merchantId_type" id="merchantId_type" class="form-control has-feedback-left" onchange="fetch_pay_choices();">
                                    <option value=""> -Select Merchant - </option>
                                    <option value="<?php echo $merchant['merchantId']; ?>"> <?php echo $merchant['merchant_name']; ?> </option>
                                    
                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                            </div>

                            <div id="pay_choices_div"> </div><!-- Content called with ajax -->


                          </div>
                        
                      </div>
                      <!--  -->

                      <!-- Step 3 -->
                      <div id="step-3">
                         
                        <div style="padding-left: 250px; min-height: 320px;">
                           
                           <p id="payment_fee_result"></p>

                              <form class="form-horizontal form-label-left" name="payment_fee_setup" id="payment_fee_setup">

                               <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="merchantId_fee" id="merchantId_fee" class="form-control has-feedback-left" onchange="fetch_pay_choice2();">
                                      <option value=""> -Select Merchant - </option>
                                      <option value="<?php echo $merchant['merchantId']; ?>"> <?php echo $merchant['merchant_name']; ?> </option>
                                      
                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                               </div>

                               <div id="pay_type_div"> </div>
                                   

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

  
//*** Payment Setup ** JS **///
$(document).on('click', '#btn_payment_choice_reset', function(){

  $('#payment_choice_setup')[0].reset();

});

$(document).on('click', '#btn_save_payment_choice', function(e){

  e.preventDefault();

    $('#payment_choice_setup').validate({

        rules:   {
        merchantId:{ required: true},
        payment_choice_name: {required: true},
        req_fee_items: {required: true}
               },

        messages: {
        merchantId: 'Merchant Name Required',
        payment_choice_name: 'Field Required',
        req_fee_items: 'Please Choose an option'
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

              if($('#payment_choice_setup').valid())
         {
         
           $("#payment_choice_result").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');

           dataString = $("#payment_choice_setup").serialize();
            
           $.ajax({
                        type: 'POST',
                        url: '../production/ajax_calls/ajax_create_payment_choice_data_form',
                        data: dataString,
                        cache: false,
                  success: function(msg)
                  {
                        $('#payment_choice_result').empty();
                        $('#payment_choice_result').html(msg);   
                  },
                  error: function()
                  {
                        alert('Payment Choice Setup Failed');
                  }
                     });
                
        } 
    });

//Function to load payment choices -->
function fetch_pay_choices()
{
  $("#pay_choices_div").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var merchantName = $('#merchantId_type').val();

    if(merchantName != '')
    {

    $.ajax({
             type: 'POST',
             url: '../production/ajax_calls/ajax_fetch_payment_choice',
             dataType: 'html',
             data: merchantName,
             success: function(msg)
             {
               $('#pay_choices_div').empty();
               $('#pay_choices_div').html(msg);

             },
             error: function()
             {
                 alert('Payment Choices Build Failed');
             }

           });
    }
    else 
    {
       $('#pay_choices_div').html('<i class="fa fa-ban"></i> *No Selection*');
    }  
}


//Ajax-jQuery to create Payment type
$(document).on('click', '#btn_payment_type_reset', function(){

  $('#payment_type_setup')[0].reset();

});

$(document).on('click', '#btn_save_payment_type', function(e){

  e.preventDefault();

    $('#payment_type_setup').validate({

        rules: {
        merchantId_type:{ required: true},
        choiceId:{ required: true},
        payment_type_name: {required: true}
               },

        messages: {
        merchantId_type: 'Merchant Name Required',
        choiceId:   'Choose Payment Choice Name',
        payment_type_name: 'Field Required'
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

        if($('#payment_type_setup').valid())
         {
         
           $("#payment_type_result").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');

           dataString = $("#payment_type_setup").serialize();
            
           $.ajax({
                        type: 'POST',
                        url: '../production/ajax_calls/ajax_create_payment_type_data_form',
                        data: dataString,
                        cache: false,
                        success: function(msg)
                        {
                              $('#payment_type_result').empty();
                              $('#payment_type_result').html(msg);   
                        },
                        error: function()
                        {
                              alert('Payment Type Setup Failed');
                        }
                     });
                
        } 
    });


//Function to load payment choices for the payment fee setup -->
function fetch_pay_choice2()
{
  $("#pay_type_div").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var merchantname = $('#merchantId_fee').val();

    if(merchantname != '')
    {

    $.ajax({
             type: 'GET',
             url: '../production/ajax_calls/ajax_fetch_payment_choice2?merchantname='+merchantname,
             dataType: 'html',
             //data: merchantname,
             success: function(msg)
             {
               $('#pay_type_div').empty();
               $('#pay_type_div').html(msg);

             },
             error: function()
             {
                 alert('Payment Choice Build Failed');
             }

           });
    }
    else 
    {
       $('#pay_type_div').html('<i class="fa fa-ban"></i> *No Selection*');
    }  
}

//Function to load payment types-->
function fetch_pay_type()
{
  $("#pay_type_div2").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var choiceid = $('#choiceId').val();

    if(choiceid != '')
    {

    $.ajax({
             type: 'GET',
             url: '../production/ajax_calls/ajax_fetch_payment_type?choiceid='+choiceid,
             dataType: 'html',
             //data: merchantname,
             success: function(msg)
             {
               $('#pay_type_div2').empty();
               $('#pay_type_div2').html(msg);

             },
             error: function()
             {
                 alert('Payment Type Build Failed');
             }

           });
    }
    else 
    {
       $('#pay_type_div2').html('<i class="fa fa-ban"></i> *No Selection*');
    }  
}

//Function to load payment setup param-->
function fetch_setup_param()
{
  $("#pay_setup_param_div").html('<span style="color: #1ABC9C;"> <i class="fa fa-2x fa-spin fa-refresh fa-fw"></i> Processing... </span>');

    var merchantid = $('#merchantId_fee').val();
    var choiceid = $('#choiceId').val();
    var typeid = $('#typeId').val();

    if((choiceid != '') && (typeid != ''))
    {

    $.ajax({
             type: 'GET',
             url: '../production/ajax_calls/ajax_fetch_payment_setup_param?choiceid='+choiceid+'&typeid='+typeid+'&merchantid='+merchantid,
             dataType: 'html',
             success: function(msg)
             {
               $('#pay_setup_param_div').empty();
               $('#pay_setup_param_div').html(msg);

             },
             error: function()
             {
                 alert('Payment Setup Parameter Build Failed');
             }

           });
    }
    else 
    {
       $('#pay_setup_param_div').html('<i class="fa fa-ban"></i> *No Selection*');
    }  
}

//Ajax-jQuery to create Payment fee
$(document).on('click', '#btn_payment_fee_reset', function(){

  $('#payment_fee_setup')[0].reset();

});

$(document).on('click', '#btn_save_payment_fee', function(e){

  e.preventDefault();

  var choiceId = $('#choiceId').val();
  var typeId = $('#typeId').val();
  var service_type_id = $('#service_type_id').val();
  var setup_name = $('#setup_name').val();
  var payment_code = $('#payment_code').val();
  var active_gateway_id = $('#active_gateway_id').val();
  var reprocessible = $('#reprocessible').val();

  

  /*var pay_fee_setup = $('#payment_fee_setup');


    pay_fee_setup.validate({

          rules:  {                 
                  choiceId:        {required: true},
                  typeId:          {required: true},
                  setup_name:      {required: true},
                  service_type_id: {required: true}
                  },

          messages: {
                    choiceId:        'Choose Payment Choice',
                    typeId:          'Choose Payment Type',
                    setup_name:      'Payment Fee Setup Name Required',
                    service_type_id: 'Service Type ID Required'
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

        if(pay_fee_setup.valid())
         {
          */
        

           if((setup_name == '') || (service_type_id == '') || (active_gateway_id == '') || (reprocessible == ''))
           {
              alert('*All fields must be filled');
           }
           else
           {
           //var dataString = pay_fee_setup.serialize();
             $('#payment_fee_result').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');
            
           $.ajax({
                        type: 'GET',
                        url: '../production/ajax_calls/ajax_create_payment_fee_data_form?choiceid='+choiceId+'&typeid='+typeId+'&setupname='+setup_name+'&serviceid='+service_type_id+'&paymentcode='+payment_code+'&activegateway='+active_gateway_id+'&reprocessible='+reprocessible,
                        //data: dataString,
                        dataType: 'html',
                        success: function(msg)
                        {
                              $('#payment_fee_result').empty();
                              $('#payment_fee_result').html(msg);   
                        },
                        error: function()
                        {
                              alert('Payment Fee Setup Failed');
                        }
                 });
            }
            
       // } 
    });
</script>

</body></html>