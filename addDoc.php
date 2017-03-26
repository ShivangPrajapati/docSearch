<?php
	require "config/config.php";
	$connect = new connector();
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
    	$uploadedFile = $_FILES['file']['tmp_name'];
    	$uploadedFileName = $_FILES['file']['name'];
        $uploadedFileSize = ($_FILES['file']['size'])/1024;
    	$extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    	$type = checkExtension(strtolower($extension));
    	$uploadTime = time();
        move_uploaded_file($uploadedFile, 'uploads/'.$connect->getLastestId().".".$extension);
    	$query = "INSERT INTO docs ( name , type , size, uploadDate ) VALUES ('".$uploadedFileName."','".$type."',".$uploadedFileSize.",".$uploadTime.")";
    	$connect->executeQuery($query);
    	echo "File Uploaded Successfully!";
    }
?>