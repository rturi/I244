<?php
// Accessible from - http://enos.itcollege.ee/~rturi/I244/Projekt/

require_once('functions.php');

start_session();
connect_db();

if (isset($_SESSION['user_id'])) {
    $_SESSION['lists'] = get_user_lists($_SESSION['user_id']);
}

if (isset($_GET['mode'])) {

    $mode = $_GET['mode'];
    switch ($mode) {
        case 'main_page':
            show_main_page();
            break;
        case 'lists';
            if (isset($_SESSION['username'])) {
                show_list();
            } else show_login();
            break;
        case 'delete_task':
            if (isset($_SESSION['username'])) {
                delete_task();
            } else show_main_page();
            break;
        case 'login':
            show_login();
            break;
        case 'register':
            show_register();
            break;
        case 'logout':
            if (isset($_SESSION['username'])) {
                end_session();
            } else show_main_page();
            break;
        case 'search_task':
            if (isset($_SESSION['username'])) {
                show_search();
            } else show_login();
            break;
        case 'tasks':
            if (isset($_SESSION['username'])) {
                tasks();
            } else show_main_page();
            break;
        case 'add_task':
            if (isset($_SESSION['username'])) {
                add_task();
            } else show_login();
            break;
        case 'edit_task':
            if (isset($_SESSION['username'])) {
                edit_task();
            } else show_login();
            break;
        case 'toggle_completed':
            if (isset($_SESSION['username'])) {
                toggle_completed();
            } else show_login();
            break;
        case 'set_task_completed':
            if (isset($_SESSION['username'])) {
                set_task_completed();
            } else show_login();
            break;
        case 'set_task_active':
            if (isset($_SESSION['username'])) {
                set_task_active();
            } else show_login();
            break;
        case 'toggle_list_order':
            if (isset($_SESSION['username'])) {
                toggle_list_order();
            } else show_login();
            break;
        default:
            $_SESSION['errors']['page_not_found'] = "Sorry could not find the page you asked for";
            show_main_page();
    }
} else {
    show_main_page();
}

?>