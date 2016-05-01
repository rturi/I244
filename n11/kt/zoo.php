<?php

//http://enos.itcollege.ee/~rturi/I244/n11/kt/zoo.php

/*Tee lahti lehekülg enos.itcollege.ee/phpmyadmin VÕI kui kasutad Linuxit, võid kasutada ka käsurida (kuidas andmebaasile ligi pääseda loe moodle-st siit)
Kes kasutavad phpMyAdmin-i võiksid (vähemalt täna) kasutada peamiselt SQL päringute vaadet. Edaspidi võite kasutada mida iganes.

Luua uus tabel 'loomaaed', kus on järgnevad väljad:
id - täisarv, automaatselt suurenev primaarvõti
nimi - tekstiline väärtus
vanus - täisarv
liik - tesktiline väärtus
puur - täisarv

Täita eelnevalt loodud tabel vähemalt 5 reaga.
Sisestamisel valida andmed nii, et mõned loomad jagavad samat puuri ja mõnest liigist on mitu looma.

Koostada järgnevad päringud:
Hankida kõigi mingis ühes kindlas puuris elavate loomade nimi ja puuri number
Hankida vanima ja noorima looma vanused
hankida puuri number koos selles elavate loomade arvuga (vihjeks: group by ja count )
suurendada kõiki tabelis olevaid vanuseid 1 aasta võrra
NB! iga punkti kohta 1 päring!
 */

$host="localhost";
$user="test";
$pass="t3st3r123";
$db="test";

// From tutorial http://www.w3schools.com/php/php_mysql_select.asp

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {

    //q0: SELECT *
    $q0 = "SELECT * FROM rturi_zoo;";
    $result0 = $connection->query($q0);


    //q1: Hankida kõigi mingis ühes kindlas puuris elavate loomade nimi ja puuri number
    $q1 = "SELECT name, cage FROM rturi_zoo WHERE cage = 5;";
    $result1 = $connection->query($q1);

    //q2: Hankida vanima ja noorima looma vanused
    $q2 = "SELECT MAX(age) as oldest, MIN(AGE) as youngest FROM rturi_zoo;";
    $result2 = $connection->query($q2);


    //q3: hankida puuri number koos selles elavate loomade arvuga (vihjeks: group by ja count )
    $q3 = "SELECT cage, count(id) as no_of_specimens FROM `rturi_zoo` GROUP BY cage;";
    $result3 = $connection->query($q3);

    //q4: suurendada kõiki tabelis olevaid vanuseid 1 aasta võrra
    $q4 = "UPDATE `rturi_zoo` SET `age`= age + 1;";
    $result4 = $connection->query($q4);

}

$connection->close();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>


<?php

echo $q0 . "<br><br>";
if ($result0->num_rows > 0) {
    // output data of each row
    while($row = $result0->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " Age: " . $row["age"] .  " Species: " . $row["species"]. " Cage: " . $row["cage"]. "<br>";
    }
} else {
    echo "0 results";
}
echo "<br>";


echo $q1 . "<br><br>";
if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {
        echo "Name: " . $row["name"]. " Cage: " . $row["cage"]. "<br>";
    }
} else {
    echo "0 results";
}
echo "<br>";


echo $q2 . "<br><br>";
if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
        echo "Oldest: " . $row["oldest"]. " - Youngest: " . $row["youngest"]. "<br>";
    }
} else {
    echo "0 results";
}
echo "<br>";

echo $q3 . "<br><br>";
if ($result3->num_rows > 0) {
    // output data of each row
    while($row = $result3->fetch_assoc()) {
        echo "Cage: " . $row["cage"]. " - Number of animals: " . $row["no_of_specimens"]. "<br>";
    }
} else {
    echo "0 results";
}
echo "<br>";

echo $q4 . "<br><br>";
echo "refresh to see the numbers grow";
echo "<br>";


?>



</body>
</html>
