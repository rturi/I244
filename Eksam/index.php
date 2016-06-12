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


    $jsonComment = json_encode($comment_data);

    //http://www.w3schools.com/php/func_filesystem_fwrite.asp
    //http://stackoverflow.com/questions/7895335/append-data-to-a-json-file-with-php

    $json = file_get_contents('comments.json');

    $data = array();
    $data = json_decode($json, true);
    $data[] = $comment_data;
    file_put_contents('comments.json', json_encode($data));


    $output_comments = array();





}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eksam - I244 - Roland Türi</title>
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


