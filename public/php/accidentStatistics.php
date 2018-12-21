<?php
 header('Content-type:application/json');
    $json_string = file_get_contents('../data/accidentStatistics.json');
    echo $json_string;
?>