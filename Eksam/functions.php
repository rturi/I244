<?php


function start_session() {
    session_start();

    $_SESSION['token'] = sha1(session_id() . "kala");
}



function show_comments() {
    if (!empty($_POST) && !empty($_POST['name']) && !empty($_POST['title']) && !empty($_POST['comment'])) {

        $comment_data = array();
        $comment_data['name'] = $_POST['name'];
        $comment_data['title'] = $_POST['title'];
        $comment_data['comment'] = $_POST['comment'];
        $comment_data['created_at'] = date('m/d/Y', time()); // http://stackoverflow.com/questions/5213528/convert-timestamp-to-readable-date-time-php


        $jsonComment = json_encode($comment_data);

        //http://www.w3schools.com/php/func_filesystem_fwrite.asp
        //ll

        //http://stackoverflow.com/questions/7895335/append-data-to-a-json-file-with-php

        $json = file_get_contents('comments.json');

        $data = array();
        $data = json_decode($json, true);
        $data[] = $comment_data;
        file_put_contents('comments.json', json_encode($data));


        $output_comments = array();

        //http://stackoverflow.com/questions/19758954/get-data-from-json-file-with-php
        $json_comments = file_get_contents('comments.json');
        $output_comments = json_decode($json_comments, true); // decode the JSON into an associative array

    } else {
        $_SESSION['errors']['empty_field'] = "Please fill out all fields.";
    }

    include_once('views/head.php');
    include('views/comments.php');
    include_once('views/foot.php');

}


?>