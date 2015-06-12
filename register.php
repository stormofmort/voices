<?php
	session_start();

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/validate.php');
	
	if (isset($_GET['cookieFail']) && $_GET['stamp'] < (time() + 2)) {
		redMsg_write("<tr><td>We have detected that cookies are disabled. You need to enable cookies to login.</td></tr>");
	} else {
		checkCookieEnabled();
	}
	 checkUserCookies();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES Register</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
<script language="javascript1.3" type="text/javascript" src="scripts/phonescript.js"></script>
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script>
<link href="styles/announce.css" rel="stylesheet" type="text/css" />
<link href="styles/register.css" rel="stylesheet" type="text/css" />
<link href="styles/billboard.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
	$error = 0;
	
	if ( isset($_POST['userName']) ) {
		$userNameCheck = check_Text($_POST['userName'], 5, 20);
		if ( $userNameCheck > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$userNameCheck = 1;
			++$error;
		} else {
			$userNameCheck = 0;
		}
	}

	if ( isset($_POST['password1']) ) {
		$password1Check = check_Text($_POST['password1'], 5, 20);
		if ( $password1Check > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$password1Check = 1;
			++$error;
		} else {
			$password1Check = 0;
		}
	}

	if ( isset($_POST['password2']) ) {
		$password2Check = check_Text($_POST['password2'], 6, 20);
		if ( $password2Check > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$password2Check = 1;
			++$error;
		} else {
			$password2Check = 0;
		}
	}

	if ( isset($_POST['password1']) && isset($_POST['password1']) ) {
		if ( $_POST['password1'] == $_POST['password2'] ) {
			$passMatchCheck = 0;
		} else {
			$passMatchCheck = 2;
			++$error;
		}
	}

	if ( isset($_POST['hiddenQ']) ) {
		$hiddenQCheck = check_Text($_POST['hiddenQ'], 10, 100);
		if ( $hiddenQCheck > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$hiddenQCheck = 1;
			++$error;
		} else {
			$hiddenQCheck = 0;
		}
	}

	if ( isset($_POST['hiddenA']) ) {
		$hiddenACheck = check_Text($_POST['hiddenA'], 10, 100);
		if ( $hiddenACheck > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$hiddenACheck = 1;
			++$error;
		} else {
			$hiddenACheck = 0;
		}
	}

	if ( isset($_POST['firstName']) && $_POST['firstName'] != '' ) {
		$firstNameCheck = check_Text($_POST['firstName'], 1, 40);
		if ( $firstNameCheck > 0 ) {
			++$error;
		}
	} else {
		$firstNameCheck = 0;
		$_POST['firstName'] = NULL;
	}

	if ( isset($_POST['lastName']) && $_POST['lastName'] != '' ) {
		$lastNameCheck = check_Text($_POST['lastName'], 1, 40);
		if ( $lastNameCheck > 0 ) {
			++$error;
		}
	} else {
		$lastNameCheck = 0;
		$_POST['lastName'] = NULL;
	}
	
	if ( isset($_POST['day']) && isset($_POST['monthList']) && isset($_POST['year']) ) {
		$DOBCheck = check_Date( $_POST['day'], $_POST['monthList'], $_POST['year'] );
		if ( $DOBCheck > 0 ) {
			++$error;
		} else {
			$DOB = $_POST['year']."-".$_POST['monthList']."-".$_POST['day'];
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$DOBCheck = 1;
			++$error;
		} else {
			$DOBCheck = 0;
		}
	}

	if ( isset($_POST['homePhone']) && $_POST['homePhone'] != '' ) {
		$homePhoneCheck = check_Phone($_POST['homePhone']);
		if ( $homePhoneCheck > 0 ) {
			++$error;
		}
	} else {
		$homePhoneCheck = 0;
		$_POST['homePhone'] = NULL;
	}
	
	if ( isset($_POST['workPhone']) && $_POST['workPhone'] != '' ) {
		$workPhoneCheck = check_Phone($_POST['workPhone']);
		if ( $workPhoneCheck > 0 ) {
			++$error;
		}
	} else {
		$workPhoneCheck = 0;
		$_POST['workPhone'] = NULL;
	}

	if ( isset($_POST['mobilePhone']) && $_POST['mobilePhone'] != '' ) {
		$mobilePhoneCheck = check_Phone($_POST['mobilePhone']);
		if ( $mobilePhoneCheck > 0 ) {
			++$error;
		}
	} else {
		$mobilePhoneCheck = 0;
		$_POST['mobilePhone'] = NULL;
	}

	if ( isset($_POST['email']) ) {
		$emailCheck = check_email($_POST['email']);
		if ( $emailCheck > 0 ) {
			++$error;
		}
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$emailCheck = 1;
			++$error;
		} else {
			$emailCheck = 0;
		}
	}
	
	if ( isset($_POST['address']) && $_POST['address'] != '' ) {
		$addressCheck = check_Text($_POST['address'], 1, 100);
		if ( $addressCheck > 0 ) {
			++$error;
		}
	} else {
		$addressCheck = 0;
		$_POST['address'] = NULL;
	}

	if ( isset($_POST['street']) && $_POST['street'] != '' ) {
		$streetCheck = check_Text($_POST['street'], 1, 100);
		if ( $streetCheck > 0 ) {
			++$error;
		}
	} else {
		$streetCheck = 0;
		$_POST['street'] = NULL;
	}

	if ( isset($_POST['city']) && $_POST['city'] != '' ) {
		$cityCheck = check_Text($_POST['city'], 1, 100);
		if ( $cityCheck > 0 ) {
			++$error;
		}
	} else {
		$cityCheck = 0;
		$_POST['city'] = NULL;
	}

	if ( isset($_POST['country']) && $_POST['country'] != '' ) {
		$countryCheck = check_Text($_POST['country'], 1, 100);
		if ( $countryCheck > 0 ) {
			++$error;
		}
	} else {
		$countryCheck = 0;
		$_POST['country'] = NULL;
	}
	
	if ( isset($_POST['ZIPCode']) && $_POST['ZIPCode'] != '' ) {
		$ZIPCodeCheck = check_ZIP($_POST['ZIPCode']);
		if ( $ZIPCodeCheck > 0 ) {
			++$error;
		}
	} else {
		$ZIPCodeCheck = 0;
		$_POST['ZIPCode'] = NULL;
	}
	
	if ( isset($_POST['AntiSpamCode']) && $_POST['AntiSpamCode'] != '' && $_POST['AntiSpamCode'] == $_SESSION['AntiSpamCode'] ) {
		$spamCheck = 0;
	} else {
		if ( isset($_POST['profileStyle']) ) {
			$spamCheck = 1;
			++$error;
		} else {
			$spamCheck = 0;
		}
	}
	
	if ( !isset($_POST['defaultAvatar']) || $_POST['defaultAvatar'] == '' ) {
		$_POST['defaultAvatar'] = 'default_01.png';
	}
