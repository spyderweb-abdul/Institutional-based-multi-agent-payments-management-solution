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
 <body>
                 <!-- Modal Header -->
                 <div class="modal-header">
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Fee Structure:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editFeeStructureCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['progId']))
                          {

                              $progId = $_GET['progId'];
                              $nationality = $_GET['natId'];
                              $level = $_GET['levId'];

                              if($nationality == 'Local'){$nationality = 1;} else {$nationality = 2;}
                               
                               //Push those variables into session. There will be need for them if an Item is to be deleted
                                  $_SESSION['progid'] = $progId;
                                  $_SESSION['natid'] = $nationality;
                                  $_SESSION['levid'] = $level;
                          
                          $sel_fees = $paydb->query("SELECT * FROM ".TBL_FEE_STRUCTURE." a INNER JOIN ".FEE_ITEMS." b ON a.feeID = b.feeID INNER JOIN ".PROGRAMME." c ON c.progId = a.progId WHERE a.progId = '$progId' AND a.nationality = '$nationality' AND a.level = '$level' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));  

                                  $res = $sel_fees->fetch_array();

                                     $programme = $res['programme'];
                                     $lv = $res['level'];
                                     $nat = $res['nationality'];

                                     $facId = $res['facId'];
                                     $deptId = $res['deptId'];
                                     $cat = $res['category'];

                                  //Push the values into a SESSION
                                   $_SESSION['facid'] = $facId;
                                   $_SESSION['deptid'] = $deptId;
                                   $_SESSION['catid'] = $cat;

                                   if($nat == 1){ $nat = 'Local'; } else { $nat = 'Foreign'; } 
                                   if($lv == 1 ) { $lv = 'Fresh'; } elseif ($lv == 2) { $lv = 'Returning'; }                         

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ feeScheduleUpdate }} </div><br/>

                              <?php echo '<div style="color:#999; text-align:center; font-weight:bold;">'.$programme.' <i class="fa fa-angle-double-right"></i> '.$lv.' <i class="fa fa-angle-double-right"></i> '.$nat. '</div><br/>'; ?>

                              <table width="60%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped">
                               
                               <tr>
                                 <th> </th>
                                 <th> Fee Items </th>
                                 <th> Amount </th>
                                 <th> Delete </th>
                               </tr>

                                   
                               <tr ng-repeat="x in feesBreakdown">
                                  <td> <i class="fa fa-angle-double-right pull-right"> </i></td>
                                  <td> {{ x.feeItem }} </td>
                                  <td> {{ x.amount }} </td>
                                  <td><a href="#" ng-click="delItem(x.feeID)"> <i class="fa fa-trash"> </i> </a> </td>
                              </tr>
                         
                              <tr>
                                <td colspan="4" ng-repeat="i in tot" style="color:red; font-weight:bold; font-size:13px;" > Total Amount: {{ i.totalSum }} </td>
                              </tr>

                               <tr>
                                  <td colspan="4"> <a href="#" onclick="openMe()"> ADD NEW ITEM <i class="fa fa-angle-double-down"> </i> </a><br/>
                                      
                                    <div style="display:none; margin: 5px;" id="openDiv" >
                                            
                                      <form name="addNew" id="addNew" >
                                        <div class="input-group">
                                          <span class="input-group-addon"> <i class="fa fa-chevron-down"></i></span> 
                                            <select name="feeID" ng-model="feeID" class="form-control" required ng-required="true">
                                               
                                               <option value=""> - Choose Item - </option>
                                               <option  ng-repeat="x in feeDrop" ng-value="{{ x.feeID }}"> {{ x.feeItem }} - {{ x.amount }} </option>                                                 
                                             </select>                                            
                                          <span class="input-group-btn"> 
                                                  <button name="btn-add" class="btn btn-success" ng-disabled="addNew.$invalid" ng-click="saveAdd(addNew.$valid)" > ADD NOW </button> 
                                          </span> 

                                        </div>
                                      </form>  
                                      
                                   </div>
                                      
                                  </td>
                                </tr>
                             </table>                          
                        
                            
                           <?php } else {echo 'Process Not Properly Defined'; } ?>

                        </div>

                           <!-- Modal Footer -->
                         <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                          <!--<button type="button" class="btn btn-warning" ng-click="saveDeptEdit(editDeptForm.$valid)" > Save Edit </button>-->
                        </div>
                   <!-- -->

        </div>

</body></html>