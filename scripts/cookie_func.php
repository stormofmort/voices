<?php
	function createCookie($name = 'testcookie', $value = 'test', $expire = NULL, $path = "/", $domain = NULL, $secure = NULL, $httponly = NULL) {
		if ($expire == NULL) {
			$expire = time()+60*60*24*30;
		}
		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	function deleteCookie($name = NULL, $value = '', $expire = NULL, $path = "/", $domain = NULL, $secure = NULL, $httponly = NULL) {
		if ($expire == NULL) {
			$expire = time()-60*60*24*30*365;
		}
		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	function checkCookieEnabled() {
		if (!isset($_COOKIE['testcookie'])) {
			createCookie();
			if (strlen($_SERVER['QUERY_STRING']) > 0) {
				$a = $_SERVER['QUERY_STRING'];
				$query = urlencode($a);
				header("Location: pages/cookieCheck.php?returnto=".$_SERVER['PHP_SELF']."&query=".$query);
			} else {
				header("Location: pages/cookieCheck.php?returnto=".$_SERVER['PHP_SELF']);
			}
		}
	}
	
	function checkUserCookies() {
		if (isset($_COOKIE['voicesuser']) && isset($_COOKIE['userchecksum'])) {
			$is_logged_in = verifyChecksum($_COOKIE['voicesuser'], $_COOKIE['userchecksum']);
			if ($is_logged_in == 1) {
				$details = getuserDetails($_COOKIE['voicesuser'], "username");
				
				if ($details['userStatus'] == -1) {
					echo "BANNED!";
					unset_validuser();
				} elseif ($details['userStatus'] == 0) {
					echo "INACTIVE!";
					unset_validuser();
				} else {
					$_SESSION['validuserID'] = $details['userID'];
					$_SESSION['validuser'] = $details['userName'];
					$_SESSION['userJoinDate'] = $details['userJoinDate'];
					$_SESSION['userGroup'] = $details['userGroup'];
					$_SESSION['userAvatar'] = $details['userAvatar'];
				}
			} else {
				unset_validuser();
			}
		} else {
			unset_validuser();
		}
	}
?>