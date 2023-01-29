<php>

	<html>
	<body>
		<?php
			$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234"); 
			$restaurant_id = $_POST["restaurant_id"];
			mysqli_query($connection, "USE id20217943_restaurant");
			
			$sql_cmd = "SELECT * FROM restaurants";
			$query_result = mysqli_query($connection, $sql_cmd);
			while($parsed_query_result = $query_result->fetch_assoc()){
				if ($restaurant_id == $parsed_query_result["restaurant_id"]) {
					$previously_available_food = $parsed_query_result["available_food"] . "<br />";
					echo "Restaurant Name: " . $parsed_query_result["restaurant_name"] . "<br />";
					echo "Meals available to give: " . $parsed_query_result["available_food"] . "<br />";
					echo "Total number of meals given: " . $parsed_query_result["total_given"] . "<br />";
					
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
		
		<button onClick = "go_back()">Return to Restaurant Dashboard</button>

	</body>
</html>
</php>
