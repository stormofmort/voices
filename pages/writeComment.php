<?php
	include('../scripts/db.php');
?>
<html>
<head>
<title></title>
<script language="javascript" type="text/javascript" src="../scripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
  theme : "simple",
	mode : "textareas",
	remove_trailing_nbsp : true,
});
</script>
<link href="../styles/common.css" rel="stylesheet" type="text/css">
<link href="../styles/articles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
		
		echo "<table width='500' border='0' cellspacing='0' cellpadding='0' align='center'>";

		if ( isset($_GET['commentID']) && isset($_GET['quotedUser']) ) {
			$conn = databaseConnect();
			$sql = "SELECT `commentText` FROM `commentTable` WHERE `commentID`=".$_GET['commentID']." AND `commentStatus`=1";
			$result = mysql_query($sql);
			$array = mysql_fetch_assoc($result);
			mysql_free_result($result);
			mysql_close($conn);
			
			echo "<tr>
					<td id='smallGreyText'><strong>".$_GET['quotedUser']."</strong> said:</td>
				</tr><tr>
					<td id='commentText'>".$array['commentText']."</td>
				</tr>";
		}
		if ( isset($_GET['validUser']) && isset($_GET['articleID']) ) {
						
				echo "<tr>
					<td id='smallGreyText'>Your Comment:</td>
				</tr><tr>
					<td><form id='commentForm' name='commentForm' action='../scripts/postComment.php' method='POST'>
						<input type='hidden' name='quotedMsg' value='".$_GET['commentID']."' />
						<input type='hidden' name='sender' value='".$_GET['validUser']."'>
						<input type='hidden' name='articleID' value='".$_GET['articleID']."'>
						<span id='content_placeholder'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('content_placeholder')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'comment';
											cols = 60;
											rows = 25;
											value = '';
										}
									}
								//-->
							</script>
							<noscript>
								<span id='notice_bad'>Javascript needs to be enabled	</span>
							</noscript>
						<input type='submit' id='blackButton' value='POST' />
					</form></td>
				</tr>
			</table>";
		} else {
			header("Location: comments.php?articleID=10");
		}
	?>
</html>