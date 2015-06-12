<?php
	session_start();

	include('scripts/db.php');
	include('scripts/user_func.php');
	include('scripts/cookie_func.php');
	include('scripts/common.php');
	include('scripts/category_func.php');
	include('scripts/article_func.php');
	include('scripts/pagination.php');


	if (isset($_GET['cookieFail']) && $_GET['stamp'] < (time() + 2)) {
		redMsg_write("<tr><td>We have detected that cookies are disabled. You need to enable cookies to login.</td></tr>");
	} else {
		checkCookieEnabled();
	}
	checkUserCookies();
	
	if ( isset($_GET['catSub']) &&  is_numeric($_GET['catSub']) && ($_GET['catSub'] > 0) ) {
		$catSub = $_GET['catSub'];
	} else {
		$catSub = 1;
	}
	
	if ( isset($_GET['sortBy']) && $_GET['sortBy'] > 0 && $_GET['sortBy'] < 4 ) {
		$sortBy = $_GET['sortBy'];
	} else {
		$sortBy = '1';
	}

	if ( isset($_GET['sortOrder']) && $_GET['sortOrder'] > 0 && $_GET['sortOrder'] < 3 ) {
		$sortOrder = $_GET['sortOrder'];
	} else {
		$sortOrder = '1';
	}

	if ( isset($_GET['showLimit']) && is_numeric($_GET['showLimit']) && $_GET['showLimit'] >= 5 && $_GET['showLimit'] <= 20 ) {
		$showLimit = $_GET['showLimit'];
	} else {
		$showLimit = 5;
	}

	switch ($sortBy) {
		case 1:
			$orderBy = "articleApproveDate";
			break;
		case 2:
			$orderBy = "articleViews";
			break;
		case 3:
			$orderBy = "articleRating";
			break;
	}

	switch ($sortOrder) {
		case 1:
			$arrange = "ASC";
			break;
		case 2:
			$arrange = "DESC";
			break;
	}

	$ifExistCatSub = ifExistCat($catSub, "CatSub");
	$catMain = getMainCat($catSub);
	$ifExistCatMain = ifExistCat($catMain, "CatMain");
	
	$numArticles = countArticlesByCat($catSub);
	$numPages = countPages($numArticles, $showLimit);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOICES - articles by category</title>
