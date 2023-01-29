<php>

	<html>
	<body>
		<?php
			/*
			$restaurant_id = $_POST["restaurant_id"];
			$remove_food = intval($_POST["num_items_remove"]);
			*/
			$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234");

			mysqli_query($connection, "USE id20217943_restaurant");
			
			$sql_cmd = "SELECT * FROM restaurants";
			$query_result = mysqli_query($connection, $sql_cmd);
			$kml_file = "<?xml version='1.0' encoding='UTF-8'?><kml xmlns='http://www.opengis.net/kml/2.2'><Document><name>Test</name>";
			while($parsed_query_result = $query_result->fetch_assoc()){
				$get_restaurant_name = $parsed_query_result["restaurant_name"];
				$get_postal_code = $parsed_query_result["postal_code"];
				$get_location = $parsed_query_result["location"];
				$get_available_food = $parsed_query_result["available_food"];
				$get_latitude = $parsed_query_result["latitude"];
				$get_longitude = $parsed_query_result["longitude"];
				$description = "🍔 " . $get_available_food . " meals available";
				//echo $description;
				
				$kml_placemark = "<Placemark><name>" . $get_restaurant_name . "</name><description>" . $description . "</description><styleUrl>#icon-1899-0288D1</styleUrl><Point><coordinates>" . $get_longitude . "," . $get_latitude . "</coordinates></Point></Placemark>";
				$kml_file = $kml_file . $kml_placemark;
				
				/*if ($restaurant_id == $parsed_query_result["restaurant_id"]) {
					$previously_available_food = $parsed_query_result["available_food"];
					$new_available_food = $previously_available_food - $remove_food;
					$sql_cmd = "UPDATE restaurants SET available_food = " . $new_available_food . " WHERE restaurant_id = " . $restaurant_id;
					mysqli_query($connection, $sql_cmd);
				}
				else {
					echo "Error: Restaurant does not exist";
				}
				*/
				
			}
			$kml_file = $kml_file . "</Document></kml>";
			echo $kml_file;
			mysqli_close($connection);
			$myfile = fopen("restaurants.kml", "w");
			fwrite($myfile, $kml_file);
			fclose($myfile);
			

		?>
		
		The restaurant id is <?php echo $_POST["restaurant_id"]; ?><br>
		The number of items available is: <?php echo $new_available_food; ?>

	</body>
</html>
</php>
