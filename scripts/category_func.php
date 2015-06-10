<?php
	function ifExistCat($catid, $cat) {
		$conn = databaseConnect();
		$query = "SELECT * FROM `".$cat."table` WHERE `".$cat."ID` = $catid";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);

		mysql_free_result($result);
		mysql_close($conn);

		return $count;
	}
	
	function countArticlesByCat($catid) {
		$conn = databaseConnect();
		$query = "SELECT `articleID` FROM `articletable` WHERE `articleSubCat` = $catid";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);

		mysql_free_result($result);
		mysql_close($conn);

		return $count;
	}
	
	function getMainCat($subCat) {
		$conn = databaseConnect();
		$sql = "SELECT `catMainID` FROM `catsubtable` WHERE `catSubID` = $subCat";
		$result = mysql_query($sql);
		
		$cat = mysql_fetch_assoc($result);
		
		mysql_free_result($result);
		mysql_close($conn);

		return $cat['catMainID'];
	}
	function getFeature($cat) {
		$conn = databaseConnect();
		$query1 = "SELECT `feature` FROM `catsubtable` WHERE `catsubID` = $cat";
		$result1 = mysql_query($query1, $conn);
		$array = mysql_fetch_assoc($result1);
		$feature = $array['feature'];
		
		$query2 = "SELECT `articleID`, `articleTitle`, `articleSummary`, UNIX_TIMESTAMP(articleApproveDate) AS `articleApproveDate`, `username`
								FROM `usertable`, `articletable`
								WHERE `articleID` = $feature
									AND `articletable`.`userID` = `usertable`.`userID";
		$result2 = mysql_query($query2, $conn);
		$array = mysql_fetch_assoc($result2);

		$array['articleRating'] = getRating($array['articleID']);
		$array['articleComments'] = countComments($array['articleID']);

		mysql_free_result($result1, $result2);
		mysql_close($conn);
		
		return $array;
	}
	
	function getArticles($catSub) {
		global $start, $showLimit, $orderBy, $arrange;
		$conn = databaseConnect();
		$query = "SELECT `articletable`.`articleID`, `articleTitle`, `articleSummary`, UNIX_TIMESTAMP(articleApproveDate) AS `articleApproveDate`, `articleViews`, AVG(articleRating) AS `articleRating`
								FROM `articletable` LEFT JOIN `articleRatings` ON `articletable`.`articleID` = `articleRatings`.`articleID`
								WHERE `articleSubCat` = $catSub AND `articleStatus` = 1
								GROUP BY `articletable`.`articleID`
								ORDER BY $orderBy $arrange
								LIMIT $start, $showLimit";
		$result = mysql_query($query);
		if ( mysql_num_rows($result) > 0 ) {
			$stop = mysql_num_rows($result);
			for ($i = 1; $i <= $stop; $i++) {
				$array = mysql_fetch_assoc($result);
				$array['articleComments'] = countComments($array['articleID']);
				$array['articleRating'] = getRating($array['articleID']);
				echo "<div id='articleContainer'>
							<table border='0' cellspacing='0' cellpadding='0' width='100%'>
								<tr>
									<td colspan='2' id='articleTitle'><a href='articles.php?articleID=".$array['articleID']."'>".$array['articleTitle']."</a></td>
								</tr>
								<tr>
									<td colspan='2' id='smallGreyText'>Added On: ";echo printDate($array['articleApproveDate'], "d-M-y")."
								</tr>
								<tr>
									<td id='articleSummary'>".$array['articleSummary']."
										<table id='tableMiniInfo' border='0' cellspacing='0'>
												<tr>
													<td id='articleMiniIcon'>Comments:&nbsp;</td>
													<td id='articleMiniInfo'>".$array['articleComments']."
													<td id='articleMiniIcon'>Views:&nbsp;</td>
													<td id='articleMiniInfo'>".$array['articleViews']."
													<td id='articleMiniIcon'>Rating:&nbsp;</td>
													<td id='articleMiniInfo'>"; drawRating($array['articleRating']); echo "
												</tr>
											</table>
									</td>
									<td  id='articlePicArea'>
										<table cellspacing='0' cellpadding='0' border='0'>
											<tr>
												<td id='articlePicSmall'><img width='124' height='84' src='images/articlePics/".$array['articleID']."/".$array['articleID']."_thumb.jpg' /></td>
												<td id='articleRight'>&nbsp;</td>
											</tr>
											<tr>
												<td id='articleBottom'>&nbsp;</td>
												<td id='articleCorner'>&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>
							</table></div>";
			}
		} else {
			echo "No articles were found under that category";
		}
		mysql_free_result($result);
		mysql_close($conn);
	}
?>