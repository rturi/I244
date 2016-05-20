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

    $sql = "SELECT rturi_pildid.id, rturi_pildid.thumb AS small, rturi_pildid.pilt AS big, rturi_pildid.pealkiri, rturi_users.username as autor, rturi_pildid.pealkiri AS alt FROM `rturi_pildid`, rturi_users WHERE rturi_pildid.kasutaja_id = rturi_users.id";

    $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

    while ($row = mysqli_fetch_assoc($result)){
        $images[] = $row;
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

    global $connection;
    $thumb_upload = '';
    $img_upload = '';
    $input_title = '';
    $input_author = '';

    if (isset($_SESSION['username'])) {

        $errors = array();
        $operation = "upload";

        if (isset($_GET['id'])) {


            $sql = "SELECT id, kasutaja_id, pealkiri FROM rturi_pildid WHERE id = " . mysqli_real_escape_string($connection, $_GET['id']);
            $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));


            if(mysqli_num_rows($result) > 0) {
                $piltBaasist = mysqli_fetch_assoc($result);

                if ($piltBaasist['kasutaja_id'] != $_SESSION['user_id']) {
                    $errors['update_rights_missing'] = "Sul pole õigust seda pilti muuta";
                    //header("Location: ?mode=img_upload");
                } else echo "pilt olemas";
            } else {
                echo "pilti pole";
                header("Location: ?");
                exit(0);
            }

            $operation = 'edit';

        }

        if (!empty($_POST)) {

            if (empty($_POST['title'])) {
                $errors['upload_empty_title'] = "Palun sisesta pildi nimi";
            } else $input_title = htmlspecialchars($_POST['title']);

            $thumb_upload = upload('thumb', 'thumb');
            $img_upload = upload('img', 'img');

            if ($img_upload == "") {
                $errors['upload_img_failed'] = "Suure pildi upload ebaõnnestus";
            }

            if ($thumb_upload == "") {
                $errors['upload_thumb_failed'] = "Väikse pildi upload ebaõnnestus";
            }

            if ($operation == "edit" && !isset($errors['upload_empty_author']) && !isset($errors['update_rights_missing'])) {


                if(!isset($errors['upload_img_failed'])) {
                    $possible_img_change = ", pilt = 'img/" . mysqli_real_escape_string($connection, $img_upload) . "' ";
                }
                if (!isset($errors['upload_thumb_failed'])) {
                    $possible_thumb_change = ", thumb = 'thumb/" . mysqli_real_escape_string($connection, $thumb_upload) . "' ";;
                }

                $sql = "UPDATE `rturi_pildid` SET `pealkiri`='" . $input_title . "'" . mysqli_real_escape_string($possible_img_change) . $possible_thumb_change .  " WHERE id=" . $piltBaasist['id'];
                $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));
//                `thumb`=" . mysqli_real_escape_string($connection, $thumb_upload) . "`,`pilt`='" . mysqli_real_escape_string($connection, $img_upload) . "',
                $_SESSION['img_edit_success'] = "pildi uuendamine õnnestus";





                header("Location: ?mode=gallery");
                exit(0);
            }


            if($operation == "upload" && !isset($errors['upload_empty_author']) && !isset($errors['upload_empty_title']) && !isset($errors['upload_img_failed']) && !isset($errors['upload_thumb_failed'])) {

                $sql = "INSERT INTO `rturi_pildid`(`thumb`, `pilt`, `pealkiri`, `kasutaja_id`) VALUES ('thumb/" . mysqli_real_escape_string($connection, $thumb_upload) . "','img/" . mysqli_real_escape_string($connection, $img_upload) . "','" . mysqli_real_escape_string($connection, $input_title) . "','" . mysqli_real_escape_string($connection, $_SESSION['user_id']) . "')";
                $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

                if (mysqli_insert_id($connection) > 0) {
                    $_SESSION['upload_success'] = 'Pildi upload õnnestus';
                    header("Location: ?mode=gallery");
                    exit(0);
                } else $errors['upload_db_insert_failed'] = "Pildi salvestamine ebaõnnestus. Sorry.";

            }
        }


        include_once('view/head.html');
        include('view/img_upload.html');
        include_once('view/foot.html');
    } else {
        header('Location: ?mode=main_page');
        exit(0);
    }
}


function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ol>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li>'.$ff;
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ol>';
}

function upload($name, $loc){
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
    $tmp = explode(".", $_FILES[$name]["name"]);
    $extension = end($tmp);

    if ( in_array($_FILES[$name]["type"], $allowedTypes)
        && ($_FILES[$name]["size"] < 100000) // see on 100kb
        && in_array($extension, $allowedExts)) {
        // fail õiget tüüpi ja suurusega
        if ($_FILES[$name]["error"] > 0) {
            return "";
        } else {
            // vigu ei ole
            if (file_exists($loc."/" . $_FILES[$name]["name"])) {
                // fail olemas ära uuesti lae, tagasta failinimi
                return $_FILES[$name]["name"];
            } else {
                // kõik ok, aseta pilt
                move_uploaded_file($_FILES[$name]["tmp_name"], $loc."/" . $_FILES[$name]["name"]);
                return $_FILES[$name]["name"];
            }
        }
    } else {
        return "";
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

            $sql = "SELECT id, username, role FROM `rturi_users` WHERE username = '" . mysqli_real_escape_string($connection, $input_user) . "' AND passw = SHA1('" . mysqli_real_escape_string($connection, $input_password) . "')";

            $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = htmlspecialchars($row['username']);
                $_SESSION['user_id'] = htmlspecialchars($row['id']);
                $_SESSION['user_role'] = htmlspecialchars($row['role']);
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