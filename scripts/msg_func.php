<?php
	function msgRead($msgID) {
		$conn = databaseConnect();
		$sql = "UPDATE `voices_mv_-_maindb`.`messagetable` SET `sendDate` = NOW( ), `read` = '1' WHERE `messageID` = $msgID LIMIT 1 ";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $count;
	}
	
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
	
	function readMessage($msgID, $userID) {
		$conn = databaseConnect();
		$sql = "SELECT `senderID`, `recieverID`, `subject`, `message`, UNIX_TIMESTAMP(sendDate) AS `sendDate` FROM `messagetable` WHERE (`recieverID` = $userID AND `recieverStatus` = 'Inbox' AND `messageID` = '$msgID') OR (`senderID` = $userID AND `senderStatus` = 'Outbox' AND `messageID` = '$msgID') LIMIT 1";
		$result = mysql_query($sql);
		$array = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array;
	}

	function getMessages( $userID, $page, $method='GET' ) {
		switch ($page) {
			case "Inbox":
				$criteria = "`recieverID` = ".$userID." AND `recieverStatus`='Inbox' AND `userID` = `recieverID`";
				$suffix = NULL;
				break;
			case "Outbox":
				$criteria = "`senderID` = ".$userID." AND `senderStatus`='Outbox' AND `userID` = `senderID`";
				$suffix = NULL;
				break;
			case "Trash":
				$criteria = "(`recieverID` = ".$userID." AND `recieverStatus`='Trash') OR (`senderID` = ".$userID." AND `senderStatus`='Inbox')";
				$fromto = "`recieverID`, `senderID`";
				$suffix = NULL;
				break;
		}
		if ( $method == "count" ) {
			$fields = "COUNT(*)";
		} else {
			$fields = "`messageID`, `senderID`, `recieverID`, `subject`, `message`, UNIX_TIMESTAMP(sendDate) AS `sendDate`, `userID`, `username`";
		}

		$conn = databaseConnect();
		$sql = "SELECT $fields FROM `messagetable`, `usertable` WHERE $criteria";
		$result = mysql_query($sql);
		
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
		mysql_close($conn);
		return $array;
	}
	
	function drawMsgNav($currPage) {
		$pages = array("Inbox", "Outbox", "Write", "Trash");
		echo "<table border='0' cellspacing='0' cellpadding='0' align='center'>";
		echo "<tr>";
		for ( $i = 0; $i <= 3; ++$i ) {
			if ( $currPage == $pages[$i] ) {
				echo "<td id='msgNav".$pages[$i]."_active'>&nbsp;</td>";
				echo "<td id='boldBlackText'>".$pages[$i]."</td>";
			} else {
				echo "<td id='msgNav".$pages[$i]."_inactive'><a href='messages.php?page=".$pages[$i]."' />&nbsp;</a></td>";
			}
		}
		echo "</tr>";
		echo "</table>";
	}
	
	function billboardMessage($page) {
		switch ($page) {
			case "Inbox":
				$msg = "<p>Communicate with your friends and us using messages. You could:-</p>
								- Send/ receive mail from registered users<br />
								- Send mail/recieve mail to us<br />
								- Delete unwanted mails<br />
								- Save drafts<br />
								<p>The inbox displays all mail that you have recieved";
				break;
			case "Outbox":
				$msg = "<p>Communicate with your friends and us using messages. You could:-</p>
								- Send/ receive mail from registered users<br />
								- Send mail/recieve mail to us<br />
								- Delete unwanted mails<br />
								- Save drafts<br />
								<p>The inbox displays all mail that you have recieved";
				break;
			case "Write":
				$msg = "<p>Communicate with your friends and us using messages. You could:-</p>
								- Send/ receive mail from registered users<br />
								- Send mail/recieve mail to us<br />
								- Delete unwanted mails<br />
								- Save drafts<br />
								<p>The inbox displays all mail that you have recieved";
				break;
			case "Trash":
				$msg = "<p>Communicate with your friends and us using messages. You could:-</p>
								- Send/ receive mail from registered users<br />
								- Send mail/recieve mail to us<br />
								- Delete unwanted mails<br />
								- Save drafts<br />
								<p>The inbox displays all mail that you have recieved";
				break;
			case "View":
				$msg = "<p>Communicate with your friends and us using messages. You could:-</p>
								- Send/ receive mail from registered users<br />
								- Send mail/recieve mail to us<br />
								- Delete unwanted mails<br />
								- Save drafts<br />
								<p>The inbox displays all mail that you have recieved";
				break;
		}
		echo $msg;
	}
?>