<?php
	session_start();
	include('../scripts/db.php');
	include('../scripts/user_func.php');
	include('../scripts/cookie_func.php');
	include('../scripts/validate.php');

	if ((!$_POST['usernameInput']) || (!$_POST['passwordInput'])) {
		header("Location: ../pages/error.php?msg=2.1");
		exit;
	} else {
		$userNameCheck = check_Text($_POST['usernameInput'], 5, 20);
		$passwordCheck = check_Text($_POST['passwordInput'], 5, 20);
		
		if ( $userNameCheck == 0 && $passwordCheck == 0 ) {
			$user_exist = checkUserExist($_POST['usernameInput'], $_POST['passwordInput']);
			$details = getuserDetails($_POST['usernameInput'], "username");
			
			if ($details['userStatus'] == -1) {
				echo "BANNED!";
				unset_validuser();
			} elseif ($details['userStatus'] == 0) {
				echo "INACTIVE!";
				unset_validuser();
			} else {
				$_SESSION['validuserID'] = $details['userID'];
				$_SESSION['validuser'] = $details['userName'];
				$_SESSION['userJoinDate'] = $details['userJoinDate'];
				$_SESSION['userAvatar'] = $details['userAvatar'];
				$_SESSION['userGroup'] = $details['userGroup'];
				
				createCookie("voicesuser", $details['userName']);
				createCookie("userchecksum", sha1($details['userName'].sha1($_POST['passwordInput'])));
			}
			if ($_POST['query'] != NULL) {
				$query = "?".$_POST['query'];
			}
			header("Location: ".$_POST['returnto'].$query);
		} else {
			header("Location: ../pages/error.php?msg=2.2");
			exit;;
		}
	}
?>