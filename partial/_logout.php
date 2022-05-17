<?php
    session_start();
    
    echo 'loggin you out...please wait';
    session_unset();
    session_destroy();
    header("Location: /forum/index.php");

?>