<?php

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/validate.php');
	include('scripts/avatar_func.php');
	
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
<met http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
<title>VOICES Options</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />
<link href="styles/announce.css" rel="stylesheet" type="text/css" />
<link href="styles/register.css" rel="stylesheet" type="text/css" />
<link href="styles/billboard.css" rel="stylesheet" type="text/css" />
<script language="javascript1.3" type="text/javascript" src="scripts/phonescript.js"></script>
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script>
<link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<?php
if ( isset($_SESSION['validuserID']) ) {
	$userDetails = loadUserOptions($_SESSION['validuserID']);
	
	$error = 0;
	
	if ( isset($_POST['hiddenQ']) && $_POST['hiddenQ'] != '' && $_POST['hiddenQ'] != $userDetails['userHiddenQ'] ) {
		$hiddenQCheck = check_Text($_POST['hiddenQ'], 10, 100);
		if ( $hiddenQCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['hiddenQ'] == '' && isset($_POST['profileStyle']) ) {
		$hiddenQCheck = 1;
		++$error;
	} else {
		$hiddenQCheck = 0;
		$_POST['hiddenQ'] = $userDetails['userHiddenQ'];
	}

	if ( isset($_POST['hiddenA']) && $_POST['hiddenA'] != '' && $_POST['hiddenA'] != $userDetails['userHiddenA'] ) {
		$hiddenACheck = check_Text($_POST['hiddenA'], 10, 100);
		if ( $hiddenACheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['hiddenA'] == '' && isset($_POST['profileStyle']) ) {
		$hiddenACheck = 1;
		++$error;
	} else {
		$hiddenACheck = 0;
		$_POST['hiddenA'] = $userDetails['userHiddenA'];
	}

	if ( isset($_POST['firstName']) && $_POST['firstName'] != '' && $_POST['firstName'] != $userDetails['userFirstName'] ) {
		$firstNameCheck = check_Text($_POST['firstName'], 1, 40);
		if ( $firstNameCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['firstName'] == '' && isset($_POST['profileStyle']) ) {
		$firstNameCheck = 0;
		$_POST['firstName'] = NULL;
	} else {
		$firstNameCheck = 0;
		$_POST['firstName'] = $userDetails['userFirstName'];
	}

	if ( isset($_POST['lastName']) && $_POST['lastName'] != '' && $_POST['lastName'] != $userDetails['userLastName'] ) {
		$lastNameCheck = check_Text($_POST['lastName'], 1, 40);
		if ( $lastNameCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['lastName'] == '' && isset($_POST['profileStyle']) ) {
		$lastNameCheck = 0;
		$_POST['lastName'] = NULL;
	} else {
		$lasstNameCheck = 0;
		$_POST['lastName'] = $userDetails['userLastName'];
	}

	$dob_d = printDate($userDetails['userDOB'], "d");
	$dob_m = printDate($userDetails['userDOB'], "n");
	$dob_y = printDate($userDetails['userDOB'], "Y");
	if ( (isset($_POST['day']) && $_POST['day'] != '' && $_POST['day'] != $dob_d) ||
			 (isset($_POST['monthList']) && $_POST['monthList'] != '' && $_POST['monthList'] != $dob_m) ||
			 (isset($_POST['year']) && $_POST['year'] != '' && $_POST['year'] != $dob_y) ) {
		$DOBCheck = check_Date( $_POST['day'], $_POST['monthList'], $_POST['year'] );
		if ( $DOBCheck > 0 ) {
			++$error;
		} else {
			$DOB = $_POST['year']."-".$_POST['monthList']."-".$_POST['day'];
			$userDetails['userDOB'] = mktime(0, 0, 0, $_POST['monthList'], $_POST['day'], $_POST['year']);
		}
	} else {
		$DOBCheck = 0;
	}

	if ( isset($_POST['homePhone']) && $_POST['homePhone'] != '' && $_POST['homePhone'] != $userDetails['userHomePhone'] ) {
		$homePhoneCheck = check_Phone($_POST['homePhone']);
		if ( $homePhoneCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['homePhone'] == '' && isset($_POST['profileStyle']) ) {
		$homePhoneCheck = 0;
		$_POST['homePhone'] = NULL;
	} else {
		$homePhoneCheck = 0;
		$_POST['homePhone'] = $userDetails['userHomePhone'];
	}
	
	if ( isset($_POST['workPhone']) && $_POST['workPhone'] != '' && $_POST['workPhone'] != $userDetails['userWorkPhone'] ) {
		$workPhoneCheck = check_Phone($_POST['workPhone']);
		if ( $workPhoneCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['workPhone'] == '' && isset($_POST['profileStyle']) ) {
		$workPhoneCheck = 0;
		$_POST['workPhone'] = NULL;
	} else {
		$workPhoneCheck = 0;
		$_POST['workPhone'] = $userDetails['userWorkPhone'];
	}

	if ( isset($_POST['mobilePhone']) && $_POST['mobilePhone'] != '' && $_POST['mobilePhone'] != $userDetails['userMobilePhone'] ) {
		$mobilePhoneCheck = check_Phone($_POST['mobilePhone']);
		if ( $mobilePhoneCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['mobilePhone'] == '' && isset($_POST['profileStyle']) ) {
		$mobilePhoneCheck = 0;
		$_POST['mobilePhone'] = NULL;
	} else {
		$mobilePhoneCheck = 0;
		$_POST['mobilePhone'] = $userDetails['userMobilePhone'];
	}

	if ( isset($_POST['email']) && $_POST['email'] != '' && $_POST['email'] != $userDetails['userEmail'] ) {
		$emailCheck = check_email($_POST['email']);
		if ( $emailCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['email'] == '' && isset($_POST['profileStyle']) ) {
		$emailCheck = 1;
		++$error;
	} else {
		$emailCheck = 0;
		$_POST['email'] = $userDetails['userEmail'];
	}
	
	if ( isset($_POST['address']) && $_POST['address'] != '' && $_POST['address'] != $userDetails['userAddress'] ) {
		$addressCheck = check_Text($_POST['address'], 1, 100);
		if ( $addressCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['address'] == '' && isset($_POST['profileStyle']) ) {
		$addressCheck = 0;
		$_POST['address'] = NULL;
	} else {
		$addressCheck = 0;
		$_POST['address'] = $userDetails['userAddress'];
	}

	if ( isset($_POST['street']) && $_POST['street'] != '' && $_POST['street'] != $userDetails['userStreet'] ) {
		$streetCheck = check_Text($_POST['street'], 1, 100);
		if ( $streetCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['street'] == '' && isset($_POST['profileStyle']) ) {
		$streetCheck = 0;
		$_POST['street'] = NULL;
	} else {
		$streetCheck = 0;
		$_POST['street'] = $userDetails['userStreet'];
	}


	if ( isset($_POST['city']) && $_POST['city'] != '' && $_POST['city'] != $userDetails['userCity'] ) {
		$cityCheck = check_Text($_POST['city'], 1, 100);
		if ( $cityCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['city'] == '' && isset($_POST['profileStyle']) ) {
		$cityCheck = 0;
		$_POST['city'] = NULL;
	} else {
		$cityCheck = 0;
		$_POST['city'] = $userDetails['userCity'];
	}

	if ( isset($_POST['country']) && $_POST['country'] != '' && $_POST['country'] != $userDetails['userCountry'] ) {
		$countryCheck = check_Text($_POST['country'], 1, 100);
		if ( $countryCheck > 0 ) {
			++$error;
		}
	} elseif ( $_POST['country'] == '' && isset($_POST['profileStyle']) ) {
		$countryCheck = 0;
		$_POST['country'] = NULL;
	} else {
		$countryCheck = 0;
		$_POST['country'] = $userDetails['userCountry'];
	}
	
	if ( isset($_POST['ZIPCode']) && $_POST['ZIPCode'] != '' && $_POST['ZIPCode'] != $userDetails['userZIP'] ) {
		$ZIPCodeCheck = check_ZIP($_POST['ZIPCode']);
		if ( $ZIPCodeCheck > 0 ) {
			++$error;
		}
	} else {
		$ZIPCodeCheck = 0;
		$_POST['ZIPCode'] = $userDetails['userZIP'];
	}
	
	if ( !isset($_POST['avatarGroup']) || $_POST['avatarGroup'] == '' ) {
		$_POST['avatarGroup'] = $userDetails['userAvatar'];
	}
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
            <td id='posterBox'><img src='images/pageGrafix/options.jpg' /></td>
            <td align="right"><table width="100%" border='0' callpadding='0' cellspacing='0'>
              <tr>
                <td id='cornerTL4'>&nbsp;</td>
                <td id='lineT4'>&nbsp;</td>
                <td id='cornerTR4'>&nbsp;</td>
              </tr>
              <tr>
                <td id='lineL4'>&nbsp;</td>
                <td id="billboard">
                  <div id="billboardHeading">CHANGE YOUR OPTIONS &amp; SETTINGS</div>
                  <div id="normalText">
                  <p>- Change username and password<br />
                    - Update your personal information<br />
                    - Change your display pic<br />
                    - Add/ delete components<br />
                    - Change how you receive emails<br />
                    - Change your billing address<br />
                    - Set your search preferences</p>
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
					if ( !isset($_SESSION['validuserID']) ) {
						echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td align='center'><img src='images/worryFace.jpeg' /></td>
							</tr><tr>
								<td id='notice_bad'>You have to first login to change your preferences.</td>
							</tr>
						</table>";
					} elseif ( $error == 0 && isset($_POST['profileStyle']) ) {
						$update = updateUser($_SESSION['validuserID'], trim($_POST['hiddenQ']), trim($_POST['hiddenA']), trim($_POST['firstName']), trim($_POST['lastName']), trim($_POST['sex']), $userDetails['userDOB'], trim($_POST['address']), trim($_POST['street']), trim($_POST['city']), trim($_POST['country']), $_POST['ZIPCode'], $_POST['homePhone'], trim($_POST['workPhone']), trim($_POST['mobilePhone']), trim($_POST['email']), $_POST['profileStyle'], $_POST['avatarGroup']);
						if ( $update == 1 ) {
							$_SESSION['userAvatar'] = $_POST['avatarGroup'];
							echo "<table width='100%' border='0'>
								<tr>
									<td align='center'><img src='images/happyFace.jpeg' /></td>
								</tr><tr>
									<td id='notice_good'>Your settings have been successfully updated!</td>
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
						require_once('include/optTable.php');
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