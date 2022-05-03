<?php
echo '<div class="container main-container">

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
      // Indicators -->
   echo'<ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        

        

      </ol>';//<!-- Indicator ends -->

      // Wrapper for slides -->
      echo' <div class="carousel-inner" role="listbox">';

        // First slide -->
       echo '<div class="item active">

             <span class="seven-content"> <img src="images/avatar.png" /> <h5>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod."</h5>

             <p> <b> Remi Balogun (Proprietor, Providence Academy) </b></p>
           </span>
         
            </div>'; //<!-- Item -->


            echo '<div class="item">

             <span class="seven-content"> <img src="images/avatar.png" /> <h5>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum eget felis eu rhoncus. Donec elit massa, malesuada et orci eget, posuere malesuada erat. Donec laoreet laoreet euismod."</h5>

             <p> <b> Lawal Hassan (DG, Inland Revenue Service) </b></p>
           </span>
            </div>'; //<!-- Item -->
      
	  echo '</div>'; //<!-- /.carousel-inner -->

     // <!-- Controls -->
      echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="sr-only">Previous</span>
            </a>
			
           <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
           <span class="sr-only">Next</span>
           </a>
	  
    </div>'; //<!-- /.carousel -->

echo '</div>'; //<!-- /.container -->