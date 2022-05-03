<?php
session_start();
   $msg = "User ".$_SESSION['userID']." has logged out";
   unset($_SESSION['userID']);
   session_destroy();
   header("Location: ../index.php?msg=$msg");

?>
