<?php
	include('messages/scripts/db.php');
	$conn = databaseConnect();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form id="messageSubmit" name="messageSubmit" method="post" action="messageSubmit.php">
  <label></label>
  <br />
  <label></label>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><label>Send to: </label></td>
      <td><input name="receiverName" type="text" id="receiverName" /></td>
    </tr>
    <tr>
      <td><label>Message</label></td>
      <td><textarea name="message" cols="50" rows="10" id="message"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>

<?php

$receiver =  $_POST['receiverName'];
//$sender = SESSION_USER();
$sender = "general";
$message = $_POST['message'];


mysql_select_db("voices_mv_-_maindb") or die(mysql_error());

//convert receiver nameinto receiver ID

$rec = "SELECT userID FROM usertable WHERE userName='$receiver'";
$query1 = mysql_query($rec)or die(mysql_error());
$row = mysql_fetch_array( $query1, MYSQL_ASSOC );
$recID = $row['userID'];

//check if username exist
if ($recID>0) {

//insert message into database
$sql = "INSERT INTO messages (senderID, recieverID, message) VALUES('1', '$recID', '$message' ) ";  
$result = mysql_query($sql) or die(mysql_error());
echo "Message Sent!";
}

else {
	print "Message not sent, check if you typed the receiver name correctly!";
	}

?>