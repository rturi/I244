<?php

function start_session() {
    session_start();
}

function end_session() { //lopeta_sessioon() in the example
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    header("Location: ?");
    exit(0);
}

function connect_db() {
    global $connection;
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("mysql connection failed");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - " . mysqli_error($connection));
}


function show_main_page() {
    include_once('view/head.html');
    include('view/main_page.html');
    include_once('view/foot.html');
}

function get_user_lists($user_id) {

    if (!is_numeric($user_id) || $user_id < 0 || $user_id > 10000000000) {
        //ToDo: improve user_id check
        $_SESSION['errors']['illegal_list_id'] = "Could not find requested list";
        header("Location: ?mode=main_page");
        exit(0);
    }

    $answer = array();
    global $connection;


    $sql = "SELECT id, name FROM rturi_lists WHERE user_id =" . mysqli_real_escape_string($connection, $user_id);

    $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $answer[$row['id']] = $row;
        }
    }
    return $answer;
}

function show_search()
{

    include_once('view/head.html');
    include('view/search.html');
    include_once('view/foot.html');
}


function show_login()
{

    global $connection;

    if (!empty($_POST)) {

        if (empty($_POST['user'])) {
            $_SESSION['errors']['login_empty_user'] = "Palun sisesta kasutajanimi";
        } else $input_user = htmlspecialchars($_POST['user']);

        if (empty($_POST['password'])) {
            $_SESSION['errors']['login_empty_password'] = "Palun sisesta parool";
        } else $input_password = htmlspecialchars($_POST['password']);


        if (!isset($_SESSION['errors']['login_empty_password']) && !isset($_SESSION['errors']['login_empty_user'])) {

            $sql = "SELECT id, username FROM `rturi_users` WHERE username = '" . mysqli_real_escape_string($connection, $input_user) . "' AND passw = SHA1('" . mysqli_real_escape_string($connection, $input_password) . "')";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = htmlspecialchars($row['username']);
                $_SESSION['user_id'] = htmlspecialchars($row['id']);
                header('Location: ?mode=main_page');
                exit(0);
            } else {
                $_SESSION['errors']['login_wrong_credentials'] = "Sisestatud parool/kasutaja on vale";
            }
        }


    }
    include_once('view/head.html');
    include('view/login.html');
    include_once('view/foot.html');
}

function tasks(){

    if (isset($_GET['list_id'])) {

        isLegalListId($_GET['list_id']);
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation

        global $connection;

        // old search query stuff
//        $searchKey = mysqli_real_escape_string($connection, $_GET['q']);
//        $sql = "SELECT * FROM rturi_tasks WHERE user_id = " . $_SESSION['user_id'] . " and (info LIKE '%" . $searchKey . "%' or name LIKE '%" . $searchKey . "%') ";

        $sql = "SELECT id, name, list_id FROM rturi_tasks WHERE user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

        $answer = array();

        $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $answer[] = $row;
            }
        }
        echo json_encode($answer);

    } else {
        // Todo: json fail answer;
    }


}


function show_list() {

    if (isset($_GET['list_id'])) {

        if (!isLegalListId($_GET['list_id'])) {
        $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
        }
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation

        global $connection;

        $sql = "SELECT id, name, info, due_time, status, list_id FROM rturi_tasks WHERE user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . " AND list_id = " . mysqli_real_escape_string($connection, $active_list_id . " AND status = 1");

        $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $active_tasks_list[$row['id']] = $row;
            }
        }



        $sql = "SELECT id, name, info, due_time, status, list_id FROM rturi_tasks WHERE user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . " AND list_id = " . mysqli_real_escape_string($connection, $active_list_id . " AND status = 0");

        $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $completed_tasks_list[$row['id']] = $row;
            }
        }

        include_once('view/head.html');
        include('view/list.html');
        include_once('view/foot.html');

    }

}

