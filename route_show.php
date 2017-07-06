<html>
<head>
	<title>Google Maps JavaScript API</title>
	<style type="text/css">
		body{
			padding: 0px;
			margin: 0px;
		}
		#map{
			height: 500px;
			width: 800px;
			margin: 100 auto 0;
		}
	</style>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7BSB-Jt2WrQiTbPoj6KUNc4LU4KmUCBU&libraries=places&callback=initMap" async defer></script>
	<script type="text/javascript">

		var map;

		var i = 1;

		var markers = [];

		var flightPath;

		function initMap(){

			map = new google.maps.Map(document.getElementById('map'),{
				center: {lat: 26.845179,lng: 75.802219}, 
				zoom: 4
			});


			// Adding click listener on the map

			map.addListener('click', function(event){

				var marker = new google.maps.Marker({
		            position: event.latLng,
		            map: map,
		            label: i.toString()
		        });

		        console.log(marker);

				// Increasing marker label counter(global)

		        i++;

		        // Inserting the created marker into the markers array(global)

		        markers.push(marker);

		        // Adding click listener on the map

		        marker.addListener('click',function(){

		        	// Removing this marker from the map

		        	this.setMap(null);

		        	// Decreasing marker label counter(global)

		        	i--;

		        	// Removing current marker from the markers array(global)

		        	var index = markers.indexOf(this);

				    if (index > -1) {
				       markers.splice(index, 1);
				    }

				    // Renaming left markers in the markers array(global)

		        	for(var j = 0; j < markers.length; j++){

		        		markers[j].setLabel((j+1).toString());

		        	}

		        	// Re-render Polyline

		        	renderPolyline();

		        });


		        // Render PolyLine

		        renderPolyline();


			});


		}

		function renderPolyline(){

			// Inserting updated maker coordinates(global) for rendering polyline

			var coords = [];

			for(var j = 0; j < markers.length; j++){

				coords.push(markers[j].position);

			}

			if(flightPath){

				// If flightpath is defined (filepath.setMap(null) removes just the last edge)

				flightPath.setPath(coords);

			}
			else{

				// First time rendering of the edge

				flightPath = new google.maps.Polyline({
	          		path: coords,
	          		geodesic: true,
	          		strokeColor: '#FF0000',
	          		strokeOpacity: 1.0,
	          		strokeWeight: 2
	        	});

				flightPath.setMap(map);

			}
		}

		
	</script>
</head>
<body>
	<div id="map"></div>
</body>
</html>