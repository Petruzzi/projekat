<?php

include_once 'connection.php';


class User{
	
	private $connection;
	
	public function __construct(){
		$this->connection=new Connection();
		$this->connection=$this->connection->getDb();
	}
	
	
	 
	 public function logout(){
		  session_destroy();
		  $_SESSION['id'] = false;
		  $msg = 'Korisnik uspesno izlogovan';
		  header ("Location: index?submit_msg=$msg");
		  exit;
    }
	
	public function login($email,$password){
		if(empty($email) && empty($password)){
			$msg = 'Nisu popunjena sva polja za login'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			exit;
		}
		if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$msg = 'Email nije važeći'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		} 
		
		
		  
    		try{
    		$sql = "SELECT * FROM user WHERE email=:email";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row['status']!=='1'){
                    $msg = 'Profil nije aktiviran. Uputstvo za aktivaciju vam je poslato na email'; 		
        			header ("Location: logreg?submit_msg=$msg");
        			exit;
                    
                }
               
            
        	    if($row['email']==null){
        			$msg = 'Email ne postoji u bazi'; 		
        			header ("Location: logreg?submit_msg=$msg");
        			exit;
        		}
    		    if($row && (password_verify($password,$row['password']))){
        			if (session_status() == PHP_SESSION_NONE) {
        				session_start();
        				$_SESSION['id'] = $row['id'];
        				$_SESSION['email'] = $row['email'];
        			 header( "Location:/profile.php" );
        			}
                } else {
    				$msg = 'Neispravni login podaci'; 		
    				header ("Location: logreg.php?submit_msg=$msg");
    				exit;
                }
    	        if($row['suspend']==='1'){
                    $msg = 'Vas nalog je suspendovan'; 		
        			header ("Location: logreg?submit_msg=$msg");
        			exit;
                }
        		}catch(PDOException $e){
        			echo $e->getMessage();
        		}
		
		
		
    }
	
	
	public function register($first_name,$last_name,$email,$password){
		if(empty($first_name) || empty($last_name) || empty($email) || empty($password)){
			$msg = 'Nisu popunjena sva polja za registraciju'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		}
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $first_name)){
			$msg = 'Ime  ne može imati specijalne karaktere'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		}
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $last_name)){
			$msg = 'Prezime  ne može imati specijalne karaktere'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		}
		if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$msg = 'Email nije važeći'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		} 
		if(strlen($password)<3){
			$msg = 'Lozinka je suviše kratka'; 		
			header ("Location: logreg.php?submit_msg=$msg");
			break;
		}
		try{
			$activated="SELECT email FROM user WHERE email=:email";
			$stmt1=$this->connection->prepare($activated);
			$stmt1->bindParam(":email",$email,PDO::PARAM_STR);			
			$stmt1->execute();
			$result=$stmt1->fetch(PDO::FETCH_ASSOC);
			 if($result>0){
				 $msg="Email vec postoji u bazi";
				 header( "refresh:3;url=http://petarsocogr.x3.rs/logreg.php?submit_msg=$msg" );
				 exit;
			 }
			$verificationCode = md5($email.time());
			$sql="INSERT INTO user (firstname,lastname,email,password,activationcode)
			 VALUES (:first_name,:last_name,:email,:password,:activationcode)";
			 $enc_pass = password_hash ( $password , PASSWORD_DEFAULT ) ;
			 $stmt=$this->connection->prepare($sql);
			 $stmt->bindParam(":first_name",$first_name,PDO::PARAM_STR);
			 $stmt->bindParam(":last_name",$last_name,PDO::PARAM_STR);
			 $stmt->bindParam(":email",$email,PDO::PARAM_STR);
			 $stmt->bindParam(":password",$enc_pass,PDO::PARAM_STR);
			 $stmt->bindParam(":activationcode",$verificationCode,PDO::PARAM_STR);
			 $stmt->execute();

            // verifikacija emaila
	        $verificationLink = "http://petarsocogr.x3.rs/activate.php?code=".$verificationCode."&?email=".$email;

            $htmlStr = "";
            $htmlStr .= "Zdravo " . $email . ",<br /><br />";

            $htmlStr .= "Klikni na dugme ispod kako bi verifikovao tvoj email.<br /><br /><br />";
            $htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";

            $htmlStr .= "Puno pozdrava,<br />";
            $htmlStr .= "<a href='http://petarsocogr.x3.rs' target='_blank'>Prijavi deponiju</a><br />";

            $name = "Prijavi deponiju";
            $email_sender = "no-reply@prijavideponiju.com";
            $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
            $recipient_email = $email;

            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: {$name} <{$email_sender}> \n";
            
            $body = $htmlStr;
            // funkcija za slanje maila
            if( mail($recipient_email, $subject, $body, $headers) ){
                // obavestenje za korisnika na mail
                echo "<div id='successMessage'>Verifikacioni mail je poslat na  <b>" 
				. $email . "</b>, verifikuj mail.</div>";
            }else{
			$msg = 'Neuspela registracija'; 		
			header ("Location:/logreg.php?submit_msg=$msg");
			exit;
			}
		}
		catch(PDOException $e){ 
		echo $e->getMessage();
	    }
	}
	
	public function activate($activationcode){
		try{	
			$activated="SELECT status FROM user";
			$stmt1=$this->connection->prepare($activated);; 
			$stmt1->execute();
			$result=$stmt1->fetch(PDO::FETCH_ASSOC);
			 if($result>0){
				 echo "Tvoj email je već aktiviran";
				 header( "Location:/logreg.php" );
			 }
			$status=1;	
			$sql="UPDATE user SET status=:status WHERE activationcode=:activationcode";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":activationcode",$activationcode,PDO::PARAM_STR);
			$stmt->bindParam(":status",$status,PDO::PARAM_STR); 
			$stmt->execute();
			 return true;
		}			 
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	 
	 public function ulogovan() {
        session_start();
        if (isset($_SESSION["id"])) {
            $sql = "SELECT *  FROM user WHERE id=:id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":id", $_SESSION['id']);
			$stmt->execute();
        } else {
            header("location:index");
        }
    }
	
	public function user_email(){
		$sql = "SELECT email FROM user WHERE id=:id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		$uemail=$row['email'];
		return $uemail;
	}
	
	public function user_emailForAdmin($id){
		$sql = "SELECT email FROM user WHERE id=:id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		$uemail=$row['email'];
		return $uemail;
	}
	
	
	public function insertToMap($uemail,$address,$lat,$lng,$type){//$img
			try{
				$sql="INSERT INTO markers (user_email,address,lat,lng,type)
				VALUES (:user_email,:address,:lat,:lng,:type)";
				$stmt=$this->connection->prepare($sql);
				$stmt->bindParam(":user_email",$uemail,PDO::PARAM_STR);
				$stmt->bindParam(":address",$address,PDO::PARAM_STR);
				$stmt->bindParam(":lat",$lat);
				$stmt->bindParam(":lng",$lng);
				$stmt->bindParam(":type",$type);
				$ok=$stmt->execute();
				$msg = 'Uneto';
				header("refresh:0;profile");
				echo"<script>alert('Uneto');</script>";
				exit();
			}			 
			catch(PDOException $e){
				echo $e->getMessage();
			}
	}
	
	public function getFromMap(){
		try{
			$sql="SELECT * FROM markers";
			$stmt=$this->connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	/*Dodato 23.4.2017 15:51*/
	public function getFromMapById($id){
		try{
			$sql="SELECT * FROM markers WHERE id=:id";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":id",$id,PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	
	public function getUserMap(){
		try{
			$sql="SELECT * FROM markers WHERE user_email=:user_email";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":user_email",$_SESSION['email'],PDO::PARAM_STR);
			$stmt->execute();
			$rezultati = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rezultati[] = $row;
        }
        return $rezultati;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function getUserData(){
		try{
			$sql="SELECT user_email,image,address FROM markers WHERE user_email=:user_email";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":user_email",$_SESSION['email'],PDO::PARAM_STR);
			$stmt->execute();
			$stmt->bindColumn(1, $user_email, PDO::PARAM_STR, 256);
			$stmt->bindColumn(2, $image, PDO::PARAM_LOB);
			$stmt->bindColumn(3, $address, PDO::PARAM_STR, 256);
			$userData=$stmt->fetch(PDO::FETCH_BOUND);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function getImage(){
		try{
			$sql="SELECT  image_path1 FROM markers WHERE user_email=:user_email";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":user_email",$_SESSION['email'],PDO::PARAM_STR);
			$stmt->execute();
			$stmt->bindColumn(1, $user_email, PDO::PARAM_STR);
			return $userData=$stmt->fetch(PDO::FETCH_BOUND);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	public function pagination(){
		try{
			$sql="SELECT COUNT (*) FROM markers WHERE user_email=:user_email";
			$stmt=$this->connection->prepare($sql);
			$stmt->bindParam(":user_email",$_SESSION['email'],PDO::PARAM_STR);
			$stmt->execute();
			$getTotalRows=$stmt->fetch();
			$pages=ceil($getTotalRows[0]/7);
			return $pages;
		}catch(PDOException $e){
			echo $e->getMessage();
			}
	}
	
	public function getUserInfo (){
		try {
			$sql="SELECT firstname,lastname FROM user WHERE id=:id ";

			$stmt = $this->connection->prepare($sql);
	        $stmt->bindParam(":id",$_SESSION['id'] , PDO::PARAM_INT);
	      
	        $stmt->execute();

	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	        return $row;
			//password ne bih ni stavljao jer nema poentu kad ga svakako user nece videti, ostavimo samo opciju da se promeni password.
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function getUserInfoForAdmin ($id){
		try {
			$sql="SELECT firstname,lastname FROM user WHERE id=:id ";

			$stmt = $this->connection->prepare($sql);
	        $stmt->bindParam(":id",$id , PDO::PARAM_INT);
	      
	        $stmt->execute();

	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	        return $row;
			//password ne bih ni stavljao jer nema poentu kad ga svakako user nece videti, ostavimo samo opciju da se promeni password.
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function changeUserInfo () {
		if (isset($_POST['submit1'])) {
			$firstname=$_POST['firstname'];
			    if(strlen($firstname)>0){
            			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $firstname)){
            				$msg = 'Ime  ne može imati specijalne karaktere'; 		
            				header ("Location: profile.php?submit_msg=$msg&tab=3");
            				exit;
            			}else{
            				try {							
            					$sql = "UPDATE user SET firstname=:firstname WHERE id=:id";
            					$stmt = $this->connection->prepare($sql);
            					$stmt->bindParam(":id", $_SESSION['id']);
            					$stmt->bindParam(":firstname",$firstname,PDO::PARAM_STR);
            					$stmt->execute();
            					header("Refresh:0");
            					$msg = 'Ime uspesno promenjeno'; 		
            					header ("Location: profile.php?submit_msg=$msg&tab=3");
            					exit;
            				} catch (Exception $e) {
            					echo $e->getMessage();
            				}
            			}
			    }else{
			        $msg = 'Polje ne moze biti prazno'; 		
            		header ("Location: profile.php?submit_msg=$msg&tab=3");
            		exit;
			        
			        
			    }		
		}
		if (isset($_POST['submit2'])) {
			$lastname=$_POST['lastname'];
    			 if(strlen($lastname)>0){
            			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lastname)){
            				$msg = 'Prezime  ne može imati specijalne karaktere'; 		
            				header ("Location: profile.php?submit_msg=$msg&tab=3");
            				exit;
            			}else{
            				try{
            					$sql = "UPDATE user SET lastname=:lastname WHERE id=:id";
            					$stmt = $this->connection->prepare($sql);
            					$stmt->bindParam(":id", $_SESSION['id']);
            					$stmt->bindParam(":lastname",$lastname,PDO::PARAM_STR);
            					$stmt->execute();
            					header("Refresh:0");
            					$msg = 'Prezime uspesno promenjeno'; 		
            					header ("Location: profile.php?submit_msg=$msg&tab=3");
            					exit;
            				} catch (Exception $e) {
            					echo $e->getMessage();
            				}	
            			}
    			 }else{
    			    $msg = 'Polje ne moze biti prazno'; 		
                	header ("Location: profile.php?submit_msg=$msg&tab=3");
                	exit;
			    }		
		}
        if (isset($_POST['submit3'])) {
        	$email=$_POST['email'];
        	if (filter_var($email,FILTER_VALIDATE_EMAIL)){
	        	try{
					$sql = "UPDATE user SET email=:email WHERE id=:id";
					$stmt = $this->connection->prepare($sql);
					$stmt->bindParam(":id", $_SESSION['id']);
					$stmt->bindParam(":email",$email,PDO::PARAM_STR);
					$stmt->execute();
					header("Refresh:0");
					$msg = 'E-mail uspesno promenjen'; 		
					header ("Location: profile.php?submit_msg=$msg&tab=3");
					exit;
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}else {
				$msg = 'Email nije važeći'; 		
				header ("Location: profile.php?submit_msg=$msg&tab=3");
				exit;
			}
		}
		if (isset($_POST['submit4'])) {
			$password=$_POST['password'];
			$password1=$_POST['password1'];
			if (strlen($password)>2){
				if($password===$password1){
					try{	
						$sql = "UPDATE user SET password=:value WHERE id=:id";
						$value=password_hash ( $password , PASSWORD_DEFAULT ) ;
						$stmt = $this->connection->prepare($sql);
						$stmt->bindParam(":id", $_SESSION['id']);
						$stmt->bindParam(":value",$value,PDO::PARAM_STR);
						$stmt->execute();
						header("Refresh:0");
						$msg = 'Lozinka uspesno promenjena'; 		
						header ("Location: profile.php?submit_msg=$msg&tab=3");
						exit;
					} catch (Exception $e) {
						echo $e->getMessage();
					}
				}else{
					$msg = 'Lozinke se ne poklapaju'; 		
					header ("Location: profile.php?submit_msg=$msg&tab=3");
					exit;
				}
			}else{
				$msg = 'Lozinka je suviše kratka'; 		
				header ("Location: profile.php?submit_msg=$msg&tab=3");
				exit;
			}
		}
	}
	
	public function passwordChange (){	
		//STEP 1	
		if (isset($_POST['submit1'])) {	
			$email=$_POST['email'];			
			if (!empty($email)) {
				try{
					$sql="SELECT email,activationcode FROM user WHERE email=:email";
					$stmt = $this->connection->prepare($sql);
					$stmt->bindParam(":email", $email,PDO::PARAM_STR);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($row>0) {
		//slanje emaila
					 	$htmlStr = "";
               			$htmlStr .= "Zdravo " . $email . ",<br /><br />";
               			$htmlStr .= "Vas kod za promenu lozinke je <strong>".$row['activationcode']."</strong><br /><br />";

               			$name = "Prijavi deponiju";
               			$email_sender = "no-reply@prijavideponiju.com";
                		$subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
               			$recipient_email = $email;

               			$headers  = "MIME-Version: 1.0\r\n";
              			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
              			$headers .= "From: {$name} <{$email_sender}> \n";
 
              			$body = $htmlStr;
                        // funkcija za slanje maila
                            if( mail($recipient_email, $subject, $body, $headers) ){
            				    $msg = 'Email uspesno poslat'; 		
                				header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=2");
                				exit;
                            }else{
                                $msg = 'Slanje emaila neuspesno'; 		
                				header ("Location: passwordChange.php?submit_msg=$msg&email=$email");
                				exit;
                            }
					}else{
					    $msg = 'Email ne postoji u bazi podataka'; 		
                		header ("Location: passwordChange.php?submit_msg=$msg&email=$email");
                		exit;
					}    
				}catch(Exception $e){
					echo $e->getMessage();
				}
			}else{	
				$msg = 'Morate popuniti polje'; 		
                header ("Location: passwordChange.php?submit_msg=$msg&email=$email");
                exit;	
			}
		}
		//STEP 2
		if($_GET['step']==='2'){   
	        ?>    
            <script type="text/javascript" >
				$(document).ready(function(){
					$('#step1').removeClass(' in active '),
					$('#btnStep1').removeClass(' active '),
					$('#step2').addClass(' in active '),
					$('#btnStep2').addClass(' active ')
				});
			</script>
	    	<?php  
	       $email=$_GET['email'];
		}
		if (isset($_POST['submit2'])) {
			$code=$_POST['code'];
			if (!empty($code)) {
				try{
					$sql="SELECT activationcode FROM user WHERE email=:email";
					$stmt=$this->connection->prepare($sql);
					$stmt->bindParam(":email",$email,PDO::PARAM_STR);
					$stmt->execute();
        		$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$codeFromDB=$row['activationcode'];
					if ($code===$codeFromDB) {
					    $msg = 'Ispravan kod'; 		
                		header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=3");
                		exit;
					}else{
						$msg = 'Pogresan kod'; 		
                		header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=2");
                		exit;
					}
				}catch(PDOException $e){
					echo $e->getMessage();
				}
			}else{
				$msg = 'Morate da popunite polje'; 		
                header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=2");
                exit;
			}
		}
		//STEP 3
		if($_GET['step']==='3'){    
			?>
				<script type="text/javascript" >
					$(document).ready(function(){
						$('#step1').removeClass(' in active '),
    		            $('#btnStep1').removeClass(' active '),
						$('#step3').addClass(' in active '),
						$('#btnStep3').addClass(' active ')
					});
				</script>
			<?php
        }
        $email=$_GET['email'];
		if (isset($_POST['submit3'])) {
			$password=$_POST['password'];
			$password1=$_POST['password1'];
			if (strlen($password)>2){
				if($password===$password1){
					try{	
						$sql = "UPDATE user SET password=:value WHERE email=:email";
						$value=password_hash ( $password , PASSWORD_DEFAULT ) ;
						$stmt = $this->connection->prepare($sql);
						$stmt->bindParam(":email", $email,PDO::PARAM_STR);
						$stmt->bindParam(":value",$value,PDO::PARAM_STR);
						$stmt->execute();
						$msg = 'Lozinka uspesno promenjena'; 		
						header ("Location:logreg.php?submit_msg=$msg");
						exit;
					} catch (Exception $e) {
						echo $e->getMessage();
					}
				}else{
					$msg = 'Lozinke se ne poklapaju';
                	header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=3");
                	exit;		
				}
			}else{
			    $msg = 'Lozinka je suviše kratka';	
            	header ("Location: passwordChange.php?submit_msg=$msg&email=$email&step=3");
                exit;	
			}
		}
	}
	
	public function deleteRow($id){
	    try{	
			$sql = "DELETE FROM markers WHERE id=:id";
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(":id", $id,PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	    
	}
	public function deleteProfile ($email,$password){
		try{
		$sql = "SELECT password FROM user WHERE email=:email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    
		    if($row && (password_verify($password,$row['password']))){
		        
		        $sql = "DELETE FROM user WHERE email=:email";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->execute();
		        
		        $sql = "DELETE FROM markers WHERE user_email=:email";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->execute();
		        
    				
    			$msg = 'Profil uspesno izbrisan';
			    header ("location:/index?submit_msg=$msg");
			    exit;
    			 
    			
            } else {
				$msg = 'Lozinka neispravna'; 		
				header ("Location: deleteProfile.php?submit_msg=$msg");
				exit;
            }
		}catch(PDOException $e){
			echo $e->getMessage();
		}
    }
	
    public function checkAdmin($email){
		try{
			$sql = "SELECT admin FROM user WHERE email=:email";
	        $stmt = $this->connection->prepare($sql);
	        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
	        $stmt->execute();
	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	       	return $row;
       	} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
  	public function selectAllUsers(){
  		try{
			$sql = "SELECT * FROM user";
	        $stmt = $this->connection->prepare($sql);
	        $stmt->execute();
	        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	       	return $row;
       	} catch (Exception $e) {
			echo $e->getMessage();
		}
  	}
	
	public function sendMessage($email){
	    
	    if(isset($_POST['buttonSendMessage'])){
	        $emailContent=$_POST['mailContent'];
	        echo $emailContent;
	        if(isset($emailContent) && !empty($emailContent) ){//
	    
    	    
    	         $htmlStr = "";
                $htmlStr .=  $emailContent;
                echo $htmlStr;
                
    
                $name = "Prijavi deponiju";
                $email_sender = "no-reply@prijavideponiju.com";
                $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
                $recipient_email = $email;
    
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: {$name} <{$email_sender}> \n";
                
                $body = $htmlStr;
                // funkcija za slanje maila
                if( mail($recipient_email, $subject, $body, $headers) ){
                    // poruka za korisnika poslata od admina
                    $msg = 'Slanje uspesno'; 		
    			    header ("Location:/profile.php?submit_msg=$msg");
    			    exit;
    				
                }else{
        			$msg = 'Neuspelo slanje'; 		
        			header ("Location:/profile.php?submit_msg=$msg");
        			exit;
    			}
	        } else{
    	        $msg = 'Morate uneti tekst'; 		
        		header ("Location:/profile.php?submit_msg=$msg");
        		exit;
	        }
	    
	    }
	    
	    
	}
	
	public function sendSuspendInfo(){
	            $htmlStr = "";
                $htmlStr .= "Zdravo " . $email . ",<br /><br />";
    
                $htmlStr .= "Vas nalog je suspendovan.<br /><br /><br />";
    
                $name = "Prijavi deponiju";
                $email_sender = "no-reply@prijavideponiju.com";
                $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
                $recipient_email = $email;
    
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: {$name} <{$email_sender}> \n";
                
                $body = $htmlStr;
                // funkcija za slanje maila
                if( mail($recipient_email, $subject, $body, $headers) ){
                    // obavestenje za korisnika na mail
                    $msg = 'Slanje uspesno'; 		
    			    header ("Location:/profile.php?submit_msg=$msg");
    			    exit;
    				
                }else{
        			$msg = 'Neuspelo slanje'; 		
        			header ("Location:/profile.php?submit_msg=$msg");
        			exit;
    			}
	}
	
	public function suspendUser($id){
	    
	   try{
			$sql = "SELECT suspend,email FROM user WHERE id=:id";
	        $stmt = $this->connection->prepare($sql);
	        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
	        $stmt->execute();
	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	       	$suspend=$row['suspend'];
	       	$email=$row['email'];
	       	
	       	if($suspend==='0'){
	       	    try{
                    $sql="UPDATE user SET suspend=1 WHERE id=:id";
			        $stmt=$this->connection->prepare($sql);
			        $stmt->bindParam(":id",$id,PDO::PARAM_STR);
			        
			        $stmt->execute();
			       
			       $htmlStr = "";
                $htmlStr .= "Zdravo " . $email . ",<br /><br />";
    
                $htmlStr .= "Vas nalog je suspendovan od strane admina. Necete biti u mogucnosti da koristite nalog dok se suspenzija ne ukloni<br /><br /><br />";
    
                $name = "Prijavi deponiju";
                $email_sender = "no-reply@prijavideponiju.com";
                $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
                $recipient_email = $email;
    
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: {$name} <{$email_sender}> \n";
                
                $body = $htmlStr;
                // funkcija za slanje maila
                if( mail($recipient_email, $subject, $body, $headers) ){
                    // obavestenje za korisnika na mail
                    $msg = 'Slanje uspesno'; 		
    			    header ("Location:/profile.php?submit_msg=$msg");
    			    exit;
    				
                }else{
        			$msg = 'Nalog uspesno suspendovan'; 		
        			header ("Location:/profile.php?submit_msg=$msg");
        			exit;
    			}
			       
			       
	            }catch(PDOException $e){
			        echo $e->getMessage();
		        }
	       	}else{
	       	    try{
                    $sql="UPDATE user SET suspend=0 WHERE id=:id";
			        $stmt=$this->connection->prepare($sql);
			        $stmt->bindParam(":id",$id,PDO::PARAM_STR);
			        
			        $stmt->execute();
			        
			       
			           $htmlStr = "";
                $htmlStr .= "Zdravo " . $email . ",<br /><br />";
    
                $htmlStr .= "Ukinuta vam je suspenzija naloga. Vas nalog je ponovo aktivan<br /><br /><br />";
    
                $name = "Prijavi deponiju";
                $email_sender = "no-reply@prijavideponiju.com";
                $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
                $recipient_email = $email;
    
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: {$name} <{$email_sender}> \n";
                
                $body = $htmlStr;
                // funkcija za slanje maila
                if( mail($recipient_email, $subject, $body, $headers) ){
                    // obavestenje za korisnika na mail
                    $msg = 'Uspesno ste aktivirali nalog korisnika'; 		
    			    header ("Location:/profile.php?submit_msg=$msg");
    			    exit;
    				
                }else{
        			$msg = 'Neuspelo slanje'; 		
        			header ("Location:/profile.php?submit_msg=$msg");
        			exit;
    			}
	            }catch(PDOException $e){
			        echo $e->getMessage();
		        }
	       	    
	       	}
       	}catch(PDOException $e){
	          echo $e->getMessage();
		}
	    
	}
	public function promoteToAdmin($id){
	    try{
			$sql = "SELECT admin,email FROM user WHERE id=:id";
	        $stmt = $this->connection->prepare($sql);
	        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
	        $stmt->execute();
	        $row = $stmt->fetch(PDO::FETCH_ASSOC);
	       	$suspend=$row['admin'];
	       	$email=$row['email'];
    	    try{
                        $sql="UPDATE user SET admin=1 WHERE id=:id";
    			        $stmt=$this->connection->prepare($sql);
    			        $stmt->bindParam(":id",$id,PDO::PARAM_STR);
    			        
    			        $stmt->execute();
    			        
    			       
    			           $htmlStr = "";
                    $htmlStr .= "Zdravo " . $email . ",<br /><br />";
        
                    $htmlStr .= "Cestitamo!!! Unapredjeni ste u admina.<br /><br /><br />";
        
                    $name = "Prijavi deponiju";
                    $email_sender = "no-reply@prijavideponiju.com";
                    $subject = "Verifikacioni Link | Prijavi deponiju | Subscription";
                    $recipient_email = $email;
        
                    $headers  = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                    $headers .= "From: {$name} <{$email_sender}> \n";
                    
                    $body = $htmlStr;
                    // funkcija za slanje maila
                    if( mail($recipient_email, $subject, $body, $headers) ){
                        // obavestenje za korisnika na mail
                        $msg = 'Unapredjenje izvrseno'; 		
        			    header ("Location:/profile.php?submit_msg=$msg");
        			    exit;
        				
                    }else{
            			$msg = 'Neuspelo slanje'; 		
            			header ("Location:/profile.php?submit_msg=$msg");
            			exit;
                    }
			}catch(PDOException $e){
		        echo $e->getMessage();
	        }
	    }catch(PDOException $e){
		        echo $e->getMessage();
	    }
	}
	public function checkSuspend($id){
	    try{
	        $sql="SELECT suspend FROM user WHERE id=:id";
    		$stmt=$this->connection->prepare($sql);
    		$stmt->bindParam(":id",$id,PDO::PARAM_STR);
    			        
    		$stmt->execute();
    		$suspend = $stmt->fetch(PDO::FETCH_ASSOC);
    		return $suspend;
	    }catch(PDOException $e){
		        echo $e->getMessage();
	        }
	}
}

