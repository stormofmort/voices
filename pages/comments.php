<?php
	session_start();
	include('../scripts/db.php');
	include('../scripts/user_func.php');
	include('../scripts/cookie_func.php');
	include('../scripts/common.php');
	include('../scripts/article_func.php');
	include('../scripts/pagination.php');
	
	if ( isset($_GET['showLimit']) && is_numeric($_GET['showLimit']) && $_GET['showLimit'] >= 5 && $_GET['showLimit'] <= 20 ) {
		$showLimit = $_GET['showLimit'];
	} else {
		$showLimit = 5;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES comments</title>
<link href="../styles/common.css" rel="stylesheet" type="text/css" />
<link href="../styles/billboard.css" rel="stylesheet" type="text/css" />
<link href="../styles/articles.css" rel="stylesheet" type="text/css" />
<link href="../styles/pagination.css" rel="stylesheet" type="text/css" />
</head>

<body onLoad="parent.onLoadPage();">
<?php
	$numComments = countComments($_GET['articleID']);
	$numPages = countPages($numComments, $showLimit);

	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	if ( $numPages > 0 ) {
		getPages();
		getComments($_GET['articleID']);
	}
	echo "<tr>"; if ( $numPages > 0 ) { echo "<td>"; drawPagination($currStart, $currEnd, "comments"); echo "</td>"; } else { echo "<td id='notice_neutral'>NO COMMENTS</td>"; } echo "</tr>";
	if ( isset($_SESSION['validuser']) ) {
		echo "<tr>
				<td id='boldBlackText'>Quick Comment</td>
			</tr>
				<form id='commentForm' name='commentForm' action='../scripts/postComment.php' method='POST'>
			<tr>
				<td align='center'>
					<textarea id='inputText' name='comment' cols='91' rows='5'></textarea>
					<input type='hidden' name='sender' value='".$_SESSION['validuserID']."' />
					<input type='hidden' name='articleID' value='".$_GET['articleID']."' />
					<input type='hidden' name='query' value='".$_SERVER['QUERY_STRING']."' />
				</td>
			</tr><tr>
				<td align='center'>
					<table border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td><input type='submit' id='blackButton' value='POST' /></td>
							<td id='blackButton'><a href='writeComment.php?validUser=".$_SESSION['validuserID']."&articleID=".$_GET['articleID']."'>WRITE NEW</a></td>
						</tr>
					</table>
				</td>
			</tr>
		</form>";
	}
	echo "</table>";
?>
</body>
</html>
