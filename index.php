<?php 
/*
 Create connection here 
*/

// Database Credentials 

$link = mysqli_connect("localhost","DBuser","DBpass","DBname");

// Check the connection 
if($link == false ){
	die("ERROR : Could not connect to the database " . mysqli_connect_error());
}
// The Select Query You can change it according to the database model 
$sql = "SELECT * FROM 

( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS longt FROM natch_module_realestates_fieldval WHERE fielddef_id='33') as A 


join 

( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS latt FROM natch_module_realestates_fieldval WHERE fielddef_id='34') as B 


join 


(SELECT natch_module_realestates_item.item_id ,natch_module_realestates_item.title , natch_module_realestates_item.alias AS name FROM natch_module_realestates_item) as C 

join 

(SELECT item_id , filename , position FROM natch_module_realestates_images WHERE position = 2) as K


on A.item_id=B.item_id AND A.item_id=C.item_id AND K.item_id = A.item_id";

$sql2 = "SELECT * FROM 

( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS longt FROM natch_module_realestates_fieldval WHERE fielddef_id='33') as A 


join 

( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS latt FROM natch_module_realestates_fieldval WHERE fielddef_id='34') as B 


join 


(SELECT natch_module_realestates_item.item_id ,natch_module_realestates_item.title , natch_module_realestates_item.alias AS name FROM natch_module_realestates_item) as C 

join 

(SELECT item_id , filename , position FROM natch_module_realestates_images WHERE position = 2) as K


on A.item_id=B.item_id AND A.item_id=C.item_id AND K.item_id = A.item_id AND (C.title = '".$_GET["rec1"]."' OR C.title = '".$_GET["rec2"]."' OR C.title = '".$_GET["rec3"]."' )";




// Get the result to result var
$result = mysqli_query($link,$sql);
$result2 = mysqli_query($link,$sql2);


?>

<!-- https://developers.google.com/maps/documentation/javascript/tutorial#Audience -->

<!DOCTYPE html>

