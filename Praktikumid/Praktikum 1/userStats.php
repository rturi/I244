<?php

//CREATE TABLE rturi_stats (id integer PRIMARY KEY auto_increment, ip varchar(45), time datetime)

    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));

    $visitTime = date("Y-m-d H:i:s");
    $visitorAddress = $_SERVER['REMOTE_ADDR'];
    $insertVisitQuery = "INSERT INTO rturi_stats (ip, time) VALUES ('" . $visitorAddress . "', '" . $visitTime . "');";

    mysqli_query($connection, $insertVisitQuery) or die("Ei saanud kirjet lisatud - ".mysqli_error($connection));

    mysqli_close($connection);
?>