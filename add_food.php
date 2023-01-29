<php>

	<html>
	<body>
		<?php
			$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234"); 
			$restaurant_id = $_POST["restaurant_id"];
			$add_food = intval($_POST["num_items_add"]);
			mysqli_query($connection, "USE id20217943_restaurant");
			
			$sql_cmd = "SELECT * FROM restaurants";
			$query_result = mysqli_query($connection, $sql_cmd);
			while($parsed_query_result = $query_result->fetch_assoc()){
				if ($restaurant_id == $parsed_query_result["restaurant_id"]) {
					$previously_available_food = $parsed_query_result["available_food"];
					$new_available_food = $previously_available_food + $add_food;
					$sql_cmd = "UPDATE restaurants SET available_food = " . $new_available_food . " WHERE restaurant_id = " . $restaurant_id;
					mysqli_query($connection, $sql_cmd);
				}
				
			}
			
			
			mysqli_close($connection);

		?>
		
		<script>
		wait = setTimeout(go_back, 5000);
		
		function go_back(){
			history.back()
		}
	    </script>
		
		<p style="color:white">Success! Redirecting back in 5s.</p>
		<iframe src = https://foodavalanche.000webhostapp.com/updateKML.php">

	</body>
</html>
</php>
