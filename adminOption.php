<?php 

include_once('includes/User.php');
ob_start();
$user=new User();
$id=$_GET['id'];
 
 

$uEmailForAdmin=$user->user_emailForAdmin($id);
$row=$user->getUserInfoForAdmin ($id);
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$user->ulogovan();
$uemail=$user->user_email();
$user->sendMessage($uEmailForAdmin);
$suspend=$user->checkSuspend($id);
$suspend=$suspend['suspend'];
$admin=$user->checkAdmin($uEmailForAdmin);
$admin=$admin['admin'];
if(isset($_POST['buttonSuspend'])||isset($_POST['buttonSuspend1'])){
   $user->suspendUser($id);

}
if(isset($_POST['buttonPromote'])){
   $user->promoteToAdmin($id);

}


//echo $id."</br>";
//echo $firstname."</br>";
//echo $lastname."</br>";
//echo $uemail."</br>";
//echo $_SESSION['id'];
include_once('template/header.php');
 ?>
 <div class="row">
<div class="col-md-4 col-md-offset-4">
    <div class="well"><h3 style='text-align:center;'>
        <strong>Opcije za admina</strong><h3>
            
    </div>
</div><br>
 </div>
 
 <h3 style='text-align:center;'>Korisnik: <?php echo $firstname." ".$lastname ?></h3><br>
 <h3 style='text-align:center;'>Email: <?php echo $uemail?></h3>
<br>
 
 <?php if($admin==='1'){ ?>
    <h3 style='text-align:center;'>Status: Admin</h3>
     <br><hr><br>
    
 <?php }else{ 
      if($suspend==='0'){
     ?>
        <h3 style='text-align:center;'>Status: Korisnik</h3>
         <br>
     <?php 
     }else{
       ?>  
       <h3 style='text-align:center;'>Status: Suspendovan</h3>
         <br>
    <?php      
     }
 } ?>
 
 
  
  <?php if($admin!=='1'){ ?>
 
     <form method='post'>
     <h4 style='text-align:center;'>Unapredi korisnika u admina</h4>
     <div align="center">
        
       <input type='submit' class='btn btn-primary col-xs-12 col-sm-2 col-sm-offset-5' id='buttonPromote' name='buttonPromote'  value='Unapredi' >
        
     </div><br> 
     </form>
     <br><hr><br>
     
     
 
    
     
 <?php } ?>
 
 
 
 
 <?php if($admin!=='1'){ 
            if($suspend==='0'){ 
 
 ?>
 
         
            <form method='post'>
                <h4 style='text-align:center;'>Zelite da suspendujete nalog korisnika?</h4>
                <div align="center">
                    <input type='submit' class='btn btn-danger col-xs-12 col-sm-2 col-sm-offset-5' id='buttonSuspend' name='buttonSuspend'  value='Suspenduj' >
                
                </div><br> 
             </form>
             <br><hr><br>
         <?php }else{?>
             
            <form method='post'>
                <h4 style='text-align:center;'>Zelite da da ponovo aktivirate nalog korisnika?</h4>
                <div align="center">
                    <input type='submit' class='btn btn-danger col-xs-12 col-sm-2 col-sm-offset-5' id='buttonSuspend1' name='buttonSuspend1'  value='Aktiviraj' >
                
                </div><br> 
             </form>
             <br><hr><br>
         
         
         <?php } ?>
            
    <?php } ?>
 
 

 
 <form method='post'>
     <div class='row'> 
     
        <div id='divPosaljiPoruku' class='form-group '>    
             <h4 style='text-align:center;'>Posalji poruku korisniku</h4>   
            <textarea class=" col-xs-12 col-sm-4 col-sm-offset-4" rows="5" name="mailContent" id="mailContent" placeholder='Ovde unesite tekst'></textarea>
            <input type="submit" name="buttonSendMessage" if="buttonSendMessage" class='btn btn-success col-xs-12 col-sm-2 col-sm-offset-5' value='Posalji' style='margin-top:15px;'>   
        </div>
                                
     </div>
 </form>
 <?php
 include_once('template/footer.php');
 ?>
 
 
 <script type="text/javascript" >
   

     function YesNoAlert() {
    if (confirm('Da li zelite da potvrdite suspendovanje korisnika?')) {
    // Save it!
    } else {
    // Do nothing!
    };
}
 </script>
