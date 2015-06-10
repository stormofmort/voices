<?php
	function simpleSearch($searchText, $method='find') {
		global $numResults, $showLimit, $start;
		
		$conn = databaseConnect();
		$words = explode(" ", $searchText);
		$numWords = count($words);
		for ($i = 0; $i < $numWords; ++$i) {
			$title .= "`articleTitle` LIKE '%".trim($words[$i])."%'";
			$summary .= "`articleSummary` LIKE '%".trim($words[$i])."%'";
			$text .= "`articleText` LIKE '%".trim($words[$i])."%'";
			if ($i < $numWords - 1) {
				$title .= " OR ";
				$summary .= " OR ";
				$text .= " OR ";
			}
		}
		$sql = "SELECT `articleTitle`, `articleText` FROM `articletable`
			WHERE ".$title." OR
						".$summary." OR
						".$text;
		
		if ( $method == 'count' ) {
			$result = mysql_query($sql);
			$array = mysql_num_rows($result);
		} else {
			$sql .= " LIMIT $start, $showLimit";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
		
			for ( $i=1; $i <= $count; ++$i ) {
				$array[$i] = mysql_fetch_assoc($result);
			}
		}
		mysql_free_result($result);
		mysql_close($conn);

		return $array;
	}
	
	function cuttext($string, $match_to, $length)
	{   
			$match_start = stristr($string, $match_to);
			$match_compute = strlen($string) - strlen($match_start);
	
			if (strlen($string) > $length)
			{
					if ($match_compute < ($length - strlen($match_to)))
					{
							$pre_string = substr($string, 0, $length);
							$pos_end = strrpos($pre_string, " ");
							if($pos_end === false) $string = $pre_string."...";
							else $string = substr($pre_string, 0, $pos_end)."...";
					}
					else if ($match_compute > (strlen($string) - ($length - strlen($match_to))))
					{
							$pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));
							$pos_start = strpos($pre_string, " ");
							$string = "...".substr($pre_string, $pos_start);
							if($pos_start === false) $string = "...".$pre_string;
							else $string = "...".substr($pre_string, $pos_start);
					}
					else
					{       
							$pre_string = substr($string, ($match_compute - round(($length / 3))), $length);
							$pos_start = strpos($pre_string, " "); $pos_end = strrpos($pre_string, " ");
							$string = "...".substr($pre_string, $pos_start, $pos_end)."...";
							if($pos_start === false && $pos_end === false) $string = "...".$pre_string."...";
							else $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
					}
	
					$match_start = stristr($string, $match_to);
					$match_compute = strlen($string) - strlen($match_start);
			}
		 
			return $string;
	}
	
	function findWord ($haystack, $needle) {
		$needleLen = strlen($needle);
		while ( stripos($haystack, $needle) !== false ) {
			$match_start = stristr($haystack, $needle);
			$str .= substr($haystack, 0, ( strlen($haystack) - strlen($match_start) ));
			$x = substr($match_start, 0, $needleLen);
			$str .= "<span id='found_text'>".$x."</span>";
			$haystack = substr( $match_start, strlen($needle), (strlen($match_start) - $needleLen) );
		}
		
		$str .= $haystack;
		return trim($str);
	}
	
	function formatResult($records, $searchText) {
		$words = explode(" ", $searchText);
		$countR = count($records);
		$countW = count($words);
		for ( $i=1; $i <= $countR; ++$i ) {
			for ( $x=0; $x < $countW; ++$x ) {
				$theWord = $words[0];
				$records[$i]['articleTitle'] = cuttext(htmlspecialchars_decode(strip_tags($records[$i]['articleTitle'])), $theWord, 255);
				$records[$i]['articleTitle'] = findWord($records[$i]['articleTitle'], $theWord);
				$records[$i]['articleText'] = cuttext(htmlspecialchars_decode(strip_tags($records[$i]['articleText'])), $theWord, 300);
				$records[$i]['articleText'] = findWord($records[$i]['articleText'], $theWord);
			}
		}
		return $records;
	}
?>