<link href="styles/common.css" rel="stylesheet" type="text/css" />
<link href="styles/chat.css" rel="stylesheet" type="text/css" />
<link href="styles/category.css" rel="stylesheet" type="text/css" />
<link href="styles/billboard.css" rel="stylesheet" type="text/css" />
<link href="styles/pagination.css" rel="stylesheet" type="text/css" />
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
		        <td align="center" valign="top"><table id="navLinks" border="0" cellpadding="0" cellspacing="0">
              	<tr>
                  <td id="navHome"><a href="home.php">&nbsp;</a></td>
                  <td id="navFAQ"><a href="category.php">&nbsp;</a></td>
                  <td id="navRegister"><a href="register.php">&nbsp;</a></td>
                </tr>
          		</table>
        		</td>
      		</tr>
    		</table>
				  <?php
					if ( $ifExistCatMain > 0 && $ifExistCatSub > 0 && $numArticles > 0 ) {
						$feature = getFeature($catSub);
						getPages();
						echo "<table id='componentTable' width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td id='categoryName'><img width='30' height='200' src='images/cat/".$catSub."_1.jpg' /></td>
								<td id='categoryImage'><img width='170' height='200' src='images/cat/".$catSub."_2.jpg' /></td>
								<td align='right'>
									<table border='0' callpadding='0' cellspacing='0'>
										<tr>
											<td id='cornerTL4'>&nbsp;</td>
											<td id='lineT4'>&nbsp;</td>
											<td id='cornerTR4'>&nbsp;</td>
										</tr>
										<tr>
											<td id='lineL4'>&nbsp;</td>
											<td id='billboard'>
												<table id='spotlightContainer' width='100%' border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td id='billboardHeading' colspan='2'>Featured Article</td>
													</tr><tr>
														<td id='smallHeading'>Arthur:</td>
														<td id='username'>".$feature['username']."</td>
													</tr><tr>
														<td id='smallHeading'>Rating:</td>
														<td id='spotlightDetail'>"; drawRating($feature['articleRating']); echo "</td>
													</tr><tr>
														<td id='smallHeading'>Added On:</td>
														<td id='spotlightDetail'>"; echo printDate($feature['articleApproveDate'], "d-M-y")."</td>
													</tr>
													<tr>
														<td id='featureTitle' colspan='2'>".$feature['articleTitle']."</td>
													</tr><tr>
														<td id='spotlightDetail' colspan='2'>".$feature['articleSummary']."</td>
													</tr><tr>
														<td id='readArticle'><a href='articles.php?articleID=".$feature['articleID']."'>Read Article</a></td>
														<td id='readComment'>Comments(".countComments($feature['articleID']).")</td>
													</tr>
												</table>
											</td>
											<td id='lineR4'>&nbsp;</td>
										</tr>
										<tr>
											<td id='cornerBL4'>&nbsp;</td>
											<td id='lineB4'>&nbsp;</td>
											<td id='cornerBR4'>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table id='componentTable' width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td id='boldBlackText'>More Options</td>
							</tr>
							<tr>
								<td id='optionsContainer'><form name='options' method='get' action='category.php'>
									<table border='0' cellspacing='0' cellpadding='0'>
										<tr>
											<td id='simpleText'>Sort by</td>
											<td>
												<input name='prevStart' type='hidden' value='".$currStart."' >
												<input name='currPage' type='hidden' value='".$currPage."' >
												<input name='catSub' type='hidden' value='".$catSub."' >
												<select id='optionList' name='sortBy'>
													<option value='1'"; if ($sortBy == 1) { echo " selected"; }; echo ">Date</option>
													<option value='2'"; if ($sortBy == 2) { echo " selected"; }; echo ">Views</option>
													<option value='3'"; if ($sortBy == 3) { echo " selected"; }; echo ">Rating</option>
												</select>
											</td>
											<td id='simpleText'>Order</td>
											<td>
												<select id='optionList' name='sortOrder'>
													<option value='1'"; if ($sortOrder == 1) { echo " selected"; }; echo ">Ascending</option>
													<option value='2'"; if ($sortOrder == 2) { echo " selected"; }; echo ">Descending</option>
												</select>
											</td>
											<td id='simpleText'>Limit</td>
											<td>
												<select id='optionList' name='showLimit'>
													<option value='5'"; if ($showLimit == 5) { echo " selected"; }; echo ">5</option>
													<option value='10'"; if ($showLimit == 10) { echo " selected"; }; echo ">10</option>
													<option value='15'"; if ($showLimit == 15) { echo " selected"; }; echo ">15</option>
													<option value='20'"; if ($showLimit == 20) { echo " selected"; }; echo ">20</option>
												</select>
											</td>
											<td><input id='optionSubmit' type='submit' value='Sort Now' /></td>
										</tr>
									</table>
								</form></td>
							</tr>
						</table>
						<table id='componentTable' width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td id='boldBlackText'>Showing pages $currPage of $numPages</td>
							</tr><tr>
								<td id='resultContainer'>"; getArticles ($catSub); echo "</td>
							</tr><tr>
								<td align='center'>"; if ( $numPages > 1 ) { drawPagination($currStart, $currEnd, "category"); } echo "</td>
							</tr>
						</table>";
					} elseif ( $ifExistCatMain > 0 && $ifExistCatSub > 0 ) {
						echo "<div id='notice_neutral'>No articles Submitted in this categroy</div>";
					} else {
						echo "<div id='notice_neutral'>Please Select a valid category</div>";
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
              	<?php include('include/browser.php'); ?>
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
	var components=['chat', 'calendar', 'publications', 'sponsors', 'browser'];
	start(components);
</script>
</body>
</html>