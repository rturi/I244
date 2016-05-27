<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 - kt 7</title>
</head>
<body>

<form action="reverser.php" method="post">
    Enter string to reverse: <input type="text" name="inputString"><br>
    <input type="submit" value="Submit">
</form>
<br><br>
<?php


if (!empty($_POST)) {
    $tmpString = $_POST["inputString"];
    echo "Original string: " . $tmpString . "<br>";
    echo "Reversed string: " . stringReverser($tmpString);
}


function stringReverser ($str){

    $answer = "";



    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        $answer = $answer . $str[$i];
    }

    return $answer;
}

?>
</body>
</html>