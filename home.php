<?php
	session_start();

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	
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
<title>VOICES hom epa ge</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />
<link href="styles/announce.css" rel="stylesheet" type="text/css" />
<link href="styles/browser.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
<script language="javascript1.3" type="text/javascript" src="scripts/phonescript.js"></script>
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script>
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
          	<td id="normalText"><p>voices magazine is youth oriented, to-be-published magazine that has been in development for sometime. The voices headquaters is located at the grafix cafe’ in Male’, Republic of Maldives.</p>
          	<p>Please feel free to read articles, download our magazines in pdf and contribute to the literary world that makes voices happen. Get credit for your articles on our site and our magazine which is on the course of being printed.</p>
          	<p>Sign-up today to submit your articles. In addition to submitting articles, members can comment to other articles and chat with other members in the chatbox. Members could submit any article they want, which fits into one of the categories in the magazine. Once all articles are evaluated for each month, members will be notified if their articles are chosen for the monthly publication.</p>
          	<p>By the way, this site was designed in, designed for and optimized for Mozilla Firefox. We adamently advocate the use of firefox.</p></td>
          </tr>
        </table>
        <table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
          <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
              <td id="componentNameContent">Browser <a id="browserLink" onclick="componentHide('browser')"></a></td>
            </tr></table>          
          </td>
          </tr>
          <tr>
            <td id="componentContainer">
              <div id="browser">
              	<?php include('include/browser.php'); ?>
              </div>
            </td>
          </tr>
        </table><table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          	<tr>
              <td id="componentNameContent">Announcements <a id="announceLink" onclick="componentHide('announce')"></a></td>
            </tr></table>           
          </td>
          </tr>
          <tr>
            <td id="componentContainer" align="right">
              <div id="announce">
              	<table width="570" border="0" cellpadding="0" cellspacing="0">
                	<?php getAnnouncements(); ?>
                </table>
              </div>
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
	var cats=[<?php
			for ($i = 1; $i < $countMain; ++$i ) {
				echo "'cat".$i."',";
			}
			echo "'cat".$countMain."'";
		?>];
	start(cats);
	var components=['chat', 'calendar', 'publications', 'sponsors', 'browser', 'announce'];
	start(components);
</script>
</body>
</html>