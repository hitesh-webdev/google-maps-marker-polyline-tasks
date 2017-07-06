<html>
<head>
	<title>Google Maps JavaScript API</title>
	<style type="text/css">
		body{
			padding: 0px;
			margin: 0px;
			font-family: sans-serif;
		}
		#map{
			height: 500px;
			width: 800px;
			margin: 50 auto 0;
		}
		.search_place{
			height: 50px;
			width: 800px;
			margin: 100 auto 0;
			text-align: center;
		}
		#place_input{
			height: 40px;
			width: 400px;
			margin-left: 30px;
		}
		label{
			margin: 20px 20px 20px 0px;
		}
		input[type="radio"]{
			margin: 20px 20px 20px 0px;
		}
	</style>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7BSB-Jt2WrQiTbPoj6KUNc4LU4KmUCBU&libraries=places&callback=initMap" async defer></script>
	<script type="text/javascript">

		var map;

		var infowindow;

		var bounds;

		var i = 0;

		function initMap(){

			map = new google.maps.Map(document.getElementById('map'),{
				center: {lat: 26.845179,lng: 75.802219}, 
				zoom: 2
			});

			// Initialising global variable infowindow

			infowindow = new google.maps.InfoWindow();

			// Getting initial bounds of the map

			bounds = new google.maps.LatLngBounds();

			var input_box = document.getElementById('place_input');
			var searchBox = new google.maps.places.SearchBox(input_box);

			searchBox.addListener('places_changed',function(){
				
				var places = searchBox.getPlaces();

				var store_type = document.querySelector('input[name="store_type"]:checked').value;

				//console.log(store_type);

				//console.log(places);

				// The fetched places is an object

				places.forEach(function(place) {

					labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            		if (!place.geometry) {
              			console.log("Returned place contains no geometry");
              			return;
            		}

					var marker = new google.maps.Marker({
		            	position: place.geometry.location,
		            	map: map,
		            	label: labels[i % labels.length]
		        	});

		        	i++; // increasing the label's index

		        	// Adding zoom on click event of the marker

		        	marker.addListener('click', function(){

		        		map.setCenter(marker.position);
		        		map.setZoom(15);

		        	})

		        	// Calling the nearbySearch method of places library

	            	var service = new google.maps.places.PlacesService(map);

	            	console.log(service);

				    service.nearbySearch({
				        location: place.geometry.location,
				        radius: 2000,
				        type: [store_type]
				    }, processResults);

				    // Showing infoWindow

		        	var markerinfo = new google.maps.InfoWindow({
          				content: place.name+"<br>Click marker to zoom."
        			});

		        	markerinfo.open(map, marker);

		        	marker.addListener('click', function() {
          				markerinfo.open(map, marker);
        			});

					bounds.extend(marker.position);
				});

				map.fitBounds(bounds);

				// Changing zoom after setting bounds

				var listener = google.maps.event.addListener(map, "idle", function() { 
					console.log(map.getZoom());
			  		if (map.getZoom() > 14) map.setZoom(14); 
			  		google.maps.event.removeListener(listener); 
				});

			});

		}


		// Success callback of nearby search method

		function processResults(results, status){

			console.log(status);

			if (status !== google.maps.places.PlacesServiceStatus.OK) {
          		alert("Cannot find "+store_type+"'s near you.");
          		return;
        	}
        	else{

        		console.log('Creating markers');

        		createMarkers(results);

        	}

		}


		// Creating Markers

		function createMarkers(places) {

			console.log(places);

			for(var i = 0; i < places.length; i++){

				var place = places[i];

				//console.log(place);

				var image = {
		            url: place.icon,
		            size: new google.maps.Size(71, 71),
		            origin: new google.maps.Point(0, 0),
		            anchor: new google.maps.Point(17, 34),
		            scaledSize: new google.maps.Size(25, 25)
		        };

		        var marker = new google.maps.Marker({
		            map: map,
		            icon: image,
		            title: place.name,
		            position: place.geometry.location
		        });

		        // Adding infowindow to each marker

		        google.maps.event.addListener(marker, 'click', (function(marker,i) {
		        	return function(){

		        		console.log('infoWindow');

			          	infowindow.setContent("<b class='place_name'>"+places[i].name+"</b><br>"+places[i].vicinity);
			          	infowindow.open(map, marker);
			        }
		        })(marker,i));

			}

		}

		
	</script>
</head>
<body>
	<div class="search_place">
		Search: <input type="text" id="place_input" /><br>
		<input type="radio" value="cafe" name="store_type" id="cafe" checked/><label for="cafe">Cafe</label>
		<input type="radio" value="restaurant" name="store_type" id="restaurant"/><label for="restaurant">Restaurant</label>
		<input type="radio" value="bank" name="store_type" id="bank"/><label for="bank">Bank</label>
		<input type="radio" value="atm" name="store_type" id="atm"/><label for="atm">ATM</label>
		<input type="radio" value="bus_station" name="store_type" id="bus"/><label for="bus">Bus</label>
		<input type="radio" value="gym" name="store_type" id="gym"/><label for="gym">Gym</label>
	</div>
	<div id="map"></div>
</body>
</html>