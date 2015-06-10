<?php
	include('../scripts/db.php');
	
	function deleteDuplicate($image, $type) {
		$image = strtolower($image);
		$avatar_dir = '../images/avatars/';
		$curr_dir = opendir($avatar_dir);
		while ( $file = readdir($curr_dir) ) {
			$file = strtolower($file);
			if ( ($file == $image.".jpeg" || $file == $image.".jpg" || $file == $image.".gif" || $file == $image.".png") && $file != $image.".".$type ) {
				unlink("../images/avatars/".$file);
			}
		}
		closedir($curr_dir);
	}
	
	function updateAvatar($new, $userID) {
		$conn = databaseConnect();

		$sql = "UPDATE `usertable` SET `userAvatar` = '$new' WHERE `usertable`.`userID` = $userID LIMIT 1";
		$result = mysql_query($sql);
		
		mysql_free_result($result);
		mysql_close($conn);
	}
?>