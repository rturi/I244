<?php
// http://enos.itcollege.ee/~rturi/I244/n10/kt/kontrolleriga/controller.php
session_start();

if (!empty($_GET['end']) && $_GET['end'] == 'true') {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    session_start();
}



$pildid = array(
    array('id'=>1, 'src'=>'pildid/nameless1.jpg', 'img_id'=>'p1', 'alt'=>'nimetu 1'),
    array('id'=>2, 'src'=>'pildid/nameless2.jpg', 'img_id'=>'p2', 'alt'=>'nimetu 2'),
    array('id'=>3, 'src'=>'pildid/nameless3.jpg', 'img_id'=>'p3', 'alt'=>'nimetu 3'),
    array('id'=>4, 'src'=>'pildid/nameless4.jpg', 'img_id'=>'p4', 'alt'=>'nimetu 4'),
    array('id'=>5, 'src'=>'pildid/nameless5.jpg', 'img_id'=>'p5', 'alt'=>'nimetu 5'),
    array('id'=>6, 'src'=>'pildid/nameless6.jpg', 'img_id'=>'p6', 'alt'=>'nimetu 6')
);

if (!isset($_SESSION['gallery_already_voded'])) {
    $_SESSION['gallery_already_voded'] = false;
}

require_once('head.html');



if (!empty($_GET['mode'])) {

    switch ($_GET['mode']) {
        case 'pealeht':
            include('pealeht.php');
            break;
        case 'galerii':
            include('galerii.php');
            break;
        case 'vote':
            include('vote.php');
            break;
        case 'tulemus':
            include('tulemus.php');
            break;
        default:
            echo "page not found";
    }

} else echo include('pealeht.php');

echo

require_once('foot.html');

?>