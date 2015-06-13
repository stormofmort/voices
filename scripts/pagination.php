<?php
	function countPages($total_items, $per_page) {
		if ( ($total_items < $per_page) && $total_items > 0 ) {
			return 1;
		} elseif ( $total_items > 0 ) {
			$remainder = $total_items % $per_page;
			if ($remainder == 0) {
				return $count = $total_items / $per_page;
			} else {
				return $count = (($total_items - $remainder) / $per_page) + 1;
			}
		} else {
			return 0;
		}
	}
	
	function getPages() {
		global $currPage, $currStart, $currEnd, $numPages, $start, $showLimit;
		if ( $numPages < 5 ) {
			$addPages = $numPages - 1;
		} else {
			$addPages = 4;
		}
	
		if ( isset($_GET['currPage']) &&  is_numeric($_GET['currPage']) && ($_GET['currPage'] > 0) ) {
			$currPage = $_GET['currPage'];
		} else {
			$currPage = 1;
		}
	
		if ( isset($_GET['prevStart']) &&  is_numeric($_GET['prevStart']) && ($_GET['prevStart'] > 0) ) {
			$currStart = $_GET['prevStart'];
			$currEnd = $currStart + $addPages;
		} else {
			$currStart = 1;
			$currEnd = $currStart + $addPages;
		}
	
		if ($currEnd > $numPages) {
			$currEnd = $numPages;
			$currStart = $currEnd - $addPages; 
		}
		
		if ( $currPage >= $numPages ) {
			$currPage = $numPages;
			$currEnd = $numPages;
			$currStart = $currEnd - $addPages; 
		}
	
		if ( ($currPage <= $currStart) && $currStart != 1 ) {
			while ($currStart >= $currPage) {
				--$currStart;
			}
			if ($currEnd - $currStart > $addPages) {
				$currEnd = $currStart + $addPages;
			}
		} elseif ( ($currPage >= $currEnd) && ($currEnd < $numPages) ) {
			while ($currEnd <= $currPage) {
				++$currEnd;
			}
			if ($currEnd - $currStart > $addPages) {
				$currStart = $currEnd - $addPages;
			}
		}
		
		$start = ($currPage - 1) * $showLimit;
		
		//echo $currPage . '<br>' . $currStart . '<br>' . $currEnd . '<br>' . $numPages . '<br>' . $start . '<br>' . $showLimit;
		//exit();
	}

	function drawPagination($begin, $end, $caller, $add=NULL) {
		global $numArticles, $numPages, $currPage, $currStart, $catSub, $sortBy, $sortOrder, $showLimit, $searchText, $searchType;
		echo "<table border='0' cellspacing='2' cellpadding='0' align='center'><tr>";
		if ( $currPage > 1 ) {
			if ( $caller == "category" ) {
				echo "<td id='firstPage'><a href='category.php?currPage=1&catSub=$catSub&sortBy=$sortBy&sortOrder=$sortOrder&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='prevPage'><a href='category.php?currPage="; echo ($currPage - 1); echo "&prevStart=$currStart&catSub=$catSub&sortBy=$sortBy&sortOrder=$sortOrder&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "comments" ) {
				echo "<td id='firstPage'><a href='comments.php?articleID=".$_GET['articleID']."&currPage=1&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='prevPage'><a href='comments.php?articleID=".$_GET['articleID']."&currPage="; echo ($currPage - 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "results" ) {
				echo "<td id='firstPage'><a href='results.php?currPage=1&showLimit=$showLimit&searchText=$searchText&searchType=$searchType'>&nbsp;</a><td>";
				echo "<td id='prevPage'><a href='results.php?currPage="; echo ($currPage - 1); echo "&prevStart=$currStart&showLimit=$showLimit&searchText=$searchText&searchType=$searchType'>&nbsp;</a><td>";
			} elseif ( $caller == "messages" ) {
				echo "<td id='firstPage'><a href='messages.php?&".$add."&currPage=1&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='prevPage'><a href='messages.php?&".$add."&currPage="; echo ($currPage - 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "workarea" ) {
				echo "<td id='firstPage'><a href='workarea.php?&".$add."&currPage=1&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='prevPage'><a href='workarea.php?&".$add."&currPage="; echo ($currPage - 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
			}
		} else {
			if ( $caller == "category" ) {
				echo "<td id='firstPage'>&nbsp;<td>";
				echo "<td id='prevPage'>&nbsp;<td>";
			} elseif ( $caller == "comments" ) {
				echo "<td id='firstPage'>&nbsp;<td>";
				echo "<td id='prevPage'>&nbsp;<td>";
			} elseif ( $caller == "results" ) {
				echo "<td id='firstPage'>&nbsp;<td>";
				echo "<td id='prevPage'>&nbsp;<td>";
			} elseif ( $caller == "messages" ) {
				echo "<td id='firstPage'>&nbsp;<td>";
				echo "<td id='prevPage'>&nbsp;<td>";
			} else if($caller == "workarea" ) {
				echo "<td id='firstPage'>&nbsp;<td>";
				echo "<td id='prevPage'>&nbsp;<td>";
			}
		}
		for ( $i = $begin; $i <= $end; $i++ ) {
			if ( $currPage != $i ) {
				if ( $caller == "category" ) {
					echo "<td id='pagination'><a href='category.php?prevStart=$currStart&currPage=$i&catSub=$catSub&sortBy=$sortBy&sortOrder=$sortOrder&showLimit=$showLimit'>$i</a></td>";
				} elseif ( $caller == "comments" ) {
					echo "<td id='pagination'><a href='comments.php?articleID=".$_GET['articleID']."&prevStart=$currStart&currPage=$i&showLimit=$showLimit'>$i</a></td>";
				} elseif ( $caller == "results" ) {
					echo "<td id='pagination'><a href='results.php?prevStart=$currStart&currPage=$i&showLimit=$showLimit&searchText=$searchText&searchType=$searchType'>$i</a></td>";
				} elseif ( $caller == "messages" ) {
					echo "<td id='pagination'><a href='messages.php?".$add."&prevStart=$currStart&currPage=$i&showLimit=$showLimit'>$i</a></td>";
				} elseif ( $caller == "workarea" ) {
					echo "<td id='pagination'><a href='workarea.php?".$add."&prevStart=$currStart&currPage=$i&showLimit=$showLimit'>$i</a></td>";
				}
			} else {
				if ( $caller == "category" ) {
					echo "<td id='currNumber'>$i</td>";
				} elseif ( $caller == "comments" ) {
					echo "<td id='currNumber'>$i</td>";
				} elseif ( $caller == "results" ) {
					echo "<td id='currNumber'>$i</td>";
				} elseif ( $caller == "messages" ) {
					echo "<td id='currNumber'>$i</td>";
				} elseif ( $caller == "workarea" ) {
					echo "<td id='currNumber'>$i</td>";
				}
			}
		}
		if ( $currPage < $numPages ) {
			if ( $caller == "category" ) {
				echo "<td id='nextPage'><a href='category.php?currPage="; echo ($currPage + 1); echo "&prevStart=$currStart&catSub=$catSub&sortBy=$sortBy&sortOrder=$sortOrder&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='lastPage'><a href='category.php?currPage=$numPages&catSub=$catSub&sortBy=$sortBy&sortOrder=$sortOrder&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "comments" ) {
				echo "<td id='nextPage'><a href='comments.php?articleID=".$_GET['articleID']."&currPage="; echo ($currPage + 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='lastPage'><a href='comments.php?articleID=".$_GET['articleID']."&currPage=$numPages&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "results" ) {
				echo "<td id='nextPage'><a href='results.php?currPage="; echo ($currPage + 1); echo "&prevStart=$currStart&showLimit=$showLimit&searchText=$searchText&searchType=$searchType'>&nbsp;</a><td>";
				echo "<td id='lastPage'><a href='results.php?currPage=$numPages&showLimit=$showLimit&searchText=$searchText&searchType=$searchType'>&nbsp;</a><td>";
			} elseif ( $caller == "messages" ) {
				echo "<td id='nextPage'><a href='messages.php?".$add."&currPage="; echo ($currPage + 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='lastPage'><a href='messages.php?".$add."&currPage=$numPages&showLimit=$showLimit'>&nbsp;</a><td>";
			} elseif ( $caller == "workarea" ) {
				echo "<td id='nextPage'><a href='workarea.php?".$add."&currPage="; echo ($currPage + 1); echo "&prevStart=$currStart&showLimit=$showLimit'>&nbsp;</a><td>";
				echo "<td id='lastPage'><a href='workarea.php?".$add."&currPage=$numPages&showLimit=$showLimit'>&nbsp;</a><td>";
			}
		} else {
			if ( $caller == "category" ) {
				echo "<td id='nextPage'>&nbsp;<td>";
				echo "<td id='lastPage'>&nbsp;<td>";
			} elseif ( $caller == "comments" ) {
				echo "<td id='nextPage'>&nbsp;<td>";
				echo "<td id='lastPage'>&nbsp;<td>";
			} elseif ( $caller == "results" ) {
				echo "<td id='nextPage'>&nbsp;<td>";
				echo "<td id='lastPage'>&nbsp;<td>";
			} elseif ( $caller == "messages" ) {
				echo "<td id='nextPage'>&nbsp;<td>";
				echo "<td id='lastPage'>&nbsp;<td>";
			} elseif ( $caller == "workarea" ) {
				echo "<td id='nextPage'>&nbsp;<td>";
				echo "<td id='lastPage'>&nbsp;<td>";
			}
		}
		echo "</tr></table>";
	}
?>