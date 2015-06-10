<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>avatarUpload</title>
</head>

<body>
<?php
	session_start();
	include('../scripts/avatar_func.php');

	$error = 0;

	$dimensions = getimagesize($_FILES['newAvatar']['tmp_name']);
	
	if ( $dimensions[0] > 1000 || $dimensions[1] > 1000 ) {
		++$error;
		$msg = "Image resolution is too large. Max resolution = 1000pixel x 1000pixel";
	}

	if ( isset($_FILES['newAvatar']) ) {
		if ( $_FILES['newAvatar']['tmp_name'] == '' ) {
			$msg = "No file was selected for upload!";
			++$error;
		}

		if ( $_FILES['newAvatar']['size'] > $_POST['maxFileSize'] ) {
			$msg = "Filesize too big!";
			++$error;
		}
		
		if ( $_FILES['newAvatar']['size'] == 0 ) {
			$msg = "filesize zero error";
			++$error;
		}
		
		if ( $_FILES['newAvatar']['type'] == 'image/png' ) {
			$type = "png";
		} elseif ( $_FILES['newAvatar']['type'] == 'image/jpeg' ) {
			$type = "jpeg";
		} elseif ( $_FILES['newAvatar']['type'] == 'image/jpg' ) {
			$type = "jpg";
		} elseif ( $_FILES['newAvatar']['type'] == 'image/gif' ) {
			$type = "gif";
		} else {
			$msg = "Wrong filetype";
			++$error;
		}
		
		if ( $error == 0 ) {
			$upfile = "../images/avatars/".$_POST['newFileName']."_new.".$type;
			
			if ( !copy($_FILES['newAvatar']['tmp_name'], $upfile) ) {
				echo "upload failed";
			} else {
				$image = $_POST['newFileName']."_new";
				deleteDuplicate($image, $type);
				header("Location: ../options.php");
			}
		} else {
			echo $msg;
		}
	} else {
		echo "No file selected for upload!";
	}
?>
</body>
</html>
