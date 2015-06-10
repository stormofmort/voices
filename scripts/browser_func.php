<?php
	function getCats() {
		$conn = databaseConnect();
		
		$sqlMain = "SELECT `catMainID`, `catMainName` FROM `catmaintable`";
		$resultMain = mysql_query($sqlMain);
		$countMain = mysql_num_rows($resultMain);
		for ( $i = 1; $i <= $countMain; ++$i ) {
			$catMain[$i] = mysql_fetch_assoc($resultMain);
			$sqlSub = "SELECT `catSubID`, `catSubName` FROM `catsubtable` WHERE `catMainID`=$i";
			$resultSub = mysql_query($sqlSub);
			$countSub = mysql_num_rows($resultSub);
			$catMain[$i]['numSub'] = $countSub;
			for ( $j = 1; $j <= $countSub; ++$j ) {
				$catMain[$i][$j] = mysql_fetch_assoc($resultSub);
				$sqlCount = "SELECT `articleID` FROM `articletable` WHERE `articleSubCat` = ".$catMain[$i][$j]['catSubID'];
				$resultCount = mysql_query($sqlCount);
				$catMain[$i][$j]['numArticles'] = mysql_num_rows($resultCount);
			}
		}
		mysql_free_result($resultMain);
		mysql_free_result($resultSub);
		mysql_free_result($resultCount);
		mysql_close($conn);
		return $catMain;
	}		
?>