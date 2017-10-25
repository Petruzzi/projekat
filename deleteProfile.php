<?php
    ob_start();
    include_once 'includes/User.php';
   
	
    $password=(isset($_POST['password'])) ? $_POST['password'] :'';
    $user=new User();
	$user->ulogovan();
	$uemail=$user->user_email();
	echo $password;
	
//	
//	$msg = 'Profil uspesno izbrisan'; 		
	//header ("Location:index.php?submit_msg=$msg");
	//exit;
	if(isset($_POST["deleteProfileConfirmation"])){
	
		    
		    $user->deleteProfile($uemail,$password);
		    
		    
		
		
	}

 
 
	if (isset($_GET['submit_msg'])){
		echo "<p id='msg' align=center>";
		echo $_GET['submit_msg'];
		echo "</p>";
	}
	
	
	
    include_once 'template/header.php';
?>


<div class=" col-sm-6 col-sm-offset-3">
<!-- login -->
     <div class="row ">
        <form method="post" action="">
            <div class="col-xs-12 col-sm-12 col-md-12">
            	<div class="panel panel-default">
            		<div class="panel-heading">
    			    	<h3 class="panel-title">Upisite vasu lozinku kako biste potvrdili brisanje profila</h3>
    			 	</div>
		 			<div class="panel-body">
		    		    <form role="form">
    			        	<div class="col-xs-12 col-sm-12 col-md-12">
    				        	<div class="form-group">
    				        		<input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
    				        	</div>
    			        	</div>
	    			        <div class="col-xs-12 col-sm-12 col-md-12">
	    			            <input type="submit" value="Potvrdi" name="deleteProfileConfirmation" class="btn btn-success btn-block"></br>
    	    		        </div>
	    		        </form>
			    	</div>
	    		</div>
    		</div>
		</form>
	</div>
</div><!--./ login -->
