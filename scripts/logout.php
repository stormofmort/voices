<?php
	session_start();
	include('cookie_func.php');

	if (!(isset($_SESSION['validuserID']))) {
		session_destroy();
		header("Location: ".$_GET['returnto']."?".$_GET['query']);
	} else {
		session_destroy();
		deleteCookie("voicesuser");
		deleteCookie("userchecksum");
		deleteCookie("PHPSESSID");
		if ($_POST['query'] != NULL) {
			$query = "?".$_POST['query'];
		}

		header("Location: ".$_GET['returnto'].$query);
	}
?>