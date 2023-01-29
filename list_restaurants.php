<html>
    <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Map</title>
    <style>
      html, body {
        height: 100%;
        padding: 0;
        margin: 0;
        }
      #map {
       height: 60%;
       width: 100%;
       overflow: hidden;
       float: left;
       border: thin solid #333;
       }
      #capture {
       min-height: 0%;
       width: 100%;
       overflow: hidden;
       float: left;
       background-color: #ECECFB;
       border: thin solid #333;
       border-left: none;
       }
    </style>
    </head>

    <body>
    <div id="map"></div>
    <div id="capture"></div>
    <script>
      var map;
      var src = 'https://foodavalanche.000webhostapp.com/restaurants.kml';
      let destLat = 44.2342986;
      let destLng = -76.4967884;
      
      function changeURL(des_long, des_lat) {
		destLat = des_lat;
		destLng = des_long;
		initMap();
        }
      
      function initMap() {
        navigator.geolocation.getCurrentPosition(function(position) {
        let currentLat = position.coords.latitude;
        let currentLng = position.coords.longitude;

        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: currentLat, lng: currentLng },
          zoom: 2,
          mapTypeId: 'terrain'
        });

        var kmlLayer = new google.maps.KmlLayer(src, {
          suppressInfoWindows: true,
          preserveViewport: false,
          map: map
        });

        kmlLayer.addListener('click', function(event) {
          var content = event.featureData.infoWindowHtml;
          var testimonial = document.getElementById('capture');
          testimonial.innerHTML = content;
        });

        var directionsRenderer = new google.maps.DirectionsRenderer();
        var directionService = new google.maps.DirectionsService();
        directionsRenderer.setMap(map);
        directionsRenderer.setOptions({
        travelMode: 'WALKING'
        });

        var request = {
            origin: `${currentLat},${currentLng}`,
            destination: `${destLat},${destLng}`,
            travelMode: 'WALKING'
        };

        directionService.route(request, function(response, status) {
        if (status === 'OK') {
            directionsRenderer.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
        });

        });
      }

    </script>
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZxMCEEnY4L_SteBz4wsFTvpQ8TNAfyL8&callback=initMap">
    </script>
	<?php
		error_reporting(E_ALL & ~E_WARNING);
		/*
		try {
			$restaurant_id_number = $_GET["resNum"];
		} catch (Exception $e) {
			echo "";
		}
		*/
		$user_longitude = $_GET["longitude"];
		$user_latitude = $_GET["latitude"];
		
	//	echo "user_longitude, user_latitude" . $user_longitude . " " . $user_latitude . "<br />";
		
		$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234");
		mysqli_query($connection, "USE id20217943_restaurant");
		
		$sql_cmd = "SELECT * FROM restaurants";
		$query_result = mysqli_query($connection, $sql_cmd);
		$restaurant_list = array();
		while($parsed_query_result = $query_result->fetch_assoc()){
			$restaurant_id = $parsed_query_result["restaurant_id"];
			$restaurant_name = $parsed_query_result["restaurant_name"];
			$postal_code = $parsed_query_result["postal_code"];
			$location = $parsed_query_result["location"];
			$available_food = $parsed_query_result["available_food"];
			$total_given = $parsed_query_result["total_given"];
			$longitude = $parsed_query_result["longitude"];
			$latitude = $parsed_query_result["latitude"];
			
			$information_restaurant = array(
				$restaurant_id, //0
				$restaurant_name, //1
				$postal_code, //2
				$location, //3
				$available_food, //4
				$total_given, //5
				$longitude, //6
				$latitude //7
			);
		
			array_push($restaurant_list, $information_restaurant);
				
		}
		//print_r($restaurant_list);
		$num_restaurants = count($restaurant_list);
		for ($outter = 0; $outter < $num_restaurants; $outter++) {
			for ($inner = 0; $inner < ($num_restaurants - 1); $inner++){ 
			$restaurant_distance = pow(($restaurant_list[$inner][6] - $user_longitude), 2) + pow(($restaurant_list[$inner][7] - $user_latitude), 2);
			$next_restaurant_distance = pow(($restaurant_list[$inner+1][6] - $user_longitude), 2) + pow(($restaurant_list[$inner+1][7] - $user_latitude), 2);
			if ($restaurant_distance > $next_restaurant_distance) {
				$temporary_store = $restaurant_list[$inner];
				$restaurant_list[$inner] = $restaurant_list[$inner+1];
				$restaurant_list[$inner+1] = $temporary_store;
				
			}
			}
		}
		
		$i = 0;
		while ($i < count($restaurant_list)) {
			if ($restaurant_list[$i][4] == 0) {
				unset($restaurant_list[$i]);
				$restaurant_list = array_values($restaurant_list);
				$i = 0;
			} else {
				$i++;
			}
		}
		
		//print_r($restaurant_list);		
		for ($i = 0; $i < min(count($restaurant_list), 5); $i++) {
			echo "<button onClick='changeURL(" . $restaurant_list[$i][6] . "," . $restaurant_list[$i][7] . ")'><b>" . $restaurant_list[$i][1] . "</b> <br />" . $restaurant_list[$i][3] . ", Kingston, ON <br /> 🍔 " . $restaurant_list[$i][4] . " meals available <br /></button><br /><br />";
		}
		mysqli_close($connection);
	?>
    </body>
</html>