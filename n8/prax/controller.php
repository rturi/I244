<?php

$images = array(
    array(0, "big"=>"img/1.jpg", "small"=>"thumb/1.jpg", "alt"=>"image1 by an anonymous genius"),
    array(1, "big"=>"img/2.jpg", "small"=>"thumb/2.jpg", "alt"=>"image2 by an anonymous genius"),
    array(2, "big"=>"img/3.jpg", "small"=>"thumb/3.jpg", "alt"=>"image3 by an anonymous genius"),
    array(3, "big"=>"img/4.jpg", "small"=>"thumb/4.jpg", "alt"=>"image4 by an anonymous genius"),
    array(4, "big"=>"img/5.jpg", "small"=>"thumb/5.jpg", "alt"=>"image5 by an anonymous genius"),
    array(5, "big"=>"img/6.jpg", "small"=>"thumb/6.jpg", "alt"=>"image6 by an anonymous genius")
);

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
        case 'image':
            $mainContentView = 'view/image.html';
            $imageId = 0;
            if (isset($_GET['id'])){
                if(!is_numeric($_GET['id']) || !array_key_exists($_GET['id'],$images)) break;
                else $imageId = $_GET['id'];
                $activeImage = $images[$imageId];

                if ($imageId == 5) $jargmine = 0;
                else $jargmine = $imageId + 1;
                if ($imageId == 0) $eelmine = 5;
                else $eelmine = $imageId - 1;
            }
            break;
        default:
            $mainContentView = 'view/404.html';
    }
}




include 'view/head.html';
include $mainContentView;
include 'view/foot.html';

?>