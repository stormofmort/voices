<?php
	session_start();
	include('../scripts/db.php');
	include('../scripts/user_func.php');
	include('../scripts/cookie_func.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES hom epa ge</title>
<link href="../styles/common.css" rel="stylesheet" type="text/css" />
<link href="../styles/register.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../favicon.ico">
</head>
<body>
<table id="maintable" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contentCell"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
      	<td><table id='navTable' border="0" cellpadding="0" cellspacing="0">
			 		<tr>
		      	<td id="logo"><img src="../images/Logo.jpg" alt="logo" width="225" height="65" /></td>
		        <td align="center" valign="top">
  		      	<table id="navLinks" border="0" cellpadding="0" cellspacing="0">
              	<tr>
                  <td id="navHome"><a href="../home.php">&nbsp;</a></td>
                  <td id="navFAQ"><a href="../category.php">&nbsp;</a></td>
                  <td id="navRegister"><a href="../register.php">&nbsp;</a></td>
                </tr>
          		</table>
        		</td>
      		</tr>
    		</table></td>
      </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
    	<tr>
      	<td>
					<?php
						if ( isset($_GET['step']) ) {
							$step = $_GET['step'];
						} else {
							$step = 1;
						}
												
						echo "<div id='boldBlackText' align='center'>Step $step</div>
							<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
								<tr>
									<td id='cornerTL1'>&nbsp;</td>
									<td id='lineT1'>&nbsp;</td>
									<td id='cornerTR1'>&nbsp;</td>
								</tr>
								<tr>
									<td id='lineL1'>&nbsp;</td>
									<td id='sidebarContent'>";
						if ( $get = 1 ) {
							include('../include/step1.php');
						} elseif ( $get = 2 ) {
							include('../include/step2.php');
						} else {
							include('../include/step3.php');
						}
						echo "</td>
								<td id='lineR1'>&nbsp;</td>
							</tr>
							<tr>
								<td id='cornerBL1'>&nbsp;</td>
								<td id='lineB1'>&nbsp;</td>
								<td id='cornerBR1'>&nbsp;</td>
							</tr>
						</table>";
          ?>        
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>