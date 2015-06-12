<?php
	function getRating($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT AVG(articleRating) FROM `articleRatings` WHERE `articleID` = $articleID";
		$result = mysql_query($query);
		$array = mysql_fetch_array($result);

		$value = intval($array[0]);
		
		$query = "SELECT `ratingName` AS `articleRating` FROM `articleRatingSystem` WHERE `ratingID` = $value";
		$result = mysql_query($query);
		$array = mysql_fetch_assoc($result);

		mysql_free_result($result);
		mysql_close($conn);

		if ($value == 0) {
			$array['articleRating'] = "unrated";
		}
//		return $array['articleRating'];
			return $value;
	}
	
	function countComments($articleID) {
		$conn = databaseConnect();
		$query = "SELECT `commentID` FROM `commenttable` WHERE `commenttable`.`articleID` = $articleID AND `commenttable`.`commentStatus` = 1";
		$result = mysql_query($query, $conn);

		$count = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);

		if ( $count < 1 ) {
			return 0;
		} else {
			return $count;
		}
	}
		
	function getFlags($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT * FROM `articleflags` WHERE `articleID` = $articleID";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);

		mysql_free_result($result);
		mysql_close($conn);
		
		return $count; 
	}
		
	function getAuthor($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT `usertable`.`userID`  FROM `articletable`, `usertable` WHERE `articleID` = $articleID AND `articletable`.`userID` = `usertable`.`userID`";
		$result = mysql_query($query);
		$array = mysql_fetch_array($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array[0];
	}
	
	function checkIfFav($userID, $articleID) {
		$conn = databaseConnect();
		
		$sql = "SELECT `favID` FROM `favorites` WHERE `userID` = $userID AND `articleID` = $articleID";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		mysql_free_result($result);
		mysql_close($conn);
		return $count;
	}
	
	function readArticle($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT `articleID`, `articleTitle`, `articleText`, UNIX_TIMESTAMP(articleApproveDate) AS `articleApproveDate`, `articleViews`, `articleStatus` FROM `articletable` WHERE `articleID` = $articleID";
		$result = mysql_query($query);
		mysql_close($conn);
		$array = mysql_fetch_assoc($result);
		$array['articleRating'] = getRating($articleID);
		$cats = getCategories($articleID);
		$array['articleSubCat'] = $cats['catSubName'];
		$array['articleSubCatID'] = $cats['catSubID'];
		$array['articleMainCat'] = $cats['catMainName'];
		
		
		mysql_free_result($result);
		

		return $array;
	}
	
	function getCategories($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT `catSubName`, `catSubID`, `catMainName` FROM `catmaintable`, `catsubtable`, `articletable` WHERE `articletable`.`articleID` = $articleID AND `articletable`.`articleSubCat` = `catsubtable`.`catSubID` AND `catsubtable`.`catMainID` = `catmaintable`.`catMainID`";
		$result = mysql_query($query);
		$array = mysql_fetch_assoc($result);

		mysql_free_result($result);
		mysql_close($conn);

		return $array;
	}
	
	function getArticlePics($articleID) {
		$pic_dir = "images/articlePics/".$articleID;
		$curr_dir = opendir($pic_dir);
		echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td>";
		$i = 1;
		while ( ($file = readdir($curr_dir)) && $i <= 5) {
			if ( ereg("^[0-9]+_[0-9]+\.(jpg)|(jpeg)|(png)|(gif)$", $file ) ) {
				echo "<a href='images/articlePics/$articleID/$file' target='_blank'><img id='thumb' src='scripts/generateThumb.php?loc=articlePics/".$articleID."&file=".htmlspecialchars($file)."' /></a>";
				$i++;
			}
		}
		echo "</td></tr></table>";
		closedir($curr_dir);
	}
	
	function getUserVote($userID, $articleID) {
		if ( isset($_SESSION['validuserID']) ) {
			$conn = databaseConnect();
			
			$query = "SELECT `articleRating` FROM `articleratings` WHERE `userID` = $userID AND `articleID` = $articleID";
			$result = mysql_query($query);
			$array = mysql_fetch_assoc($result);
			
			$count = mysql_num_rows($result);
			
			mysql_free_result($result);
			mysql_close($conn);
	
			if ( $count < 1 ) {
				echo "<tr>
					<td id='boldBlackText'>Rate This Article</td>
				</tr><tr>
					<td>hahahahaha</td>
				</tr>";
			} else {
				echo "<tr>
					<td id='boldBlueText'>You Rated This As</td>
				</tr><tr>
					<td>"; drawRating($array['articleRating']); echo "</td>
				</tr>";
			}
		}
	}
	
	function hit($articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT `articleViews` FROM `articletable` WHERE `articleID`=$articleID";
		$result = mysql_query($query);
		$array = mysql_fetch_assoc($result);
		$array['articleViews']++;
		
		$query = "UPDATE `articletable` SET `articleViews` = '".$array['articleViews']."' WHERE `articletable`.`articleID` = $articleID LIMIT 1";
		$result = mysql_query($query);

		mysql_close($conn);
	}
	
	function readQuote($commentID, $articleID) {
		$conn = databaseConnect();
		
		$query = "SELECT `commentID`, `userID`, `commentText`, UNIX_TIMESTAMP(commentTime) AS `commentTime`, `replyto` FROM `commenttable` WHERE `articleID`=$articleID AND `commentID`=$commentID AND `commentStatus`=1";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		
		if ( $count > 0 ) {
			$array = mysql_fetch_assoc($result);
		} else {
			$array['commentText'] = '<span style="color:#AAAAAA"; >[[ Removed by Admin ]]</span>';
		}
		
		mysql_free_result($result);
		mysql_close($conn);
		
		return $array;
	}
	
	function getComments($articleID) {
		global $start, $showLimit;
		
		if ( !$start ) {
			$start = 0;
		}
		
		$conn = databaseConnect();

		$query = "SELECT `commentID`, `userID`, `commentText`, UNIX_TIMESTAMP(commentTime) AS `commentTime`, `replyto` FROM `commenttable` WHERE `articleID`=$articleID AND `commentStatus`=1 LIMIT $start, $showLimit";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);

		$i = 1;
		while ( $i <= $count ) {
			$loop = 1;
			$array[$loop] = mysql_fetch_assoc($result);
			$spotlight[$loop] = userSpotLight($array[$loop]['userID']);
			
			echo "<tr>
					<td><table id='commentContainer'border='0' cellspacing='0' cellpadding='0' width='100%'>
						<tr>
							<td id='userArea'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td id='userName_heading'>".$spotlight[$loop]['userName']."</td>
								</tr><tr>
									<td id='userGroup_heading'>".$spotlight[$loop]['groupName']."</td>
								</tr><tr>
									<td align='center'><img width='50' height='50' src='../images/avatars/".$spotlight[$loop]['userAvatar']."' /></td>
								</tr><tr>
									<td id='billboardLink'><a src='#'>[Profile]</a></td>
								</tr>
							</table></td>
							<td id='commentText'>
								<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td>";
									while ( $loop < 5 && $array[$loop]['replyto'] > 0 ) {
										$dig = $array[$loop]['replyto'];
										$loop++;

										$array[$loop] = readQuote($dig, $articleID, $conn);
										$spotlight[$loop] = userSpotLight($array[$loop]['userID']);
										
									}

									if ( $loop > 1 ) {
										$digLevel = 2;
										for ($x = $digLevel; $x <= $loop; ++$x) {
											echo "<div>In reply to what <strong>".$spotlight[$x]['userName']."</strong> said";
											echo "<div id='quotedText'>";
										}
										for ($x = $loop; $x >= $digLevel; --$x) {
											echo $array[$x]['commentText']."<div align='right' id='smallGreyText'>Written On: ".printDate($array[$x]['commentTime'], 'd-M-Y H:i:s')."</div></div>";
											echo "</div>";
										}
										++$digLevel;
									}

								$loop = 1;
								echo "</td>
									</tr><tr>
										<td>".$array[$loop]['commentText']."</td>
									</tr><tr>
										<td align='right' id='smallGreyText'>Written On: "; echo printDate($array[$loop]['commentTime'], "d-M-Y H:i:s"); echo "</td>
									</tr>
								</table>
							</td>
						</tr>";
						if ( isset($_SESSION['validuser']) ) {
							echo "<tr>
								<td align='right' colspan='2'>
									<table >
										<tr>
											<td><img src='../images/quote.png' /></td>
											<td id='smallGreyText'><a href='writeComment.php?commentID=".$array[$loop]['commentID']."&quotedUser=".$spotlight[$loop]['userName']."&validUser=".$_SESSION['validuserID']."&articleID=".$_GET['articleID']."'>Quote reply</a></td>
											<td><img src='../images/flag.png' /></a></td>
											<td id='smallGreyText'><a href='flagComment.php?commentID=".$array[$loop]['commentID']."'>Flag it!</a></td>
										</tr>
									</table>
								</td>
							</tr>";
						}
					echo "</table></td>
				</tr>";
			++$i;
		}
	}
?>