 
<?php

// CREATE TABLE markers (
  // id INT(11) default none auto_increment,
  // name varchar(60) default none,
  // address varchar(80) default none,
  // lat float (10,6) default none,
  // lng float(10,6) default none, 
  // type varchar (30) default none	
  // PRIMARY KEY (id)
// ) ENGINE=MyISAM


?>



<?php include_once 'includes/User.php'; 
 		$user=new User();	
	?>
	<!DOCTYPE html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
     
	<meta charset="UTF-8">
    <title>Google Maps JavaScript API Example: Map Simple</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEZ5RlhXnEkXC3G34ZTb_lOVjVOXQuFkA"
            type="text/javascript"></script>
    <script type="text/javascript">
	
	  var myJsarray = <?= json_encode($user->getFromMap()); ?>;
	  var pos ;
	  var infowindow = new google.maps.InfoWindow({
    content: ''
});
	 
	
	function init(){
		var center={lat:45.547509 ,lng:19.789974};
		var map=new google.maps.Map(document.getElementById('map'),{
			zoom:15,
			center:center,
			animation: google.maps.Animation.DROP
		});
		
		 for(i=0;i<myJsarray.length;i++){
			console.log("Initialize funkc "+myJsarray[i].name );
			//addMarker1(myJsarray[i].name,myJsarray[i].address,myJsarray[i].lat,myJsarray[i].lng,myJsarray[i].type);
			pos = new google.maps.LatLng(myJsarray[i].lat, myJsarray[i].lng);
			var content=myJsarray[i].name;
			console.log("pos "+pos);
			
			var marker=new google.maps.Marker({
			position:pos,
			map:map,
			content:content
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
             map.setZoom(20);
        }
		
    })(marker, content));
	  }
		
	
		
	}
	</script>
	  </head>

  <body style="margin:0px; padding:0px;" onload="init()">
  
    <div id="map" style="width: 500px; height: 300px"></div>
    <div id="message"></div>
	
	
	 
 <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>	
  </body>

 
<?php

// CREATE TABLE markers (
  // id INT(11) default none auto_increment,
  // name varchar(60) default none,
  // address varchar(80) default none,
  // lat float (10,6) default none,
  // lng float(10,6) default none, 
  // type varchar (30) default none	
  // PRIMARY KEY (id)
// ) ENGINE=MyISAM


?>



<?php include_once 'includes/User.php'; 
 		$user=new User();	
	?>
	<!DOCTYPE html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
     
	<meta charset="UTF-8">
    <title>Google Maps JavaScript API Example: Map Simple</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEZ5RlhXnEkXC3G34ZTb_lOVjVOXQuFkA"
            type="text/javascript"></script>
    <script type="text/javascript">
	
	  var myJsarray = <?= json_encode($user->getFromMap()); ?>;
	  var pos ;
	  var infowindow = new google.maps.InfoWindow({
    content: ''
});
	 
	
	function init(){
		var center={lat:45.547509 ,lng:19.789974};
		var map=new google.maps.Map(document.getElementById('map'),{
			zoom:15,
			center:center,
			animation: google.maps.Animation.DROP
		});
		
		 for(i=0;i<myJsarray.length;i++){
			console.log("Initialize funkc "+myJsarray[i].name );
			//addMarker1(myJsarray[i].name,myJsarray[i].address,myJsarray[i].lat,myJsarray[i].lng,myJsarray[i].type);
			pos = new google.maps.LatLng(myJsarray[i].lat, myJsarray[i].lng);
			var content=myJsarray[i].name;
			console.log("pos "+pos);
			
			var marker=new google.maps.Marker({
			position:pos,
			map:map,
			content:content
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
             map.setZoom(20);
        }
		
    })(marker, content));
	  }
		
	
		
	}
	</script>
	  </head>

  <body style="margin:0px; padding:0px;" onload="init()">
  
    <div id="map" style="width: 500px; height: 300px"></div>
    <div id="message"></div>
	
	
	 
 <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>	
  </body>

 
</html>