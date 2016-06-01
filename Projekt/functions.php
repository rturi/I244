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
    include_once('view/head.php');
    include('view/main_page.php');
    include_once('view/foot.php');
}

function show_register() {

    global $connection;

    if(!empty($_POST)) {

        if(empty($_POST['user'])) {
            $_SESSION['errors']['register_empty_user'] = "Please enter an username";
        } else {
            if(isLegitRegUsername($_POST['user'])) {
                $inputUserName = $_POST['user'];
            }
        }


        if(empty($_POST['password'])) {
            $_SESSION['errors']['register_empty_password'] = "Please enter a password";
        } if (isLegitRegPassword($_POST['password'])) {
            $inputPassword = $_POST['password'];
        } else {
            $_SESSION['errors']['register_unlegit_password'] = "Username should be 3 - 500 characters long and can consist only of english alphabet letters and numbers";
        }

        if(empty($_POST['re_password'])) {
            $_SESSION['errors']['register_empty_re_password'] = "Please fill the 'repeat password' field";
        } if (isLegitRegPassword($_POST['password'])) {
            $inputRePassword = $_POST['re_password'];
        }

        if(empty($_SESSION['errors']) && $inputPassword != $inputRePassword) {
            $_SESSION['errors']['register_passwords_do_not_match'] = "Entered passwords don't match";
        }

        if(empty($_SESSION['errors'])) {
            $sql = "SELECT id FROM rturi_users WHERE username = '" . mysqli_real_escape_string($connection, htmlspecialchars($inputUserName)) . "'";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_num_rows($result) > 0) {
                $_SESSION['errors']['register_username_taken'] = "That name is already taken, sorry.";
            }
        }

        if(empty($_SESSION['errors'])) {


            $sql = "INSERT INTO `rturi_users`(username, passw) VALUES ('" . mysqli_real_escape_string($connection, htmlspecialchars($inputUserName)) . "',SHA1('" . mysqli_real_escape_string($connection, ($inputPassword)) . "'))";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));


            if (mysqli_affected_rows($connection) < 1) {
                $_SESSION['errors']['register_db_insert_failed'] = "Creating your new user failed. Sorry. Please try again.";
                header("Location: ?mode=register");
                exit(0);
            } else { // generate first list for new user

                // get the user_id of the new user
                $sql = "SELECT id FROM rturi_users WHERE username = '" . mysqli_real_escape_string($connection, htmlspecialchars($inputUserName)) . "'";
                $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));
                // ToDo: there should be a try-catch here
                $row = mysqli_fetch_assoc($result);

                $new_user_id = $row['id'];

                $sql = "INSERT INTO rturi_lists (name, user_id) VALUES ('My tasks', " . mysqli_real_escape_string($connection, $new_user_id) . "), ('Shopping', " . mysqli_real_escape_string($connection, $new_user_id) . ")";
                $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));
            }


            $_SESSION['messages']['register_success'] = "Congratulations, you have successfully created your new account! Log in and start todoing.";
            header("Location: ?mode=main_page");
            exit(0);
        }

    }

    include_once('view/head.php');
    include('view/register.php');
    include_once('view/foot.php');
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


function show_login() {

    global $connection;

    if (!empty($_POST)) {

        if (empty($_POST['user'])) {
            $_SESSION['errors']['login_empty_user'] = "Please enter your username";
        } else if (isLegitLoginPassword($_POST['user'])) {
            $input_user = htmlspecialchars($_POST['user']);
        }

        if (empty($_POST['password'])) {
            $_SESSION['errors']['login_empty_password'] = "Please enter your password";
        } else if (isLegitLoginUsername($_POST['password'])){
            $input_password = htmlspecialchars($_POST['password']);
        };


        if (!isset($_SESSION['errors'])) {

            $sql = "SELECT id, username FROM `rturi_users` WHERE username = '" . mysqli_real_escape_string($connection, $input_user) . "' AND passw = SHA1('" . mysqli_real_escape_string($connection, $input_password) . "')";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = htmlspecialchars($row['username']);
                $_SESSION['user_id'] = htmlspecialchars($row['id']);
                header('Location: ?mode=main_page');
                exit(0);
            } else {
                $_SESSION['errors']['login_wrong_credentials'] = "Entered password and user name don't match";
            }
        }

    }
    include_once('view/head.php');
    include('view/login.php');
    include_once('view/foot.php');
}

