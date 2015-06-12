<?php
	include("db.php");
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header( "Cache-Control: no-cache, must-revalidate" ); 
	header( "Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");
	
	if (isset($_GET['lastID'])) {
		$lastID = $_GET['lastID'];
	} else {
		$lastID = 0;
	}
	getData($lastID);
	
	function getData($lastID) {
		$sql = 	"SELECT * FROM chatdata WHERE chatdataID > ".$lastID." ORDER BY chatdataID ASC LIMIT 60";
		$conn = databaseConnect();
		$results = mysql_query($sql, $conn);
		if (!$results || empty($results)) {
			end;
		}
		while ($row = mysql_fetch_array($results)) {
			$name = $row[1];
			$text = $row[2];
			$date = $row[3];
			//$color = $row[4];
			$id = $row[0];
			if ($name == '') {
				$name = 'no name';
			}
			if ($text == '') {
				$text = 'no message';
			}
			echo $id." ---".$name." ---".$text." ---".$date." ---";
		}
	}
?>