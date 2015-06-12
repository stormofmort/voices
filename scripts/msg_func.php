<?php
	function performAction ($action, $array, $userID) {
		switch ($action) {
			case "MarkRead" :
				markread($array);
				break;
			case "MarkUnread" :
				markunread($array);
				break;
			case "ReceiverTrash" :
				receiverTrash($array);
				break;
			case "SenderTrash" :
				senderTrash($array);
				break;
			case "Delete" :
				delete($array, $userID);
				break;
			case "Restore" :
				restore($array, $userID);
				break;
		}
	}

	function delete($array, $userID) {
		$conn = databaseConnect();
		$count = count($array);
		for ( $i=0; $i < $count; ++$i ) {
			$sql = "SELECT `receiverID`, `senderID` FROM `messagetable` WHERE `messageID`=".$array[$i];
			$result = mysql_query($sql);
			
			$msg = mysql_fetch_assoc($result);
			if ( $msg['senderID'] == $userID ) {
				$x = mysql_query("UPDATE `messagetable` SET `senderStatus` = 'Delete' WHERE `messageID` = ".$array[$i]." LIMIT 1");
			} else {
				$x = mysql_query("UPDATE `messagetable` SET `receiverStatus` = 'Delete' WHERE `messageID` = ".$array[$i]." LIMIT 1");
			}
			mysql_free_result($result);
		}
	}
	
	function restore($array, $userID) {
		$conn = databaseConnect();
		$count = count($array);
		for ( $i=0; $i < $count; ++$i ) {
			$sql = "SELECT `receiverID`, `senderID` FROM `messagetable` WHERE `messageID`=".$array[$i];
			$result = mysql_query($sql);
			
			$msg = mysql_fetch_assoc($result);
			if ( $msg['senderID'] == $userID ) {
				$x = mysql_query("UPDATE `messagetable` SET `senderStatus` = 'Outbox' WHERE `messageID` = ".$array[$i]." LIMIT 1");
			} else {
				$x = mysql_query("UPDATE `messagetable` SET `receiverStatus` = 'Inbox' WHERE `messageID` = ".$array[$i]." LIMIT 1");
			}
			mysql_free_result($result);
		}
	}
	
	function markread($array) {
		$conn = databaseConnect();
		
		for ( $i=0; $i < count($array); ++$i ) {
			echo gettype($array[$i]);
			$sql = "UPDATE `messagetable` SET `read` = '1' WHERE `messageID` = ".$array[$i]." LIMIT 1";
			$result = mysql_query($sql);
		}
		mysql_close($conn);
	}
	
	function markunread($array) {
		$conn = databaseConnect();
		
		for ( $i=0; $i < count($array); ++$i ) {
			$sql = "UPDATE `messagetable` SET `read` = '0' WHERE `messageID` = ".$array[$i]." LIMIT 1";
			$result = mysql_query($sql);
		}
		mysql_close($conn);
	}
		
	function receiverTrash($array) {
		$conn = databaseConnect();
		
		for ( $i=0; $i < count($array); ++$i ) {
			$sql = "UPDATE `messagetable` SET `receiverStatus` = 'Trash' WHERE `messageID` = ".$array[$i]." LIMIT 1";
			$result = mysql_query($sql);
		}
		mysql_close($conn);
	}

	function senderTrash($array) {
		$conn = databaseConnect();
		
		for ( $i=0; $i <= count($array); ++$i ) {
			$sql = "UPDATE `messagetable` SET `senderStatus` = 'Trash' WHERE `messageID` = ".$array[$i]." LIMIT 1";
			$result = mysql_query($sql);
		}
		mysql_close($conn);
	}

	function postMessage($senderID, $receiverID, $subject, $message) {
		$conn = databaseConnect();
		$sql = "INSERT INTO `messagetable` (`messageID`, `senderID`, `receiverID`, `subject`, `message`, `sendDate`, `flagged`, `read`, `senderStatus`, `receiverStatus`) VALUES (NULL, $senderID, $receiverID, '$subject', '$message', NOW(), '0', '0', 'Outbox', 'Inbox')";
		$result = mysql_query($sql);
		
		mysql_close($conn);
		
		return $result;
	}
	
	function cnvrtRecNameToRecID($name) {
		$conn = databaseConnect();
		$sql = "SELECT userID FROM usertable WHERE userName='$name' LIMIT 1";
		$result = mysql_query($sql) or die (mysql_error());
		if ( mysql_num_rows($result) > 0 ) {
			$array = mysql_fetch_array($result);
			$receiverID = $array['userID'];
			return $receiverID;
		} else {
			return "doesNotExist";
		}
	}
	
	function drawMsgWriteArea() {
		if (isset($_POST['sendto'])){
			$sendto = $_POST['sendto'];
		} else {
			$sendto = "";
		}
		if (isset($_POST['subject'])){
			$subject = $_POST['subject'];
		} else {
			$subject = "";
		}
		if (isset($_POST['daMsg'])){
			$daMsg = $_POST['daMsg'];
		} else {
			$daMsg = "";
		}
		echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
			<form id='daMsgForm' method='POST' action='messages.php?folder=Write'>
			<tr>
				<td id='normalTextRight'>To:</td>
				<td><input id='MsgTextInput' name='sendto' type='text' size='84' maxlength='20' value='". $sendto ."' /></td>
			</tr><tr>
				<td id='normalTextRight'>Subject:</td>
				<td><input id='MsgTextInput' name='subject' type='text' size='84' maxlength='255' value='".$subject."' /></td>
			</tr><tr>
				<td colspan='2' id='daMsgContainer'><textarea cols='70' rows='25' name='daMsg' id='daMsg'>".$daMsg."</textarea></td>
			</tr><tr>
				<td colspan='2' align='center'>
					<input type='reset' id='blackButton' />
					<input type='submit' id='blackButton' value='SEND' />
				</td>
			</form>
		</table>";
	}
	
	function msgRead($msgID) {
		$conn = databaseConnect();
		$sql = "UPDATE `messagetable` SET `sendDate` = NOW( ), `read` = '1' WHERE `messageID` = $msgID LIMIT 1 ";
		$result = mysql_query($sql);
		
		mysql_close($conn);
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
						<td>Joined On: "; echo printDate(strtotime($array['userJoinDate'])); echo "</td>
					</tr>
				</table></td>
				<td align='center'><img id='avatarPic' src='images/avatars/".$array['userAvatar']."' /></td>
			</tr><tr>
				<td id='msgBlueLink'><a href='profile.php?userID=".$array['userID']."'>View Profile</a></td>
		</table>";
	}
	
	function readMessage($msgID, $userID) {
		$conn = databaseConnect();
		$sql = "SELECT `messageID`, `senderID`, `receiverID`, `subject`, `message`, UNIX_TIMESTAMP(sendDate) AS `sendDate` FROM `messagetable` WHERE (`receiverID` = $userID AND `receiverStatus` != 'Delete' AND `messageID` = '$msgID') OR (`senderID` = $userID AND `senderStatus` != 'Delete' AND `messageID` = '$msgID') LIMIT 1";
		$result = mysql_query($sql);
		if ( mysql_num_rows($result) > 0 ) {
			$array = mysql_fetch_assoc($result);
		} else {
			$array = 0;
		}	
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array;
	}

	function getMessages( $userID, $folder, $method='GET' ) {
		global $start, $showLimit, $folder, $currPage, $numPages;
		$limit = "";
		switch ($folder) {
			case "Inbox":
				$criteria = "`receiverID` = ".$userID." AND `receiverStatus`='Inbox' AND `userID` = `senderID`";
				$suffix = NULL;
				break;
			case "Outbox":
				$criteria = "`senderID` = ".$userID." AND `senderStatus`='Outbox' AND `userID` = `receiverID`";
				$suffix = NULL;
				break;
			case "Trash":
				$criteria = "(`receiverID` = ".$userID." AND `receiverStatus`='Trash' AND `senderID` = `userID`) OR (`senderID` = ".$userID." AND `senderStatus`='Trash' AND `receiverID` = `userID`)";
				$fromto = "`receiverID`, `senderID`";
				$suffix = "GROUP BY `messageID`";
				break;
		}
		if ( $method == "count" ) {
			$fields = "`messageID`";
		} else {
			$fields = "`messageID`, `senderID`, `receiverID`, `subject`, `message`, UNIX_TIMESTAMP(sendDate) AS `sendDate`, `read`, `userID`, `username`";
			$limit = "LIMIT $start, $showLimit";
		}

		$conn = databaseConnect();
		$sql = "SELECT $fields FROM `messagetable`, `usertable` WHERE $criteria $suffix ORDER BY `sendDate` DESC $limit";
		
		$result = mysql_query($sql);
		
		if ( $method == "count" ) {
			
			$array = mysql_num_rows($result);
		} else {
			$array = [];
			$count = mysql_num_rows($result);

			echo "<form id='allMsgForm' method='POST' action='messages.php?folder=$folder'>
			<table border='0' width='100%' cellspacing='0' cellpadding='0'>
				<tr>
					<td id='boldBlackText' colspan='4'>Showing pages $currPage of $numPages</td>
				</tr>
				<tr>
					<td id='msgHeader'>Date</td>
					<td id='msgHeader'>";
					if ( $folder == "Inbox" ) {
						echo "FROM";
					} elseif ( $folder == "Outbox" ) {
						echo "TO";
					} else {
						echo "FROM/TO";
					}
					echo "</td>
					<td id='msgHeader'>Subject</td>
					<td>&nbsp;</td>
				</tr>";
			for ( $i = 0; $i < $count; ++$i  ) {
				$message = mysql_fetch_assoc($result);
				echo "<tr>
					<td id='msgField' width='70'>"; echo printDate($message['sendDate'], "d/m/y"); echo "</td>
					<td id='msgField' width=150'><a href='profile.php?userID=".$message['userID']."' />".$message['username']."</a></td>
					<td id='msgField' width='100%'>
						<a href='messages.php?folder=View&messageID=".$message['messageID']."' />".$message['subject'];
						if ( $folder == "Inbox" && $message['read'] == 0 ) {
							echo "<span style='color: #FF0000; font-size: 10px;' > Unread</span>";
						}
				echo "</a></td>
					<td id='msgField' width='70'><input type='checkbox' id='select$i' name='select$i' value='".$message['messageID']."' /></td>
				</tr>";
			}
			echo "<tr>
					<td id='buttonHolder' colspan='4' align='left'>
						<span id='boldBlackText'>Selected: </span><select id='list' name='multiAction' id='multiAction'>
							<option value='None' Selected>None</option>";
							if ( $folder == "Inbox" ) {
								echo "<option value='MarkRead'>Mark As Read</option>
								<option value='MarkUnread'>Mark As Unread</option>";
							}
							if ( $folder == "Trash" ) {
								echo "<option value='Restore'>Restore</option>";
								echo "<option value='Delete'>Delete</option>";
							} elseif ( $folder == "Outbox" ) {
								echo "<option value='SenderTrash'>Trash</option>";
							} else {
								echo "<option value='ReceiverTrash'>Trash</option>";
							}
						echo "</select>
						<input type='hidden' name='hidden' value='posted' />
						<input id='blackButton' type='submit' value='GO' />
					</td>
				</tr>
			</table></form>";
		}
		
		mysql_free_result($result);
		mysql_close($conn);
		return $array;
	}
	
	function drawMsgNav($currFolder) {
		$folders = array("Inbox", "Outbox", "Write", "Trash");
		echo "<table border='0' cellspacing='0' cellpadding='0' align='center'>";
		echo "<tr>";
		for ( $i = 0; $i <= 3; ++$i ) {
			if ( $currFolder == $folders[$i] ) {
				echo "<td id='msgNav".$folders[$i]."_active'>&nbsp;</td>";
				echo "<td id='boldBlackText'>".$folders[$i]."</td>";
			} else {
				echo "<td id='msgNav".$folders[$i]."_inactive'><a href='messages.php?folder=".$folders[$i]."' />&nbsp;</a></td>";
			}
		}
		echo "</tr>";
		echo "</table>";
	}
	
	function billboardMessage($folder) {
		switch ($folder) {
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