function show_list() {

    if (isset($_GET['list_id'])) {

        if (!isLegitListId($_GET['list_id'])) {
        $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
        }
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation
        $page_title = htmlspecialchars($_SESSION['lists'][$active_list_id]['name']);

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

        include_once('view/head.php');
        include('view/list.php');
        include_once('view/foot.php');

    }

}

function add_task()
{

    if (isset($_GET['list_id'])) {

        if (!isLegitListId($_GET['list_id'])) {
        $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
    }
        $active_list_id = ($_GET['list_id']); // safe because of list_id validation

        global $connection;

        if (!empty($_POST['name'])) {

            if (isLegitTaskName($_POST['name'])) {

                $input_name = htmlspecialchars($_POST['name']);

                $sql = "INSERT INTO rturi_tasks (name, user_id, list_id, created, last_change) VALUES ('" . mysqli_real_escape_string($connection, $input_name) . "', " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . ", " . mysqli_real_escape_string($connection, $active_list_id) . ", '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";

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

    } else {
        $_SESSION['errors']['illegal_list_id'] = "The list you tried to view or change does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
    }

}

function edit_task() {


    if (isset($_GET['task_id'])) {

        $active_task_id = $_GET['task_id'];

        if(isLegitTaskId($active_task_id)) {

            if(!empty($_POST)) {

                global $connection;
                $input_info = '';
                $input_due_time = '';

                if(!empty($_POST['name'])) {
                    if(isLegitTaskName($_POST['name'])) {
                        $input_name = mysqli_real_escape_string($connection, htmlspecialchars($_POST['name']));
                    }
                } else {
                    $_SESSION['errors']['edit_task_empty_name'] = "Task name can't be empty";
                }

                if(!empty($_POST['info'])) {
                    if(isLegitTaskInfo($_POST['info'])){
                        $input_info = ", info = '" . mysqli_real_escape_string($connection, htmlspecialchars($_POST['info'])) . "'";
                    }
                }

                if(!empty($_POST['due_time'])) {
                    if(isLegitTaskDueTime($_POST['due_time'])){
                        $input_due_time = ", due_time = '" . mysqli_real_escape_string($connection, htmlspecialchars($_POST['due_time'])) . "'";
                    }
                }

                if(!isset($_SESSION['errors'])) {

                    $sql = "UPDATE rturi_tasks SET last_change = '" . date('Y-m-d H:i:s') . "', name = '" . $input_name . "'" . $input_info . $input_due_time . " WHERE id = " . mysqli_real_escape_string($connection, htmlspecialchars($active_task_id)) . " AND user_id = " . mysqli_real_escape_string($connection, htmlspecialchars($_SESSION['user_id']));
                    mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

                }

            }


            if ($_GET['source'] == "list") {

                $sql = "SELECT list_id FROM rturi_tasks WHERE id = ". mysqli_real_escape_string($connection, $active_task_id);
                $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));
                $row = mysqli_fetch_assoc($result);

                header("Location: ?mode=lists&list_id=" .  $row['list_id']);
                exit(0);

            }


            if ($_GET['source'] == "search") {

                if(isset($_GET['q']) && isLegitSearchKey($_GET['q'])){
                    header("Location: ?mode=search_task&q=" . htmlspecialchars($_GET['q']));
                    exit(0);
                } else {
                    $_SESSION['errors']['lost_searchkey'] = "Could not find the right place to redirect. Sorry";
                    header("Location: ?mode=main_page");
                    exit(0);
                }
            }

        } else {
            $_SESSION['errors']['illegal_task_id'] = "The task you tried to delete does not exist or belong to you.";
            header("Location: ?mode=main_page");
            exit(0);
        }


    }

}

