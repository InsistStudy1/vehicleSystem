<?php
    header('Content-type:application/json');
	//$page = $_GET['page'];
    $json_string = file_get_contents('../data/selectDriverData.json');
    echo $json_string;
?>