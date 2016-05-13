<?php


function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){

    $errors = array();
    global $connection;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(empty($_POST['user'])) $errors['empty_username'] = "Sisesta kasutajanimi";
        if(empty($_POST['pass'])) $errors['empty_password'] = "Sisesta parool";

        $input_user = mysqli_real_escape_string($connection, $_POST['user']);
        $input_password = sha1(mysqli_real_escape_string($connection, $_POST['pass']));

        $sql = "SELECT username FROM rturi_kylastajad WHERE username = '". $input_user . "' AND passw = '" . $input_password . "'";

        $result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['user'] = htmlspecialchars($input_user);
            header("Location: ?");
            exit(0);
        } else $errors['vale_sisend'] = "Sisestatud kasutja ja parooli kombo ei sobi";


    }


	include_once('views/login.html');
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
	exit(0);
}

function kuva_puurid(){
	// siia on vaja funktsionaalsust

    global $connection;

    $sql = "SELECT DISTINCT(cage) FROM `rturi_zoo`";

    $puurid[] = array();

	$result = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

    while ($row = mysqli_fetch_assoc($result)){

        $sql = "SELECT species FROM `rturi_zoo` WHERE cage = " . $row['cage'];

        $result2 = mysqli_query($connection, $sql) or die("$sql - ".mysqli_error($connection));

        $i = 0;
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $puurid[$row['cage']][] = $row2['species'];
            $i++;
        }

    }

    include_once('views/puurid.html');
	
}

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	
	include_once('views/loomavorm.html');
	
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>