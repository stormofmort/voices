<?php
	session_start();
	if ( isset($_GET['page']) ) {
		$page = $_GET['page'];
	} else {
		$page = "Portfolio";
	}
	$start=0;
	$showLimit=0;
	$currPage=0;
	$numPages=0;
	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/pagination.php');
	include('scripts/article_func.php');
	include('scripts/workarea_func.php');
	$countMain = 3;
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
	
	$numArticles = getArticles($_SESSION['validuserID'], $page, "count");
	$numPages = countPages($numArticles, $showLimit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES Messages</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />

<link href="styles/billboard.css" rel="stylesheet" type="text/css" />
<link href="styles/workarea.css" rel="stylesheet" type="text/css" />
<link href="styles/pagination.css" rel="stylesheet" type="text/css" />
<link href="styles/category.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
<script language="javascript1.3" type="text/javascript" src="scripts/phonescript.js"></script>
<script language="javascript" type="text/javascript" src="scripts/component_func.js"></script>
<script language="javascript" type="text/javascript" src="scripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "exact",
    elements : "articleSummary,articleText",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	remove_trailing_nbsp : true,
});
</script></head>
<body>
<div id="googleStyleComment"><table><?php redMsg_print(); ?></table></div>
<table id="maintable" width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contentCell"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
      	<td height="316"><table id='navTable' border="0" cellpadding="0" cellspacing="0">
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
            <td id='posterBox'><img src="images/workareaImages/pageIcon.jpg" alt="pageIcon" width="170" height="162" /></td>
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
								if ( $page == "Portfolio" || $page == "Unfinished" || $page == "Trash") {
									if ( $numPages > 0 ) {
										getPages();
										$articles = getArticles($_SESSION['validuserID'], $page);
										echo "";
										echo "<table border='0' width='100%' cellspacing='0' cellpadding='0'>
											<tr>
												<td id='boldBlackText'>Showing pages $currPage of $numPages</td>
											</tr>";
										for ( $i = 0; $i < count($articles); ++$i  ) {
											echo "<tr><td id='resultContainer'>";
											drawArticleTable($articles, $i, $page);
											echo "</td></tr>";
										}
										echo "</table>";
										if ( $numPages > 1 ) {
											drawPagination($currStart, $currEnd, "workarea", "page=$page");
										}
									} else {
										echo "<div id='notice_neutral'>No articles in this category!! <a href='workarea.php?page=New'>Click here</a> to write a new article</div>";
									}
								} else if ( $page == "New" ) {
									echo "<form id='articleForm' name='articleForm' action='scripts/postArticle.php' method='POST' enctype='multipart/form-data'>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr><td id='boldBlackText'>
						Name:</td></tr><tr><td>
									<input type='text' name='articleTitle' id='articleTitle'  class='formField'  />
									</td></tr>
									<tr><td id='boldBlackText'>
									Category:<a id=\"cat1Link\" onclick=\"componentHide('cat1')\"></a>	
									</td></tr>
									<tr><td>
									<div id='cat1'>
									<select name='articleSubCat' size='1'>
									";
									$conn = databaseConnect();
									$query = "SELECT * FROM `catsubtable`";
									$result = mysql_query($query, $conn);
									$count = 1;
									if ($result) {
										while ($row = mysql_fetch_assoc($result)) {
											if ($count == 1) {
												echo "<option value='" . $row['catSubID'] . "' selected='selected'>" . $row['catSubName'] . "</option>";
												$count++;
											} else {
												echo "<option value='" . $row['catSubID'] . "'>" . $row['catSubName'] . "</option>";
											}
										}
									}
									echo "</select></div></td></tr>
									<tr><td id='boldBlackText'>
									Summary:<a id=\"cat2Link\" onclick=\"componentHide('cat2')\"></a></td></tr>
									<tr><td>
									<span id='cat2'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat2')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleSummary';
											cols = 70;
											rows = 10;
											value = '';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleSummary' id='textarea' cols='70' rows='10'></textarea>
							</noscript>
									</td></tr>
							<tr><td id='boldBlackText'>
									Article:<a id=\"cat3Link\" onclick=\"componentHide('cat3')\"></a>
									</td></tr><tr><td>
									<span id='cat3'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat3')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleText';
											cols = 70;
											rows = 45;
											value = '';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleText' id='textarea' cols='70' rows='45'></textarea>
							</noscript>
							</td></tr><tr>
							<td id='boldBlackText'>
							Thumb preview:<a id=\"cat4Link\" onclick=\"componentHide('cat4')\"></a>
							</td></tr>
							<tr><td id='picfieldTD'>
								<div id='cat4'>
								<a name='imageAnchor' id='imageAnchor'></a>
								<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td id='articleTableTopLeft'>&nbsp;</td>
									<td id='articleTableTop'>&nbsp;</td>
									<td id='articleTableTopRight'>&nbsp;</td>
								</tr>
								<tr><td id='articleTableLeft'>&nbsp;</td>
									<td id='articleTableContent'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' id='imageTable'>
								<tr>
									<td id='tableHeaderCells'>Select file for upload</td>
									<td id='tableHeaderCells'>Use as thumbnail</td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage1' id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage1' checked='checked' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage2' id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage2' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage3' id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage3' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage4' id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage4' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage5'id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage5' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='newImage6' id='formField' size='45' /></td>
									<td class='centerTD'><input name='thumb' type='radio' value='newImage6' /></td>
								</tr>
								</table></td>
										<td id='articleTableRight'>&nbsp;</td>
									</tr>
									<tr>
										<td id='articleTableBottomLeft'>&nbsp;</td>
										<td id='articleTableBottom'>&nbsp;</td>
										<td id='articleTableBottomRight'>&nbsp;</td>
									</tr>
									</table>
								<div id='addImage'>
								</div>
								<script language='javascript' type='text/javascript'>
									<!--
										document.getElementById('addImage').innerHTML = \"<span class='articleBlueLink'><a href='#imageAnchor' onClick='addField();'>Add more</a></span>\";
									//-->
								</script>
								</div>
							</td></tr>
							<tr><td>
							<noscript>
							<input name='addImage' type='submit' id='blackButton' value='Add Image' />
							</noscript>
							<input name='publish' type='submit' id='blackButton' value='Publish' />
							<input name='saveUnfinished' type='submit' id='blackButton' value='Save unfinished' />
							<input type='hidden' name='imageNum' id='imageNum' value='6'>
							<input type='hidden' name='maxFileSize' value='1048576' />
							<input type='hidden' name='validUser' value='".$_SESSION['validuserID']."'>
							<input type='hidden' name='articleID' value='" . $_GET[articleID] . "'>
							</table>
							</form>";
							$countMain = 4;
							
								} else if($page == "Error") {
									$countMain = 0;
									echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
									$conn = databaseConnect();
									$sql = "SELECT articleBanText, articleText, articleSummary FROM articletable WHERE articleStatus = '2' AND articleID = '" . $_GET[articleID] . "'";
									//exit();
									$result = mysql_query($sql, $conn);
									if($result) {
										$articleBanInfo = mysql_fetch_assoc($result);
										if ($articleBanInfo['articleBanText'] != "") {
											$countMain++;
											echo "<tr><td id='boldBlackText'>Reason for article ban<a id='cat" . $countMain . "Link' onclick=\"componentHide('cat" .$countMain . "')\"></a></td></tr>";
											echo "<tr><td>";
											echo "<div id='cat" . $countMain . "' class='notice_bad'>";
											echo $articleBanInfo['articleBanText'];
											echo "</div>";
											echo "</td></tr>";
											$countMain++;
											echo "<tr><td id='boldBlackText'>Article<a id='cat" . $countMain ."Link' onclick=\"componentHide('cat" . $countMain . "')\"></a></td></tr>";
											echo "<tr><td>";
											echo "<div id='cat" . $countMain . "' class='article_bad'><table width='100%' cellpadding='0' cellspacing='0' border='0'>";
											echo "<tr><td id='boldBlackText'>Summary:</td></tr>";
											echo "<tr><td>" . $articleBanInfo['articleSummary'] . "</td></tr>";
											echo "<tr><td id='boldBlackText'>Article:</td></td>";
											echo "<tr><td>" . $articleBanInfo['articleText'] . "</td></tr>";
											echo "</table>";
											echo "</div>";
											echo "</td></tr>";
											mysql_free_result($result);
										}	
									}
									
									$sql = "SELECT imageBanText, imageName, imageType FROM imagetable WHERE imageStatus = '2' AND articleID = '" . $_GET[articleID] . "'";
									$result = mysql_query($sql, $conn);
									if($result) {
										$imageBanCount = mysql_num_rows($result);
										if ($imageBanCount >= 1) {
											$countMain++;
											echo "<tr><td id='boldBlackText'>Banned thumbs<a id='cat" . $countMain ."Link' onclick=\"componentHide('cat" . $countMain . "')\"></a></td></tr>";
											echo "<tr><td>";
											echo "<div id=\"cat" . $countMain . "\">
											<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr>
												<td id='tableHeaderCells'>Thumbs</td>
												<td id='tableHeaderCells'>Banned Reason</td>
											</tr>";
											while ($row = mysql_fetch_assoc($result)) {
											echo "
												<tr>
													<td class='centerTD'>
														<table border='0' cellpadding='0' cellspacing='0' width='124' align='center'>
														<tr>
															<td><img width='124' height='84' src='images/articlePics/" . $_GET[articleID] . "/" . $row['imageName'] . "." . $row['imageType'] . "' /></td>
															<td id='articleRight'>$nbsp</td>
														</tr>
														<tr>
															<td id='articleBottom'>&nbsp;</td>
															<td id='articleCorner'>&nbsp;</td>
														</tr>
														</table>
													</td>";
											echo "<td>" . $row['imageBanText'] . "</td></tr>";
											}		
											echo "</table>
											</div>";
											echo "</td></tr>";
										}
										mysql_free_result($result);
									}
									mysql_close($conn);
									echo "</table>";
								} else if ($page == "Edit") {
								$conn = databaseConnect();
								$sql = "SELECT * FROM `articletable` WHERE articleID=" . $_GET['articleID'];
								$result = mysql_query($sql, $conn);
								if ($result) {
									$count = mysql_num_rows($result);
									for ( $i = 0; $i < $count; ++$i ) {
										$articleText[$i] = mysql_fetch_assoc($result);
									}
									if ($articleText[0]['userID'] == $_SESSION['validuserID']) {
								//echo $articleText[0]['articleText'];
								echo "<form id='articleForm' name='articleForm' action='scripts/workarea_setup.php' method='POST' enctype='multipart/form-data'>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr><td id='boldBlackText'>
						Name:</td></tr><tr><td>
									<input type='text' name='articleTitle' id='articleTitle' value='" . $articleText[0]['articleTitle'] . "' class='formField' />
									</td></tr>
									<tr><td id='boldBlackText'>
									Category:<a id=\"cat1Link\" onclick=\"componentHide('cat1')\"></a></td></tr>
									<tr><td>
									<div id='cat1'>
									<select name='articleSubCat' size='1'>
									";
									$query = "SELECT * FROM `catsubtable`";
									$result = mysql_query($query, $conn);
									$count = 1;
									if ($result) {
										while ($row = mysql_fetch_assoc($result)) {
											if ($articleText[0]['articleSubCat'] == $row['catSubID']) {
												echo "<option value='" . $row['catSubID'] . "' selected='selected'>" . $row['catSubName'] . "</option>";
											} else {
												echo "<option value='" . $row['catSubID'] . "'>" . $row['catSubName'] . "</option>";
											}
										}
									}
									echo "</select></div></td></tr>
									<tr><td id='boldBlackText'>
									Summary:<a id=\"cat2Link\" onclick=\"componentHide('cat2')\"></a></td></tr>
									<tr><td>
									<span id='cat2'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat2')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleSummary';
											cols = 70;
											rows = 10;
											value = '" . nl2br($articleText[0]['articleSummary']) . "';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleSummary' id='textarea' cols='70' rows='10'>" . nl2br($articleText[0]['articleSummary']) . "</textarea>
							</noscript>
									</td></tr>
							<tr><td id='boldBlackText'>
									Article:<a id=\"cat3Link\" onclick=\"componentHide('cat3')\"></a>
									</td></tr><tr><td>
									<span id='cat3'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat3')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleText';
											cols = 70;
											rows = 45;
											value = '" . nl2br($articleText[0]['articleText']) . "';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleText' id='textarea' cols='70' rows='45'>" . nl2br($articleText[0]['articleText']) . "</textarea>
							</noscript>
							</td></tr>";
							$conn = databaseConnect();
							$query = "SELECT * FROM `imageTable` WHERE `articleID` = '" . $_GET['articleID'] ."'";
							$result = mysql_query($query, $conn);
							$imageCount = mysql_num_rows($result);
							if (mysql_num_rows($result)>=1) {
								echo "<tr><td id='boldBlackText'>
								Pics:<a id=\"cat4Link\" onclick=\"componentHide('cat4')\"></a></td></tr>
								<tr><td>
								<div id='cat4'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
									<tr>
										<td id='articleTableTopLeft'>&nbsp;</td>
										<td id='articleTableTop'>&nbsp;</td>
										<td id='articleTableTopRight'>&nbsp;</td>
									</tr>
									<tr><td id='articleTableLeft'>&nbsp;</td>
										<td id='articleTableContent'>
										<table border='0' cellpadding='0' cellspacing='0' width='100%' id='picTable'>
										<tr>
											<td id='tableHeaderCells'>Available pics</td>
											<td id='tableHeaderCells'>Information</td>
											<td id='tableHeaderCells'>Use as thumbnail</td>
										</tr>";
									$count = 1;
									while ($row = mysql_fetch_assoc($result)) {
									echo "
									<tr>
										<td class='centerTD'>
											<table border='0' cellpadding='0' cellspacing='0' width='124' align='center'>
											<tr>
												<td><img width='124' height='84' src='images/articlePics/" . $_GET['articleID'] . "/" . $row['imageName'] . "." . $row['imageType'] . "' /></td>
												<td id='articleRight'>&nbsp;</td>
											</tr>
											<tr>
												<td id='articleBottom'>&nbsp;</td>
												<td id='articleCorner'>&nbsp;</td>
											</tr>
											</table>
										</td>";
									echo "
										<td><b>Submited date:</b> " . $row['imageSubmitDate'] . "<br />";
									if ($row['imageStatus'] != 2) {
										if ($row['imageStatus'] == 1) {
											echo "<span class='spanBlue'><b>Approved date:</b> " . $row['imageApprovalDate'] . "</span></td>";
										} else {
											echo "<b><span class='spanOrange'>Not moderated yet</span><b></td>";
										}
									} else {
										echo "<b><span class='spanRed'>Image has been rejected. <a href='workarea.php?page=Error&articleID=" . $_GET[articleID] . "'>Click here</a> to view the reason</span></b></td>";
									}
									//echo "<td><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' /></td></tr>";
									if ($row['imageThumb'] == 1) {
										$thumbSelected = 1;
										echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' checked='checked' /></td></tr>";
									} else {
										echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' /></td></tr>";
									}
								}
								echo "</table></td>
										<td id='articleTableRight'>&nbsp;</td>
									</tr>
									<tr>
										<td id='articleTableBottomLeft'>&nbsp;</td>
										<td id='articleTableBottom'>&nbsp;</td>
										<td id='articleTableBottomRight'>&nbsp;</td>
									</tr>
									</table></div>
								</td></tr>";
							}
							echo "<tr>
							<td id='boldBlackText'>
							Thumb preview:<a id=\"cat5Link\" onclick=\"componentHide('cat5')\"></a>
							</td></tr>
							<tr><td id='picfieldTD'>
								<div id='cat5'>
								<a name='imageAnchor' id='imageAnchor'></a>
								<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td id='articleTableTopLeft'>&nbsp;</td>
									<td id='articleTableTop'>&nbsp;</td>
									<td id='articleTableTopRight'>&nbsp;</td>
								</tr>
								<tr><td id='articleTableLeft'>&nbsp;</td>
									<td id='articleTableContent'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' id='imageTable'>
								<tr>
									<td id='tableHeaderCells'>Select file for upload</td>
									<td id='tableHeaderCells'>Use as thumbnail</td>
								</tr>
								<tr><td class='centerTD'><input type='file' name='" . $_GET['articleID'] . "_" . ($imageCount+1) . "' id='formField' size='45' /></td>";
								if($thumbSelected != 1) {	
									echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET['articleID'] . "_" . ($imageCount+1) . "' checked='checked' /></td>";
								} else {
									echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET['articleID'] . "_" . ($imageCount+2) . "' /></td>";
								}
								echo "</tr>
								<tr>
									<td class='centerTD'><input type='file' name='" . $_GET['articleID'] . "_" . ($imageCount+2) . "' id='formField' size='45' /></td>
									<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET['articleID'] . "_" . ($imageCount+2) . "' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='" . $_GET['articleID'] . "_" . ($imageCount+3) . "' id='formField' size='45' /></td>
									<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET['articleID'] . "_" . ($imageCount+3) . "' /></td>
								</tr>
								</table></td>
									<td  id='articleTableRight'>&nbsp;</td>
								</tr>
								<tr>
									<td id='articleTableBottomLeft'>&nbsp;</td>
									<td id='articleTableBottom'>&nbsp;</td>
									<td id='articleTableBottomRight'>&nbsp;</td>
								</tr>
								</table>
								<div id='addImage'>
								</div>
								<script language='javascript' type='text/javascript'>
									<!--
										document.getElementById('addImage').innerHTML = \"<span class='articleBlueLink'><a onClick='addField2(" . $_GET['articleID'] . ");'>Add more</a></span>\";
									//-->
								</script>
								</div>
							</td></tr>
							<tr><td>
							<noscript>
							<input name='addImage' type='submit' id='blackButton' value='Add Image' />
							</noscript>
							<input name='funcType' type='submit' id='blackButton' value='Publish' />
							<input name='funcType' type='submit' id='blackButton' value='Unfinished' />
							<input type='hidden' name='imageNum' id='imageNum' value='" . ($imageCount+3) . "' />
							<input type='hidden' name='maxFileSize' value='1048576' />
							<input type='hidden' name='validUser' value='".$_SESSION['validuserID']."'>
							<input type='hidden' name='articleID' value='" . $_GET['articleID'] . "'>
							</table>
							</form>";
							$countMain =5;	
								mysql_free_result($result);
								} else {
									echo "error";
								}
							}
							mysql_close($conn);
								}
							} else {
								echo "<div id='notice_bad'>You are not Logged in. You must login first access this area.</div>";
							}
							
							function drawArticleTable($articles, $i, $page) {
								echo "<form id='articleTableForm" . $i . "' name='articleTableForm" . $i . "' action='scripts/workarea_setup.php?' method='POST'>
												<table width='100%' border='0' cellspacing='0' cellpadding='0'>
												<tr><td colspan='2' id='articleTitle'>";
												/*if ($articles[$i]['articleStatus'] == 2) {
													echo "<span class='articleBlueLink'>";
												} else if ($articles[$i]['articleStatus'] == 1) {
													echo "<span class='articleOrangeLink'>";
												} else if ($articles[$i]['articleStatus'] == 3) {
													echo "<span class='articleRedLink'>";
												}*/
												echo "<a href='articles.php?articleID=" . $articles[$i]['articleID'] . "'>" . $articles[$i]['articleTitle'] . "</a></td></tr>";
												echo "<tr><td id='smallGreyText'>";
												
												if ($articles[$i]['articleStatus'] == 0) {
													echo "<b>Status:</b> <span class='spanOrange'>Not active</span>";
												} else if ($articles[$i]['articleStatus'] == 1) {
													echo "<b>Added On:</b> " . $articles[$i]['articleApproveDate'];
												} else {
													echo "<b>Status:</b> <span class='spanRed'>Banned.</span> <a href='workarea.php?page=Error&articleID=" . $articles[$i]['articleID'] . "'>Click here</a> to find out why";
												}
												
												echo "<br /><b>Submitted on:</b> " . $articles[$i]['articleSubmitDate'] . "</td>";
												echo "<td rowspan='3'  id='articleThumb'>
												<table cellspacing='0' cellpadding='0' border='0'>
											<tr>
												<td id='articlePicSmall'><img width='124' height='84' src='";
												$dir = "images/articlePics/".$articles[$i]['articleID']."/";
												$conn2 = databaseConnect();
												$query2 = "SELECT `imageName`, `imageType` FROM `imagetable` WHERE `articleID` = '" . $articles[$i]['articleID'] . "' AND `imageThumb` = '1'";
												$result2 = mysql_query($query2, $conn2);
												if (mysql_num_rows($result2) == 1) {
													$dir = "images/articlePics/".$articles[$i]['articleID']."/";
													while ($row = mysql_fetch_assoc($result2)) {
														echo $dir.$row['imageName'].".".$row['imageType'];
													}
												} else {
													$dir = "images/articlePics/";
													echo $dir."thumbUnknown.jpg";
												}
												echo "' /></td><td id='articleRight'>&nbsp;</td>
											</tr>
											<tr>
												<td id='articleBottom'>&nbsp;</td>
													<td id='articleCorner'>&nbsp;</td>
													</tr>
													<tr>
														<td colspan='2' class='centerTD'>";
														drawRating(getRating($articles[$i]['articleID']));
												echo "</td>
													</tr>
												</table>
												</td></tr>";
												echo "<tr><td id='articleInfo'>";
												echo $catname = drawCatSubCat($articles[$i]['articleSubCat']);
												echo "</td>";
												echo "<tr><td id='articleInfo'>" . $articles[$i]['articleSummary'] . "
												<table border='0' cellspacing='4'>
													<tr>
												<td><input id='editButton' name='pagefunc' type='submit' value='Edit' /></td>";
												if ($page == "Portfolio") {
													echo "<td><input id='unfinishedButton' name='pagefunc' type='submit' value='Unfinished' /></td>";
												} else if ($page == "Unfinished") {
													echo "<td><input id='publishButton' name='pagefunc' type='submit' value='Publish' /></td>";
													echo "<td><input id='deleteButton' name='pagefunc' type='submit' value='Delete' /></td>";
												} else if ($page == "Trash") {
													echo "<td><input id='publishButton' name='pagefunc' type='submit' value='Publish' /></td>";
													echo "<td><input id='unfinishedButton' name='pagefunc' type='submit' value='Unfinished' /></td>";
													echo "<td><input id='deleteButton' name='pagefunc' type='submit' value='Delete forever' /></td>";
												}
												echo "</tr>
												</table>
												</td></tr>";
												
												
												echo "<input type='hidden' name='validUser' value='".$_SESSION['validuserID']."'>
												<input type='hidden' name='articleID' value='" . $articles[$i]['articleID'] . "'>
												<input type='hidden' name='page' value='" . $page . "'>
												</td></tr>
												</table>
												</form>";
							}
							function drawCatSubCat($subcatID) {
								$conn = databaseConnect();
								$sql = "SELECT `catMainID`, `catSubName` FROM `catsubtable` WHERE `catSubID` = " . $subcatID;
								$result = mysql_query($sql, $conn);
								$count = mysql_num_rows($result);
								for ( $i = 0; $i < $count; ++$i ) {
									$array[$i] = mysql_fetch_assoc($result);
								}
								mysql_free_result($result);
								$sql = "SELECT `catMainName` FROM `catmaintable` WHERE `catMainID` = " . $array[0]['catMainID'];
								$result = mysql_query($sql, $conn);
								$count = mysql_num_rows($result);
								for ( $i = 0; $i < $count; ++$i ) {
									$array2[$i] = mysql_fetch_assoc($result);
								}
								mysql_free_result($result);
								mysql_close($conn);
								return "<b>" . $array2[0]['catMainName'] . " | " . $array[0]['catSubName'] . "</b>";
							}
						?></td>
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
	
	var components=['chat', 'calendar', 'publications', 'sponsors'];
	
	start(components);
	start(cats);
	
	
	function addField() {
		var imageNum = document.getElementById('imageNum').value;
		
		var table = document.getElementById('imageTable');
		var tr = document.createElement ('tr');
		var td1 = document.createElement ('td');
		var td2 = document.createElement ('td');
		td1.setAttribute('class' ,'centerTD');
		td2.setAttribute('class' ,'centerTD');
		document.getElementById('imageNum').value = ((1*imageNum)+1);
		td1.innerHTML = "<input type='file' name='newImage" + ((1*imageNum)+1) + "' id='formField' size='45' />";
		td2.innerHTML = "<input name='thumb' type='radio' value='newImage" + ((1*imageNum)+1) + "' />";
		tr.appendChild(td1);
		tr.appendChild(td2);
		table.appendChild(tr);
		
	}
		function addField2(articleID) {
		var imageNum = document.getElementById('imageNum').value;
		
		var table = document.getElementById('imageTable');
		var tr = document.createElement ('tr');
		var td1 = document.createElement ('td');
		var td2 = document.createElement ('td');
		
		td1.setAttribute('class' ,'centerTD');
		td2.setAttribute('class' ,'centerTD');
		document.getElementById('imageNum').value = ((1*imageNum)+1);
		td1.innerHTML = "<input type='file' name='"+ articleID + "_" + ((1*imageNum)+1) + "' id='formField' size='45' />";
		td2.innerHTML = "<input name='thumb' type='radio' value='"+ articleID + "_" + ((1*imageNum)+1) + "' />";
		tr.appendChild(td1);
		tr.appendChild(td2);
		table.appendChild(tr);
		
	}
</script>
</body>
</html>