<?php

function start_session(){ //alusta_sessioon() in the example
    session_start();
}

function end_session(){ //lopeta_sessioon() in the example
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    show_main_page();
}

function connect_db() {
    global $connection;
    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa mootoriga ühendust");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function getDBImages() {

    $images = array();
    global $connection;

    $sql = "SELECT thumb AS small, pilt AS big, pealkiri, autor, CONCAT(pealkiri, ' by ', autor) AS alt FROM `rturi_pildid`";

    $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

    while ($row = mysqli_fetch_assoc($result)){
        $images[] = $row;
    }

    $i = 0;
    while (isSet($images[$i])) {
        $images[$i]['id'] = $i;
        $i++;
    }

    return $images;
}

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
    if (isset($_SESSION['username'])) {
        include_once('view/head.html');
        include('view/img_upload.html');
        include_once('view/foot.html');
    } else {
        header('Location: ?mode=main_page');
        exit(0);
    }
}

function show_login() {

    global $connection;
    $errors = array();

    if (!empty($_POST)) {

        if (empty($_POST['user'])) {
            $errors['login_empty_user'] = "Palun sisesta kasutajanimi";
        } else $input_user = htmlspecialchars($_POST['user']);

        if (empty($_POST['password'])) {
            $errors['login_empty_password'] = "Palun sisesta parool";
        } else $input_password = htmlspecialchars($_POST['password']);


        if (!isset($errors['login_empty_password']) && !isset($errors['login_empty_user'])) {

            $sql = "SELECT id, username FROM `rturi_users` WHERE username = '" . mysqli_real_escape_string($connection, $input_user) . "' AND passw = SHA1('" . mysqli_real_escape_string($connection, $input_password) . "')";

            $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = htmlspecialchars($row['username']);
                $_SESSION['user_id'] = htmlspecialchars($row['id']);
                header('Location: ?mode=gallery');
                exit(0);
            }else {
                $errors['login_wrong_credentials'] = "Sisestatud parool/kasutaja on vale";
            }
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