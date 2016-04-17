<?php

function show_main_page() {
    include_once('view/head.html');
    include('view/main_page.html');
    include_once('view/foot.html');
}


function show_gallery() {
    include_once('view/head.html');
    include('view/gallery.html');
    include_once('view/foot.html');
}

function show_img_upload() {
    include_once('view/head.html');
    include('view/img_upload.html');
    include_once('view/foot.html');
}

function show_login() {

    $error_login_empty_password = null;
    $error_login_empty_user = null;
    $input_user = '';
    $input_password = '';

    if (!empty($_POST)) {
        if (empty($_POST['user'])) {
            $error_login_empty_user = "Palun sisesta kasutajanimi";
        } else $input_user = htmlspecialchars($_POST['user']);

        if (empty($_POST['password'])) {
            $error_login_empty_password = "Palun sisesta parool";
        } else $input_password = htmlspecialchars($_POST['password']);

        if (is_null($error_login_empty_password) && is_null($error_login_empty_user)) {
            header('Location: ?mode=gallery');
            exit(0);
        }

        include_once('view/head.html');
        include('view/login.html');
        include_once('view/foot.html');

    } else {
        include_once('view/head.html');
        include('view/login.html');
        include_once('view/foot.html');
    }
}

function show_register() {
    include_once('view/head.html');
    include('view/register.html');
    include_once('view/foot.html');
}

function show_image() {

    $imageId = 0;
    if (isset($_GET['id'])){
        if(!is_numeric($_GET['id']) || !array_key_exists($_GET['id'],$GLOBALS['images'])){

        } else {
            $imageId = $_GET['id'];
            $activeImage = $GLOBALS['images'][$imageId];
        }

        if ($imageId == 5) $jargmine = 0;
        else $jargmine = $imageId + 1;
        if ($imageId == 0) $eelmine = 5;
        else $eelmine = $imageId - 1;
    }

    include_once('view/head.html');
    include('view/image.html');
    include_once('view/foot.html');
}

function show_error($error_code) {
    include_once('view/head.html');

    switch ($error_code){
        case '404':
            echo "404 page not found";
            break;
        default:
            echo "something went terribly wrong";
    }

    include_once('view/foot.html');
}


?>