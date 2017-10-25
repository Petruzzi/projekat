<?php 
ob_start();
		if (isset($_GET['submit_msg'])){
			echo "<p id='msg' align=center>";
			echo $_GET['submit_msg'];
			echo "</p>";
		}
include_once ('includes/User.php');
include_once ('template/header.php');

$user=new User();
$a=$user->passwordChange();
?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel with-nav-tabs panel-default">
			<div class="panel-heading">
				<ul class="nav nav-tabs">
					<li id='btnStep1' class='active' >
						<a href="#step1" data-toggle='tab' class='btn disabled' >Korak 1</a>
					</li>
					<li id='btnStep2' >
						<a href="#step2" data-toggle='tab' class='btn disabled'>Korak 2</a>
					</li >
					<li id='btnStep3' >
						<a href="#step3" data-toggle='tab' class='btn disabled' >Korak 3</a>
					</li>
				</ul>
			</div>

			<div class="panel-body">
				<div class="tab-content">
				<!-- STEP 1 -->
					<div class="tab-pane fade in active col-xs-12 col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-4" id="step1">
						<h4>U polje unesite vasu email adresu:</h4>
						 <div class='row'>
						    <form method="POST">
    						    <div class='col-xs-7 col-sm-6 col-lg-5 '>
    							    <input type="email" name="email" id="email" placeholder="Upisite email" class="form-control">
    							</div>
    							<div class='col-xs-5 col-sm-4 col-lg-3'>
    							    <input type="submit" name="submit1" id="submit1" value="Dalje" class="btn btn-primary btn-block">
    						    </div>
						    </form>
						</div>
						<h4>Na email ce vem biti poslat kod za promenu lozinke.</h4>
					</div>
				<!-- STEP 2 -->		
					<div class="tab-pane fade col-xs-12 col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-4" id="step2">
						<h4>Kod koji smo vam poslali na vas email upisite u polje:</h4>
						<div class='row'>
    						<form method="POST">
        						<div class='col-xs-7 col-sm-6 col-lg-5 '>
        							<input type="text" name="code" id="code" placeholder="Upisite kod" class="form-control">
        						</div>	
        						<div class='col-xs-5 col-sm-4 col-lg-3'>	
        							<input type="submit" name="submit2" id="submit2" value="Dalje" class="btn btn-primary btn-block">
                                 </div>
    						</form>
    					</div>	
					</div>
				<!-- STEP 3 -->
					<div class="tab-pane fade col-xs-12 col-sm-12 col-lg-12 col-xs-offset-2 col-sm-offset-1 col-lg-offset-2" id="step3">
						<h4>Ovde upisite vasu novu lozinku</h4>
						<div class='row'>
    						<form method="POST">
    						    <div class='col-xs-8 col-sm-4 col-lg-3 ' >
        							<input type="password" name="password" id="password" placeholder="Upisite lozinku" class="form-control">
        						</div>	
        						<div class='col-xs-8 col-sm-4 col-lg-3 '>	
        							<input type="password" name="password1" id="password1" placeholder="Ponovo upisite lozinku" class="form-control">
        						</div>		
        						<div class='col-xs-8 col-sm-2 col-lg-2 '>	
        							<input type="submit" name="submit3" name="submit3" value="Potvrdi" class="btn btn-success btn-block">
                                </div>	
    						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
