function delete_task() {

    if (isset($_GET['task_id'])) {

        global $connection;

        if (!isLegitTaskId($_GET['task_id'])){
        $_SESSION['errors']['illegal_task_id'] = "The task you tried to delete does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
        }
        $input_task_id = htmlspecialchars($_GET['task_id']);

        $input_list_id = '';
        if (isLegitListId($_GET['list_id'])) {
            $input_list_id = htmlspecialchars($_GET['list_id']);
        }


        $sql = "DELETE FROM rturi_tasks WHERE id = " . mysqli_real_escape_string($connection, $input_task_id) . " and user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

        $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

        if (mysqli_affected_rows($connection) > 0) {


            if ($_GET['source'] == "list") {

                $sql = "SELECT list_id FROM rturi_tasks WHERE id = ". mysqli_real_escape_string($connection, $input_task_id);
                $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));
                $row = mysqli_fetch_assoc($result);

                header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
                exit(0);

            }


            if ($_GET['source'] == "search") {

                if(isset($_GET['q']) && isLegitSearchKey($_GET['q'])){
                    header("Location: ?mode=search_task&q=" . htmlspecialchars($_GET['q']));
                    exit(0);
                } else {
                    $_SESSION['errors']['lost_searchkey'] = "Could not find the right place to redirect. Sorry";
                    header("Location: ?mode=main_page");
                    exit(0);
                }
            }

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

function toggle_completed() {

    if (isset($_GET['list_id']) || isset($_GET['q'])) {

        $input_list_id = "";
        if (isset($_GET['list_id']) && isLegitListId($_GET['list_id'])) {
            $input_list_id = htmlspecialchars($_GET['list_id']);
        }

        $input_key = '';
        if (isset($_GET['q']) && isLegitSearchKey($_GET['q'])) {
            $input_key = htmlspecialchars($_GET['q']);
        }

        if (!isset($_SESSION['errors'])) {

            if (isset($_SESSION['show_completed_tasks'])) {
                $_SESSION['show_completed_tasks'] = null;
            } else $_SESSION['show_completed_tasks'] = true;

            if ($_GET['source'] == "list") {
                header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
                exit(0);
            }

            if ($_GET['source'] == "search") {
                //$_SESSION['errors']['test'] = 'a';
                header("Location: ?mode=search_task&q=" . htmlspecialchars($input_key));
                exit(0);
            }



        } else {
            $_SESSION['errors']['error_toggling_completed_tasks'] = "Something went wrong when toggling completed tasks";
            header("Location: ?mode=main_page");
            exit(0);
        }

    } else {
        $_SESSION['errors']['error_toggling_completed_tasks'] = "Something went wrong when toggling completed tasks";
        header("Location: ?mode=main_page");
        exit(0);
    }

}

function set_task_active() {

    if ((isset($_GET['task_id']) && isset($_GET['list_id']) || isset($_GET['q']))) {
        global $connection;

        if (isset($_GET['task_id']) && isLegitTaskId($_GET['task_id'])) {
            $input_task_id = htmlspecialchars($_GET['task_id']);
        }

        $input_list_id = "";
        if (isset($_GET['list_id']) && isLegitListId($_GET['list_id'])) {
            $input_list_id = htmlspecialchars($_GET['list_id']);
        }

        $input_key = '';
        if (isset($_GET['q']) && isLegitSearchKey($_GET['q'])) {
            $input_key = htmlspecialchars($_GET['q']);
        }

        if(!isset($_SESSION['errors'])){

            $sql = "UPDATE rturi_tasks SET status = 1, last_change = '" . date('Y-m-d H:i:s') . "' WHERE id = " . mysqli_real_escape_string($connection, $input_task_id) . " and user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);
            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_affected_rows($connection) > 0) {

                if ($_GET['source'] == "list") {
                    header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
                    exit(0);
                }

                if ($_GET['source'] == "search") {

                    if(isset($_GET['q']) && isLegitSearchKey($_GET['q'])){
                        header("Location: ?mode=search_task&q=" . htmlspecialchars($input_key));
                        exit(0);
                    } else {
                        $_SESSION['errors']['lost_searchkey'] = "Could not find the right place to redirect. Sorry";
                        header("Location: ?mode=main_page");
                        exit(0);
                    }
                }
                $_SESSION['errors']['task_set_active_failed'] = "Changin the task status failed, sorry. Please try again.";
                header("Location: ?mode=main_page");
                exit(0);
            } else {
                $_SESSION['errors']['task_set_active_failed'] = "Changin the task status failed, sorry. Please try again.";
                header("Location: ?mode=main_page");
                exit(0);
            }


        } else {
            $_SESSION['errors']['illegal_task_id'] = "The task you tried to delete does not exist or belong to you.";
            header("Location: ?mode=main_page");
            exit(0);
        }

    }
}


