<?php

$mode = 'main_page';
$mainContentView = 'view/main_page.html';
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    switch($mode) {
        case 'main_page':
            $mainContentView = 'view/main_page.html';
            break;
        case 'gallery':
            $mainContentView = 'view/gallery.html';
            break;
        case 'img_upload':
            $mainContentView = 'view/img_upload.html';
            break;
        case 'login':
            $mainContentView = 'view/login.html';
            break;
        case 'register':
            $mainContentView = 'view/register.html';
            break;
        default:
            $mainContentView = 'view/404.html';
    }
}

$images = array(
    array("big"=>"img/1.jpg", "small"=>"thumb/1.jpg", "alt"=>"image1 by an anonymous genius"),
    array("big"=>"img/2.jpg", "small"=>"thumb/2.jpg", "alt"=>"image2 by an anonymous genius"),
    array("big"=>"img/3.jpg", "small"=>"thumb/3.jpg", "alt"=>"image3 by an anonymous genius"),
    array("big"=>"img/4.jpg", "small"=>"thumb/4.jpg", "alt"=>"image4 by an anonymous genius"),
    array("big"=>"img/5.jpg", "small"=>"thumb/5.jpg", "alt"=>"image5 by an anonymous genius"),
    array("big"=>"img/6.jpg", "small"=>"thumb/6.jpg", "alt"=>"image6 by an anonymous genius")
);


include 'view/head.html';
include $mainContentView;
include 'view/foot.html';

?>