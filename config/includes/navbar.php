<?php

//<!--   Navbar Starts Here -->
echo '<nav class="navbar navbar-default navbar-inner navbar-fixed-top">';
   
   //<!-- Brand and toggle get grouped for better mobile display -->
   
   echo '<div class="container-fluid"> 
           
          <div class="navbar-header">
		 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
		 </button>
		  
          <a class="navbar-brand" href="index"><span class="navbar-logo"><img src="images/paytonify-logo.png" /> Paytonify</span><span class="navbar-logo-alt">.ng</span> </a>    
	        </div>
	
	       <div class="navbar-collapse collapse" aria-expanded="false" id="myNavbar">
           
           <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-toggle="modal" data-target="#modal-verify"> Verify Payment </a> </li>
            <li><a href="#" data-toggle="modal" data-target="#modal-reprocess"> Reprocess Payment </a> </li>
            <li><a href="#"> User Guide </a> </li>
            <li><a href="#" data-toggle="modal" data-target="#modal-login"> Login </a> </li>';
		    
            /*<li class="dropdown">
			
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-sign-in"> </i> Login <span class="caret"></span></a>
			 <ul class="dropdown-menu">
			   <li>
					
					<form name="login" id="login" method="get" action="">
			          
			            <div class="form-group has-feedback">
			               <input name="userID" type="text" autofocus required="required" class="form-control" id="userID" placeholder="Username" title="USER ID" data-toggle="tooltip" data-placement="bottom" />
			                <i class="glyphicon glyphicon-user form-control-feedback"> </i>
			            </div>
			 		              
			              <div class="form-group has-feedback">
			                <input name="passCode" type="password" required="required" class="form-control styleTb" id="passCode" placeholder="Password" title="PASSWORD"  data-toggle="tooltip" data-placement="bottom" />
			                <i class="glyphicon glyphicon-lock form-control-feedback"> </i>
			              </div>
			            
			              <button type="button" name="btn-login" id="btn-login" class="btn btn-success" ><i class="glyphicon glyphicon-unlock"> </i> Login </button>
		         
		          </form>
		          <br/>
		          <p style="text-align:center;"><a href=""> Forgot Password? </a> </p>
			    </li>
			</ul>
			</li>*/
			
			echo '<li><a href="user-signup"> <i class="fa fa-user"> </i> Sign Up </a> </li>
			</ul>
			
          </div>
		  
		  </div>';
	  
	  //<!--.navbar-collapse -->
	  
	   //<!--container-fluid -->
   echo '</nav>';
	
	?>
