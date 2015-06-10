<?php
	include('db.php');
	include('article_func.php');
	include('pagination.php');

	$numComments = countComments($_POST['articleID']);
	$numPages = countPages($numComments, 1);
	
	if ( !isset($_POST['articleID']) ) {
		header("Location: ../home.php");
	}
	
	if ( isset($_POST['query']) ) {
		$query = "&".$_POST['query'];
	} else {
		$query = NULL;
	}
		
	if ( !isset($_POST['comment']) || !isset($_POST['sender']) || $_POST['comment'] == '' || !isset($_POST['articleID'])) {
		header("Location: ../pages/comments.php?articleID=".$_POST['articleID']."&currPage=".$numPages.$query);
	} else {
		if ( !isset($_POST['quotedMsg']) || $_POST['quotedMsg'] == '' ) {
			$quotedMsg = "NULL";
		} else {
			$quotedMsg = $_POST['quotedMsg'];
		}

		$conn = databaseConnect();
		$sql = "INSERT INTO `commenttable` (
				`commentID` ,
				`articleID` ,
				`userID` ,
				`commentText` ,
				`replyto` ,
				`commentTime` ,
				`commentFlag` ,
				`commentStatus`
			) VALUES (
				NULL , '".addslashes($_POST['articleID'])."', '".addslashes($_POST['sender'])."', '".addslashes($_POST['comment'])."', ".addslashes($quotedMsg)." , NOW() , '0', '1'
			)";
		$result = mysql_query($sql);
		header("Location: ../pages/comments.php?articleID=".$_POST['articleID']."&currPage=".$numPages.$query);
	}
	
			
?>