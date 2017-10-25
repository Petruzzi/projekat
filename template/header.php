<?php ob_start(); ?> 
<!DOCTYPE html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
     
	<meta charset="UTF-8">
    <title>Google Maps: Report Ecocide</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEZ5RlhXnEkXC3G34ZTb_lOVjVOXQuFkA"
            type="text/javascript"></script>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"> </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<script type="text/javascript">
//Check if browser supports W3C Geolocation API
// if (navigator.geolocation) {
  // navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
  // } else {
  // alert('Geolocation is required for this page, but your browser doesn&apos;t support it. Try it with a browser that does, such as Opera 10.60.');
// }

// function successFunction(position) {
  // var lat = position.coords.latitude;
  // var lng = position.coords.longitude;
 
  // console.log('Your latitude is '+lat+' and longitude is '+lng);
// }

// function errorFunction(position) {
  // alert('Error!');
// }
</script>
<!-- custom css -->
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-inverse">
	<div class='container-fluid'>
	<!-- LOGO -->
		<div class="panel-heading">
			<div class='navbar-header'>
				<button type='button' class="navbar-toggle" data-toggle='collapse' data-target='#navBar'>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>

				</button>
				<a href="" class='navbar-brand'>LOGO</a>
			</div>

			<!-- MENU-->
			<div class='collapse navbar-collapse' id='navBar'>
				<ul class='nav navbar-nav '>
				    
				    <?php if(isset($uemail)){ ?>
                            <li ><a href="/profile">Pocetna</a></li>
                    <?php }else{ ?>
                            <li><a href="/index">Pocetna</a></li>
                    <?php }?>
				     
				    
				   
				    
				    
				    
		  
		  
		  
			   	  
			   	  
				<!-- REG/LOG-->
				
			        <?php if(isset($uemail)){?>
						    <li ><a href="/logout">Logout</a></li>
			        <?php }else{?>
						    <li><a href="/logreg">Login/Registration</a></li>
					<?php }?>
				</ul>
								<ul class='nav navbar-nav pull-right'>
				    <?php
                        if(isset($uemail)){?>
                            <li class='pull-right'><a>Ulogovan korisnik: <strong><?php echo $uemail ?></strong></a></li>  
                    <?php }?>
				
				   </ul> 
				
			</div>
		</div>
	</div>
</nav>