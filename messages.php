<?php
	session_start();

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/msg_func.php');
	include('scripts/pagination.php');
	include('scripts/validate.php');
	
	if (isset($_GET['cookieFail']) && $_GET['stamp'] < (time() + 2)) {
		redMsg_write("<tr><td>We have detected that cookies are disabled. You need to enable cookies to login.</td></tr>");
	} else {
		checkCookieEnabled();
	}
	checkUserCookies();
	
	// sets the number of messages to display per page
	if ( isset($_GET['showLimit']) && is_numeric($_GET['showLimit']) && $_GET['showLimit'] >= 5 && $_GET['showLimit'] <= 20 ) {
		$showLimit = $_GET['showLimit'];
	} else {
		$showLimit = 20;
	}
	
	// if no folder is specified defaults to inbox;
	if ( isset($_GET['folder']) ) {
		$folder = $_GET['folder'];
	} else {
		$folder = "Inbox";
	}
	
	// $_POST['selectX'] variables give the message ids of articles on which an action is to be performed;
	if ( isset($_POST['hidden']) ) {
		$c = 0;
		for ( $i = 0; $i < $showLimit; ++$i ) {
			$name = "select".$i;
			if ( $_POST[$name] != NULL ) {
				// $_POST['selectX'] gives article id;
				$selected[$c] = $_POST[$name];
				++$c;
			}
		}
		// perform action on multiple selected messages;
		performAction($_POST['multiAction'], $selected, $_SESSION['validuserID']);
	}
	
	// $_POST['daMsgCopy'] is the hidden duplicate of the message - used to post for forwarding;
	if ( isset($_POST['daMsgCopy']) ) {
		$_POST['daMsg'] = $_POST['daMsgCopy'];
	}
	
	if ( $folder != "Write" && $folder != "View" ) {
		$numMessages = getMessages($_SESSION['validuserID'], $folder, "count");
		$numPages = countPages($numMessages, $showLimit);
	}
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
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script>
<script language="javascript" type="text/javascript" src="scripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
  theme : "advanced",
	mode : "exact",
	elements : "daMsg",
	remove_trailing_nbsp : true,
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
	+ "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
	+ "bullist,numlist,outdent,indent",
	theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
	+"undo,redo,cleanup,code,separator,sub,sup,charmap",
	theme_advanced_buttons3 : "forecolor",
});
</script>
</head>
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
                  <div id="billboardHeading"><?php echo $folder; ?></div>
                  <div id="normalText">
                  	<?php
											billboardMessage($folder);
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
	            	// draw the navigation;
								drawMsgNav($folder);
								
								// a message deleted
								if (isset($_GET['del'])){
									if ( $_GET['del'] == 'success' ) {
										echo "<div id='notice_good'>Message Delete operation successful.</div>";
									} elseif ( $_GET['del'] == 'fail' ) {
										echo "<div id='notice_bad'>Message Delete operation failed.</div>";
									}
								}
								if ( $folder != "Write" && $folder != "View" ) {
									if ( $numPages > 0 ) {
										// get list of pages
										getPages();
										
										// read and display messages in folder
										getMessages($_SESSION['validuserID'], $folder);
										if ( $numPages > 1 ) {
											drawPagination($currStart, $currEnd, "messages", "folder=$folder");
										}
									} else {
										echo "<div id='notice_neutral'>You do not have any messages</div>";
									}
								} elseif ( $folder != "View" ) {
									// folder is 'write';
									if ( isset($_POST['sendto']) && isset($_POST['subject']) && isset($_POST['daMsg']) ) {
										// converts posted values safe by removing html php tags and adding slashes;
										$sendto = htmlspecialchars($_POST['sendto']);
										$subject = htmlspecialchars($_POST['subject']);
										
										// convert given username to user id;
										$recID = cnvrtRecNameToRecID($sendto);

										// validations;
										if ( strlen($subject) < 1 ) { $subjectCheck = 0; } else { $subjectCheck = 1; }
										if ( strlen($_POST['daMsg']) < 1 ) { $msgCheck = 0; } else { $msgCheck = 1; }
										
										if ( $recID == "doesNotExist" || $subjectCheck == 0 || $msgCheck == 0 ) {
											// draw message write form;
											drawMsgWriteArea();
										} else {
											$postMsg = postMessage($_SESSION['validuserID'], $recID, $subject, $_POST['daMsg']);
											if ( $postMsg == 1 ) {
												echo "<div id='notice_good'>You message has been successfully send to ".$_POST['sendto'];
											} else {
												echo "<div id='notice_bad'>You message could not be send to ".$_POST['sendto'];
											}
										}
									} else {
										drawMsgWriteArea();
									}
								} else {
									// folder is set as 'view';
									$message = readMessage($_GET['messageID'], $_SESSION['validuserID']);

									// if the message is a recieved messages display sender information above message;
									if ( $message['receiverID'] == $_SESSION['validuserID'] ) {
										$otherUser = getuserDetails($message['senderID']);
										otherUserDetails($otherUser, "Sender");
										msgRead($_GET['messageID']);
									}
									
									if( $message != 0 ) {
										printMessage($message);
									} else {
										echo "<div id='notice_bad'>Could not retrieve the message</div>";
									}
									
									// if you send this message display receiver info after message;
									if ( $message['senderID'] == $_SESSION['validuserID'] && $message['receiverID'] != $_SESSION['validuserID'] ) {
										$otherUser = getuserDetails($message['receiverID']);
										otherUserDetails($otherUser, "Receiver");
									} elseif ( $message != 0 ) {
										// message could be receiver;
										// ie: message no deleted;
										// display a reply form;
										echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
											<form id='quickMsgTable' method='POST' action='messages.php?folder=Write'>
											<tr>
												<td id='boldBlackText'>Reply:</td>
											</tr><tr>
												<td>
													<input type='hidden' value='".$otherUser['userName']."' name='sendto' />
													<input type='hidden' value='RE: ".$message['subject']."' name='subject' />
													<textarea id='inputText' name='daMsg' cols='91' rows='15'></textarea>
												</td>
											</tr><tr>
												<td align='center'>
													<input id='blackButton' type='submit' value='Send' />
													<input id='blackButton' type='reset' value='Reset' />
												</td>
											</tr>
											</form>
										</table>";
									}
									if ( $message != 0 ) {
										// again if message has not been deleted;
										// message actions;
										echo "<table id='msgCommonTable' width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td align='center'><table border='0'>
													<tr>
														<td id='msgAction'>
															<form id='hiddenform' method='POST' action='messages.php?folder=Write'>
																<input type='hidden' name='subject' value='".$message['subject']."' />
																<input type='hidden' name='daMsgCopy' value='".$message['message']."' />
																<img id='msgActionPic' height='32' width='44' src='images/forward.jpg' />
																<input type='submit' id='forwardButton' value='Forward' />
															</form>
														</td>
														<td id='msgAction'>
															<img id='msgActionPic' height='32' width='44' src='images/delete.jpg' />
															<a href='pages/deleteMsg.php?msgID=".$message['messageID']."&userID=".$_SESSION['validuserID']."'>Delete</a>
														</td>";
														if ( $message['senderID'] != $_SESSION['validuserID'] ) {
															echo "<td id='msgAction'>
																<img id='msgActionPic' height='32' width='44' src='images/spam.jpg' />
																<a href='#'>Report Spam</a>
															</td>";
														}
													echo "</tr>
												</table></td>
											</tr>
										</table>";
									}
								}
							} else {
								echo "<div id='notice_bad'>You are not Logged in. You must login first to view messages.</div>";
							}
						?>            </td>
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
	var components=['chat', 'calendar', 'publications', 'sponsors'];
	start(components);
</script>
</body>
</html>