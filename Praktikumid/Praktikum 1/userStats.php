<?php

    // Table in enos.itcollege.ee:
    // CREATE TABLE rturi_stats (id integer PRIMARY KEY auto_increment, ip varchar(45), time datetime)

    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));

    // php and mysql datetime compatibility http://stackoverflow.com/questions/2215354/php-date-format-when-inserting-into-datetime-in-mysql
    $visitTime = date("Y-m-d H:i:s");
    $visitorAddress = $_SERVER['REMOTE_ADDR'];

    // Insert visitors IP ind current time to DB
    $insertVisitQuery = "INSERT INTO rturi_stats (ip, time) VALUES ('" . $visitorAddress . "', '" . $visitTime . "');";
    mysqli_query($connection, $insertVisitQuery) or die("Ei saanud kirjet lisatud - ".mysqli_error($connection));

    // query how many visits there have been from users IP
    $selectNumberOfVisitsQuery = "SELECT * FROM rturi_stats WHERE ip = '" . $visitorAddress . "';";

    //row count code copied from http://php.net/manual/en/mysqli-stmt.num-rows.php
    if ($stmt = mysqli_prepare($connection, $selectNumberOfVisitsQuery)) {

        /* execute query */
        mysqli_stmt_execute($stmt);

        /* store result */
        mysqli_stmt_store_result($stmt);

        $numberOfVisits = mysqli_stmt_num_rows($stmt);

        /* close statement */
        mysqli_stmt_close($stmt);
    }

    // get the earliest visit datetime from DB
    // some help from mysqli tutorial http://codular.com/php-mysqli
    $selectEarliestVisitQuery = "SELECT MIN(time) FROM rturi_stats WHERE ip ='88.196.181.145';";
    $earliestVisitQueryResult = mysqli_query($connection, $selectEarliestVisitQuery) or die("Kõige varasema külstuse aja päring ebaõnnestus - ".mysqli_error($connection));
    $resultRow = $earliestVisitQueryResult -> fetch_assoc();
    $earliestVisit = $resultRow['MIN(time)'];

    echo "Sinu IP aadress on " . $_SERVER['REMOTE_ADDR'] . "<br><br>";
    echo "See on sinu " . $numberOfVisits . ". külastus sellel lehel. Esimene külastus oli " . $earliestVisit;

    mysqli_close($connection);
?>
