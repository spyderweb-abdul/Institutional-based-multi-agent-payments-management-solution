<?php
 include_once('../../include/constant_connection.php');	 
					
					//Check if fees have been built for the programme before
					 $ver = $paydb->query("SELECT * FROM ".TBL_FEE_STRUCTURE." GROUP BY facName, deptName, prog, level, nationality");
					 
					 while($r = mysqli_fetch_array($ver))
			          {
						  $prog = $r['prog'];
						  $level = $r['level'];
						  $nationality = $r['nationality'];
						  
					$sel = $paydb->query("SELECT SUM(amount) FROM ".TBL_FEE_STRUCTURE." WHERE prog = '$prog' AND level = '$level' AND nationality = '$nationality'");
                    $f = mysqli_fetch_array($sel);
					
					  $amount = $f['SUM(amount)'];
					
		           $postFullFee = $paydb->query("INSERT INTO ".TBL_FULL_FEE_STRUCTURE." (prog, level, nationality, amount) values ('$prog', '$level', '$nationality', '$amount')");
									 
					  }
					     echo 'I have finished';


?>