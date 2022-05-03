// JavaScript Document

//This function is a call to populate the payment choice of a perticular merchant
function load_choice()
{
	
if($('#merchant_id').val() == '')
{
		$('#merchant_pay_choice').empty();
		$('#merchant_pay_type').empty();
}
else
{
   	$('#merchant_choice').html('<i class="fa fa-spin fa-3x fa-spinner fa-fw"> </i>');
	var dataString = $('#merchant_id').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/merchantPaymentChoice',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_choice').html(data);
		   if($('#payNull').html() == '-NO PAYMENT CHOICE LISTED YET-')
		   {
			   $('#merchant_pay_type').empty();
		   }
	   }, 
	   error: function()
	   {
		   alert('Operation Failed');
	   }
 
       });

}

}
//

//This function calls the payment type perculiar to a payment option of a merchant
function load_type()
{
	var dataString = $('#payChoice').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/merchantPaymentType',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_type').html(data);
	   }, 
	    error: function()
	   {
		   alert('Operation Failed');
	   }  
 
       });

}

//This function helps to push user selection into the Modal overlay
function get_choice_value()
{
	var merchant = $('#merchant_id').val();
	var choice = $('#payChoice').val();
	var type = $('#payType').val();
	
	concat_all(merchant, choice, type); //This calls another function below
	
}

//This function helps to pass the chosen parameters to the Modal content page.
function concat_all(a, b, c)
	{
		var payChoiceValue = 'operations/core/processChoicePayment?merch='+a+'&payChoice='+b+'&payType='+c;
		var retURL = $('button').attr('href', payChoiceValue);
		
		return;
	}

//This function sends the chosen payment gateway to populate specific payment options available under a payment gateway	
function fetch_payment_options(gateway, merchid, setup)
{    
	if($('#amount').val() != 0)
	{
		$.ajax({
			type: 'GET',
			url: 'ajax_calls/paymentOptionList?gateway='+gateway+'&merchantId='+merchid+'&setupname='+setup,
			success: function(data)
			{
				$('#paymentOption').html(data);
			},
			error: function()
			{
				alert('Error populating payment option');
			}
			
		  });
	}
	else
	{
		  $('#paymentOption').html('<i class="fa fa-ban"></i> <b style="color:red;"> FEE AMOUNT CANNOT BE ZERO! </b>');
	}

}

//This function extracts payer details.
function payers_details()
{
	$('#spinner').html('<i class="fa fa-spin fa-3x fa-spinner fa-fw"> </i>');
	
	var dataString = $('#payment-details-form').serialize();
	$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/merchantUserDetails',
	   data: dataString,
	   success: function(data)
	   {
		   $('#spinner').empty();
		   $('#merchant_user_details').html(data);
	   }, 
	    error: function()
	   {
		   alert('Operation Failed');
	   }  
 
       });
}

//To focus on the user ID field on load of the Modal
$('#myModal').on('shown.bs.modal', function () {
  $('#userId').focus()
})
//To refresh the home page onClose of the Modal
$('#myModal').on('hidden.bs.modal', function(){
	location.reload();
})

//To focus on the user ID field on load of the Modal-reprocess
$('#modal-reprocess').on('shown.bs.modal', function () {
  $('#userId').focus()
})
//To refresh the home page onClose of the Modal-reprocess
$('#modal-reprocess').on('hidden.bs.modal', function(){
	location.reload();
})

//To focus on the user ID field on load of the Modal-verify
$('#modal-verify').on('shown.bs.modal', function () {
  $('#userId').focus()
})
//To refresh the home page onClose of the Modal-verify
$('#modal-verify').on('hidden.bs.modal', function(){
	location.reload();
})

//To refresh the home page onClose of the Modal-signup
$('#modal-signup').on('hidden.bs.modal', function(){
	location.reload();
})





