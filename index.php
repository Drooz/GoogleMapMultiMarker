<?php 
/*
 Create connection here 
*/

// Database Credentials 
$link = mysqli_connect("localhost","userDB","DBPassword","DBName");

// Check the connection 
if($link == false ){
	die("ERROR : Could not connect to the database" . mysqli_connect_error());
}

// The Select Query You can change it according to the database model 
$sql = "SELECT * FROM ( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS longt FROM natch_module_realestates_fieldval WHERE fielddef_id='33') as A join ( SELECT natch_module_realestates_fieldval.item_id ,`natch_module_realestates_fieldval`.`value` AS latt FROM natch_module_realestates_fieldval WHERE fielddef_id='34') as B join (SELECT natch_module_realestates_item.item_id ,natch_module_realestates_item.title , natch_module_realestates_item.alias AS name FROM natch_module_realestates_item) as C on A.item_id=B.item_id AND A.item_id=C.item_id";

// Get the result to result var
$result = mysqli_query($link,$sql);
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
			var locations = [ [ 'Uniproperty HQ',41.067221, 28.992060] ];// Initializing var
			
			    // Start While Loop To Loop Through The Result 
				<?php while($row = $result->fetch_assoc()){?>
				
				//Push items to the locations var which is array of points populated by the database 
		        locations.push([
		            
		           <?php 
		           $path = "http://www.uniproperty.com/realestates/".$row["item_id"]."/201/".$row["name"].".html"; // Create the URL
		           
		           $code = "<a href=$path target=_blank>View Project</a>"; // Put URL in html tag to convert it to hyperlink 
		           
		           echo "'" . $row["title"] ."</br>"."$code"."'" .",". $row["longt"]. "," . $row["latt"]; ?>// echo the needed info as following locations.push(['TEXT HERE', longt , latt]);

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
