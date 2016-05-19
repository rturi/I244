<?php
require_once('funk.php');
session_start();
connect_db();

$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

include_once('views/head.html');

switch($page){
	case "login":
		logi();
	break;
	case "loomad":
        if(isset($_SESSION['user'])){
		    kuva_puurid();
        } else {
            header("Location: ?page=login");
            exit(0);
        }
	break;
	case "logout":
		logout();
	break;
	case "lisa":
		if(isset($_SESSION['user'])){
		    lisa();
        } else {
            header("Location: ?page=login");
            exit(0);
        }
	break;
	default:
		include_once('views/v2rav.html');
	break;
}

include_once('views/foot.html');

?>