<?php
	error_reporting(0);
	require 'config/config.php';
	$query = "SELECT * FROM docs WHERE ";
	$flag = 0;
	if(!empty($_POST['query'])) $query = $query."name like '%".$_POST['query']."%' and ";
	else $flag++;		
	if(!empty($_POST['type'])) 
	{
		if($_POST['type'] == 'all')
			$flag++;
		else
			$query = $query."type = '". $_POST['type'] . "' and ";
	}
	else $flag++;
	
	if( $flag == 2 ) $query = substr($query,0,-6);
	else $query = substr($query,0,-4);
	$connect = new connector();
	$result = $connect->executeQuery($query);
	if($result != false)
	{
		$i = 0;
		while ($row = $result->fetch_assoc())
		{
			$fileName = $row['name'];
			$extension = pathinfo($fileName, PATHINFO_EXTENSION); 
			$output[$i]['name'] = str_replace(".".$extension,"",$fileName);
			$output[$i]['downloadLocation'] = "uploads/".$row['id'].".".$extension;
			$output[$i]['type'] = $row['type'];
			$output[$i]['size'] = $row['size'];
			$output[$i]['uploadDate'] = $row['uploadDate'];
			$output[$i]['fileId'] = $row['id'];
			$i++;
		}
		echo json_encode($output);
	}
	else
		echo "not here"	;
?>