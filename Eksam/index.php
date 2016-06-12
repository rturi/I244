<?php
/**
Loo lihtne kommentaaride lisamise vorm. Andmed salvesta tekstifaili. Kuva salvestatud kommentaare.
Lahendust mõeldes eelda, et kasutaja brauseris on lubatud nii Javascript kui ka küpsised.
 */


if (!empty($_POST)) {

    echo $_POST['name'];

    $comment_data = array();


    $comment_data['name'] = $_POST['name'];
    $comment_data['title'] = $_POST['title'];
    $comment_data['comment'] = $_POST['comment'];
    $comment_data['created_at'] = date('m/d/Y', time()); // http://stackoverflow.com/questions/5213528/convert-timestamp-to-readable-date-time-php

    //print_r($comment_data);


    $jsonComment = json_encode($comment_data);
    //print_r($jsonComment);

    //http://www.w3schools.com/php/func_filesystem_fwrite.asp
    $file = fopen("comments.json","w");

    //http://stackoverflow.com/questions/7895335/append-data-to-a-json-file-with-php
    file_put_contents('comments.json', $jsonComment);

    fclose($file);






}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="index.php" method="post">
    <table>
        <tr>
            <td>Title</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr>
            <td>Your name:</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>Your Comment:</td>
            <td><textarea rows="4" cols="50" name="comment"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Add comment"></td>
        </tr>

    </table>
</form>

</body>
</html>


