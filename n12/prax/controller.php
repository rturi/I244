<?php

require_once('functions.php');

start_session();
connect_db();

$images = getDBImages();

//$images = array(
//    array(0, "big"=>"img/1.jpg", "small"=>"thumb/1.jpg", "alt"=>"image1 by an anonymous genius"),
//    array(1, "big"=>"img/2.jpg", "small"=>"thumb/2.jpg", "alt"=>"image2 by an anonymous genius"),
//    array(2, "big"=>"img/3.jpg", "small"=>"thumb/3.jpg", "alt"=>"image3 by an anonymous genius"),
//    array(3, "big"=>"img/4.jpg", "small"=>"thumb/4.jpg", "alt"=>"image4 by an anonymous genius"),
//    array(4, "big"=>"img/5.jpg", "small"=>"thumb/5.jpg", "alt"=>"image5 by an anonymous genius"),
//    array(5, "big"=>"img/6.jpg", "small"=>"thumb/6.jpg", "alt"=>"image6 by an anonymous genius")
//);

$error_messages = array();

$mode = 'main_page';
$mainContentView = 'view/main_page.html';
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    switch($mode) {
        case 'main_page':
            show_main_page();
            break;
        case 'gallery':
            show_gallery();
            break;
        case 'img_upload':
            show_img_upload();
            break;
        case 'login':
            show_login();
            break;
        case 'register':
            show_register();
            break;
        case 'image':
            show_image();
            break;
        case 'logout';
            end_session();
            show_main_page();
        default:
            show_error('404');
    }
} else {
    show_main_page();
}

?>