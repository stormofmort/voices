<?php
	/*
	function msgRead($msgID) {
		$conn = databaseConnect();
		$sql = "UPDATE `voices_mv_-_maindb`.`messagetable` SET `sendDate` = NOW( ), `read` = '1' WHERE `messageID` = $msgID LIMIT 1 ";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $count;
	}
	*/
	function printMessage($msg) {
		echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td id='boldBlackText'>Subject: ".$msg['subject']."</td>
			</tr><tr>
				<td id='messagePane'>".$msg['message']."</td>
			</tr>
		</table>";
	}
	
	function otherUserDetails($array, $side) {
		echo "<table id='otherUserTable' align='center' cellspacing='0' cellpadding='0'>
			<tr>
				<td valign='top' rowspan='2' width='100%'><table>
					<tr>
						<td id='boldBlackText'>$side's Information</td>
					</tr><tr>
						<td>Username: ".$array['userName']."</td>
					</tr><tr>
						<td>Group: ".$array['userGroup']."</td>
					</tr><tr>
						<td>Joined On: "; echo printDate($array['userJoinDate']); echo "</td>
					</tr>
				</table></td>
				<td align='center'><img id='avatarPic' src='images/avatars/".$array['userAvatar']."' /></td>
			</tr><tr>
				<td id='msgBlueLink'><a href='profile.php?userID=".$array['userID']."'>View Profile</a></td>
		</table>";
	}
/*	
	function readMessage($msgID, $userID) {
		$conn = databaseConnect();
		$sql = "SELECT `senderID`, `recieverID`, `subject`, `message`, UNIX_TIMESTAMP(sendDate) AS `sendDate` FROM `messagetable` WHERE (`recieverID` = $userID AND `recieverStatus` = 'Inbox' AND `messageID` = '$msgID') OR (`senderID` = $userID AND `senderStatus` = 'Outbox' AND `messageID` = '$msgID') LIMIT 1";
		$result = mysql_query($sql);
		$array = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array;
	}
*/
	function getArticles($userID, $page, $method='GET' ) {
		global $start, $showLimit, $currPage, $numPages;
		switch ($page) {
			case "Portfolio":
				$criteria = "`userID` = ".$userID." AND `articleUserStatus`=2";
				break;
			case "Unfinished":
				$criteria = "`userID` = ".$userID." AND `articleUserStatus`=1";
				break;
			case "New":
				$criteria = "`userID` = ".$userID." AND `articleUserStatus`=4";
				break;
			case "Trash":
				$criteria = "`userID` = ".$userID." AND `articleUserStatus`=3";
				break;
		}
		if ( $method == "count" ) {
			$fields = "COUNT(*)";
			$limit = "";
		} else {
			$fields = "*";
			$limit = "LIMIT $start, $showLimit";
			
		}
		if ($page != "Setup" && $page != "Edit") {
			$conn = databaseConnect();
			$sql = "SELECT $fields FROM `articletable` WHERE $criteria $limit";
			$result = mysql_query($sql, $conn);
			//$array = [];
			if ($result) {
				if ( $method == "count" ) {
					$x = mysql_fetch_array($result);
					$array = $x[0];
				} else {
					$count = mysql_num_rows($result);
					for ( $i = 0; $i < $count; ++$i ) {
						$array[$i] = mysql_fetch_assoc($result);
					}
				}
				mysql_free_result($result);
			}
			
			
			mysql_close($conn);
			return $array;
		}
	}

	function drawMsgNav($currPage) {
		$pages = array("Portfolio", "Unfinished", "New", "Trash");
		echo "<table border='0' cellspacing='0' cellpadding='0' align='center'>";
		echo "<tr>";
		for ( $i = 0; $i <= 3; $i++ ) {
			if ( $currPage == $pages[$i] ) {
				echo "<td id='workAreaNav".$pages[$i]."_active'>&nbsp;</td>";
				echo "<td id='boldBlackText'>".$pages[$i]."</td>";
			} else {
				echo "<td id='workAreaNav".$pages[$i]."_inactive'><a href='workarea.php?page=".$pages[$i]."' />&nbsp;</a></td>";
			}
		}
		if ($currPage == "Setup") {
			echo "<td id='workAreaNavSetup_active'>&nbsp;</td>";
			echo "<td id='boldBlackText'>Setup</td>";
		}else if($currPage == "Edit"){
			echo "<td id='workAreaNavEdit_active'>&nbsp;</td>";
			echo "<td id='boldBlackText'>Edit</td>";
		}
		echo "</tr>";
		echo "</table>";
	}
	
	function billboardMessage($page) {
		switch ($page) {
			case "Portfolio":
				$msg = "<p>All your pubished works at one glance. You could:-</p>
								- View your published articles<br />
								- Inspect status of articles<br />
								- Edit existing articles
								<p>Edited articles and newly uploaded pics are moderated</p>";
				break;
			case "New":
				$msg = "<p>Show your creativity with words. You could:-</p>
								- Publish new articles<br />
								- Upload pics related to your article<br />
								- Save unfinished work so that you could publish it later<br />
								<p>All articles and pics are moderated</p>";
				break;
			case "Unfinished":
				$msg = "<p>All unfinished articles comes here and will stay here until you deem it to be ready for the public. You could:-</p>
								- Edit articles<br />
								- Upload or delete associated pics<br />
								<p>Articles here are not moderated until it is published</p>";
				break;
			case "Trash":
				$msg = "<p>All deleted articles wind up here. You could:-</p>
								- Restore articles into unfinished section<br />
								- Publish articles directly<br />";
				break;
			case "Edit":
				$msg = "<p>Make changes to your article. You could:-</p>
								- Change the title, summary and article<br />
								- Upload new thumbnails<br />
								- Inspect status of thumbnails<br />
								- Delete existing thumbnails
								<p>Associated pics are also kept here. Deleted material is kept for 3 months before being completely deleted";
				break;
			case "Error":
				$msg = "<p>Errors in your article. You could:-</p>
								- Where and why you have gone wrong<br />
								- Correct your mistakes";
				break;
		}
		echo $msg;
	}
	
	function getarticleErrors($articleID) {
		$conn = databaseConnect();
		$sql = "SELECT articleBanTExt, articleText, articleSummary FROM articletable WHERE articleID = '" . $articleID . "'";
		$result = mysql_query($sql, $conn);
		$articleBanText;
		if($result) {
			$articleBanInfo = mysql_fetch_assoc($result);
			mysql_free_result($result);
		}
		mysql_close($conn);
		return $articleBanInfo;
	}
	
	function getthumbErrors($articleID) {
		$conn = databaseConnect();
		$sql = "SELECT imageBanTExt, imageName, imageType FROM imagetable WHERE articleID = '" . $articleID . "'";
		$result = mysql_query($sql, $conn);
		$imageBanInfo;
		if($result) {
			mysql_free_result($result);
		}
		mysql_close($conn);
		return $result;
	}
?>