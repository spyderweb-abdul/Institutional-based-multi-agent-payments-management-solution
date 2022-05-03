<?php

$sess_value = hash('sha256', $_SESSION['userId']);
       //menu profile quick info -->
           echo '<div class="profile clearfix">
		              <div class="profile_pic">';

		               $sel_pics = $paydb->query("SELECT pics, user_name FROM ".USERS." WHERE userId = '$_SESSION[userId]' AND merchantId = '$_SESSION[merchID]' ") or die(mysqli_error($paydb));

                   $folder = 'user_pics/';

                   $fetch_pics = $sel_pics->fetch_array();

                   $pics = $fetch_pics[0];
                   $name = $fetch_pics[1];

                   $path = $folder.$pics;

                   if($pics != NULL)
                   {
                     echo '<img src="'.$path.'" class="img-circle profile_img" width="65px" height="60px" />';
                   }
                   else
                   {
                     echo '<img src="../../images/avatar.png" class="img-circle profile_img" width="65px" height="60px" />';
                   }
		              
                echo '</div>
		              <div class="profile_info">
		                <span> &nbsp; </span>
		              </div>
		          </div><br />

              <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>'.$name.'</h3>';
           //menu profile quick info -->

              if($_SESSION['merchID'] == 0)//For Paytonify Admin
              {
           //Sidebar Menu
          echo '<ul class="nav side-menu">
                 <li><a href="ajax_main/ajax_home_page"><i class="fa fa-home"></i> Home </a>  
                  </li>

                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/admin_users_page" > Administrative Users </a></li>
                      <li><a href="ajax_main/edit_users_settings"> Edit Settings </a></li>                     
                    </ul>
                  </li>

                  <li><a><i class="fa fa-wrench"></i> Payments Setup <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_setup_page" > Merchant Setup </a></li>
                      <li><a href="ajax_main/merchant_payment_gateway_setup_page"> Payment Gateways </a></li>
                      <li><a href="ajax_main/edit_payment_settings"> Edit Settings </a></li>

                    </ul>
                  </li>

                                   
                </ul>
              </div>
              <div class="menu_section">
                <h3> Advanced </h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> General Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> General Report <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>

            </div>';

              }
          
              else
              {
            
          // sidebar menu -->
           echo '<ul class="nav side-menu">                
                  <li><a href="ajax_main/ajax_home_page"><i class="fa fa-home"></i> Home </a>  
                  </li>

                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/admin_users_page" > Administrative Users </a></li>
                      <li><a href="ajax_main/general_users_page"> General Users </a></li>
                      <li><a href="ajax_main/edit_users_settings"> Edit Settings </a></li>
                     
                    </ul>
                  </li>

                  <li><a><i class="fa fa-wrench"></i> Payments Setup <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_setup_page" > Merchant Setup </a></li>
                      <li><a href="ajax_main/merchant_payments_setup_page"> Merchant Payments Setup </a></li>
                     
                      <li><a href="ajax_main/edit_payment_settings"> Edit Settings </a></li>

                    </ul>
                  </li>

                  <li><a><i class="fa fa-folder-open"></i> Merchant Structure <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_create_structure_page" > Create Structure </a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-list"></i> Fees Setup <span class="fa fa-chevron-down"></span></a>
                    
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_single_fee_structure"> Build Single Fees </a></li>
                      <li><a href="ajax_main/merchant_bulk_fee_structure"> Build Bulk Fees</a></li>
                      <li><a href="ajax_main/merchant_fee_schedules"> Fees Schedules </a></li>
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-bar-chart-o"></i> Collection Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_payment_codes"> Payment Codes </a></li>
                      <li><a href="ajax_main/merchant_general_collection_report"> General Reports </a></li>
                      <li><a href="ajax_main/merchant_collection_breakdown_report"> Collections Breakdown </a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i> Verification <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="ajax_main/merchant_payment_verification">Payment Verification & Clearance </a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3> Advanced </h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> General Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> General Report <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>

            </div>';
           //sidebar menu -->

          }


             //menu footer buttons -->
            /*<div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>*/
            //menu footer buttons -->

?>