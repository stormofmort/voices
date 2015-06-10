<html>
<head>
<title>Calendar</title>
<link href="../styles/calendar.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
	function submitCalendar() {
		document.changeDate.submit();
	}
</script>
</head>

<body>
<?php
	include("../scripts/db.php");

	$months = array("0", "Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	
	if (!$_POST[monthList] || $_POST[monthList] == ""){ 
		$month = date("n");
	} else {
		$month = $_POST[monthList];
	}

	if (($_POST[year] > date("Y")) || ($_POST[year] < 2006) || !$_POST[year] || ($_POST[year] == "")) { 
		$year = date("Y"); 
	} else {
		$year = $_POST[year];
	}
	
	function num_of_days() {
		global $month;
		
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
		
	function leap() {
		global $year;
		
		$base_year = 2000;
		$diff = $year - $base_year;
	
		$result = $diff%4;
		if ($result != 0) { 
			return 1; 
		} else { 
			return 0; 
		}
	}
		
	function write_calendar($i, $date) {
		global $year, $month;
		databaseConnect();
		$query = "SELECT * FROM articletable WHERE articleApproveDate='$year-$month-$date[$i]'";
		$result = mysql_query($query);
		$rows = mysql_num_rows($result);
		if ($rows > 0) {
			$format1 = "<td id='link'><a target='_parent' href='../categories.php'>";
			$format2 = "</a></td>";
			$echo = $date[$i];
		} else {
			$format1 = "<td id='no_link'>";
			$format2 = "</td>";
			$echo = $date[$i];
		}
		
		if ($date[$i] <= 0 || $i > count($date)) {
			$echo = "&nbsp;";
			$format1 = "<td id='blank'>";
			$format2 = "</td>";
		}
		return $output = $format1.$echo.$format2;
	}
			
	function draw_calendar() {
		global $month, $months, $year;
		
		$days = array("S", "M", "T", "W", "TH", "F", "SA");
		echo "<table width='238' cellspacing='0' cellpadding='0' align='center' >";
		echo "<tr>";
		for ($i = 0; $i < 7; $i++) {
			echo "<td id='calendar_days' align='center' valign='middle'>".$days[$i]."</td>";
		}
		echo "</tr>";
		
		$timestamp = mktime(0,0,0,$month,01,$year);
		$full_date = getdate($timestamp);
		
		$start_pos = 1 - $full_date["wday"];
		$end_pos = num_of_days();
		$date = range($start_pos, $end_pos);
		
		$i = 0;
		for ($r = 0; $r < 6; $r++) {
			echo "<tr>";
			for ($c = 0; $c <= 6; $c++) {
				echo write_calendar($i, $date);
				$i++;
			}
			echo "</tr>";
			if ($i >= count($date)) { break; }
		};
		echo "</table>";
	}
		
	draw_calendar();
	
		echo "<table width='238'align='center'>
		<tr><td align='justify' valign='center'>
		<form name='changeDate' method='post' action='calendar.php' id='changeDate'>
		<select name='monthList' id='monthList'  onchange='submitCalendar()'>
			<option value='1'";if ($month == 1) {echo " selected"; };echo ">January</option>
			<option value='2'";if ($month == 2) {echo " selected"; };echo ">February</option>
			<option value='3'";if ($month == 3) {echo " selected"; };echo ">March</option>
			<option value='4'";if ($month == 4) {echo " selected"; };echo ">April</option>
			<option value='5'";if ($month == 5) {echo " selected"; };echo ">May</option>
			<option value='6'";if ($month == 6) {echo " selected"; };echo ">June</option>
			<option value='7'";if ($month == 7) {echo " selected"; };echo ">July</option>
			<option value='8'";if ($month == 8) {echo " selected"; };echo ">August</option>
			<option value='9'";if ($month == 9) {echo " selected"; };echo ">September</option>
			<option value='10'";if ($month == 10) {echo " selected"; };echo ">October</option>
			<option value='11'";if ($month == 11) {echo " selected"; };echo ">November</option>
			<option value='12'";if ($month == 12) {echo " selected"; };echo ">December</option>
		</select>
		<input id='yearInput' name='year' type='text' maxlength='4' size='2' value='";echo $year;echo "' onchange='submitCalendar()'>";
		echo "<noscript>&nbsp;<input type='submit' value='Submit' id='submitClass' /></noscript>
		</form>
		</td>
		</tr>
		</table>";
?>
</body>

</html>
