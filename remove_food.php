<php>

	<html>
	<body>
		<?php
			$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234"); 
			$restaurant_id = $_POST["restaurant_id"];
			$remove_food = intval($_POST["num_items_remove"]);
			mysqli_query($connection, "USE id20217943_restaurant");
			
			$sql_cmd = "SELECT * FROM restaurants";
			$query_result = mysqli_query($connection, $sql_cmd);
			while($parsed_query_result = $query_result->fetch_assoc()){
				if ($restaurant_id == $parsed_query_result["restaurant_id"]) {
					$previously_available_food = $parsed_query_result["available_food"];
					$total_given = $parsed_query_result["total_given"];
					$new_available_food = $previously_available_food - $remove_food;
					$total_given = $total_given + $remove_food;
					$sql_cmd = "UPDATE restaurants SET available_food = " . $new_available_food . " WHERE restaurant_id = " . $restaurant_id;
					mysqli_query($connection, $sql_cmd);
					
					$sql_cmd = "UPDATE restaurants SET total_given = " . $total_given . " WHERE restaurant_id = " . $restaurant_id;
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


	</body>
</html>
</php>
