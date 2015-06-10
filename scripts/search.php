<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#found_text {
	color: #FF6600;
}
-->
</style>
</head>

<body>
<?php
	include('db.php');
	include('search_func.php');
	if ( isset($_POST['searchField']) )	{
		$search = simpleSearch($_POST['searchField']);
		$search = formatResult($search, $_POST['searchField']);
		for ( $i=1; $i <= count($search); ++$i ) {
			echo $search[$i]['articleTitle']."<br>";
			echo $search[$i]['articleText']."<br>";
			echo "<br>";
		}
	} else {
		echo "NO SEARCH PARAMETERS!";
	}
?>
</body>
</html>
