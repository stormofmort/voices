<?php
/*Personal Message post page
it goes like this, the first till the last, 
the blah the blah, 
the ifs' that needs to be true and false
and then the views that comfort the eyes
and then the forms that connect the hearts
and then the strings that knot the ties
*/
//the first the first, call dr.(d)umb (b)oy.
//$absUrl = "http://localhost/voices2008/";
include("db.php");
//include("common.php");
$conn = databaseConnect();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../styles/common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>
  <?php 


/*$receiverID = "general";
$query = "SELECT userID FROM usertable WHERE userName='$receiverID'";
$result = @mysql_query($query) or die("Couldn't select a username");

while ($row = mysql_fetch_array($result)) :
	print "<select>\n";
	print "<option value\"\">".$row["userID"]."</option>\n";
	print "</select>\n";
endwhile;
*/
/*
$receiver = array();
while ($row = mysql_fetch_array ($result)){
$receiver[] = $row;
}

$select_list = '<select name=\"receiver\">';
		$select_list .= '<option value="-1">' . '</option>';

		for($i = 0; $i < count($receiver); $i++)
		{
			$select_list .= '<option value="' . $receiver
[$i]['userID'] . '">' . $receiver[$i]['userName'] . '</option>';
		}
		$select_list .= '</select>';
*/

////echo 'tuytu: ' . $row['userName'] . '</br>';
//echo '<select><option>'. $row['userName'] .'</option></select>';

//}
//print $select_list;
function submitMessage() {
//	if ($_GET['submitMessage.php'] && $_POST['']){
	$form = <<<EOD
		<p>Who do you want to send a message to: </p>
		<form id="submitMessage" name="submitMessage" method="post" action="message.php?folder=new">
		 
			<input name="receiverName" type="text" id="receiverName" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;" />

			<p>Subject</p>
			<input name="heading" type="text" id="heading" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;" />

			<p>Message</p>
  			<textarea name="message" cols="50" rows="10" id="message" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;"></textarea>
			
  			<br/>
  			<input type="submit" name="Submit" value="Submit" />
		</form>
EOD;
	print $form;
	//}
	//elseif($_GET['submitMessage.php'] && !$_POST['']) {
	//return chkOkPost();
	//}
}
//submitMessage();


function chkOkPost() {
	 //check if the form is blank
	 //if(!@$_POST['receiverName'] || !@$_POST['message'] || !@$_POST['heading']) {
		//echo "kaley bafayah message fonuvantha thiulhenee?";
		//}
	if($_POST['Submit'] && @$_POST['receiverName'] && @$_POST['message'] && @$_POST['heading']){
	
		$senderId = "1";
		$message = @$_POST['message'];
		$heading = @$_POST['heading'];
		$time = time();
		//$recieverName = @$_POST['receiverName'];
		
		//$recieverID = 2;
		$recID = cnvrtRecNameToRecID();
		//echo "<br>";
		//echo $recieverID;
		/*print "$receiverName \n <br />";
		print "$senderId \n <br />";
		print "$message";*/
		$sql = "INSERT INTO messagetable (senderID, recieverID, heading, message, sendDate) VALUES ('".$senderId."', '".$recID."', '".$heading."', '".$message."', '".$time."')";
		$query = mysql_query($sql) or die(mysql_error());
		echo "message sent";
		}
	elseif($_POST['Submit'] != Null || @$_POST['receiverName'] != Null || @$_POST['message'] != Null || @$_POST['heading'] != Null) {
		
		echo "kaley bafayah message fonuvantha thiulhenee?";
	}
	
	//if not empty, assign variable name to posted infos
	/*else {
	
		$senderId = "1";
		$message = @$_POST['message'];
		$heading = @$_POST['heading'];
		//$recieverName = @$_POST['receiverName'];
		
		//$recieverID = 2;
		$recID = cnvrtRecNameToRecID();
		//echo "<br>";
		//echo $recieverID;
		//print "$receiverName \n <br />";
		//print "$senderId \n <br />";
		//print "$message";
		$sql = "INSERT INTO messagetable (senderID, recieverID, heading, message) VALUES ('".$senderId."', '".$recID."', '".$heading."', '".$message."')";
		$query = mysql_query($sql) or die(mysql_error());
		echo "message sent";
		}*/
}
//the function to convert userID into User Name
function cnvrtSenderIdtoUserName($senderID){
//$senderID= "1";
	if ($senderID >0) {
		$conn = databaseConnect();
		$sql = "SELECT userName FROM usertable WHERE userID='$senderID'";
		$query = mysql_query($sql) or die (mysql_error());
		while ($result = mysql_fetch_array($query)) {
			print $result['userName'];
			}
	}
	else {
		echo "hmmm...there is a fuckin plobrem, dont u kinth?";
	}
}

