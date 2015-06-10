<?php
	session_start();

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/msg_func.php');
	include('scripts/pagination.php');
	
	if (isset($_GET['cookieFail']) && $_GET['stamp'] < (time() + 2)) {
		redMsg_write("<tr><td>We have detected that cookies are disabled. You need to enable cookies to login.</td></tr>");
	} else {
		checkCookieEnabled();
	}
	checkUserCookies();
	
	if ( isset($_GET['showLimit']) && is_numeric($_GET['showLimit']) && $_GET['showLimit'] >= 5 && $_GET['showLimit'] <= 20 ) {
		$showLimit = $_GET['showLimit'];
	} else {
		$showLimit = 5;
	}

		if ( isset($_GET['page']) ) {
		$page = $_GET['page'];
	} else {
		$page = "Inbox";
	}

	$numMessages = getMessages($_SESSION['validuserID'], $page, "count");
	$numPages = countPages($numMessages, $showLimit);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES Messages</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />

<link href="styles/billboard.css" rel="stylesheet" type="text/css" />
<link href="styles/messages.css" rel="stylesheet" type="text/css" />
<link href="styles/pagination.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
<script language="javascript1.3" type="text/javascript" src="scripts/phonescript.js"></script>
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script></head>
<body>
<div id="googleStyleComment"><table><?php redMsg_print(); ?></table></div>
<table id="maintable" width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contentCell"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
      	<td><table id='navTable' border="0" cellpadding="0" cellspacing="0">
			 		<tr>
		      	<td id="logo"><img src="images/Logo.jpg" alt="logo" width="225" height="65" /></td>
		        <td align="center" valign="top">
  		      	<table id="navLinks" border="0" cellpadding="0" cellspacing="0">
              	<tr>
                  <td id="navHome"><a href="home.php">&nbsp;</a></td>
                  <td id="navFAQ"><a href="category.php">&nbsp;</a></td>
                  <td id="navRegister"><a href="register.php">&nbsp;</a></td>
                </tr>
          		</table>
        		</td>
      		</tr>
    		</table>
        <table id="componentTable" width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            <td id='posterBox'><img src='images/pageGrafix/messages.jpg' /></td>
            <td align="right"><table width="100%" border='0' callpadding='0' cellspacing='0'>
              <tr>
                <td id='cornerTL4'>&nbsp;</td>
                <td id='lineT4'>&nbsp;</td>
                <td id='cornerTR4'>&nbsp;</td>
              </tr>
              <tr>
                <td id='lineL4'>&nbsp;</td>
                <td id="billboard">
                  <div id="billboardHeading"><?php echo $page; ?></div>
                  <div id="normalText">
                  	<?php
											billboardMessage($page);
										?>
                  </div>
                </td>
                <td id='lineR4'>&nbsp;</td>
              </tr>
              <tr>
                <td id='cornerBL4'>&nbsp;</td>
                <td id='lineB4'>&nbsp;</td>
                <td id='cornerBR4'>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
        <hr />
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
          	<td>
						<?php
							if ( isset($_SESSION['validuserID']) ) {
	            	drawMsgNav($page);
								if ( $page != "Write" && $page != "View" ) {
									if ( $numPages > 0 ) {
										getPages();
										$messages = getMessages($_SESSION['validuserID'], $page);
										echo "";
										echo "<table border='0' width='100%' cellspacing='0' cellpadding='0'>
											<tr>
												<td id='boldBlackText' colspan='4'>Showing pages $currPage of $numPages</td>
											</tr>
											<tr>
												<td id='msgHeader'>Date</td>
												<td id='msgHeader'>From/To</td>
												<td id='msgHeader'>Subject</td>
												<td><option>.</option></td>
											</tr>";
										for ( $i = 0; $i < $numMessages; ++$i  ) {
											echo "<tr>
												<td id='msgField' width='70'>"; echo printDate($messages[$i]['sendDate'], "d/m/y"); echo "</td>
												<td id='msgField' width=150'><a href='profile.php?user=".$messages[$i]['userID']."' />".$messages[$i]['username']."</a></td>
												<td id='msgField' width='100%'><a href='messages.php?page=View&messageID=".$messages[$i]['messageID']."' />".$messages[$i]['subject']."</a></td>
												<td><option>.</option></td>
											</tr>";
										}
										echo "</table>";
										if ( $numPages > 1 ) {
											drawPagination($currStart, $currEnd, "messages", "page=$page");
										}
									} else {
										echo "<div id='notice_neutral'>You do not have any messages</div>";
									}
								} elseif ( $page != "View" ) {
									echo "<div id='notice_neutral'>write you damned message</div>";
								} else {
									$message = readMessage($_GET['messageID'], $_SESSION['validuserID']);
									if ( $message['recieverID'] == $_SESSION['validuserID'] ) {
										$otherUser = getuserDetails($message['senderID']);
										otherUserDetails($otherUser, "Sender");
										msgRead($_GET['messageID']);
									}
									printMessage($message);
									if ( $message['senderID'] == $_SESSION['validuserID'] && $message['recieverID'] != $_SESSION['validuserID'] ) {
										$otherUser = getuserDetails($message['recieverID']);
										otherUserDetails($otherUser, "Receiver");
									} else {
										echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
											<form id='quickMsgTable'>
											<tr>
												<td id='boldBlackText'>Quick Reply:</td>
											</tr><tr>
												<td><textarea id='inputText' name='message' cols='91' rows='5'></textarea></td>
											</tr><tr>
												<td align='center'>
													<input id='blackButton' type='submit' value='Send' />
													<input id='blackButton' type='reset' value='Reset' />
												</td>
											</tr>
											</form>
										</table>";
									}
									echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
										<tr>
											<td align='center'><table border='0'>
												<tr>
													<td id='msgAction'>
														<img id='msgActionPic' height='32' width='44' src='images/forward.jpg' />
														<a href='#'>Forward</a>
													</td>
													<td id='msgAction'>
														<img id='msgActionPic' height='32' width='44' src='images/delete.jpg' />
														<a href='#'>Delete</a>
													</td>";
													if ( $message['senderID'] != $_SESSION['validuserID'] ) {
														echo "<td id='msgAction'>
															<img id='msgActionPic' height='32' width='44' src='images/folder.jpg' />
															<a href='#'>Move to Folder</a>
														</td>
														<td id='msgAction'>
															<img id='msgActionPic' height='32' width='44' src='images/spam.jpg' />
															<a href='#'>Report Spam</a>
														</td>";
													}
												echo "</tr>
											</table></td>
										</tr>
									</table>";
								}
							} else {
								echo "<div id='notice_bad'>You are not Logged in. You must login first to view messages.</div>";
							}
						?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table>
    </td>
    <td width="300" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
      	<td><table id="sidebar" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="lineL1">&nbsp;</td>
            <td id="sidebarContent">
            	<?php
								drawUserTable();
							?>
            </td>
            <td id="lineR1">&nbsp;</td>
          </tr>
          <tr>
            <td id="cornerBL1">&nbsp;</td>
            <td id="lineB1">&nbsp;</td>
            <td id="cornerBR1">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
      </tr>
      <tr>
      	<td id="sidebar"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
            <td id="cornerTL1">&nbsp;</td>
            <td id="lineT1">&nbsp;</td>
            <td id="cornerTR1">&nbsp;</td>
        	</tr>
        	<tr>
            <td id="lineL1">&nbsp;</td>
            <td id="sidebarContent"><?php include('include/sidebar.php'); ?></td>
            <td id="lineR1">&nbsp;</td>
        	</tr>
        	<tr>
            <td id="cornerBL1">&nbsp;</td>
            <td id="lineB1">&nbsp;</td>
            <td id="cornerBR1">&nbsp;</td>
        	</tr>
        </table>
      </td>
    </table></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
	var components=['chat', 'calendar', 'publications', 'sponsors', 'browser', 'announce'];
	start(components);
</script>
</body>
</html>