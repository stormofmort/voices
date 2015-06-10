<?php
	include('scripts/db.php');
	$conn = databaseConnect();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php 

if(!isset($_GET['id']))
{

$you = "1";
$rec = "SELECT * FROM messagetable WHERE recieverID='$you'";
$result = mysql_query($rec)or die(mysql_error());

echo "<table border='1'>";
echo "<tr> <th>From</th> <th>Subject</th> </tr>"; 
while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table
	echo "<tr><td>"; 
	echo $row['recieverID'];
	echo "</td><td>"; 
	echo "<a href=\"messageView.php?id=".$row['messageID']. "\">".$row['heading']."</a>";
	echo "</td></tr>"; 
	

} 
echo "</table>";
}
else {
$query = "SELECT senderID, heading, message FROM messages where recieverID=".$_GET['id']; 
$result = mysql_query($query) or die('Error : ' . mysql_error());


echo "<table border='1'>";
echo "<tr> <th>From</th> <th>Subject</th> </tr>"; 
while($row = mysql_fetch_array( $result )) {
	// Print out the contents of each row into a table
	echo "<tr><td>"; 
	echo $row['senderID'];
	echo "</td><td>"; 
	echo $row['message'];
	echo "</td></tr>"; 
	

} 
echo "</table>";
/*echo "<table border='1'>";

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

echo "<tr><th>";
echo $row['heading'];
echo "</tr></th><tr><td>"
echo $row['message'];
echo "</tr></td>";
}
echo "</table>";
*/
}
?>
<body>
</body>
</html>

