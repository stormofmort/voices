<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error Page</title>
<link href="../styles/common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	if ( isset($_GET['error']) ) {
		echo hi;
	} else {
		echo "<div id='notice_bad'>No Error Found!</div>";
	}
?>
</body>
</html>
