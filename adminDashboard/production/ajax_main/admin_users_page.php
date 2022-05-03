<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    //$getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    //$merchantId = $getDetails['merchantId'];
    //$current_session = $getDetails['current_session'];

?>

 <html><body>
          

          <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Users Setup - <small> Administrative Users </small></h4>
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
                    <br />

                    <p id="admin_result_div"> </p><br/>

                    <form class="form-horizontal form-label-left input_mask" name="admin_user_form" id="admin_user_form">
                                     
                     <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" placeholder="User Name (8 xters only)" name="userId" id="userId">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     

                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left"  placeholder="Full Name" name="user_name" id="user_name">
                        <span class="fa fa-list form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>


                     <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="password" class="form-control has-feedback-left" placeholder="Password" name="passcode" id="pass">
                        <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                      </div>
                                          
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="password" class="form-control has-feedback-left" placeholder="Confirm Password" name="conf_passcode" id="confirm_pass" >
                        <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>

                             

                     <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" placeholder="Email" name="user_email" id="user_email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left"  placeholder="Phone" name="user_phone" id="user_phone">
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>

                    <div class="row">
                     <?php 
                       //This should only be shown to paytonify admin 

                      if($_SESSION['merchID'] == 0) {  
                    ?>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">

                        <select name="merchantId" id="merchantId" class="form-control has-feedback-left">

                       
                        <option value=""> - Select Merchant - </option>
                        <?php
                           
                           //Select all Merchants 
                           $merchants = $paydb->query("SELECT * FROM ".MERCHANTS);
                           while ($merch = $merchants->fetch_array())

                            {
                              echo '<option value="'.$merch['merchantId'].'">'.$merch['merchant_name'].'</option>';
                         
                            }


                        ?> 

                         </select>
                        <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        
                  <?php } ?>


                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                    <select name="sel_role" id="sel_role" class="form-control has-feedback-left">
                    <option value=""> - Select Admin Role - </option>
                    <?php
                       
                       //call to get roles function
                       $roles = get_users_roles();
                       while ($usr = $roles->fetch_array())

                       {
                          echo '<option value="'.$usr['roleId'].'">'.$usr['roles'].'</option>';
                       }


                    ?>

                    </select>
                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    </div>
                    <br/>

                      
                      <div class="ln_solid"></div>

                    </form>

                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="reset" id="btn_admin_user_reset" ><i class="fa fa-times"></i> Reset</button>
                          <button type="button" class="btn btn-success" id="btn_save_admin_user"><i class="fa fa-save"></i> Create User</button>
                        </div>
                      </div>

              </div>
            

            </div>
          </div>
        </div>

          
<script type="text/javascript">
  
  $(document).on('click', '#btn_admin_user_reset', function(){

  $('#admin_user_form')[0].reset();

});

$(document).on('click', '#btn_save_admin_user', function(e){

  e.preventDefault();

    $('#admin_user_form').validate({

      rules: {
        userId:{ required: true, maxlength: 8},
        user_name: 'required',
        passcode: 'required',
        conf_passcode: {equalTo: "#pass"},
        user_email: { required: true, email: true},
        user_phone: 'required',
        sel_role: {required: true},
        merchantId: {required: true}
             },

      messages: {

        userId: { required: 'User ID is Required', maxlength: 'ID should not be more that 8 Characters'},
        passcode: 'Password is Required',
        conf_passcode: {equalTo: 'Password Do Not Match'},
        user_name: 'Full Name Required',
        user_email: {required: 'Email is Required', email: 'Enter a Valid Email'},
        user_phone: 'Phone Number Required',
        sel_role: 'Select  Role',
        merchantId: 'Select Merchant Name'

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

    if($('#admin_user_form').valid() == true)
    {
    $('#admin_result_div').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...')
    
    var formdata = $('#admin_user_form').serialize();
    
    $.ajax({
        type: 'POST',
        url: '../production/ajax_calls/ajax_admin_users_data_form',
        data: formdata,
        dataType: 'html',
        cache: 'false',
        success: function(data)
        {         
          $('#admin_result_div').html(data);
          
        },
        error: function()
        {
          alert('Error: Account Creation Operation Failed.');
        }     
          });
   }
    

});


</script>

</body></html>