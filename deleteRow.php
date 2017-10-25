<?php
    include_once 'includes/User.php'; 
    $id=(isset($_GET['id'])) ? (int) $_GET['id']:'';
    $user=new User();
	$uemail=$user->user_email();
	$user->deleteRow($id);
	$tab=$_GET['tab'];
	$msg = 'Deponija uspesno izbrisana'; 		
	header ("Location:profile.php?submit_msg=$msg&tab=$tab");
	exit;
?>