//To display User's payment details
$('#process').click(function(){
	if(($('#amount').val() == 0) || ($('#optionId').val() == '') || ($("input[name='gateway']:checked").size() == 0))
	{
		alert('Check the amount field or your choice of payment selections');
	}
	else
	{
		
		$('#display-content').hide();
		$('#display-spinner').html('<i class="fa fa-spin fa-3x fa-spinner fa-fw"></i> Processing...')
		
		var formdata = $('#payment-details-form').serialize();
		
		$.ajax({
				type: 'GET',
				url: 'ajax_calls/processPayment',
				data: formdata,
				dataType: 'html',
				success: function(msg)
				{
					$('#display-spinner').hide();
					$('#display-result').html(msg);
					$('#process').hide(); //Hide the process payment button
					$('#process-close').hide(); //Hide the close button
				},
				error: function()
				{
					alert('Error: Operation Failed.');
				}			
		      });
	}
		
   
});

//To Process Payment
$(document).on('click', '#btn-submit-payment-details', function(){
	
		//$('.warning-div').hide();		
		var dataString = $('#process-payment').serialize();
	
		$.ajax({
				type: 'POST',
				url: 'ajax_calls/paymentGatewayIntegration',
				dataType: 'html',
				data: dataString,
				success: function(msg)
				{
					$('#div-submit-details').hide(); //Hide the continue and discard button on paymentGatewayIntegration
					//$('#btn-process-payment-details').show();
					$('#process-pay').html(msg);
				},
				error: function()
				{
					alert('Error: Operation Failed.');
				}			
		      });
});

//******* ALL FOR REPROCESS *********************//
//getting payer institution and payment type for reprocess payment
function get_payer_institution()
{
   	$('#merchant_pay_options').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	
	if($('#userId').val() != '')
	{
		var dataString = $('#reprocess').serialize();
		$.ajax({
		   type: 'POST',
		   url: 'ajax_calls/getPayersPaymentOption',
		   data: dataString,
		   success: function(data)
		   {
			   $('#merchant_pay_options').html(data);
			   
			      if($('#merchant_pay_options').html() == '<button class="btn btn-danger btn-sm">User Not Found</button>')
					{ 
						$('#merchant_pay_session').empty();
						$('#merchant_pay_gateway').empty();
						$('#merchant_pay_gateway_invoice').empty();
					
					}
			   
		   }, 
		   error: function()
		   {
			   alert('User Not Found');
		   }
	 
	       });
	}
 
}

function display_session()
{
	$('#merchant_pay_invoice').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	var dataString = $('#reprocess').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersPaymentSession',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_session').html(data);
		   
	   }, 
	   error: function()
	   {
		   alert('User Not Found');
	   }
 
       });
}

//getting payer gateway and invoice for a partiular payment type
function get_gateway_invoice()
{
   	$('#merchant_pay_gateway_invoice').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	var dataString = $('#reprocess').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersGateway-invoice',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_gateway_invoice').html(data);
	   }, 
	   error: function()
	   {
		   alert('No Payment Record Found');
	   }
 
       });
}

//To reprocess payer's previous transaction
$('#btn-reprocess').click(function(){
	if(($('#setupId').val() != '') && ($('#session') != '')&& ($('#invoice') != '')&& ($('#gateway') != ''))
	{
		$('#reprocess-form').hide();
		$('#display-spinner').html('<i class="fa fa-spin fa-3x fa-spinner fa-fw"></i> Please wait...')
		
		var formdata = $('#reprocess').serialize();
		
		$.ajax({
				type: 'POST',
				url: 'ajax_calls/reprocessPaymentGatewayAPI',
				data: formdata,
				dataType: 'html',
				success: function(msg)
				{
					$('#display-spinner').hide();
					$('#reprocess-result').html(msg);
					$('#reprocess-close').hide(); //Hide the discard button
					$('#btn-reprocess').hide(); //Hide the reprocess payment button
				},
				error: function()
				{
					alert('Error: Operation Failed.');
				}			
		      });
	}
	else
	{
		alert('All fields must be filled');
	}
   
});

//*****************ALL FOR REPROCESS ENDS *************************//

