<?php

session_start();
include_once 'includes/User.php';
$user=new User();
if($user->logout())
{
  
 $msg = 'Logged out';
header("Location:http://localhost/gmap-projekat?submit_msg=$msg");
}