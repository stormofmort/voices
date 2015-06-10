<?php
	
	// date validating functions
	function num_of_days($month) {
		// checks the number of days in a given month
		
		if ( (($month%2 == 1) && ($month <= 7)) || (($month%2 == 0) && ($month > 7)) ) {
			return 31;
		} else if ( (($month%2 == 0 && ($month > 2 && $month <= 7))) || (($month%2 == 1) && ($month > 7)) ) { 
			return 30; 
		} else {
			$leap = leap();
			if ($leap == 1) {
				return 29; 
			} else { 
				return 28; 
			}
		}
	}
		
	function leap($year) {
		// checks if the given year is a leap year
		
		$base_year = 2000;
		$diff = $year - $base_year;
	
		$result = $diff%4;
		if ($result != 0) { 
			return 1; 
		} else { 
			return 0; 
		}
	}
	
	function check_email($email) {
		$email_valid= trim($email);
		if ( eregi("^[a-zA-Z0-9_][a-zA-Z0-9_\.]+@[a-zA-Z0-9_]+\.[a-zA-Z0-9\-\.]+$", $email_valid) ) {
			return 0;
		} else {
			return 3;
		}
	}
	
	function check_Text($str, $minlen, $maxlen) {
		$str_valid = trim($str);
		if ( strlen($str_valid) < $minlen ||  strlen($str_valid) > $maxlen ) {
			return 2;
		} elseif ( eregi("[a-zA-Z0-9_]+", $str_valid) ) {
			return 0;
		} else {
			return 3;
		}
	}
	
	function check_Date($day, $month, $year) {
		if ( $year >= date("Y") || $year < 1900 ) {
			return 2;
		} else {
			$correct_days = num_of_days($month);
			if ( $correct_days < $day ) {
				return 2;
			} else {
				return 0;
			}
		}
	}
	
	function check_Phone($num, $min=6, $max=20) {
		$num_valid = trim($num);
		if ( strlen($num_valid) < $min ||  strlen($num_valid) > $max ) {
			return 2;
		} else {
			if ( eregi("^[0-9+]{1}[0-9]+$", $num_valid) ) {
				return 0;
			} else {
				return 3;
			}
		}
	}
	
	function check_ZIP($zip) {
		if ( strlen($zip) > 5 || strlen($zip) < 2 ) {
			return 2;
		} elseif ( eregi("^[0-9]+$", $zip) ) {
			return 0;
		} else {
			return 3;
		}
	}
?>