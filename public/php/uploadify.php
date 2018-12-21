<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '../images/icon'; // Relative to the root

// $verifyToken = md5('unique_salt' . $_POST['timestamp']);
if (!empty($_FILES)) {
	$tempFile = $_FILES['img_path']['tmp_name'];
	$targetFile = rtrim($targetFolder,'/') . '/' . 'admin.jpg';
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['img_path']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		$data = array(
			'success'=>1,
			'path'=>$targetFile
		);
		echo json_encode($data);
	} else {
		echo 'Invalid file type.';
	}
}
?>