<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		
		
		<!--Style START-->
		<style type="text/css">
		html{ height:100%; }
		body{ height:100%; margin:0; padding:0; }
		#map_canvas{ height:100%; width:100%; }
		</style>
		<!--Style END-->
		
		<!--Google Map API Code START-->
		<script type="text/javascript">
		function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
		    if ((new Date().getTime() - start) > milliseconds){
		      break;
		    }
		  }
		}
		
		function initialise() {
			// create object literal to store map properties
			var myOptions = {
				zoom: 8 // set zoom level
				, mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
			};
			
			// create map object and apply properties
			var map = new google.maps.Map( document.getElementById( "map_canvas" ), myOptions );
			
			// create map bounds object
			var bounds = new google.maps.LatLngBounds();
			// create array containing locations from sql query
						// Featured Locations 
			var flocations = [ [ 'Uniproperty HQ',41.067221, 28.992060] ];

			    // Start While Loop To Loop Through The Result 
				<?php while($row2 = $result2->fetch_assoc()){?>
				
				//Push items to the locations var which is array of points populated by the database 
		        flocations.push([
		            
		           <?php 
		           $path2 = "http://www.uniproperty.com/realestates/".$row2["item_id"]."/201/".$row2["name"].".html"; // Create the URL
		           
		           $linkStyle2 = "text-align:right";
		           
		           $code2 = "<a href=$path target=_blank><p style=$linkStyle>View Project</a>"; // Put URL in html tag to convert it to hyperlink 
		           
		           $imgPath2 = "http://www.uniproperty.com/uploads/_realestates/id".$row2["item_id"]."/gallery/".$row2["filename"];// Creating the img link
		           
		           $imgStyle2 = "width:200px;height:150px;";
		           
		           $img2 = "<img src=$imgPath2 style=$imgStyle2>";// Put the image into html tag
		           
		           echo "'" ."$img2"."</br>". $row2["title"] ."$code2"."'" .",". $row2["longt"]. "," . $row2["latt"]; ?>
		           // echo the needed info as following locations.push(['TEXT HERE', longt , latt]);
		            ]); // END OF PUSH FUNCTION
				
				
				<?php } ?>// END Of The While Loop
	
			
			var locations = [ [ 'Uniproperty HQ',41.067221, 28.992060] ];// Initializing var
			
			    // Start While Loop To Loop Through The Result 
				<?php while($row = $result->fetch_assoc()){?>
				
				//Push items to the locations var which is array of points populated by the database 
		        locations.push([
		            
		           <?php 
		           $path = "http://www.uniproperty.com/realestates/".$row["item_id"]."/201/".$row["name"].".html"; // Create the URL
		           
		           $linkStyle = "text-align:right";
		           
		           $code = "<a href=$path target=_blank><p style=$linkStyle>View Project</a>"; // Put URL in html tag to convert it to hyperlink 
		           
		           $imgPath = "http://www.uniproperty.com/uploads/_realestates/id".$row["item_id"]."/gallery/".$row["filename"];// Creating the img link
		           
		           $imgStyle = "width:200px;height:150px;";
		           
		           $img = "<img src=$imgPath style=$imgStyle>";// Put the image into html tag
		           
		           echo "'" ."$img"."</br>". $row["title"] ."$code"."'" .",". $row["longt"]. "," . $row["latt"]; ?>// echo the needed info as following locations.push(['TEXT HERE', longt , latt]);
		            ]); // END OF PUSH FUNCTION
				
				
				<?php } ?>// END Of The While Loop
				
				
				
				
				
				
			// loop through locations and add to map
			for ( var i = 0; i < locations.length; i++ )
			{
				// get current location
				var location = locations[ i ];
				
				// create map position
				var position = new google.maps.LatLng( location[ 1 ], location[ 2 ] );
				
				// add position to bounds
				bounds.extend( position );
				
				// create marker (https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
				var marker = new google.maps.Marker({
					animation: google.maps.Animation.DROP
					, icon: "http://map.uniproperty.com/img/iconMap.png"
					, map: map
					, position: position
					, title: location[ 0 ]
				});
				
				// create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
				google.maps.event.addListener( marker, 'click', ( 
					function( marker, i ) {
						return function() {
							var infowindow = new google.maps.InfoWindow();
							infowindow.setContent( locations[ i ][ 0 ] );
							infowindow.open( map, marker );
						}
					}
				)( marker, i ) );
			};	
				
				sleep(2000);// Delay to render red points 
				
		    // loop through locations and add to map
			for ( var i = 0; i < flocations.length; i++ )
			{
				// get current location
				var location = flocations[ i ];
				
				// create map position
				var position = new google.maps.LatLng( location[ 1 ], location[ 2 ] );
				
				// add position to bounds
				bounds.extend( position );
				
				// create marker (https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
				var featuredMarker = new google.maps.Marker({
					animation: google.maps.Animation.DROP
					, icon: "http://map.uniproperty.com/img/iconMap-red.png"
					, map: map
					, position: position
					, title: location[ 0 ]
				});
				
				
				// create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
				google.maps.event.addListener( featuredMarker, 'click', ( 
					function( featuredMarker, i ) {
						return function() {
							var infowindow = new google.maps.InfoWindow();
							infowindow.setContent( flocations[ i ][ 0 ] );
							infowindow.open( map, featuredMarker );
						}
					}
				)( featuredMarker, i ) );
			};
			
				
				
				
				
				
				

			
			
			
			






			// fit map to bounds
			map.fitBounds( bounds );
		}
		// load map after page has finished loading
		function loadScript() {
			var script = document.createElement( "script" );
			script.type = "text/javascript";
			script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyACspF5wnv03bC0yJlKi_mFNn6nsmCQclg&sensor=false&callback=initialise"; // initialize method called using callback parameter
			document.body.appendChild( script );
		}
		window.onload = loadScript;		
		</script>
		<!--Google Map API Code END-->
		<?php 
		// Close Connection When Done 
		$link->close();
		?>
	</head>

	<body>
		<!-- map container -->
		<div id="map_canvas"><noscript><p>JavaScript is required to render the Google Map.</p></noscript></div>
		<!-- Footer container -->
		<div id="footer" ><a href="https://github.com/drooz" target="_blank">Codded By Dr.ooz</a></div>
	</body>
</html>
