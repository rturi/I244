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
    header("Location: ?");
    exit(0);
}

function connect_db() {
    global $connection;
    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("mysql connection failed");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}


function show_main_page() {
    include_once('view/head.html');
    include('view/main_page.html');
    include_once('view/foot.html');
}

function get_user_lists($user_id) {

    if(!is_numeric($user_id) || $user_id < 0 || $user_id > 10000000000) {
        //ToDo: improve user_id check
        $_SESSION['errors']['illegal_list_id'] = "Could not find requested list";
        header("Location: ?mode=main_page");
        exit(0);
    }

    $answer = array();
    global $connection;


    $sql = "SELECT id, name FROM rturi_lists WHERE user_id =" . mysqli_real_escape_string($connection, $user_id);

    $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $answer[$row['id']] = $row;
        }
    }

    return $answer;
}

function show_search() {



    include_once('view/head.html');
    include('view/search.html');
    include_once('view/foot.html');
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
                header('Location: ?mode=main_page');
                exit(0);
            }else {
                $errors['login_wrong_credentials'] = "Sisestatud parool/kasutaja on vale";
            }
        }


    }
    include_once('view/head.html');
    include('view/login.html');
    include_once('view/foot.html');
}

function show_list() {

    // ToDo: add upper limit for number of tasks in a list

    if(isset($_GET['list_id'])) {

        // ToDo: check GET list_id

        global $connection;
        $active_list_id = htmlspecialchars($_GET['list_id']);
        $active_list_tasks = array();


        if (!empty($_POST)) {

            // ToDo: check input due_time
            // ToDo: check input task info

            // ToDo: task name unique?

            if (empty($_POST['name'])) {
                // ToDo: check input name
                $errors['add_task_empty_name'] = "Please enter task name";
            } else $input_name = htmlspecialchars($_POST['name']);

            if(!isset($errors['add_task_empty_name'])) {

                $sql = "INSERT INTO rturi_tasks (name, user_id, list_id, last_change) VALUES ('" . mysqli_real_escape_string($connection, $input_name) . "', " . $_SESSION['user_id'] . ", " . $active_list_id . ", '" . date('Y-m-d H:i:s') . "')";

                $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

                if (mysqli_insert_id($connection) > 0) {
                    // ToDo: add success message
                }


            }



        }


        $sql = "SELECT id, name, info, due_time, status FROM rturi_tasks WHERE user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . " AND list_id = " . mysqli_real_escape_string($connection, $active_list_id);

        $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)){
                $active_list_tasks[$row['id']] = $row;
            }
        }else {
            // ToDo: handle lists that have no tastks
        }

        $tasks_json = json_encode($active_list_tasks);

    } else {
        //ToDo: if is not GET list_id
    }

    include_once('view/head.html');
    include('view/list.html');
    include_once('view/foot.html');

}

function show_list_data () {
    include_once('view/head.html');
    include('view/show_list_data.html');
    include_once('view/foot.html');
}

function delete_task () {

    if (isset($_GET['task_id'])) {

        // ToDo: check GET list_id
        // ToDo: check GET task_id

        global $connection;
        $input_task_id = htmlspecialchars($_GET['task_id']);
        $input_list_id = htmlspecialchars($_GET['list_id']);

        $sql = "DELETE FROM rturi_tasks WHERE id = " . mysqli_real_escape_string($connection, $input_task_id) . " and user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

        $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

        if (mysqli_affected_rows($connection) > 0) {
            header("Location: ?mode=list&list_id=" . $input_list_id);
            exit(0);
        } else {
        // ToDo: error handling when delete fails
        }

    }

}

function set_status () {



}


function show_register() {
    include_once('view/head.html');
    include('view/register.html');
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