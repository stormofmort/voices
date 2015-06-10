<?php
	if (!isset($_GET['returnto']) || $_GET['returnto'] == NULL) {
		header("Location: error.php");
	} else {
		$returnto = $_GET['returnto'];
	}
	
	$pattern1 = "\?cookieFail=.*&stamp=.*";
	$pattern2 = "&cookieFail=.*&stamp=.*";
	$string = $_GET['query'];
	eregi_replace($pattern1, NULL, $string);
	eregi_replace($pattern2, NULL, $string);
	
	if (strlen($string) < 1) {
		$query = NULL;
	} else {
		$query = $string;
	}

	if (isset($_COOKIE['testcookie'])) {
		header("Location: ".$returnto.$query);
	} else {
		if ($query == NULL) {
			header("Location: ".$returnto."?cookieFail=1&stamp=".time());
		} else {
			header("Location: ".$returnto.$query."&cookieFail=1$stamp=".time());
		}
	}
?>
