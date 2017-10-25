<?php include_once 'includes/User.php'; 
	  include_once 'includes/Photo.php';  	
 	  ob_start();
		 $name=(isset($_GET['name'])) ? $_GET['name'] : '';
		 $address=(isset($_GET['address'])) ? $_GET['address'] : '';
		 $image=(isset($_GET['img'])) ? $_GET['img'] : '';
		  
		 //$image = isset($_FILES['img']['tmp_name']) ;
 
		 
		 $lat=(isset($_GET['lat'])) ? $_GET['lat']:'';	 
		 $lng=(isset($_GET['lng'])) ? $_GET['lng'] :'';
		 $type=(isset($_GET['type'])) ? $_GET['type'] :'';
 
 		 $user=new User();
		 $photo=new Photo();
		 $getImage=$user->getImage();
		 $all= $user->getFromMap();
 
		 $user->ulogovan();
		 $uemail=$user->user_email();
		 $usermap=$user->getUserMap();
		 $admin=$user->checkAdmin($uemail);
		
				
		
		if(!empty($uemail)  && !empty($address) && !empty($lat)
			&& !empty($lng) && !empty($type) ){

		
			$user->insertToMap($uemail,$address,$lat,$lng,$type);
			header("Refresh:0; url=profile");
		} 
			
		 
		if (isset($_GET['submit_msg']))
		{
			echo "<p id='msg' align=center>";
			echo $_GET['submit_msg'];
			echo "</p>";
		}
		
	 //header
 require_once('template/header.php'); ?>
  
    <script type="text/javascript">
    var marker;
    var infowindow;

    function initialize() {
      var latlng = new google.maps.LatLng(44.768366, 20.436385);
      var options = {
        zoom: 12,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(document.getElementById("map"), options);
	  
	  for(i=0;i<myJsarray.length;i++){
			//console.log("Initialize funkc "+myJsarray[i].name );
			//addMarker1(myJsarray[i].name,myJsarray[i].address,myJsarray[i].lat,myJsarray[i].lng,myJsarray[i].type);
			pos = new google.maps.LatLng(myJsarray[i].lat, myJsarray[i].lng);
			var content="";
			var img= myJsarray[i].image_path1;
      var img2=  myJsarray[i].image_path2;    
      var id= myJsarray[i].id;   
      var imgEmail= myJsarray[i].user_email;
      var userEmail= "<?php echo $uemail; ?>";
      var admin= "<?php echo $admin['admin'] ;?>";

      if ( imgEmail==userEmail) {//prepoznaje markere korinsnika i omogucava mu da edituje info      
        if(img===null && img2===null){
          content=content+
            '<div class="row col-sm-11">'+  
                '<div class="col-xs-12 col-sm-7">'+
                    '<h4>Adresa: '+myJsarray[i].address+'</br></h4>'+
                    '<h5>Tip: '+myJsarray[i].type+'</h5>'+
                '</div>'+
                '<div class="col-xs-12 col-sm-5">'+
                    '<a href="deleteRow.php?id='+id+'" class="btn btn-danger" style="width:150px">Izbrisi deponiju</a>'+
                '</div>'+             
            '</div></br>'+
            '<div class="row col-sm-11">'+
                '<div class="col-xs-12 col-sm-7">'+
                    '</br><p>Slika nije dodata.</p>'+
                '</div>'+
                '<div class="col-xs-12 col-sm-5">'+
                    '<a href="edit.php?id='+id+'&photoNum=1" class="btn btn-primary" style="width:150px">Dodaj sliku</a></br>'+
                '</div>'+
             '</div>';
            
            
            
        }else{
            content=content+
                '<div class="row col-sm-12">'+  
                    '<div class="col-xs-12 col-sm-7">'+
                        '<h4>Adresa: '+myJsarray[i].address+'</br></h4>'+
                        '<h5>Tip: '+myJsarray[i].type+'</h5>'+
                    '</div>'+
                    '<div class="col-xs-12 col-sm-5">'+
                        '<a href="deleteRow.php?id='+id+'" class="btn btn-danger" style="width:150px">Izbrisi deponiju</a>'+
                    '</div>'+             
                '</div></br>';
          if(img!==null && img2!==null){
            content=content+ 
// slika 1
            '<div class="row col-sm-12">'+ 
               
                  '<div class="col-xs-12 col-sm-7">'+
                    '<a href="'+img+'" class=\'image\'><img  src='+img+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a>'+
                  '</div>'+
                  '<div class="col-xs-12 col-sm-5"></br>'+
                    '<a href="edit.php?id='+id+'&photoNum=1" class="btn btn-primary" style="width:150px">Promeni sliku</a></br></br>'+
                    '<a href="deletePhoto?id='+id+'&photoNum=1" class="btn btn-danger" style="width:150px">Izbrisi sliku</a>'+
                  '</div>'+ 
                 
            '</div></br>'+
            '<div class="row"><div class="col-xs-12 col-sm-12 col-lg-12"><hr style="border-top: 1px solid gray;"></div></div>'+
 // slika 2 
            
            '<div class="row col-sm-12">'+ 
                '<div class="col-xs-12 col-sm-7">'+
                  '<a href="'+img2+'" class=\'image\'><img src='+img2+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a>'+
                '</div>'+
                '<div class="col-xs-12 col-sm-5"></br>'+
                  '<a href="edit.php?id='+id+'&photoNum=2" class="btn btn-primary" style="width:150px">Promeni sliku</a></br></br>'+
                  '<a href="deletePhoto?id='+id+'&photoNum=2" class="btn btn-danger" style="width:150px">Izbrisi sliku</a>'+
                '</div>'+
            '</div>';
          }

          if(img!==null && img2===null){
            content=content+
          
           '<div class="row col-sm-12" >'+
              '<div class="col-xs-12 col-sm-7">'+
                '<a href="'+img+'" class=\'image\'><img  src='+img+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a>'+
              '</div>'+
              '<div class="col-xs-12 col-sm-5"></br>'+
                '<a href="edit.php?id='+id+'&photoNum=1" class="btn btn-primary" style="width:150px">Promeni sliku</a></br></br>'+
                '<a href="deletePhoto?id='+id+'&photoNum=1" class="btn btn-danger" style="width:150px">Izbrisi sliku</a></br></br>'+
                '<a href="edit.php?id='+id+'&photoNum=2" class="btn btn-primary" style="width:150px">Dodaj drugu sliku</a> ';
              '</div>'+            
          '</div>';


          }
          if(img===null && img2!==null){
            content=content+
          '<div class="row col-sm-12" >'+
            '<div class="col-xs-12 col-sm-7">'+
              '<a href="'+img2+'" class=\'image\'><img src='+img2+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a>'+
            '</div>'+
            '<div class="col-xs-12 col-sm-5"></br>'+
              '<a href="edit.php?id='+id+'&photoNum=2" class="btn btn-primary" style="width:150px">Promeni sliku</a></br></br>'+
              '<a href="deletePhoto?id='+id+'&photoNum=2" class="btn btn-danger" style="width:150px" >Izbrisi sliku</a></br></br>'+
              '<a href="edit.php?id='+id+'&photoNum=1" class="btn btn-primary" style="width:150px">Dodaj drugu sliku</a>'+
            '</div>'+
          '</div>';
          
          }
        }
      }else{//ako markeri nisu ud usera samo ih izlistava bez dodatnih opcija
        content=content+
                    
                        '<h4>Adresa: '+myJsarray[i].address+'</br></h4>'+
                        '<h5>Tip: '+myJsarray[i].type+'</h5>';
                        
                    
            if (admin !== '0') {
                content=content+
                    
                '<div style=\'width:220px;\'>'+
                        '<a href="deleteRow.php?id='+id+'" class="btn btn-danger" style="width:150px">Izbrisi deponiju</a></br></br>'+
                        '</div>';

            }
                

            if (img!==null) {
                 content=content+'<div style=\'width:220px;\'><a href="'+img+'" class=\'image\'><img  src='+img+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a></div></br></br>';
            }
            if (img2!==null) {
                 content=content+'<div style=\'width:220px;\'><a href="'+img2+'" class=\'image\'><img  src='+img2+' height=\'200\' width=\'200\' style=\'border: 2px solid black;border-radius:15px;\'></a></div>';
            }      
      }    

  			 marker=new google.maps.Marker({
  			position:pos,
  			map:map,
  			content:content,
  			title:content,
  			animation: google.maps.Animation.DROP
  		});
  		
  			// Marker click listener
      google.maps.event.addListener(marker, 'click', (function (marker, content) {
          return function () {
              console.log('Gmarker 1 gets pushed');
              infowindow.setContent(
  			'<p class="kocka">'+ content+'</p>'
  			);
  		 
              infowindow.open(map, marker);
              map.panTo(this.getPosition());
               map.setZoom(12);
          }
  		
      })(marker, content));
  	  }
  	  
        var html = "<table method='get' enctype='multipart/form-data' class='col-xs-12 col-sm-12 col-lg-12'>" +				 
                   "<tr class='row'><td ><h4>Tvoj Email:</h4></td> <td ><input class='form-control' type='text' readonly='readonly' value=<?=$uemail; ?> id='name'/><td></tr>" +
                   "<tr class='row'><td ><h4>Adresa:</h4></td> <td ><input class='form-control' type='text' id='address'/><td> </tr>" +
  				 
                   "<tr class='row'><td><h4>Tip:</h4></td> <td><select class='form-control' id='type' name='type'>" +
                   "<option value='ekocid' SELECTED>ekocid</option>" +
                   "<option value='deponija'>deponija</option>" +
                   "</select> </td></tr>" +
                   "<tr class='row'><td></td><td><input class='btn btn-primary btn-block' type='submit' value='Sacuvaj' onclick='saveData();' /></td></tr>";
      infowindow = new google.maps.InfoWindow({
       content: html
      });
  	//za unos
      google.maps.event.addListener(map, "click", function(event) {
          marker = new google.maps.Marker({
            position: event.latLng,
            map: map
          });
          google.maps.event.addListener(marker, "click", function() {
            infowindow.open(map, marker);
          });
      });
    }

    function saveData() {
      var name = escape(document.getElementById("name").value);
      var address = escape(document.getElementById("address").value);
	  //var image = escape(document.getElementById("img").files[0].name);
      var type = document.getElementById("type").value;
      var latlng = marker.getPosition();
		console.log(name +" "+address+" "+type+" "+latlng);
      var url = "profile.php?name=" + name + "&address=" + address +
                "&type=" + type + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
				
      downloadUrl(url, function(data, responseCode) {
        if (responseCode == 200 && data.length >= 1) {
          infowindow.close();
          document.getElementById("message").innerHTML = alert("Dodata lokacija u bazu podataka");
		  
        }
      });
      
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
	

	   function addMarker(lat, lng, info) {
                var pt = new google.maps.LatLng(lat, lng);
                bounds.extend(pt);
                var marker = new google.maps.Marker({
                    position: pt,
                    icon: icon,
                    map: map
                });
                var popup = new google.maps.InfoWindow({
                    content: info,
                    maxWidth: 300
                });
                google.maps.event.addListener(marker, "click", function() {
                    if (currentPopup != null) {
                        currentPopup.close();
                        currentPopup = null;
                    }
                    popup.open(map, marker);
                    currentPopup = popup;
                });
                google.maps.event.addListener(popup, "closeclick", function() {
                    map.panTo(center);
                    currentPopup = null;
                });
				
            }
			var myJsarray = <?= json_encode($all); ?>;
			//console.log(myJsarray[0].address);
			
			for(i=0;i<myJsarray.length;i++){
			//console.log(myJsarray[i].name +" "+myJsarray[i].address);
			 
		}
			
 
    </script>
<script type="text/javascript">

//Check if browser supports W3C Geolocation API
// if (navigator.geolocation) {
  // navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
  // } else {
  // alert('Geolocation is required for this page, but your browser doesn&apos;t support it. Try it with a browser that does, such as Opera 10.60.');
// }

// function successFunction(position) {
  // var lat = position.coords.latitude;
  // var lng = position.coords.longitude;
 
  // console.log('Your latitude is '+lat+' and longitude is '+lng);
// }

// function errorFunction(position) {
  // alert('Error!');
// }
</script>
  <body   onload="initialize()">
  <!-- header -->
<?php require_once('template/header.php'); ?>
    <div class="navbar navbar-default">
        <div class="panel-heading">
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#navBar2' style='margin-right:30px;'>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            </div>
            <div class='collapse navbar-collapse' id='navBar2'>
                <ul class="nav nav-tabs">
                    <li class="active col-xs-12 col-sm-2" id="tab1"><a href="#tab1default" data-toggle="tab">Unos na click</a></li>
                    <li class="col-xs-12 col-sm-2" id="tab2"><a href="#tab2default" data-toggle="tab">Svi moji unosi</a></li>
                    <li class="col-xs-12 col-sm-2" id="tab3"><a href="#tab3default" data-toggle="tab">Moj Profil</a></li>
                    <?php 
                    if ($admin['admin']==='1') { ?>
                      <li class="col-xs-12 col-sm-2" id="tab4"><a href="#tab4default" data-toggle="tab">Admin</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1default"> 
					          <div id="map" style="width: 100%; height: 500px"></div>
                </div>
                <div class="tab-pane fade" id="tab2default">
					<div class='row'> 
            	<?php   foreach($usermap as $ud){	?>
                  		<div class="col-sm-4 col-lg-4 col-xs-offset-1 col-sm-offset-0" >
                  				 <?php
                  				 $postuserid=(isset($_POST['userid'])) ? $_POST['userid']:'';
                  				 $img=$ud['image_path1'];
                  				 $img2=$ud['image_path2'];
                  				 $userId= $ud['id'];
                  				 ?> 
                  				 
                  			<div class='row'>	 
                  			    <div class='col-xs-12 col-sm-12 col-lg-7'> 
                  			        <h4><?php echo 'Adresa: '.$ud['address'].'</br>';?></h4>
                                    <h5> <?php    echo 'Tip: '.$ud['type'] ;?></h5>
                  			    </div>
                  			    <div class='col-xs-12 col-sm-12 col-lg-5'>
                  			        <a href='deleteRow.php?id=<?php echo $userId;?>&tab=2' class='btn btn-danger' style="width:150px">Izbrisi deponiju</a>
                  			    </div>
                  			
                  		    </div>
                          <br>
                          <?php if ($img===null && $img2===null){ ?>
                                  <p>Slika nije dodata.</p>
                                  <a href="edit.php?id=<?php echo $userId;?>&photoNum=1" class="btn btn-primary" style="width:150px">Dodaj sliku</a></br>
                          <?php }else{
                                  if($img!==null && $img2!==null){ ?>
                                    <div class="row" >
                                      <div class="col-xs-12 col-sm-12 col-lg-7">
                                        <a href="<?php echo $img; ?>" class='image'><img  src="<?php echo $img; ?>" height='200' width='200' style='border: 2px solid black;border-radius:15px;'></a>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-lg-5"><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=1" class="btn btn-primary" style="width:150px">Promeni sliku</a></br><br>
                                        <a href="deletePhoto?id=<?php echo $userId;?>&photoNum=1&tab=2" class="btn btn-danger" style="width:150px">Izbrisi sliku</a>
                                      </div>            
                                    </div></br>
                                    <div class="row" >
                                      <div class="col-xs-12 col-sm-12 col-lg-7">
                                        <a href="<?php echo $img2; ?>"  class='image'><img src="<?php echo $img2; ?>" height='200' width='200' style='border: 2px solid black;border-radius:15px;'></a>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-lg-5"><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=2" class="btn btn-primary" style="width:150px">Promeni sliku</a></br><br>
                                        <a href="deletePhoto?id=<?php echo $userId;?>&photoNum=2&tab=2" class="btn btn-danger" style="width:150px">Izbrisi sliku</a>
                                      </div>
                                    </div>       
                            <?php }
                                  if($img!==null && $img2===null){ ?>
                                    <div class="row" >
                                      <div class="col-xs-12 col-sm-12 col-lg-7">
                                        <a href="<?php echo $img; ?>" class='image'><img  src="<?php echo $img; ?>" height='200' width='200' style='border: 2px solid black;border-radius:15px;'></a>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-lg-5"><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=1" class="btn btn-primary" style="width:150px">Promeni sliku</a></br><br>
                                        <a href="deletePhoto?id=<?php echo $userId;?>&photoNum=1&tab=2" class="btn btn-danger" style="width:150px">Izbrisi sliku</a></br><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=2" class="btn btn-primary" style="width:150px">Dodaj drugu sliku</a>
                                      </div>            
                                    </div></br>
                                    
                            <?php }
                                  if($img===null && $img2!==null){?>
                                    <div class="row" >
                                      <div class="col-xs-12 col-sm-12 col-lg-7">
                                        <a href="<?php echo $img2; ?>"  class='image'><img src="<?php echo $img2; ?>" height='200' width='200' style='border: 2px solid black;border-radius:15px;'></a>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-lg-5"><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=2" class="btn btn-primary" style="width:150px">Promeni sliku</a></br><br>
                                        <a href="deletePhoto?id=<?php echo $userId;?>&photoNum=2&tab=2" class="btn btn-danger" style="width:150px">Izbrisi sliku</a></br><br>
                                        <a href="edit.php?id=<?php echo $userId;?>&photoNum=1" class="btn btn-primary" style="width:150px">Dodaj drugu sliku</a>
                                      </div>
                                    </div><br>
                                    
                            <?php } ?>
                          <?php } ?>
				             <hr style="border-top: 1px solid gray;"></div>						     
                  <?php } ?>
					</div>
				</div><!--tab</div> 2 kraj-->
				<div class="tab-pane fade col-sm-offset-3 col-lg-offset-3" id="tab3default">
                        <br>
                     <?php 
                        $row=$user->getUserInfo ();
                        $rowfirstname=$row['firstname'];
                        $rowlastname=$row['lastname'];          
                        $user->changeUserInfo();
                     ?>
        <!--  ROW 1  -->
                        <div class='row'>
                            <div class='col-xs-7 col-sm-5 col-lg-4 '>
                                <h4> Ime: <?php echo $rowfirstname ;?></h4>
                            </div>
                            <div class='col-xs-5 col-sm-3 col-lg-3 ' style='margin-top:3px'>
                                <input type='button' id='button1' value="Promeni ime" class="btn btn-primary btn-block" >
                            </div>
                            <div id='changeFirstName' style='display:none' class='col-xs-12 col-sm-12 col-lg-12'>
                                <form style='margin: auto' method='POST'>
                                    <div class='row'>
                                        <div class='col-xs-7 col-sm-5 col-lg-4'>
                                            <input type='text' class="form-control " name='firstname' id='firstname' placeholder='Ukucaj novo ime' >
                                        </div>
                                        <div class='col-xs-5 col-sm-3 col-lg-3'>
                                            <input type='submit' name='submit1' id='submit1' value='Potvrdi' class="btn btn-success btn-block" >
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                         <hr>
        <!-- ROW 2-->
                        <div class='row'>
                            <div class='col-xs-7 col-sm-5 col-lg-4'>
                               <h4>Prezime: <?php echo $rowlastname ;?></h4>
                            </div> 
                            <div class='col-xs-5 col-sm-3 col-lg-3' style='margin-top:3px'>
                                <input type='button' id='button2' value="Promeni prezime" class="btn btn-primary btn-block" >
                            </div>
                            <div id='changeLastName' style='display:none' class='col-xs-12 col-sm-12 col-lg-12'>
                                <form style='margin: auto' method='POST'>
                                    <div class='row'>
                                        <div class='col-xs-7 col-sm-5 col-lg-4'>
                                            <input type='text' class="form-control " name='lastname' id='lastname' placeholder='Ukucaj novo prezime'>
                                        </div>
                                        <div class='col-xs-5 col-sm-3 col-lg-3'>
                                            <input type='submit' name='submit2' id='submit2' value='Potvrdi' class="btn btn-success btn-block">
                                        </div>    
                                    </div>
                                </form>  
                            </div>
                        </div>
                        <hr>
        <!-- ROW 3 -->
                        <div class='row'>
                            <div class='col-xs-7 col-sm-5 col-lg-4'>
                               <h4>E-mail: <?php echo $uemail ;?></h4>
                            </div> 
                            <div class='col-xs-5 col-sm-3 col-lg-3' style='margin-top:3px'>
                                <input type='button' id='button3' value="Promeni e-mail" class="btn btn-primary btn-block" >
                            </div>
                            <div id='changeEmail' style='display:none' class='col-xs-12 col-sm-12 col-lg-12'>
                                <form style='margin: auto' method='POST'>
                                    <div class='row'>
                                        <div class='col-xs-7 col-sm-5 col-lg-4'>
                                            <input type='email' class="form-control " name='email' id='email' placeholder='Ukucaj novi email'>
                                        </div>
                                        <div class='col-xs-5 col-sm-3 col-lg-3'>
                                            <input type='submit' name='submit3' id='submit3' value='Potvrdi' class="btn btn-success btn-block">
                                        </div>    
                                    </div>
                                </form>  
                            </div>
                        </div>
                        <hr>
      <!-- ROW 4 -->
                        <div class='row'>
                            <div class='col-xs-7 col-sm-5 col-lg-4'>
                               <h4>Lozinka: ******</h4>
                            </div> 
                            <div class='col-xs-5 col-sm-3 col-lg-3' style='margin-top:3px'>
                                <input type='button' id='button4' value="Promeni lozinku" class="btn btn-primary btn-block" >
                            </div>
                            <div id='changePassword' style='display:none' class='col-xs-12 col-sm-12 col-lg-12'>
                                <form style='margin: auto' method='POST'>
                                    <div class='row'>
                                        <div class='col-xs-4 col-sm-3 col-lg-2'>
                                            <input type='password' class="form-control " name='password' id='password' placeholder='Ukucaj lozinku'>
                                        </div>
                                        <div class='col-xs-4 col-sm-3 col-lg-2'>
                                            <input type='password' class="form-control " name='password1' id='password1' placeholder='Potvrditi lozinku'>
                                        </div>
                                        <div class='col-xs-4 col-sm-2 col-lg-3'>
                                            <input type='submit' name='submit4' id='submit4' value='Potvrdi' class="btn btn-success btn-block">
                                        </div>    
                                    </div>
                                </form>  
                            </div>
                        </div>
                        <hr>
    <!--ROW 5 -->                    
                        <div class='row'>
                            <div class='col-xs-12 col-sm-4 col-lg-3 col-sm-offset-2'>
                                <a href='deleteProfile.php' class="btn btn-danger btn-block">Izbrisi profil</a>
                            </div>
                        </div>
                        
                        
                </div>
                               <div class="tab-pane fade" id="tab4default">
                  <div >
                    <?php  
                      $allUsers=$user->selectAllUsers();
                      //print_r($allUsers);
                      //print_r($allUsers['firstname']);
                      ?>
                      <?php   foreach($allUsers as $user){

                        $firstname=$user['firstname'];
                        $lastname=$user['lastname'];
                        $email=$user['email'];
                        $id=$user['id'];
   // print_r($user['id']) ;
                        ?>
                        <br>
                        
                        <div class='row'>
                        
                          


                          <div class='col-xs-12 col-sm-1 col-lg-1'>
                            <h4>
                            <?php echo $id.'.' ?></h4>
                          </div>
                          <div class='col-xs-12 col-sm-2 col-lg-2'>
                            <h4>
                            <?php echo $firstname ?></h4>
                          </div>
                          <div class='col-xs-12 col-sm-2 col-lg-2'>
                            <h4>
                            <?php echo $lastname ?></h4>
                          </div>
                          <div class='col-xs-12 col-sm-3 col-lg-3'>
                            <h4>
                            <?php echo $email ?></h4>
                          </div>
                          <div class='col-xs-12 col-sm-2 col-lg-2'>
                            
                            <a href="adminOption.php?id=<?php echo $id; ?>"  id='buttonOption' class='btn btn-primary btn-block'>Opcije</a>
                          </div>
                        
                          
                          
                          
                          
                        </div>
                        
                       
                        
                        
                        
                        <hr> 
                        
                        


                      <?php } ?>
                      

                  </div>

                </div><!--tab4 KRAJ-->
            </div>
        </div><!-- PANEL BODY kraj-->
    </div>
</body>
<script type="text/javascript" >
// PROFILE EDIT
// show changeFirstName   row1
$(document).ready(function(){
  $('#button1').click(function(){
    $('#button1').fadeOut(500);
    $('#changeFirstName').slideDown(500);
    $('#firstname').focus();
  });  

//hide changeFirstName  row1
  $('#firstname').focusout(function(){
    $('#changeFirstName').slideUp(500);
    $('#button1').fadeIn(500);
  })

// show changeLastName  row2
  $('#button2').click(function(){
    $('#button2').fadeOut(500);
    $('#changeLastName').slideDown(500);
    $('#lastname').focus();
  });

//hide changeLastName   row2
  $('#lastname').focusout(function(){
    $('#changeLastName').slideUp(500);
    $('#button2').fadeIn(500);
  })

// show changeEmail  row3
  $('#button3').click(function(){
    $('#button3').fadeOut(500);
    $('#changeEmail').slideDown(500);
    $('#email').focus();
  });

//hide changeEmail  row3
  $('#email').focusout(function(){
    $('#changeEmail').slideUp(500);
    $('#button3').fadeIn(500);
  })

// show changePassword 
  $('#button4').click(function(){
     $('#button4').fadeOut(500);
     $('#changePassword').slideDown(500);
     $('#password').focus();
  });
  
// hide changePassword
    $('#password').focusout(function(){
     //Ukoliko password1 nije fokusiran
     setTimeout(function() {
        if(!$('#password1').is(':focus'))
        {
            $('#changePassword').slideUp(500);
            $('#button4').fadeIn(500); 
       }
     }, 10)
      });  
      
        $('#password1').focusout(function()
        {
            setTimeout(function() {
                  if(!$('#password').is(':focus')) 
                  {
                      $('#changePassword').slideUp(500);
                      $('#button4').fadeIn(500); 
                  }
           }, 10)
      });





//ADMIN


    // show 
      $('.buttonPosaljiPoruku').click(function(){
         
         $('.divPosaljiPoruku').slideDown(500);
         $('#mailContent').focus();
      });
    
        //hide 
      $('#mailContent').focusout(function(){
        $('#divPosaljiPoruku').slideUp(500);
        
      })
    
       // show 
      $('.buttonSuspendujKorisnika').click(function(){
         
         $('.divSuspendujKorisnika').slideDown(500);
         
      });
    
        //hide 
      $('#buttonNazad').click(function(){
        $('#divSuspendujKorisnika').slideUp(500);
        
      })




//TAB NAVIGATION


    
<?php if($_GET['tab']==='2'){ ?>
          $(document).ready(function(){
            $('#tab1').removeClass(' active '),
            $('#tab1default').removeClass('in active '),
            $('#tab2').addClass(' active '),
            $('#tab2default').addClass('in active ')
          });  
<?php } ;

      if($_GET['tab']==='3'){ ?>
          $(document).ready(function(){
            $('#tab1').removeClass(' active '),
            $('#tab1default').removeClass('in active '),
            $('#tab3').addClass(' active '),
            $('#tab3default').addClass('in active ')
          });  
<?php } ;?>



})



</script> 
 <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>	
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.js'></script>	
 <script src='assets/js/script.js'></script>


  </body>
   <?php include_once 'template/footer.php';?>