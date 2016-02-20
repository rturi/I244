<?php
    $logfile = "log.txt";
    $counter = file_get_contents($logfile);
    $counter = $counter + 1;
    file_put_contents($logfile, $counter);
    echo "lehe külastuste arv on: " . $counter;
?>