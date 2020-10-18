<?php
    if ($_SESSION['error']) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        exit();
    }
    echo 'HTTP/1.0 404 Not Found';
