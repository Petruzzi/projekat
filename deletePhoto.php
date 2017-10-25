<?php 
		include_once 'includes/User.php'; 
		include_once 'includes/Photo.php';
		$id=(isset($_GET['id'])) ? (int) $_GET['id']:'';
		$user=new User();
		$photo=new Photo();
		$uemail=$user->user_email();
		$photoNum=$_GET['photoNum'];
		$photo->deletePhoto($id,$photoNum);
 ?>