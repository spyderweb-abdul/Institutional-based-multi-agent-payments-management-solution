<?php
$mdHash = hash('sha512', $_SESSION['userID']);
echo '

<ul class="nav nav-sidebar list-unstyled" style="float:left">
          	
            <li><a href="reportArena.php?ref='.$mdHash.'">Change Password</a></li>';
            
			
			$adm = $paydb->query("SELECT accessLevel FROM ".TBL_ADMIN." WHERE userID = '$_SESSION[userID]'");
			$acc = mysqli_fetch_assoc($adm);
			
			if($acc['accessLevel'] == 1)
			{
            echo '<li class="nav-divider"></li>
			      <li><a href="createUsers.php?ref='.$mdHash.'">Create Users</a></li>
				  <li class="nav-divider"></li>
                  <li><a href="checkPayments.php?ref='.$mdHash.'">Check Payments</a></li>
                  <li class="nav-divider"></li>
                  <li><a href="paymentReports.php?ref='.$mdHash.'">Payment Reports</a></li>
			      <li class="nav-divider"></li>
                  <li><a href="ugpaymentReports.php?ref='.$mdHash.'">UG Payment Reports</a></li>
                  <li class="nav-divider"></li>
			      <li><a href="pgpaymentReports.php?ref='.$mdHash.'">PG Payment Reports</a></li>
			      <li class="nav-divider"></li>
                  <li><a href="verifyPayment.php?ref='.$mdHash.'">Verify Payment</a></li>
				  <li class="nav-divider"></li>
                  <li><a href="createFees.php">Create Fees</a></li>';
				  
			}
			elseif ($acc['accessLevel'] == 2){
			
             echo '<li class="nav-divider"></li>
            <li><a href="checkPayments.php?ref='.$mdHash.'">Check Payments</a></li>
            <li class="nav-divider"></li>
            <li><a href="paymentReports.php?ref='.$mdHash.'">Payment Reports</a></li>
			 <li class="nav-divider"></li>
            <li><a href="ugpaymentReports.php?ref='.$mdHash.'">UG Payment Reports</a></li>
            <li class="nav-divider"></li>
			<li><a href="pgpaymentReports.php?ref='.$mdHash.'">PG Payment Reports</a></li>
			 <li class="nav-divider"></li>
            <li><a href="verifyPayment.php?ref='.$mdHash.'">Verify Payment</a></li>
			<li class="nav-divider"></li>
            <li><a href="createFees.php">Create Fees</a></li>';
			}
			else
			{
	          echo '<li class="nav-divider"></li>
            <li><a href="verifyPayment.php?ref='.$mdHash.'">Verify Payment</a></li>';
				
			}
         echo '</ul>';
?>