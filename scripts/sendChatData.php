<?php
	include("db.php");
	
	$name = $_POST[n]; 
	$text = trim ($_POST[c]);
	
	$ch = substr($text,0,4);
	while ($ch == "<br>") {
		$text = substr($text,4,strlen($text));
		$ch = substr($text,0,4);
	}
	
	if (strlen($text) > 150) {
		$text = substr($text,0,150); 
	}
	
	//$text = preg_replace("/([^\s]{30})/","$1 ",$text);
	
	if (strlen($name) > 20) {
		$name = substr($name, 0,20); 
	}
	
	if ($name != '' && ($text != '' || $text != 0 || $text != NULL )) {//|| $text != "<p>" || $text != "<p> </p>")) {
		addData($name,$text); 
		getID(50);
	}
	
	function addData($name,$text) {	
		$sql = "INSERT INTO `chatdata` (username, message, date) VALUES ('".$name."','".$text."', NOW())";
		$conn = databaseConnect();
		$results = mysql_query($sql, $conn);
		if (!$results || empty($results)) {
			end;
		}
	}
	
	function getID($position) {
		$sql = 	"SELECT * FROM `chatdata` ORDER BY `chatdataID` DESC LIMIT ".$position.",1";
		$conn = databaseConnect(); 
		$results = mysql_query($sql, $conn);
		if (!$results || empty($results)) {
			//echo 'There was an error creating the entry';
			end;
		}
		while ($row = mysql_fetch_array($results)) {
			$id = $row[0];
		}
		if ($id) {
			deleteEntries($id); 
		}
	}
	
	function deleteEntries($id) {
		$sql = 	"DELETE FROM `chatdata` WHERE chatdataID < ".$id;
		$conn = databaseConnect();
		$results = mysql_query($sql, $conn);
		if (!$results || empty($results)) {
			//echo 'There was an error deletig the entries';
			end;
		}
	}
?>