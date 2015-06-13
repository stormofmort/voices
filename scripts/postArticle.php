<?php
	include('db.php');
	include ('imageUpload.php');
	if ( isset($_POST['query']) ) {
		$query = "&".$_POST['query'];
	} else {
		$query = NULL;
	}
		
	if ($_POST['articleTitle']=='' || $_POST['articleText']=='' || !isset($_POST['validUser']) || $_POST['articleSummary'] == '' || $error > 1) {
		echo "error";
	} else {
		if ($_POST['publish']) {
			$userArticleStatus = 2;
		} else if($_POST['saveUnfinished']){
			$userArticleStatus = 1;
		}
		$conn = databaseConnect();
		$sql = "INSERT INTO `articletable` (
				`articleID` ,
				`userID` ,
				`articleSubmitDate` ,
				`articleApproveDate` ,
				`articleTitle` ,
				`articleSummary` ,
				`articleText` ,
				`articleViews` ,
				`articleSubCat` ,
				`articleStatus` ,
				`articleUserStatus`
			) VALUES (
				NULL , '".addslashes($_POST['validUser'])."', NOW(), NULL, '".addslashes($_POST['articleTitle'])."', '" . nl2br(addslashes($_POST['articleSummary'])) . "', '" . nl2br(addslashes($_POST['articleText'])) . "', '0' , '" . addslashes($_POST['articleSubCat']) . "' , '0', '" . $userArticleStatus . "'
				)";
		$result = mysql_query($sql, $conn);
		if (!$result) {
			echo $_POST['articleTitle'];
		} else {
			if (isset($_POST['imageNum'])) {
				$articleID = mysql_insert_id();
				mysql_close($conn);
				$x=0;
				for ($i=1; $i<=$_POST['imageNum']; $i++) {
					if ($_FILES['newImage'. $i]['tmp_name'] != '') {
						$x=$i;
						if ($_POST['thumb'] == ('newImage'.$i)) {
							$x=$i;
							break;
						}
					}
				}
				for ($j=1; $j<=$_POST['imageNum']; $j++) {
					if ($_FILES['newImage'. $j]['tmp_name'] != '') {
						if($j==$x) {
							uploadImage($j, $articleID, 0, 1, 1);
						} else {
							uploadImage($j, $articleID, 0, 0, 1);
						}
					}
				}
			}
			header("Location: ../workarea.php?page=New");
		}
	}
?>