<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbName = "utask";

    $dbc = mysqli_connect($host, $username, $password); //connect database
    mysqli_select_db($dbc, $dbName); //select database
?>