//Function to select payment gateway logo
function choose_pay_logo()
{
	var pageURL = window.location.href;

	if(($("input[name='gateway']:checked").val() == 1))
	{
		$('#pay-logo').show();
		$('#logo').html('<img src="'+pageURL+'/images/remita-logo.png" />');
	}
	else if(($("input[name='gateway']:checked").val() == 2))
	{
		$('#pay-logo').show();
		$('#logo').html('<img src="'+pageURL+'/images/etranzact-logo.png" />');
	}
	else if(($("input[name='gateway']:checked").val() == 3))
	{
		$('#pay-logo').show();
		$('#logo').html('<img src="'+pageURL+'/images/interswitch-logo.png" />');
	}
	else if(($("input[name='gateway']:checked").val() == 4))
	{
		$('#pay-logo').show();
		$('#logo').html('<img src="'+pageURL+'/images/gtpay-logo.png" />');
	}
}

//******* ALL FOR VERIFY *********************//
//getting payer institution and payment type for reprocess payment
function get_payer_institution_ver()
{
   	$('#merchant_pay_options_ver').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	
	var dataString = $('#verify').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersPaymentOption-verification',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_options_ver').html(data);
		   
		      if($('#merchant_pay_options_ver').html() == '<button class="btn btn-danger btn-sm">User Not Found</button>')
				{ 
					$('#merchant_pay_session_ver').empty();
					$('#merchant_pay_gateway_ver').empty();
					$('#merchant_pay_invoice_ver').empty();
				}		   
	   }, 
	   error: function()
	   {
		   alert('User Not Found'); 
	   }
 
       });



}

function display_session_ver()
{
	$('#merchant_pay_session_ver').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	var dataString = $('#verify').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersPaymentSession-verification',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_session_ver').html(data);
		   
		    if($('#merchant_pay_options_ver').val() == '')
			  {
				$('#merchant_pay_gateway_ver').empty();
				$('#merchant_pay_invoice_ver').empty();
				
			  }		   
	   }, 
	   error: function()
	   {
		   alert('User Not Found');
	   }
 
       });
}

//getting payer gateway and invoice for a partiular payment type
function get_gateway()
{
   	$('#merchant_pay_gateway_ver').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	var dataString = $('#verify').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersGateway-verification',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_gateway_ver').html(data);
		   		   
		   if($('#merchant_pay_gateway_ver').html() == '<button class="btn btn-danger btn-sm">Error: Payment Details Cannot be Fetched</button>')
		   {
			   $('#merchant_pay_invoice_ver').empty();
		   }
	   }, 
	   error: function()
	   {
		   alert('No Payment Record Found');
	   }
 
       });
}

//getting payer gateway and invoice for a partiular payment type
function get_invoice()
{
   	$('#merchant_pay_invoice_ver').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');
	var dataString = $('#verify').serialize();
$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/getPayersInvoice-verification',
	   data: dataString,
	   success: function(data)
	   {
		   $('#merchant_pay_invoice_ver').html(data);
	   }, 
	   error: function()
	   {
		   alert('No Payment Record Found');
	   }
 
       });
}

//To reprocess payer's previous transaction
$('#btn-verify').click(function(){
	if(($('#setupId').val() != '') && ($('#session') != '')&& ($('#invoice') != '')&& ($('#gateway') != ''))
	{
		$('#verify-form').hide();
		$('#verify-spinner').html('<i class="fa fa-spin fa-3x fa-spinner fa-fw"></i> Please wait...')
		
		var formdata = $('#verify').serialize();
		
		$.ajax({
				type: 'POST',
				url: 'ajax_calls/verifyPaymentGatewayAPI',
				data: formdata,
				dataType: 'html',
				success: function(msg)
				{
					$('#verify-spinner').hide();
					$('#verify-result').html(msg);
					$('#verify-close').hide(); //Hide the discard button
					$('#btn-verify').hide(); //Hide the reprocess payment button
				},
				error: function()
				{
					alert('Error: Operation Failed.');
				}			
		      });
	}
	else
	{
		alert('All fields must be filled');
	}
   
});

//*****************ALL FOR VERIFY ENDS *************************//


