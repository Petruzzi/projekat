<?php 		
 
ob_start();
include_once 'includes/User.php'; 

	 
			$first_name=(isset($_POST['first_name'])) ? $_POST['first_name'] : '';
			$last_name=(isset($_POST['last_name'])) ? $_POST['last_name'] : '';
			$email=(isset($_POST['email'])) ? $_POST['email']:'';	 
			$password=(isset($_POST['password'])) ? $_POST['password'] :'';
			$password_confirmation=(isset($_POST['password_confirmation'])) ? $_POST['password_confirmation'] :'';
			
	
			$user=new User();
		    
            
			if(isset($_POST["submitRegister"])){
				if($password!=$password_confirmation){
					$msg = 'Lozinke se ne poklapaju';
				header ("Location:/logreg.php?submit_msg=$msg");
				exit;
				}
			try{
				$user->register($first_name,$last_name,$email,$password);
			// Database/table insert or update
		// if everything went correctly
				$msg = 'Registracija uspešna';
				//$msg="$first_name,$last_name,$email,$password";
				header ("Location:/logreg.php?submit_msg=$msg");
			//	exit;
				}
			catch(PDOException $e){
					echo $e->getMessage();
				}
			}
			
			if(isset($_POST["submitLogin"])){
			try{
				$user->login($email,$password);
				// Database/table insert or update
				// if everything went correctly
				$msg = 'Ulogovan si';
				header ("http://petarsocogr.x3.rs/profile?submit_msg=$msg");
				exit;
				}
			catch(PDOException $e){
				echo $e->getMessage();
				}
			}
 
			if (isset($_GET['submit_msg']))
			{
				echo "<p id='msg' align=center>";
				echo $_GET['submit_msg'];
				echo "</p>";
			}
 
	?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-31j">

	<title></title>


<!-- header -->
<?php require_once('template/header.php');?>

<div class="container">
<div class="row">
 
 <div class="col-sm-6">

<!-- registration -->
 <div class="row ">
	<form method="post" action="">
 
        <div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Registrujte se da biste prijavili nelegalnu deponiju &nbsp&nbsp&nbsp&nbsp<small>Besplatno!</small></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="Ime">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Prezime">
			    					</div>
			    				</div>
			    			</div>

			    			<div class="form-group">
			    				<input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email">
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password" id="password" class="form-control input-sm" placeholder="Lozinka">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password_confirmation" 
										id="password_confirmation" class="form-control input-sm" placeholder="Potvrdi lozinku">
			    					</div>
			    				</div>
			    			</div>
			    			
			    			<input type="submit" value="Registracija" name="submitRegister" class="btn btn-info btn-block">
			    		
			    		</form>
			    	</div>
	    		</div>
    		</div>
			</form><!--./ registration -->
    	</div>
 </div> 
<div class="col-sm-6">
<!-- login -->
 <div class="row ">
 <form method="post" action="">
        <div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Imaš profil ? <small>Uloguj se !</small></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form">
			    		 

			    			<div class="form-group">
			    				<input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-12 col-sm-12 col-md-12">
			    					<div class="form-group">
			    						<input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
			    					</div>
			    				</div>
			    			 
			    			</div>
			    			
			    			<input type="submit" value="Login" name="submitLogin" class="btn btn-info btn-block"></br>
			    		    <a href="passwordChange.php">Zaboravio si lozinku?</a>
			    		</form>
			    	</div>
	    		</div>
    		</div>
			</form>
			</div>
    	</div><!--./ login -->
</div>
</div>

</div>



 <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>	
 <script src='assets/js/script.js'></script>
</body>
 
</html>