<?php
    //call to function get_users_payment_stats

    list($users_num, $merchantId, $all_trans, $all_paid, $fetch_paid, $all_pending, $fetch_pending, $total_amount_paid, $setup_num, $setup_details) = get_users_payment_stats();

       if($all_trans != 0) //To handle division by zero
       {
          $percentage_paid = $all_paid/$all_trans * 100;
          $percentage_pending = $all_pending/$all_trans * 100;
       }
       else
       {
         $percentage_paid = 0;
         $percentage_pending = 0;
       }


    //To get the number of paid transaction for merchant


//page Top content -->
      echo '<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count golden">'.number_format($users_num).'</div>
             <span class="count_bottom"><i class="golden"><i class="fa fa-angle-double-right"></i> Merchant Users </i> </span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Total Transactions </span>
              <div class="count golden">'.number_format($all_trans).'</div>
             <span class="count_bottom"><i class="golden"><i class="fa fa-angle-double-right"></i> All Merchant Trans. </i> </span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-check"></i> Total Paid </span>
              <div class="count golden">'.number_format($all_paid).'</div>
             <span class="count_bottom"><i class="golden"><i class="fa fa-angle-double-right"></i>'.round($percentage_paid).'% </i> of all transactions </span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-minus"></i> Total Pending </span>
              <div class="count golden">'.number_format($all_pending).'</div>
           <span class="count_bottom"><i class="golden"><i class="fa fa-angle-double-right"></i>'.round($percentage_pending).'% </i> of all transactions </span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-tags"></i> Total Collections</span>
              <div class="count golden">'.number_format($total_amount_paid).'</div>
              <span class="count_bottom"><i class="golden"><i class="fa fa-angle-double-right"></i>'.round($percentage_paid).'%</i> of all transactions </span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-wrench"></i> Total Setups</span>
              <div class="count golden">'.number_format($setup_num).'</div>
              <span class="count_bottom"><i class="golden"><i class="fa fa-sort-asc"></i></i> All Payment Setups </span>';
            //top tiles -->

?>