function set_task_completed()
{

    if ((isset($_GET['task_id']) && (isset($_GET['list_id'])) || isset($_GET['q']))) {

        global $connection;

        if (isset($_GET['task_id']) && isLegitTaskId($_GET['task_id'])) {
            $input_task_id = htmlspecialchars($_GET['task_id']);
        }

        $input_list_id = "";
        if (isset($_GET['list_id']) && isLegitListId($_GET['list_id'])) {
            $input_list_id = htmlspecialchars($_GET['list_id']);
        }

        $input_key = '';
        if (isset($_GET['q']) && isLegitSearchKey($_GET['q'])) {
            $input_key = htmlspecialchars($_GET['q']);
        }

        if (!isset($_SESSION['errors'])) {

            $sql = "UPDATE rturi_tasks SET status = 0, last_change = '" . date('Y-m-d H:i:s') . "' WHERE id = " . mysqli_real_escape_string($connection, $input_task_id) . " and user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);
            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_affected_rows($connection) > 0) {

                if ($_GET['source'] == "list") {
                    header("Location: ?mode=lists&list_id=" . htmlspecialchars($input_list_id));
                    exit(0);
                }

                if ($_GET['source'] == "search") {
                    //$_SESSION['errors']['test'] = 'a';
                    header("Location: ?mode=search_task&q=" . htmlspecialchars($input_key));
                    exit(0);
                }
            }

            $_SESSION['errors']['task_set_active_failed'] = "Changin the task status failed, sorry. Please try again.";
            header("Location: ?mode=main_page");
            exit(0);

        } else {
            $_SESSION['errors']['task_set_active_failed'] = "Changin the task status failed, sorry. Please try again.";
            header("Location: ?mode=main_page");
            exit(0);
        }

    } else {
        $_SESSION['errors']['illegal_task_id'] = "The task you tried to delete does not exist or belong to you.";
        header("Location: ?mode=main_page");
        exit(0);
    }



}


function show_search() {

    $active_tasks_list = array();

    $input_keyword = '';

    if ((isset($_POST['q'])) || (isset($_GET['q']))) {


        if(isset($_POST['q']) && isLegitSearchKey($_POST['q'])) {
            $input_keyword = $_POST['q'];
        }

        if(isset($_GET['q']) && isLegitSearchKey($_GET['q'])) {
            $input_keyword = $_GET['q'];
    }

        if(!isset($_SESSION['errors'])) {

            global $connection;

            $sql = "SELECT * FROM rturi_tasks WHERE user_id = " . $_SESSION['user_id'] . " and (info LIKE '%" . mysqli_real_escape_string($connection, $input_keyword) . "%' or name LIKE '%" . mysqli_real_escape_string($connection, $input_keyword) . "%') and status = 1 ";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $active_tasks_list[] = $row;
                }
            }

            $sql = "SELECT id, name, info, due_time, status, list_id FROM rturi_tasks WHERE user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']) . " AND status = 0";

            $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $completed_tasks_list[$row['id']] = $row;
                }
            }

        }

    } else {

    }


    include_once('view/head.php');
    include('view/search.php');
    include_once('view/foot.php');
}




function isLegitListId($inputID) {

    if (!is_numeric($inputID) || $inputID < 1 || $inputID > 3000000000000) return false;

    if (!isset($_SESSION['lists'][$inputID])) {
        return false;
    }

    return true;

}


function isLegitTaskId($inputID)
{

    if (!is_numeric($inputID) || $inputID < 1 || $inputID > 3000000000000) return false;

    global $connection;

    $sql = "SELECT id FROM rturi_tasks WHERE id = " . mysqli_real_escape_string($connection, $inputID) . " AND user_id = " . mysqli_real_escape_string($connection, $_SESSION['user_id']);

    $result = mysqli_query($connection, $sql) or die("$sql - " . mysqli_error($connection));

    if (mysqli_num_rows($result) != 1) return false;

    return true;

}


