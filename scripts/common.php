<?php
// chat functions
	function buttonDisabler() {
		if (!$_SESSION['validuserID']) {
			echo "disabled='disabled'";
		}
	}

	function textwrite() {
		if (!$_SESSION['validuserID']) {
			echo "Please Login first to enable chat function";
		} else {
			echo "";
		}
	}
//
	
	function redMsg_write($msg) {
		global $redMsg;
		$count = count($redMsg);
		$redMsg[$count] = $msg;
	}
		
	function redMsg_print() {
		global $redMsg;
		$count = count($redMsg);
		for ($i = 0; $i < $count; $i++) {
			echo $redMsg[$i];
		}
	}

	function getCurrFileName($path) {
		$a = explode("/", $path);
		return $a[count($a) - 1];
	}
	
	function drawUserTable() {
		if ($_SESSION['validuserID'] != NULL) {
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td id='userName_heading' colspan='2'>".$_SESSION['validuser']."</td>
				</tr>
				<tr>
					<td id='userGroup_heading' colspan='2'>".$_SESSION['userGroup']."</td>
				</tr>
				<tr>
					<td id='avatar'><img width='100' height='100' src='images/avatars/".$_SESSION['userAvatar']."' /></td>
					<td id='userLinkTable'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<tr>
							<td id='smallImage'><img src='images/messages.png' />&nbsp;</td>
							<td id='userLink'><a href='messages.php'>Messages ".messageCount($_SESSION['validuserID'])."</a></td>
						</tr>
						<tr>
							<td id='smallImage'><img src='images/workarea.png' />&nbsp;</td>
							<td id='userLink'><a href='workarea.php'>My Works</a></td>
						</tr>
						<tr>
							<td id='smallImage'><img src='images/options.png' />&nbsp;</td>
							<td id='userLink'><a href='options.php'>Options</a></td>
						</tr>
						<tr>
							<td id='smallImage'><img src='images/logout.png' />&nbsp;</td>
							<td id='userLink'><a href='scripts/logout.php?returnto=".$_SERVER['PHP_SELF']."&query=".$_SERVER['QUERY_STRING']."'>Sign Out</a></td>
						</tr>
					</table></td>
				</tr>
			</table>";
		} else {
			echo "<form id='login' name='login' method='post' action='pages/authenticate.php'>
			<input type='hidden' value='".$_SERVER['PHP_SELF']."' name='returnto' />
			<input type='hidden' value='".$_SERVER['QUERY_STRING']."' name='query'  />
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='45%' id='loginLabel'>USERNAME</td> 
						<td width='45%' id='loginLabel'>PASSWORD</td>
						<td width='10%'>&nbsp;</td>
					</tr>
					<tr>
						<td align='center'><input name='usernameInput' id='usernameInput' type='text' maxlength='20' /></td>
						<td align='center'><input name='passwordInput' id='passwordInput' type='password' maxlength='20' /></td>
						<td align='center'><input type='submit' name='submit' id='loginButton' value=' '/></td>
					</tr>
					<tr>
						<td id='blueText' colspan='3'><a href='pages/forgot.php'>Forgot username or password?</a></td>
					</tr>
				</table></form>";
		}
	}
	
	function getAnnouncements() {
		$conn = databaseConnect();
		$query = "SELECT `announceHeading`, `announceText`, UNIX_TIMESTAMP(announceTime) AS `announceTime` FROM `announcetable` WHERE `announceStatus` = 1 LIMIT 0, 5";
		$result = mysql_query($query, $conn);
		for ($i = 1; $i <= 5; $i++) {
			$announce = mysql_fetch_assoc($result);
			echo "<tr><td id='announceHeading'>".$announce['announceHeading']."</td></tr>";
			echo "<tr><td id='announceText'>".$announce['announceText']."</td></tr>";
			echo "<tr><td id='announceTime'>"; echo printDate($announce['announceTime'], "d-M-y | H:i")."</td></tr>";
		}
		mysql_free_result($result);
		mysql_close($conn);
	}

	function printDate($date, $format = "d-M-Y") {
		return date($format, $date);
	}
	
	function drawRating($rating) {
		$i=0;
		$score = intval( ($rating / 3 ) );
		while ( $i < 5 ) {
			if ( $i < $score ) {
				echo "<img src='images/redStart.jpg' width='15' height='15' />";
			} else {
				echo "<img src='images/blackStart.jpg' width='15' height='15' />";
			}
			$i++;
		}
	}
	
	redMsg_write("<noscript><tr><td>Javascript seems to be disabled. Javascript is needed for some function of this site.</td></tr></noscript>");
?>