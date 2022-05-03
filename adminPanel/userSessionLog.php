<?php
			
 echo '<div class="btn-group btn-group-sm btn">';
 echo '<button class="btn btn-default"> You are logged on as: '.$_SESSION['userID'].'</button>';
 echo '<a href="logoutAdminNow.php" class="btn btn-default"> Logout </a>'; 
// echo '<button class="btn btn-success btn-sm styleTb2"> Active </button>';
 echo '</div>';

?>