<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>avatarUpload</title>
</head>

<body>
<?php
	include('../scripts/avatar_func.php');
	// image dir;
	
	$avatar_dir = "../images/avatars/";
	
	// check if a new Avatar has been uploaded and a username set in POST vars;
	if ( isset($_POST['newCustomAvatar']) &&  isset($_POST['user']) ) {
		// get avatar details;
		$newAvatar = getimagesize($avatar_dir.$_POST['newCustomAvatar']);
		$oldAvatar = getimagesize($avatar_dir.$_POST['currCustomAvatar']);
		
		// get new avatar type;
		$newType = image_type_to_extension($newAvatar[2]);
		$oldType = image_type_to_extension($oldAvatar[2]);

		// backup old avatar;
		if ( isset($_POST['currCustomAvatar']) ) {
			rename( $avatar_dir.$_POST['currCustomAvatar'], $avatar_dir."back_".$_POST['currCustomAvatar'] );
		}
		$newFile = $_POST['user'].$newType;
		$change = rename( $avatar_dir.$_POST['newCustomAvatar'], $avatar_dir.$newFile );
		
		if ( $change == 1 ) {
			// if new avatar renamed delete old avatar;
			unlink($avatar_dir."back_".$_POST['currCustomAvatar']);
			updateAvatar($newFile, $_POST['userID']);
		} else {
			// if new avatar not renamed restore backup
			rename( $avatar_dir."back_".$_POST['currCustomAvatar'], $avatar_dir.$_POST['currCustomAvatar'] );
			$error = "could not rename";
		}
		header("Location: ../options.php");
	} else {
		echo "Error Occured!";
	}
?>
</body>
</html>
