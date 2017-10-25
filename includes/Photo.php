<?php

include_once 'connection.php';

class Photo{
	
	private $connection;
	
	public function __construct(){
		$this->connection=new Connection();
		$this->connection=$this->connection->getDb();
	}
	
	public function ubaci($id,$img,$tmp,$photoNum){
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions	

		 // get uploaded file's extension
		 $ext =strtolower(pathinfo($img, PATHINFO_EXTENSION));
		
		 // can upload same image using rand function
		 $final_image = rand(1000,1000000).$img;
		 	 
		 // check's valid format
		 if(in_array($ext, $valid_extensions)) 
		 {     
		 	$path =strtolower($final_image); 
		 	$path='assets/img/'.$path;
		  
				

			$sql="UPDATE markers SET image_path".$photoNum."=:image_path WHERE id=:id";
			 



			try{
				$stmt=$this->connection->prepare($sql);
				$stmt->bindParam(':id',$id,PDO::PARAM_INT);
				$stmt->bindParam(':image_path',$path,PDO::PARAM_STR);	
				$ok=$stmt->execute();
				  
				if($ok){
					move_uploaded_file($tmp,$path);
						
				}else{
					echo "Not uploaded";
				}
							
			}
			catch(PDOException $e) { 
				echo $e->getMessage(); 
			}
		 } 
		 else 
		 {
		  echo 'invalid file';
		 }
		  
	}
	
	public function insertPhoto($id,$userEmail,$img,$tmp){
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
		$myPathInfo = pathinfo($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']);
		$currentDir = $myPathInfo['dirname'];
		$imgDir = $currentDir . '/assets/img/';
		$path = $imgDir; // upload directory

		
		 // get uploaded file's extension
		 $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		 
		 // can upload same image using rand function
		 $final_image = rand(1000,1000000).$img;
		 
		 // check's valid format
		 if(in_array($ext, $valid_extensions)) 
		 {     
		  $path = $path.strtolower($final_image); 
		   
		  // if(move_uploaded_file($tmp,$path)) 
		    //{
			  $sql="UPDATE markers SET image=:image WHERE id=:id AND user_email=:user_email";
			   
			  try{
				  $stmt=$this->connection->prepare($sql);
				  $stmt->bindParam(':image',$path,PDO::PARAM_STR);
				  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
				  $stmt->bindParam(':user_email',$userEmail,PDO::PARAM_STR);
				  $ok=$stmt->execute();
				  
				  if($ok){
					  move_uploaded_file($tmp,$path);
				  }else{
					  echo "Not uploaded";
				  }
			  }
			  catch(PDOException $e)
			  { echo $e->getMessage(); 
			  }
		   echo "Success";
		  //}
		 } 
		 else 
		 {
		  echo 'invalid file';
		 }
		 
	}



	public function deletePhoto($id,$photoNum){
		
		
		$sql="UPDATE markers SET image_path".$photoNum."=NULL WHERE id=:id";
		try{
				$stmt=$this->connection->prepare($sql);
				$stmt->bindParam(':id',$id,PDO::PARAM_INT);	
				$stmt->execute();
				$msg='Slika uspesno izbrisana'; 
				header("Refresh:0; url=/profile.php?submit_msg=$msg");	
			    exit;
		}
		catch(PDOException $e) { 
			echo $e->getMessage(); 
		}

	}
}
?>