function add_task()
{

    if (isset($_GET['list_id'])) {

        if (!isLegalListId($_GET['list_id'])) {
        $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
    }
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation

        global $connection;

        if (!empty($_POST['name'])) {

            if (isLegalTaskName($_POST['name'])) {

                $input_name = htmlspecialchars($_POST['name']);

                $sql = "INSERT INTO rturi_tasks (name, user_id, list_id, last_change) VALUES ('" . mysqli_real_escape_string($connection, $input_name) . "', " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . ", " . mysqli_real_escape_string($connection, $active_list_id) . ", '" . date('Y-m-d H:i:s') . "')";

                $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

                if (mysqli_affected_rows($connection) < 1) {
                    $_SESSION['errors']['add_task_insert_failed'] = "Adding your new task failed, sorry. Please try again.";
                }

            } else {
                $_SESSION['errors']['add_task_illegal'] = "Task name can't be longer than 1000 characters.";
            }

        } else {
            $_SESSION['errors']['add_task_empty_name'] = "New task has to have a name.";
        }

        // no errors: reload original list page with new task
        header("Location: ?mode=lists&list_id=" . htmlspecialchars($active_list_id));
        exit(0);

    }

}

function show_list_data()
{
    include_once('view/head.html');
    include('view/show_list_data.html');
    include_once('view/foot.html');
}

function delete_task() {

    if (isset($_GET['task_id']) && isset($_GET['list_id'])) {

        global $connection;

        if (!isLegalTaskId($_GET['task_id'])){
        $_SESSION['errors']['illegal_task_id'] = "The task you tried to delete does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
        }
        $input_list_id = htmlspecialchars($_GET['list_id']);

        if (!isLegalListId($_GET['list_id'])) {
            $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
            header("Location: ?mode=main_page");
            exit(0);
        }
        $input_task_id = htmlspecialchars($_GET['task_id']);

        $sql = "DELETE FROM rturi_tasks WHERE id = " . mysqli_real_escape_string($connection, $input_task_id) . " and user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

        $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

        if (mysqli_affected_rows($connection) > 0) {
            header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
            exit(0);
        } else {
            $_SESSION['errors']['task_delete_failed'] = "Deleting the task failed, sorry. Please try again.";
            header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
            exit(0);
        }

    } else {
        $_SESSION['errors']['delete_task_missing_parameters'] = "Missing list or task id in task delete request";
        header("Location: ?mode=main_page");
        exit(0);
    }

}

// Checks that list_id is a numeric value with a realistic value and is the id of a current users list
function isLegalListId($inputID)
{

    if (!is_numeric($inputID) || $inputID < 1 || $inputID > 3000000000000) return false;

    if (!isset($_SESSION['lists'][$inputID])) return false;

    return true;

}


function isLegalTaskId($inputID)
{

    if (!is_numeric($inputID) || $inputID < 1 || $inputID > 3000000000000) return false;

    global $connection;

    $sql = "SELECT id FROM rturi_tasks WHERE id = " . mysqli_real_escape_string($connection, $inputID) . " AND user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

    $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

    if (mysqli_num_rows($result) != 1) return false;

    return true;

}


function isLegalTaskName($inputName)
{

    if (!is_string($inputName)) return false;

    if (strlen($inputName) > 1000) return false;

    global $connection;

    return true;
}


function toggle_completed() {

    if (isset($_GET['list_id'])) {

        if (!isLegalListId($_GET['list_id'])) {
            $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
            header("Location: ?mode=main_page");
            exit(0);
        }
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation

        if (isset($_SESSION['show_completed_tasks'])) {
            $_SESSION['show_completed_tasks'] = null;
        } else $_SESSION['show_completed_tasks'] = true;

        // no errors: reload original list page with new task
        header("Location: ?mode=lists&list_id=" . htmlspecialchars($active_list_id));
        exit(0);

    } else {
        $_SESSION['errors']['error_toggling_completed_tasks'] = "Something went wrong when toggling completed tasks";
        header("Location: ?mode=main_page");
        exit(0);
    }


}

function show_register()
{
    include_once('view/head.html');
    include('view/register.html');
    include_once('view/foot.html');
}


?>