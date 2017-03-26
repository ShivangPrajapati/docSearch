<?php
	header('Content-type : application/json',true);
	require 'config/config.php';
	$connect = new connector();

	if(isset($_POST['fileName']))
	{
		$query = "SELECT * FROM docs WHERE name = ".$_POST['fileName'];

		$connect = new connector();
		$result = $connect->executeQuery($query);

		if($result->num_rows == 0)
		{
			echo "There does not exist given file";
		}
		else
		{
			$no = $result->num_rows;
			$query = "DELETE FROM docs WHERE name = ".$_POST['fileName'];
			$result = $connect->executeQuery($query);

			if(!$result)
				echo "Sorry something went wrong";
			else
				echo "Successfully deleted ".$no." files";
		}	
	}
	else if(isset($_POST['req']))
	{
		$query = "SELECT * FROM docs";
		$result = $connect->executeQuery($query);
		if($result->num_rows == 0);
		else
		{
			$i = 0;
			while ($row = $result->fetch_assoc())
			{
				$fileName = $row['name'];
				$extension = pathinfo($fileName, PATHINFO_EXTENSION); 
				$name = str_replace(".".$extension,"",$fileName);
				$output[$name] = 'null';
			}
			echo json_encode($output);
		}

	}
?>