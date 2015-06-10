<?php
	$server = "localhost";
	$db = "voices_mv_-_maindb";
	$dbuser = "voices";
	$dbpass = "vioces";
	
	function databaseConnect() {
		global $server, $db, $dbuser, $dbpass;

		$conn = mysql_connect($server, $dbuser, $dbpass) or die (mysql_error());
		if (!$conn) {
			return 0;
		}
		if (!mysql_select_db($db, $conn)) {
			return 0;
		}
		return $conn;
	}
?>