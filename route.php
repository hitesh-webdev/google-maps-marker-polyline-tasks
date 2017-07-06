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
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7BSB-Jt2WrQiTbPoj6KUNc4LU4KmUCBU&callback=initMap" async defer></script>
	<script type="text/javascript">

		var map;

		var i = 1;

		var markers = [];

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

				// Increasing marker label counter(global)

		        i++;

		        // Inserting the created marker into the markers array(global)

		        markers.push(marker);

		        // Adding click listener on the map

		        marker.addListener('click',function(){

		        	// Removing this marker from the map

		        	this.setMap(null);

		        	var index = markers.indexOf(this);

				    if (index > -1) {
				       markers.splice(index, 1);
				    }

		        	createMarkers(markers);

		        });

			});



		}

		function createMarkers(coords){

			markers = [];

			var n = 1;

			for(var j = 0; j < coords.length; j++){

				coords[j].setMap(null);

				var marker = new google.maps.Marker({
		            position: coords[j].position,
		            map: map,
		            label: n.toString()
		        });

		        markers.push(marker);

		        marker.addListener('click',function(){

		        	this.setMap(null);

		        	var index = markers.indexOf(this);

				    if (index > -1) {
				       markers.splice(index, 1);
				    }

		        	createMarkers(markers);

		        });

		        console.log(marker);

		        n++;

			}

			i = n;

		}
		
	</script>
</head>
<body>
	<div id="map"></div>
</body>
</html>