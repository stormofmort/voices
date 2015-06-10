<?php
	session_start();
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/article_func.php');
	
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
<title>VOICES view articles</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />
<link href="styles/announce.css" rel="stylesheet" type="text/css" />
<link href="styles/spotlight.css" rel="stylesheet" type="text/css" />
<link href="styles/articles.css" rel="stylesheet" type="text/css" />
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
                  <td id="navFAQ"><a href="faq.php">&nbsp;</a></td>
                  <td id="navRegister"><a href="register.php">&nbsp;</a></td>
                </tr>
          		</table>
        		</td>
      		</tr>
    		</table>
        <?php
					if ( isset($_GET['articleID']) ) {
						$userID = getAuthor($_GET['articleID']);
						$article = readArticle($_GET['articleID']);
						hit($_GET['articleID']);
						echo "<table id='componentTable' width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td align='right'><table width='100%' cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td align='center'  valign='middle'>intentionally left blank</td>
										<td align='right'>";
											$spotlight = userSpotLight($userID); drawSpotlight($spotlight);
						echo "	</td>
									</tr>
								</table></td>
							</tr><tr>
								<td id='category'>".$article['articleMainCat']."-<a href='category.php?catSub=".$article['articleSubCatID']."'>".$article['articleSubCat']."</a></td>
							</tr><tr>
								<td id='articleTitle'>".$article['articleTitle']."</td>
							</tr><tr>
								<td id='smallGreyText'>Article Added On: "; echo printDate($article['articleApproveDate'], "d-M-Y H:i"); echo "</td>
							</tr><tr>
								<td>
									<div>"; getArticlePics($_GET['articleID']); echo "</div>
								</td>
							</tr><tr>
								<td id='articleText'><div id='detailBox'>
										<table border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td id='boldBlueText'>Article Rating:</td>
											</tr><tr>
												<td>"; drawRating($article['articleRating']); echo "</td>
											</tr>";
												getUserVote($_SESSION['validuserID'], $article['articleID']);
											echo "<tr>
												<td id='boldBlueText'>Views (".$article['articleViews'].")</td>
											</tr><tr>
												<td id='boldBlueText'><a href='#comments'>Comments (".countComments($_GET['articleID']).")</a></td>
											</tr><tr>
												<td><img src='images/printer.jpg' /><img src='images/pdf.jpg' /></td>
											</tr>
										</table>
									</div>
								".$article['articleText']."</td>
							</tr>
						</table><table id='componentTable' border='0' cellpadding='0' cellspacing='0' width='100%'>
							<tr>
								<td><table cellpadding='0' cellspacing='0' border='0' width='100%'>
								<tr>
									<td id='componentNameContent'>Comments <a id='commentsLink' onclick='componentHide(\"comments\")'></a></td>
								</tr></table>           
							</td>
							</tr>
							<tr>
								<td id='componentContainer'>
									<div id='comments'><iframe frameborder='0' height='100%' width='590' scrolling='no' src='pages/comments.php?articleID=".$_GET['articleID']."'></iframe></div>
								</td>
							</tr>
						</table>";
					} else {
						echo "Please Select a category";
					}
        ?>
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
              	<img src="images/Browser.jpg" />
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
            <td id="sidebarContent"><?php include('sidebar.php'); ?></td>
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
<script language="javascript" type="text/javascript">start('chat'); start('calendar'); start('publications'); start('sponsors'); start('browser'); start('comments');</script>
</body>
</html>