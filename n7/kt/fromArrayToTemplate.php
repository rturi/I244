<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php

$kassid= array(
    array('nimi'=>'Miisu', 'vanus'=>2),
    array('nimi'=>'Tom', 'vanus'=>1),
    array('nimi'=>'Liisu', 'vanus'=>2),
    array('nimi'=>'Kiisu', 'vanus'=>2),
    array('nimi'=>'Triibu', 'vanus'=>2),
    array('nimi'=>'Täpi', 'vanus'=>2),
    array('nimi'=>'Juti', 'vanus'=>3),
    array('nimi'=>'Aevastaja', 'vanus'=>5),
    array('nimi'=>'Unimüts', 'vanus'=>2),
    array('nimi'=>'Häbelik', 'vanus'=>3),
    array('nimi'=>'Toriseja', 'vanus'=>42),
    array('nimi'=>'Himpel', 'vanus'=>22),
    array('nimi'=>'Hampel', 'vanus'=>22),
    array('nimi'=>'Jõnnu', 'vanus'=>42),
    array('nimi'=>'Dilidon', 'vanus'=>24),
);

foreach($kassid as $kass) {
    include "template.html";
}

?>

</body>
</html>