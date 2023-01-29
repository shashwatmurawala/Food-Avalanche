<php>

	<html>
	<body>
		<?php
		$connection = new mysqli("localhost", "id20217943_admin", "RootAdmin#1234"); 
		$restaurant_id = $_POST["restaurant_id"];
		$available_food = $_POST["num_items_available"];
		mysqli_query($connection, "USE id20217943_restaurant");
		$sql_cmd = "UPDATE restaurants SET available_food = " . $available_food . " WHERE restaurant_id = " . $restaurant_id;
		mysqli_query($connection, $sql_cmd);
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