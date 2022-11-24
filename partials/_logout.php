<?php
    session_start();
    echo "Wait...";
    session_destroy();
    header("Location: /index.php");
?>