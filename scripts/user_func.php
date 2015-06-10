<?php
	function fetchPass($userID) {
		$conn = databaseConnect();
		
		$sql = "SELECT `password` FROM `usertable` WHERE `userID`=$userID";
		$result = mysql_query($sql);
		$array = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array['password'];
	}
	
	function changePassword($newPassword, $userID) {
		$conn = databaseConnect();
		
		$sql = "UPDATE `usertable` SET `password` = SHA1( '$newPassword' ) WHERE `usertable`.`userID`=$userID LIMIT 1";
		$result = mysql_query($sql);
		
		mysql_free_result($result);
		mysql_close($conn);
	}
	
	function loadUserOptions($userID) {
		$conn = databaseConnect();
		$sql = "SELECT `userID`, `userName`, `password`, `userHiddenQ`, `userHiddenA`, `userFirstName`, `userLastName`, `sex`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, `userAddress`,	`userStreet`,	`userCity`, `userCountry`, `userZIP`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userJoinDate`, `userGroup`, `userStatus`, `userEmail`, `userLastLogin`, `userProfileStyle`, `userAvatar` FROM `usertable` WHERE `userID`='$userID'";
		$result = mysql_query($sql);
		$array = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array;
	}
		
	function registerUser($username, $password, $hiddenQ, $hiddenA, $firstname, $lastname, $sex, $dob, $address, $street, $city, $country, $zip, $home, $work, $mobile, $email, $profile, $avatar) {
		$conn = databaseConnect();
		
		$sql = "INSERT INTO `usertable` (`userID`, `userName`, `password`, `userHiddenQ`, `userHiddenA`, `userFirstName`, `userLastName`, `sex`, `userDOB`, `userAddress`,	`userStreet`,	`userCity`, `userCountry`, `userZIP`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userJoinDate`, `userGroup`, `userStatus`, `userEmail`, `userLastLogin`, `userProfileStyle`, `userAvatar`)
			VALUES (NULL, '$username', SHA1( '$password' ), '$hiddenQ', '$hiddenA', '$firstname', '$lastname', '$sex', '$dob', '$address', '$street', '$city', '$country', '$zip', '$home', '$work', '$mobile', NOW() , '1', '1', '$email', '0000-00-00 00:00:00', '$profile', '$avatar')";
		$result = mysql_query($sql);

		mysql_free_result($result);
		mysql_close($conn);
		
		return $result;
	}
	
	function updateUser($userID, $hiddenQ, $hiddenA, $firstname, $lastname, $sex, $dob, $address, $street, $city, $country, $zip, $home, $work, $mobile, $email, $profile, $avatar) {
		$conn = databaseConnect();
		
		$sql = "UPDATE `usertable`
			SET `userHiddenQ` = '$hiddenQ',
					`userHiddenA` = '$hiddenA',
					`userFirstName` = '$firstname',
					`userLastName` = '$lastname',
					`sex` = '$sex',
					`userDOB` = FROM_UNIXTIME(".$dob."),
					`userAddress` = '$address',
					`userStreet` = '$street',
					`userCity` = '$city',
					`userCountry` = '$country',
					`userZIP` = '$zip',
					`userHomePhone` = '$home',
					`userWorkPhone` = '$work',
					`userMobilePhone` = '$mobile',
					`userEmail` = '$email',
					`userProfileStyle` = '$profile',
					`userAvatar` = '$avatar'
			WHERE `usertable`.`userID` = $userID
			LIMIT 1";
		$result = mysql_query($sql);

		mysql_free_result($result);
		mysql_close($conn);
		
		return $result;
	}
	
	function duplicateUserName($username) {
		$conn = databaseConnect();
		
		$sql = "SELECT `userID` FROM `usertable` WHERE `username` = '$username'";
		$result = mysql_query($sql);
		$rows = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);

		if ( $rows > 0 ) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function duplicateEmail($email) {
		$conn = databaseConnect();
		
		$sql = "SELECT `userID` FROM `usertable` WHERE `userEmail` = '$email'";
		$result = mysql_query($sql);
		$rows = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		if ( $rows > 0 ) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function getAge($DOB) {
		$today = mktime(0,0,0,date("n"), date("j"), date("Y"));
		$age = ($today - $DOB) / (60*60*24*365.25);
		
		return intval($age);
	}
	
	function countArticlesByUser($userID) {
		$conn = databaseConnect();
		
		$query = "SELECT * FROM `articletable` WHERE `userID` = $userID AND `articleStatus` = 1";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		if ( $count < 1 ) {
			return 0;
		} else {
			return $count;
		}
	}
	
	function userSpotLight($userID) {
		$conn = databaseConnect();

		$query = "SELECT `userID`, `userName`, `groupName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `statusName`
								FROM `usertable`, `grouptable`, `statustable`
								WHERE `userID` = $userID
									AND `usertable`.`usergroup` = `grouptable`.`groupID`
									AND `usertable`.`userStatus` = `statustable`.`statusID`";
		$result = mysql_query($query);
		$spotlight = mysql_fetch_array($result);

		mysql_free_result($result);
		mysql_close($conn);
		
		return $spotlight;
	}
	
	function drawSpotlight($spotlight) {
		echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>
			<tr>
				<td id='cornerTL4'>&nbsp;</td>
				<td id='lineT4'>&nbsp;</td>
				<td id='cornerTR4'>&nbsp;</td>
			</tr><tr>
				<td id='lineL4'>&nbsp;</td>
				<td id='billboard'>
					<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<tr>
							<td>
								<table width='100%' border='0' cellpadding='0' cellspacing='0'>
									<tr>
										<td id='billboardHeading' colspan='2'>Author Spotlight</td>
									</tr><tr>
										<td id='smallGreyHeading'>Author: </td>
										<td id='billboardUserName'>".$spotlight['userName']."</td>
									</tr>
									</tr><tr>
										<td id='smallGreyHeading'>Ranking: </td>
										<td id='billboardText'>".$spotlight['groupName']."</td>
									</tr><tr>
										<td id='smallGreyHeading'>Join Date: </td>
										<td id='billboardText'>";echo printDate($spotlight['userJoinDate'], "d-M-Y")."</td>
									</tr><tr>
										<td id='smallGreyHeading'>Age: </td>
										<td id='billboardText'>"; echo getAge($spotlight['userDOB'])." Years</td>
									</tr><tr>
										<td id='smallGreyHeading'>Live Articles: </td>
										<td id='billboardText'>"; echo countArticlesByUser($spotlight['userID'])."</td>
									</tr><tr>
										<td id='billboardLink' colspan='2'><a href='profile.php?userID=".$spotlight['userID']."'>View Profile</a></td>
									</tr>
								</table>
							</td><td id='userAvatar'>
								<img width='100' height='100' src='images/avatars/".$spotlight['userAvatar']."' />
							</td>
						</tr>
					</table>
				</td>
				<td id='lineR4'>&nbsp;</td>
			</tr><tr>
				<td id='cornerBL4'>&nbsp;</td>
				<td id='lineB4'>&nbsp;</td>
				<td id='cornerBR4'>&nbsp;</td>
			</tr>
		</table>";
	}
	
	function getUserProfile($userID) {
		$conn = databaseConnect();
		
		$query = "SELECT `userProfileStyle` FROM `usertable` WHERE `userID` = $userID";
		$result = mysql_query($query);
		$array = mysql_fetch_array($result);
		$style = $array[0];
		
		if ($style < 1 && $style > 5) {
			$style = 1;
		}
		
		switch ($style) {
			case 1: 		/* bare minimum profile ie: PERSONAL INFO + AVATAR + JOINDATE*/
				$query = "SELECT `userName`, `userAvatar`, `groupName`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `statusName`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 2:			/* show username and some personal info */
				$query = "SELECT `userName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 3:			/* whow location */
				$query = "SELECT `userName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 4:			/* whow contact Info */
				$query = "SELECT `userName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 5:			/* whow address */
				$query = "SELECT `userName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userAddress`, `userStreet`, `userZIP`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;
		}
		
		drawUserProfile($userID, $array);
				
		mysql_free_result($result);
		mysql_close($conn);
	}
	
	function drawUserProfile($userID, $userProfile) {
		echo "<table border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td><img width='100' height='100' src='images/avatars/".$userProfile['userAvatar']."' /></td>
				<td><table border='0' cellpadding='0' cellspacing='0'>
					<tr>
						<td>Username: </td>
						<td>".$userProfile['userName']."</td>
					</tr><tr>
						<td>First Name: </td>
						<td>".$userProfile['userFirstName']."</td>
					</tr>
					</tr><tr>
						<td>Last Name: </td>
						<td>".$userProfile['userLastName']."</td>
					</tr>
				</table></td>
			</tr>
		</table>";
	}
	
	function getuserDetails($user, $by = "userID") {
		$conn = databaseConnect();
		if ( $by == "username" ) {
			$add = "`userName` = '$user'";
		} else {
			$add = "`userID` = $user";
		}
		$sql = "SELECT `userID`, `userName`, `userAvatar`, `userJoinDate`, `userStatus`, `groupName` AS `userGroup` FROM `grouptable`, `usertable` WHERE $add AND `userGroup` = `groupID`";
		$result = mysql_query($sql ,$conn) or die (mysql_error());
		
		if (mysql_num_rows($result) > 0) {

			$array = mysql_fetch_assoc($result);
			mysql_free_result($result);
			mysql_close($conn);

			return $array;
		}
	}
		
	function verifyChecksum($user, $checksum) {
		$conn = databaseConnect();
		$query = "SELECT `userName`, `password` FROM `usertable` WHERE `userName` = '$user'";
		$result = mysql_query($query ,$conn) or die (mysql_error());
		
		if (mysql_num_rows($result) > 0) {
			$fields = mysql_fetch_assoc($result);
			$input = $fields['userName'].$fields['password'];
			$output = sha1($input);

			mysql_free_result ($result);
			mysql_close($conn);

			if ($checksum == $output) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
		mysql_free_result ($result);
		mysql_close($conn);
	}

	function checkUserExist($user, $pass) {
		$conn = databaseConnect();
		$query = "SELECT `userID`, `userName` FROM `usertable` WHERE `userName` = '$user' AND `password` = sha1('$pass')";
		$result = mysql_query($query ,$conn) or die (mysql_error());
		$array = mysql_fetch_assoc($result);
		
		if (mysql_num_rows($result) == 1) {
			$sql = "UPDATE `usertable` SET `userLastLogin` = NOW() WHERE `usertable`.`userID` = ".$array['userID']." LIMIT 1";
			$result = mysql_query($sql);
	
			mysql_free_result ($result);
			mysql_close($conn);

			return $array['userName'];
		} else {

			mysql_free_result ($result);
			mysql_close($conn);

			header("Location: ../pages/error.php?msg=2.2");
			exit;
		}
		mysql_free_result ($result);
		mysql_close($conn);
	}
	
	function unset_validuser() {
		$_SESSION['validuserID'] = NULL;
		$_SESSION['validuser'] = NULL;
		$_SESSION['userJoinDate'] = NULL;
		$_SESSION['userGroup'] = NULL;
	}
	
	function messageCount($userID) {
		$conn = databaseConnect();
		$query = "SELECT `messageID` FROM `messagetable` WHERE `recieverID` = '$userID' AND `read` = 0";
		$result = mysql_query($query, $conn) or die (mysql_error());
		$count = mysql_num_rows($result);

		mysql_free_result ($result);
		mysql_close($conn);

		if ($count == 0) {
			return "(0 unread)";
		} else {
			return	"<span style='color:#FF0000'>(".$count." unread)</span>";
		}
	}
?>