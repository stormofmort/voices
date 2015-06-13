<?php
	function activationMail($username, $mail) {
		$conn = databaseConnect();
		
		$rand = md5($username.mt_rand());
		$sql = "INSERT INTO `confirmemail` (`username`, `randomText`) VALUES ('$username', '$rand')";
		$result = mysql_query($sql, $conn);
		
		mysql_close($conn);
		
		if ($result == true) {
			$header = "MIME-Version: 1.0 \n";
			$header .= "Content-Type: multipart/alternative; boundary=\"==Multipart_Boundary_xc75j85x\"";
			$subject = "Account Activation - www.voices.mv";
			$msg = "This is a multi-part message in MIME format.\r\n

--==Multipart_Boundary_xc75j85x
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

Dear ".$username.".\r\n
Thank you for registering at voices.mv.\r\n
\r\n
The purpose of this confirmation message is to verify that the email address you submitted is valid and reachable. We are working hard to keep the confirmation process as simple as possible.\r\n
\r\n
To complete your member registration, simply copy and paste the link below in your browser address bar:\r\n
\r\n
http://www.voices.mv/pages/accountActivate.php?xxx=$rand\r\n
\r\n
If you If you received this message but did not attempt to register, it means that someone may have entered your email address when registering with voices.mv, probably by mistake. If this is the case, you can safely disregardthis email -- no further action is required. We apologize for the intrusion.\r\n
\r\n
If you have any problems, please visit our contacts area so a customerservice representative can help you. http://www.voices.mv/home.php\r\n
				
--==Multipart_Boundary_xc75j85x
Content-Type: text/html; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

<html>
<head><title>A</title>
<style type=\"text/css\">
<!--
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	background-color: #FFFFFF;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #0066FF;
	font-weight: bold;
}
.orange {color: #FF6600}
-->
</style>
</head>
<body>
<p>Dear ".$username.",</p>
<p>Thank you for registering at <span class=\"orange\"><a href=\"http://www.voices.mv/pages/accountActivate.php?xxx=$rand\">voices.mv</a></span>.</p>
<p>The purpose of this confirmation message is to verify that the email address you   submitted is valid and reachable. We are working hard to keep the confirmation   process as simple as possible.</p>
<p>To complete your member registration, simply click on the following link (if the link cannot be clicked, copy and paste it in the browser address bar):</p>
<p><a href=\"http://localhost/voices2008/pages/accountActivate.php?xxx=$rand\">CLICK HERE </a></p>
<p>If you If you received this message but did not attempt to register, it means that someone may have entered your email address when registering with <span class=\"orange\">voices.mv</span>, probably by mistake. If this is the case, you can safely disregard this email -- no further action is required. We apologize for the intrusion.</p>
<p> If you have any problems, please visit our contacts area so a customerservice representative can help you. <span class=\"orange\">http://2008.voices.mv/home.php</span>  <br />
</p>
</body>
</html>
--==Multipart_Boundary_xc75j85x--";
			
			$result = mail($mail, $subject, $msg, $header);
		}
		
		return $result;
	}
	
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
			VALUES (NULL, '$username', SHA1( '$password' ), '$hiddenQ', '$hiddenA', '$firstname', '$lastname', '$sex', '$dob', '$address', '$street', '$city', '$country', '$zip', '$home', '$work', '$mobile', NOW() , '1', '0', '$email', '0000-00-00 00:00:00', '$profile', '$avatar')";
		$result = mysql_query($sql, $conn);
		
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

		$sql = "SELECT `userID`, `userName`, `groupName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `statusName`
								FROM `usertable`, `grouptable`, `statustable`
								WHERE `userID` = $userID
									AND `usertable`.`usergroup` = `grouptable`.`groupID`
									AND `usertable`.`userStatus` = `statustable`.`statusID`";
		$result = mysql_query($sql);
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
		
		$sql = "SELECT `userProfileStyle` FROM `usertable` WHERE `userID` = $userID";
		$result = mysql_query($sql);
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
				$query = "SELECT `userName`, `groupName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 3:			/* whow location */
				$query = "SELECT `userName`, `groupName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 4:			/* whow contact Info */
				$query = "SELECT `userName`, `groupName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;

			case 5:			/* whow address */
				$query = "SELECT `userName`, `groupName`, `userFirstName`, `userLastName`, `userAvatar`, UNIX_TIMESTAMP(userDOB) AS `userDOB`, UNIX_TIMESTAMP(userJoinDate) AS `userJoinDate`, `userEmail`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userAddress`, `userStreet`, `userZIP`, `userCountry`, `userCity`
										FROM `usertable`, `grouptable`, `statustable`
										WHERE `userID` = $userID
											AND `usertable`.`usergroup` = `grouptable`.`groupID`
											AND `usertable`.`userStatus` = `statustable`.`statusID`";
				$result = mysql_query($query);
				$array = mysql_fetch_array($result);
				break;
		}
		
		drawUserProfile($userID, $array, $style);
				
		mysql_free_result($result);
		mysql_close($conn);
	}
	
	function drawUserProfile($userID, $userProfile, $style) {
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td id='bigUsername' colspan='2'>".$userProfile['userName']."'s Profile</td>
			</tr><tr>
				<td colspan='2'><hr /></td>
			</tr><tr>
				<td colspan='2'>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr>
							<td valign='top'>
								Group: ".$userProfile['groupName']."<br />
								Joined On: "; echo printDate($userProfile['userJoinDate'], "d-M-y | H:i")."
							</td>
							<td id='avatarPic'>
								<img width='100' height='100' src='images/avatars/".$userProfile['userAvatar']."' />
							</td>
						</tr><tr>
							<td>&nbsp;</td>
							<td id='blackButton'><a href='#'>Add As Friend</a></td>
						</tr>
					</table>
				</td>
			</tr><tr>
				<td>
					<table cellspacing='0' cellpadding='0' border='0'>
						<tr>
							<td id='componentNameContentBlack'>PERSONAL INFORMATION: <a id=\"personal_InfoLink\" onclick=\"componentHide('personal_Info')\"></a></td>
							<td id='componentNameContentBlack'>LOCATION: <a id=\"locationLink\" onclick=\"componentHide('location')\"></a></td>
						</tr><tr>
							<td id='info_container'>";
								if ( $style > 1 ) {
									echo "<div id='personal_Info'>
										First Name: ".$userProfile['userFirstName']."<br />
										Last Name: ".$userProfile['userLastName']."<br />
										Birth Day: "; echo printDate($userProfile['userDOB'])."<br />
										Email: ".$userProfile['userEmail']."<br />
									</div>";
								} else {
									echo "Cannot display this information";
								}
							echo "</td>
							<td id='info_container'>";
								if ( $style > 2 ) {
									echo "<div id='location'>
											City: ".$userProfile['userCity']."<br />
											Country: ".$userProfile['userCountry']."<br />
									</div>";
								} else {
									echo "Cannot display this information";
								}
							echo "</td>
						</tr><tr>
							<td id='componentNameContentBlack'>CONTACT INFORMATION: <a id=\"contact_InfoLink\" onclick=\"componentHide('contact_Info')\"></a></td>
							<td id='componentNameContentBlack'>ADDRESS: <a id=\"addressLink\" onclick=\"componentHide('address')\"></a></td>
						</td><tr>
							<td id='info_container'>";
								if ( $style > 3 ) {
									echo "<div id='contact_Info'>
										Home Phone: ".$userProfile['userHomePhone']."<br />
										Work Phone: ".$userProfile['userWorkPhone']."<br />
										Mobile Phone: ".$userProfile['userMobilePhone']."<br />
									</div>";
								} else {
									echo "Cannot display this information";
								}
							echo "</td>
							<td id='info_container'>";
								if ( $style > 4 ) {
									echo "<div id='address'>
										Address: ".$userProfile['userAddress']."<br />
										Street: ".$userProfile['userStreet']."<br />
										ZIP: ".$userProfile['userZIP']."<br />
									</div>";
								} else {
									echo "Cannot display this information";
								}
							echo "</td>
						</tr>
					</table>
				</td>
			</tr>";
		echo "</table>";
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
		$query = "SELECT `messageID` FROM `messagetable` WHERE `receiverID` = '$userID' AND `read` = 0";
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
	
	function getArticlesByUser($userID) {
		global $start, $showLimit;
		
		$conn = databaseConnect();
		$sql = "SELECT DISTINCT `articleID`, `articleTitle`, `articleSummary`, `catSubID`, `catSubName`, `catMainName` FROM `articletable`, `catsubtable`, `catmaintable` WHERE `userID` = $userID AND `articletable`.`articleSubCat` = `catsubtable`.`catSubID` AND `articleStatus` = 1 AND `catsubtable`.`catMainID` = `catmaintable`.`catMainID`";
		$result = mysql_query($sql);
		
		$count = mysql_num_rows($result);
		
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
		if ( $count > 0 ) {
			for ( $i=0; $i < $count; ++$i ) {
				$array = mysql_fetch_array($result);
				echo "<tr>";
				echo "<td id='articleTitle_profile'><a href='articles.php?articleID=".$array['articleID']."'>".$array['articleTitle']."</a></td>";
				echo "<td rowspan='3' id='articlePicProfile_Container'>
					<table border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td id='articlePicProfile_Left'>&nbsp;</td>
							<td><img src='images/articlePics/".$array['articleID']."/".$array['articleID']."_thumb.jpg' width='54' height='54' /></td>
						</tr><tr>
							<td id='articlePicProfile_Corner'>&nbsp;</td>
							<td id='articlePicProfile_Bottom'>&nbsp;</td>
						</tr>
					</table></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td id='articleCategory_profile'><a href='category.php?catSub=".$array['catSubID']."'>".$array['catMainName']."|".$array['catSubName']."</a></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td id='articleSummary_profile'>".$array['articleSummary']."</td>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td id='notice_neutral'>no articles</td></tr>";
		}
		echo "</table>";
	}
?>