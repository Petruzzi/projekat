<?php
        
		include_once 'includes/User.php'; 
		include_once 'includes/Photo.php';
		
		$id=(isset($_GET['id'])) ? (int) $_GET['id']:'';
		$user=new User();
		$photo=new Photo();
		$img="";
		$tmp="";
		
		
		$getFromMapById=$user->getFromMapById($id);
		$user->ulogovan();
		$uemail=$user->user_email();
		$photoNum=$_GET['photoNum'];//ovo odreduje da li ce se menjati slika 1 ili slika 2 u bazi
	 	
	if(isset($_FILES['image']))
		{
			$img = $_FILES['image']['name'];
			$tmp = $_FILES['image']['tmp_name'];
			$photo->ubaci($id,$img,$tmp,$photoNum);	
			$msg = 'Slika uspesno dodata';
			header("Refresh:0; url=/profile.php?submit_msg=$msg");
			exit;
		} 
	
		
	 include_once 'template/header.php';
 ?>

 
 

 
 <!---->
<div class="row ">
     
    <div class="col-xs-12 col-sm-6 col-lg-4 col-sm-offset-3 col-lg-offset-4" >
        <form name="editForm" method="post" action="edit.php?id=<?php echo $id?>&photoNum=<?php echo $photoNum; ?>" enctype="multipart/form-data">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                		<h3 class="panel-title">Izaberite novu fotografiju</h3>
                	</div>
                	<div class="panel-body">
                		<form role="form">
                    		<div class="form-group">
                    			<input id="uploadImage" type="file" accept="image/*" name="image" class='form-control input-sm' />
                    		</div>
                    
                    		<div class="row">
                    		    <div class='col-xs-6 col-sm-6 col-lg-6'>
                    		        <a href='/profile.php' class='btn btn-danger btn-block'>Nazad</a>
                    		    </div>
                    		    <div class='col-xs-6 col-sm-6 col-lg-6'>
                    		        <input id="button" type="submit" value="Potvrdi" class='btn btn-success btn-block'>
                    		    </div>
                    		</div>

                		</form>
                	</div>
                </div>
         	
    	</form>
    </div>          
         
      <!-- -->      
 </div>           
