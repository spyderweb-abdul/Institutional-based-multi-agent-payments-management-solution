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
                    <h4><i class="fa fa-wrench"> </i> Users Setup - <small>General Users</small></h4>
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
                                       
                        <ul class="nav nav-pills" id="myTab">
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-bars"></i> CUSTOM (SINGLE) UPLOAD </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-bars"></i> BATCH (MULTIPLE) UPLOAD </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                          <div id="menu" class="tab-pane fade in active" role="tabpanel">

                                <br/>

                                <p id="general_result_div" style="color:#FFF"> </p><br/>

                                <form class="form-horizontal form-label-left input_mask" name="general_user_form" id="general_user_form">
                                                                
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
                                    <input type="text" class="form-control has-feedback-left" placeholder="Email" name="user_email" id="user_email">
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                                
                                  <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left"  placeholder="Phone" name="user_phone" id="user_phone">
                                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                                 </div>
                                  

                                <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                <select name="sel_role" id="sel_role" class="form-control has-feedback-left">
                                <option value="6"> users </option>
                                </select>
                                <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                </div>
                                

                                  
                                 <div class="ln_solid"></div>
                                                                 
                                </form>

                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button class="btn btn-primary" type="reset" id="btn_general_user_reset" ><i class="fa fa-times"></i> Reset</button>
                                      <button type="button" class="btn btn-success" id="btn_save_general_user"><i class="fa fa-save"></i> Create User</button>
                                    </div>
                                  </div>

                         </div>

                    

                    <!-- 2nd TAB PILLS -->
                    <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                    <br/>

                    <p id="general_result_div2"> </p><br/>

                    <form class="form-horizontal form-label-left input_mask" name="batch_user_form" id="batch_user_form" enctype="multipart/form-data">
                        <div class="row">

                          <div class="panel panel-default">
                             <div class="panel-heading"> Upload Users File (CSV Format Only - .csv):  </div>                           
                               <div class="panel-body"> 
                                
                                <div class="input-group col-md-7 col-sm-7 col-xs-12">
                                  <span class="input-group-addon"> <i class="fa fa-file-o"></i> </span>
                                  <input type="file" class="form-control" name="batch_user_upload" id="batch_user_upload" style="min-height: 50px;"  />
                                  <span class="input-group-btn">
                                  <input type="button" class="btn btn-primary" name="btn_batch_upload" id="btn_batch_upload" value="Upload Now" style="min-height: 50px;" /></span>                                                             
                                </div>

                              </div>
                          </div>

                        </div>
                    </form>
                    
                    <div class="clearfix"></div><br/>

                    <h5> <strong> THINGS TO NOTE BEFORE FILE UPLOAD: </strong> </h5>
                       
                      <i class="fa fa-angle-double-right"></i> Prepare file in CSV format <br/>
                      <i class="fa fa-angle-double-right"></i> Format the entire sheet to <strong> TEXT </strong> before keying-in your data <br/>
                      <i class="fa fa-angle-double-right"></i> No special characters  <br/>
                      <i class="fa fa-angle-double-right"></i> No cell must be left unpopulated <br/>
                      <i class="fa fa-angle-double-right"></i> No headers i.e Delete file headers when you have finished keyingg-in your data.<br/><br/>

                    <p style="color:red"> <i class="fa fa-file-excel-o"> </i> CSV File should be in the format as displayed below: </p> 

                    <table width='70%' class="table table-condensed table-striped table-bordered table-responsive table-hover">
                      
                      <tr>
                      <th>User ID </th>
                      <th> Full Name </th>
                      <th> User Email </th>
                      <th> User Phone No. </th>                      
                      </tr>

                      <tr>
                      <td> 1222012344 </td>
                      <td> JOHN DOE SMART </td>
                      <td> joh.smart@you.me </td>
                      <td> 01245789566 </td>                      
                      </tr>

                      <tr>
                      <td> 0404020234 </td>
                      <td> ALAN SMITH </td>
                      <td> alan.smith@you.me </td>
                      <td> 058749563253 </td>                      
                      </tr>

                      <tr>
                      <td> 012345677 </td>
                      <td> JAMAL JEROME JACK </td>
                      <td> jerome.j@you.me </td>
                      <td> 0658975466 </td>                      
                      </tr>

                    </table>

                    <p style="color:red"> <i class="fa fa-2x fa-warning"> </i> NOTE: Headers must be removed before file upload. </p> 

                         <div class="ln_solid"></div>

                    </div>
                
             </div><!--Tab Content-->

         </div><!-- X-content -->

      
      </div>
    </div>
  </div>

<script type="text/javascript">
  
  $(document).on('click', '#btn_general_user_reset', function(){

  $('#general_user_form')[0].reset();

});



$(document).on('click', '#btn_save_general_user', function(e){

  e.preventDefault();

    $('#general_user_form').validate({

      rules: {
        userId:{ required: true},
        user_name: 'required',
        user_email: { required: true, email: true},
        user_phone: 'required',
        sel_role: {required: true}
             },
      messages: {

        userId: { required: 'User ID is Required', maxlength: 'ID should not be more that 8 Characters'},
              user_name: 'Full Name Required',
        user_email: {required: 'Email is Required', email: 'Enter a Valid Email'},
        user_phone: 'Phone Number Required',
        sel_role: 'Select  Role'

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

    if($('#general_user_form').valid() == true)
    {
    $('#general_result_div').html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...')
    
    var formdata = $('#general_user_form').serialize();
    
    $.ajax({
        type: 'POST',
        url: '../production/ajax_calls/ajax_general_users_data_form',
        data: formdata,
        dataType: 'html',
        cache: 'false',
        success: function(data)
        {         
          $('#general_result_div').html(data);
          
        },
        error: function()
        {
          alert('Error: Login Operation Failed.');
        }     
          });
   }
    

});


$(document).on('click', '#btn_batch_upload', function(e){

           e.preventDefault();
     
     if($("#batch_user_upload").val() == ''){ alert('You have not selected any file'); }
     else
     {    
     
     var formdata = new FormData($("#batch_user_form"));
     formdata.append('batch_user_upload', $('#batch_user_upload')[0].files[0]);
     
       $("#general_result_div2").html('<i class="fa fa-spin fa-2x fa-spinner fa-fw"></i> Processing...');
        
    $.ajax({
            type: 'POST',
        url: '../production/ajax_calls/ajax_batch_users_data_form',
        data: formdata,
                    mimeType: 'multipart/form-data',
                    contentType: false,
                    cache: false,
                    processData: false,
              success: function(msg)
          {
            $("#general_result_div2").empty();
            $("#general_result_div2").html(msg);    
          },
          error: function()
          {
            alert("failure");
          }
          });
   }
 });
</script>
        
</body></html>