?>
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
            <td id='posterBox'><img src='images/pageGrafix/register.jpg' /></td>
            <td align="right"><table width="100%" border='0' callpadding='0' cellspacing='0'>
              <tr>
                <td id='cornerTL4'>&nbsp;</td>
                <td id='lineT4'>&nbsp;</td>
                <td id='cornerTR4'>&nbsp;</td>
              </tr>
              <tr>
                <td id='lineL4'>&nbsp;</td>
                <td id="billboard">
                  <div id="billboardHeading">Join the Voices Community</div>
                  <div id="normalText">
                  <p>Become a member of the voices Commnunity by registering today.</p>
                  <p>Once you have registered, you can:<br />
                  -Submit your own articles.<br />
                  -Comment on articles written by others.<br />
                  -Chat on the Voices LIVE chat<br />
                  -And do a hell of a lot more</p>
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
        </table><?php
					if ( isset($_SESSION['validuserID']) ) {
						echo "<table width='100%' border='0'>
							<tr>
								<td align='center'><img src='images/worryFace.jpeg' /></td>
							</tr><tr>
								<td id='notice_bad'>You cannot create a new account while you are logged in.</td>
							</tr>
						</table>";
					} elseif ( $error == 0 && isset($_POST['profileStyle']) ) {
						$duplicateUserName = duplicateUserName($_POST['userName']);
						if ( $duplicateUserName > 0 ) {
							$userNameCheck = 4;
							++$error;
						}
						$duplicateEmail = duplicateEmail($_POST['email']);
						if ( $duplicateEmail > 0 ) {
							$emailCheck = 4;
							++$error;
						}
						
						if ( $duplicateUserName == 0 && $duplicateEmail == 0) {
							$register = registerUser(trim($_POST['userName']), trim($_POST['password1']), trim($_POST['hiddenQ']), trim($_POST['hiddenA']), trim($_POST['firstName']), trim($_POST['lastName']), trim($_POST['sex']), $DOB, trim($_POST['address']), trim($_POST['street']), trim($_POST['city']), trim($_POST['country']), $_POST['ZIPCode'], trim($_POST['homePhone']), trim($_POST['workPhone']), trim($_POST['mobilePhone']), trim($_POST['email']), $_POST['profileStyle'], $_POST['defaultAvatar']);
							if ( $register == 1 ) {
								echo "<table width='100%' border='0'>
									<tr>
										<td align='center'><img src='images/happyFace.jpeg' /></td>
									</tr><tr>
										<td id='notice_good'></p>Congrats! You have been successfully Registered!</p>
											<p>A confirmation email has been send to the email address you specified. Click on the link in the email to activate your account!</p>
										</td>
									</tr>
								</table>";
							} else {
								echo "<table width='100%' border='0'>
									<tr>
										<td align='center'><img src='images/worryFace.jpeg' /></td>
									</tr><tr>
										<td id='notice_bad'></p>Something went wrong</p>
											<p>Your account failed to register. Please try later.</p>
										</td>
									</tr>
								</table>";
							}
						} else {
							include_once('include/regTable.php');
						}
					} else {
						include('include/regTable.php');
					}
        ?></td>
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