//This function is a call to check the avilability of the username
function check_username()
{
	
   	$('#password-div').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i>');

   	var dataString = $('#user_login').serialize();

$.ajax({
	   type: 'POST',
	   url: 'ajax_calls/userAccountVerification',
	   data: dataString,
	   dataType: 'html',
	   cache: 'false',
	   success: function(msg)
	   {
		   $('#password-div').html(msg);
		   
	   }, 
	   error: function()
	   {
		   alert('Operation Failed');
	   }
 
       });

}
//


//Admin Login
$(document).on('click', '#btn-logUser', function(){

	if(($('#userId').val() != '') || ($('#securecode').val() != ''))
	{
	
		$('#login-result').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Please wait...')
		
		var formdata = $('#user_login').serialize();
		
		$.ajax({
				type: 'POST',
				url: 'ajax_calls/userAccountLogin',
				data: formdata,
				dataType: 'html',
				cache: 'false',
				success: function(data)
				{
						$('.login-div').hide();
					    $("#footnote").hide();

					    $('#login-result').html(data);

				if($('#login-result').html() == '<p style="color:red; font-size: 13px;"> <i class="fa fa-angle-double-left"></i> Username and Password Do Not Match! <i class="fa fa-angle-double-right"></i> </p>')
					{
						$('.login-div').show();
					    $("#footnote").show();

					}

					
					
				},
				error: function()
				{
					alert('Error: Login Operation Failed.');
				}			
		      });
	}
	else
	{
		alert('*Username and Password is required');
	}

	

});

//Printer friendly page
function printerFriendly(a, b, c, d, e)
{
  var URLink = 'invoicePrinterFriendlyPage?userId='+a+'&setupId='+b+'&optionId='+c+'&merchantId='+d+'&invoice='+e;

  var win = window.open(URLink, "_blank", "location=no, height=570, width=650, scrollbars=yes, status=no")
}

//This function helps to pass the logged user to admin dashboard.
function log_auth(log, token)
	{
		var loginAuth = 'adminDashboard/production/auth_page?token='+token+'&auth='+log;
		window.location.href = loginAuth;
		//window.open(loginAuth, '_blank');
		
	}
jQuery(document).ready(function()
{   
   $(".navbar-header button").click(function(event) {
   if ($(".navbar-collapse").hasClass('in'))
   {  $(".navbar-collapse").slideUp();  }
   
});
});


//To Sign Up
//Admin Login
$(document).on('click', '#btn-signup', function(e){

	e.preventDefault();


    $('#signup-form').validate({

      rules: {
        userId:{ required: true},
        user_name: 'required',
        passcode: 'required',
        conf_passcode: {equalTo: "#pass"},
        user_email: { required: true, email: true},
        user_phone: 'required',
        merchantId: {required: true}
             },

      messages: {

        userId: { required: 'User ID is Required'},
        passcode: 'Password is Required',
        conf_passcode: {equalTo: 'Password Do Not Match'},
        user_name: 'Full Name Required',
        user_email: {required: 'Email is Required', email: 'Enter a Valid Email'},
        user_phone: 'Phone Number Required',
        merchantId: 'Select Merchant Name'

             },
  
//This will align the error messages correctly with the form group
   highlight: function(element) 
        {
        $(element).closest('.input-group').addClass('has-error');
        },
    unhighlight: function(element) 
        {
        $(element).closest('.input-group').removeClass('has-error');
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

	if($('#signup-form').valid() == true)
	{
	
		$('#signup-result').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Signing Up...')
		
		var formdata = $('#signup-form').serialize();
		
		$.ajax({
				type: 'POST',
				url: 'ajax_calls/signUp',
				data: formdata,
				dataType: 'html',
				cache: 'false',
				success: function(data)
				{
					$('#signup-result').html(data);
					console.log(data);	
					
				},
				error: function()
				{
					alert('Error: Signup Operation Failed.');
				}			
		      });
	}
	
	

});

//Function to check if Passowrd Matches
/*function checkMatch()
{
	var passcode = $('#passcode').val();
	var check_passcode = $('#passcode2').val();

	if( check_passcode != passcode)
	{
		alert('Password Does Not Match!');
	}
}
*/