function isLegitTaskName($inputName)
{

    if (!is_string($inputName)) return false;

    if (strlen($inputName) > 1000) return false;

    global $connection;

    return true;
}

function isLegitRegUsername ($inputName) {

    if(strlen($inputName) < 3) {
        $_SESSION['errors']['register_username_too_short'] = "Username must be at least 3 characters long";
        return false;
    }

    if(strlen($inputName) > 500) {
        $_SESSION['errors']['register_username_too_long'] = "Username can't be longer than 500 characters";
        return false;
    }

    if ($inputName != htmlspecialchars($inputName)) {
        $_SESSION['errors']['register_username_special_chars'] = "Username can only contain numbers and letters";
        return false;
    }

    if ($inputName != htmlspecialchars($inputName)) {
        $_SESSION['errors']['register_username_special_chars'] = "Username can only contain numbers and letters";
        return false;
    }

    return true;
}


function isLegitRegPassword ($inputPassword) {

    if(strlen($inputPassword) < 5) {
        $_SESSION['errors']['register_password_too_short'] = "Password must be at least 5 characters long";
        return false;
    }

    if(strlen($inputPassword) > 500) {
        $_SESSION['errors']['register_password_too_long'] = "Password can't be longer than 500 characters";
        return false;
    }

    if ($inputPassword != htmlspecialchars($inputPassword)) {
        $_SESSION['errors']['register_password_special_chars'] = "Password can only contain numbers and letters";
        return false;
    }

    if ($inputPassword != htmlspecialchars($inputPassword)) {
        $_SESSION['errors']['register_password_special_chars'] = "Password can only contain numbers and letters";
        return false;
    }

    return true;
}


function isLegitLoginUsername ($inputName) {

    if(!is_string($inputName)) {
        $_SESSION['errors']['login_username_not_string'] = "Entered password and user name don't match";
        return false;
    }

    if(strlen($inputName) < 3) {
        $_SESSION['errors']['login_username_too_short'] = "Entered password and user name don't match";
        return false;
    }

    if(strlen($inputName) > 500) {
        $_SESSION['errors']['login_username_too_long'] = "Entered password and user name don't match";
        return false;
    }

    return true;
}


function isLegitLoginPassword ($inputPassword) {

    if(!is_string($inputPassword)) {
        $_SESSION['errors']['login_password_not_string'] = "Entered password and user name don't match";
        return false;
    }

    if(strlen($inputPassword) < 3) {
        $_SESSION['errors']['login_password_too_short'] = "Entered password and user name don't match";
        return false;
    }

    if(strlen($inputPassword) > 500) {
        $_SESSION['errors']['login_password_too_long'] = "Entered password and user name don't match";
        return false;
    }

    return true;

    return true;
}

function isLegitTaskDueTime ($inputTime) {

    if(strlen($inputTime) > 15) {
        $_SESSION['errors']['edit_task_illegal_date'] = "Incorrect date format.";
        return false;
    }

    http://stackoverflow.com/questions/12030810/php-date-validation
    $test_arr  = explode('-', $inputTime);
    if (count($test_arr) == 3) {
        if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
            $_SESSION['errors']['edit_task_illegal_date'] = "Incorrect date format ";
            return false;
        }
    } else {
        $_SESSION['errors']['edit_task_illegal_date'] = "Incorrect date format";
        return false;
    }

    return true;
}

function isLegitTaskInfo ($inputInfo) {


    if (strlen($inputInfo) > 5000) {
        $_SESSION['errors']['edit_task_info_too_long'] = "Additional info can be upto 5000 characters long";
    }

    return true;
}

function isLegitSearchKey($input_key) {

    if(!is_string($input_key)) {
        $_SESSION['errors']['searchkey_not_string'] = "Search keyword not OK";
        return false;
    }

    if(strlen($input_key) > 100) {
        $_SESSION['errors']['searchkey_too_long'] = "Search keyword can't be longer than 100 characters";
        return false;
    }


    return true;
}


?>