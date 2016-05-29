<?php
// Accessible from - http://enos.itcollege.ee/~rturi/I244/Projekt/

require_once('functions.php');

start_session();
connect_db();

if (isset($_SESSION['user_id'])) {
    $_SESSION['lists'] = get_user_lists($_SESSION['user_id']); //ToDo: find a more appropriate location
}

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    switch ($mode) {
        case 'main_page':
            show_main_page();
            break;
        case 'list';
            show_list();
            break;
        case 'delete_task':
            delete_task();
            break;
        case 'login':
            show_login();
            break;
        case 'register':
            show_register();
            break;
        case 'logout';
            end_session();
            break;
        case 'list_data';
            show_list_data();
            break;
        case 'search';
            show_search();
            break;
        case 'tasks':
            tasks();
            break;
        case 'add_task';
            add_task();
            break;
        default:
            show_error('404');
    }
} else {
    show_main_page();
}

?>