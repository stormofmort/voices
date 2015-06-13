<?php
include ('db.php');
include ('imageUpload.php');

if ($_POST[pagefunc] == 'Setup') {
	header ("location: ../workarea.php?page=Setup");
} else if ($_POST[pagefunc] == 'Edit'){
	header ("location: ../workarea.php?page=Edit&articleID=" . $_POST[articleID]);
} else if ($_POST[pagefunc] == 'Unfinished'){
	if (isset($_POST['imageNum'])) {
		$articleID = $_POST[articleID];
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
					uploadImage($j, $articleID, 1);
				} else {
					uploadImage($j, $articleID, 0);
				}
			}
		}
	}
	$conn = databaseConnect();
	$sql = "UPDATE `articletable` SET `articleUserStatus` = 1, articleStatus = 0 WHERE `articletable`.`articleID`='" . $_POST[articleID] . "' LIMIT 1";
	$result = mysql_query($sql, $conn);
	if ($result) {
		header ("location: ../workarea.php?page=" . $_POST[page]);
	}
	mysql_free_result($result);
	mysql_close($conn);
}  else if ($_POST[pagefunc] == 'Publish'){
	$conn = databaseConnect();
	$sql = "UPDATE `articletable` SET `articleUserStatus` = 2 WHERE `articletable`.`articleID`='" . $_POST[articleID] . "' LIMIT 1";
	$result = mysql_query($sql, $conn);
	if ($result) {
		header ("location: ../workarea.php?page=" . $_POST[page]);
	}
	mysql_free_result($result);
	mysql_close($conn);
} else if ($_POST[pagefunc] == 'Delete'){
	$conn = databaseConnect();
	$sql = "UPDATE `articletable` SET `articleUserStatus` = 3 WHERE `articletable`.`articleID`='" . $_POST[articleID] . "' LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		header ("location: ../workarea.php?page=" . $_POST[page]);
	}
	mysql_free_result($result);
	mysql_close($conn);
}  else if ($_POST[pagefunc] == 'Delete forever'){
	$conn = databaseConnect();
	$sql = "Delete FROM `articletable` WHERE `articletable`.`articleID`='" . $_POST[articleID] . "' LIMIT 1";
	$result = mysql_query($sql);
	if ($result) {
		header ("location: ../workarea.php?page=" . $_POST[page]);
	}
	//mysql_free_result($result);
	mysql_close($conn);
} else if ($_POST[funcType]){
	if (isset($_POST['imageNum'])) {
		$articleID = $_POST[articleID];
		$conn = databaseConnect();
		$query = "SELECT * FROM `imagetable` WHERE `articleID` = '" . $articleID . "'";
		$result = mysql_query ($query, $conn);
		if ($result) {
			$imageNum = mysql_num_rows($result);
			while ($row = mysql_fetch_assoc($result)) {
				$que = "UPDATE `imagetable` SET `imageThumb` = '0' WHERE `imagetable`.`imageID` = '" . $row['imageID'] . "'";
				$result2 = mysql_query ($que, $conn);
			}
		} else {
			$imageNum = 0;
		}
		mysql_close($conn);
		for ($j=1; $j<=$_POST['imageNum']; $j++) {
			if ($_FILES[$articleID.'_'. $j]['tmp_name'] != '') {
				uploadImage($j, $articleID, $imageNum, 0, 2);
			}
		}
		for ($j=1; $j<=$_POST['imageNum']; $j++) {
			if ($_POST['imageThumb'] == ($articleID.'_'. $j)) {
				if (isset($_FILES[$articleID.'_'. $j])) {
					$query = "UPDATE `imagetable` SET `imageThumb` = 1 WHERE `imagetable`.`imageName`='" . ($articleID.'_'. $j) . "' LIMIT 1"; 
				} else {
					$query = "UPDATE `imagetable` SET `imageThumb` = 1 WHERE `imagetable`.`imageName`='" . ($articleID.'_'. $j) . "' LIMIT 1"; 
				}
			}
		}
		$conn = databaseConnect();
		$result = mysql_query($query, $conn);
		//mysql_close($conn);
	}
	if ($_POST[funcType] == 'Publish') {
		$page = "Portfolio";
		$status = 2;
	} else if ($_POST[funcType] == 'Unfinished') {
		$page = "Unfinished";
		$status = 1;
	}
	if ($_POST['articleTitle'] == '') {
		header ("location: ../workarea.php?page=Edit&articleID=" . $articleID);
		exit();
	} else if ($_POST['articleSummary'] == '') {
		header ("location: ../workarea.php?page=Edit&articleID=" . $articleID);
		exit();
	} else if ($_POST['articleText'] == '') {
		header ("location: ../workarea.php?page=Edit&articleID=" . $articleID);
		exit();
	} else {
		$sql = "UPDATE `articletable` SET `articleUserStatus` = '3', `articleTitle` = '" . nl2br(addslashes($_POST['articleTitle'])) ."', `articleSummary` = '" .  nl2br(addslashes($_POST['articleSummary'])) ."', `articleText` = '" .  nl2br(addslashes($_POST['articleText'])) ."', `articleSubCat` = '" . addslashes($_POST['articleSubCat']) . "', `articleStatus` = '0', `articleUserStatus` = '" . $status . "' WHERE `articletable`.`articleID`='" . $_POST[articleID] . "' LIMIT 1";
		$result = mysql_query($sql);
		if ($result) {
			//mysql_free_result($result);
			header ("location: ../workarea.php?page=" . $page);
		} else {
			echo "error";
		}
		mysql_close($conn);
	}
}
?>