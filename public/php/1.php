<?php
    echo 2;
    $userName = $_POST('userName');
    $pwd = $_POST('pwd');
    if($userName == '1' && $pwd == '1'){
        echo '<script>location.href="index1.html"</script>';
    }else {
        echo 0;
    }
    
?>