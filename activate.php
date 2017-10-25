<?php 
ob_start();
 include_once 'includes/User.php'; 
$activationcode=$_GET['code'] ? $_GET['code'] : '';

echo "<br>";
 
$email=(isset($_GET['email'])) ? $_GET['email'] : '';



$user=new User();

$a=$user->activate($activationcode);

 if($a==true){
	 echo "Uspesno aktiviran profil";

 }