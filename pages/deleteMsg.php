<?php
	include('../scripts/db.php');
	include('../scripts/validate.php');
	
	$goto = "Inbox";
	if ( $_GET['msgID'] && $_GET['userID'] ) {
		$msgID = intval(strip_tags($_GET['msgID']));
		$userID = intval(strip_tags($_GET['userID']));

		$conn = databaseConnect();
		$sql = "SELECT `senderID`, `receiverID`, `receiverStatus`, `senderStatus` FROM `messagetable` WHERE `messageID` = ".$msgID." LIMIT 1";
		$result = mysql_query($sql);
		if ( mysql_num_rows($result) > 0 ) {
			$array = mysql_fetch_assoc($result);
			
			if ( $array['receiverID'] == $userID ) {
				if ( $array['receiverStatus'] == "Inbox" ) {
					$sql = "UPDATE `messagetable` SET `receiverStatus` = 'Trash' WHERE `messageID` = ".$msgID;
					$goto = "Inbox";
				} else {
					$sql = "UPDATE `messagetable` SET `receiverStatus` = 'Delete' WHERE `messageID` = ".$msgID;
					$goto = "Trash";
				}
			} elseif ( $array['senderID'] == $userID ) {
				if ( $array['senderStatus'] == "Outbox" ) {
					$sql = "UPDATE `messagetable` SET `senderStatus` = 'Trash' WHERE `messageID` = ".$msgID;
					$goto = "Outbox";
				} else {
					$sql = "UPDATE `messagetable` SET `senderStatus` = 'Delete' WHERE `messageID` = ".$msgID;
					$goto = "Trash";
				}
			} else {
				$del="fail";
			}

			mysql_free_result($result);
			$result = mysql_query($sql, $conn);
			if ( $result == 1 ) {
				$del="success";
			} else {
				$del="fail";
			}	
		} else {
			mysql_free_result($result);
			$del="fail";
		}
	}
	header("Location: ../messages.php?folder=$goto&del=$del");
?>