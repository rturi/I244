<?php
/**
Loo lihtne kommentaaride lisamise vorm. Andmed salvesta tekstifaili. Kuva salvestatud kommentaare.
Lahendust mõeldes eelda, et kasutaja brauseris on lubatud nii Javascript kui ka küpsised.
 */


require_once('functions.php');

start_session();



if (isset($_GET['mode'])) {

    $mode = $_GET['mode'];
    switch ($mode) {
        case 'comments':
            show_comments();
            break;
        default:
            $_SESSION['errors']['page_not_found'] = "Sorry could not find the page you asked for";
            show_comments();
    }
} else {
    show_comments();
}


?>