//the fuction that converts Receiver Name into receiverID
function cnvrtRecNameToRecID(){
//$senderID= "1";
	$recieverName = @$_POST['receiverName'];
//ahad, is the spelling of receiver/reciever really reciever?	
	$conn = databaseConnect();
	$sql = "SELECT userID FROM usertable WHERE userName='$recieverName'";
	$query = mysql_query($sql) or die (mysql_error());
	if (mysql_num_rows($query) > 0) {
		$result = mysql_fetch_array($query);
		$recieverID = $result['userID'];
		return $recieverID;
	}
	else {
		echo "Bakatttaaa!!! Thankolheh rangalhah nan jeheytho balan veenu dho!";
		die("<br>". "amaahandhaanvaa vahtharah viyya liyanee!! vaaneeves ehenennu");
	}
	
}

/*function receiverID() {
	//check if user is logged on
	//$user = SESSION_USER;
	$user= "general";
	$sql = "SELECT userID FROM usertable WHERE userName='$user'";
	$query = mysql_query($sql) or die(mysql_error());
	$result = mysql_fetch_array($query);
	print $result['userID'];
}
*/
function collectMessagesInbox() {
	$user = '1';
	//$user is suppose to be the logged in user, ahaaadddd....[ =:o) ] AND this should be global i think
	if(!$_GET['id']){
		$sql = "SELECT * FROM messagetable WHERE recieverID='$user' ORDER BY sendDate DESC";
		$query = mysql_query($sql) or die(mysql_error());
	
		echo "<table id=\"messages\" width=\"100%\" cellspacing=\"5px\">";
		echo "<tr><th>Date</th><th>From</th><th>Subject</th></tr>";
	
			while ($result = mysql_fetch_array($query)) {
				echo "<tr><td>";
				echo printDate($result['sendDate'], "d-M-y | H:i");
				echo "</td><td>";
				echo cnvrtSenderIdtoUserName($result['senderID']);
			if ($result['read'] ==1){
				echo "</td><td>";
				echo "<input name=\"checked\" type=\"checkbox\"/><a href=\"?folder=inbox&id=".$result['messageID']."\" >" .$result['heading']."</a>";
			}
			else {
				echo "</td><td>";
				echo "<input name=\"checked\" type=\"checkbox\"/><a href=\"?folder=inbox&id=".$result['messageID']."\" ><b>" .$result['heading']."</b></a>";
			}
			echo "</td></tr>";
		}
		echo "</table>";
	}
	else {
		$sql = "SELECT * FROM messagetable WHERE messageID=".$_GET['id']."";
		$query = mysql_query($sql) or die(mysql_error());
		
		if (mysql_num_rows($query) >= 1) {
			$sql2 = "UPDATE `messagetable`  SET `read` = 1 WHERE `messageID`=".$_GET['id']."";
			$query2 = mysql_query($sql2) or die(mysql_error());
			echo "<table id=\"messages\" width=\"100%\">";
			echo "<tr>";
				while ($result = mysql_fetch_array($query)) {
				echo "<th>";
				echo "<h1>".$result['heading']."</h1>";
				echo "</th></tr><tr><td>";
				echo $result['message'];
				echo "</td></tr>";
				}
			echo "</table>";
		}
		else {
			echo "sucker";
		}
	}
}

function collectMessagesSent() {
	$user = '1';
	if(!$_GET['id']){
		$sql = "SELECT * FROM messagetable WHERE senderID='$user' ORDER BY sendDate DESC";
		$query = mysql_query($sql) or die(mysql_error());
	
		echo "<table id=\"messages\" width=\"100%\" cellspacing=\"5px\">";
		echo "<tr><th>Date</th><th>To</th><th>Subject</th></tr>";
	
			while ($result = mysql_fetch_array($query)) {
				echo "<tr><td>";
				echo printDate($result['sendDate'], "d-M-y | H:i");
				echo "</td><td>";
				echo cnvrtSenderIdtoUserName($result['recieverID']);
			//if ($result['read'] ==1){
				echo "</td><td>";
				echo "<input name=\"checked\" type=\"checkbox\"/><a href=\"?folder=inbox&id=".$result['messageID']."\" >" .$result['heading']."</a>";
			//}
			//else {
				//echo "</td><td>";
				//echo "<input name=\"checked\" type=\"checkbox\"/><a href=\"?folder=inbox&id=".$result['messageID']."\" ><b>" .$result['heading']."</b></a>";
			//}
			echo "</td></tr>";
		}
		echo "</table>";
	}
	else {
		$sql = "SELECT * FROM messagetable WHERE messageID=".$_GET['id']."";
		$query = mysql_query($sql) or die(mysql_error());
		
		if (mysql_num_rows($query) >= 1) {
			//$sql2 = "UPDATE `messagetable`  SET `read` = 1 WHERE `messageID`=".$_GET['id']."";
			//$query2 = mysql_query($sql2) or die(mysql_error());
			echo "<table id=\"messages\" width=\"100%\">";
			echo "<tr>";
				while ($result = mysql_fetch_array($query)) {
				echo "<th>";
				echo "<h1>".$result['heading']."</h1>";
				echo "</th></tr><tr><td>";
				echo $result['message'];
				echo "</td></tr>";
				}
			echo "</table>";
		}
		else {
			echo "sucker";
		}
	}
}




//cnvrtSenderIdtoUserName(1);
//receiverID();
//cnvrtRecNameToRecID();  

//
//collectMessages();
//submitMessage();
//chkOkPost();
?>
</body>
</html>