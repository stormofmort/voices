<?php
						echo "<form id='articleForm' name='articleForm' action='scripts/workarea_setup.php' method='POST' enctype='multipart/form-data'>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr><td id='boldBlackText'>
						Name:</td></tr><tr><td>
									<input type='text' name='articleTitle' id='articleTitle' value='" . $articleText[0]['articleTitle'] . "' class='formField' />
									</td></tr>
									<tr><td id='boldBlackText'>
									Category:<a id=\"cat1Link\" onclick=\"componentHide('cat1')\"></a></td></tr>
									<tr><td>
									<div id='cat1'>
									<select name='articleSubCat' size='1'>
									";
									$query = "SELECT * FROM `catsubtable`";
									$result = mysql_query($query, $conn);
									$count = 1;
									if ($result) {
										while ($row = mysql_fetch_assoc($result)) {
											if ($articleText[0]['articleSubCat'] == $row['catSubID']) {
												echo "<option value='" . $row['catSubID'] . "' selected='selected'>" . $row['catSubName'] . "</option>";
											} else {
												echo "<option value='" . $row['catSubID'] . "'>" . $row['catSubName'] . "</option>";
											}
										}
									}
									echo "</select></div></td></tr>
									<tr><td id='boldBlackText'>
									Summary:<a id=\"cat2Link\" onclick=\"componentHide('cat2')\"></a></td></tr>
									<tr><td>
									<span id='cat2'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat2')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleSummary';
											cols = 70;
											rows = 10;
											value = '" . nl2br($articleText[0]['articleSummary']) . "';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleSummary' id='textarea' cols='70' rows='10'>" . nl2br($articleText[0]['articleSummary']) . "</textarea>
							</noscript>
									</td></tr>
							<tr><td id='boldBlackText'>
									Article:<a id=\"cat3Link\" onclick=\"componentHide('cat3')\"></a>
									</td></tr><tr><td>
									<span id='cat3'></span>
							<script language='javascript' type='text/javascript'>
								<!--
									with (document.getElementById ('cat3')) {
										with (appendChild (document.createElement ('TEXTAREA'))) {
											name = 'articleText';
											cols = 70;
											rows = 45;
											value = '" . nl2br($articleText[0]['articleText']) . "';
										}
									}
								//-->
							</script>
							<noscript>
								<textarea name='articleText' id='textarea' cols='70' rows='45'>" . nl2br($articleText[0]['articleText']) . "</textarea>
							</noscript>
							</td></tr>";
							$conn = databaseConnect();
							$query = "SELECT * FROM `imageTable` WHERE `articleID` = '" . $_GET[articleID] ."'";
							$result = mysql_query($query, $conn);
							$imageCount = mysql_num_rows($result);
							if (mysql_num_rows($result)>=1) {
								echo "<tr><td id='boldBlackText'>
								Pics:<a id=\"cat4Link\" onclick=\"componentHide('cat4')\"></a></td></tr>
								<tr><td>
								<div id='cat4'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
									<tr>
										<td id='articleTableTopLeft'>&nbsp;</td>
										<td id='articleTableTop'>&nbsp;</td>
										<td id='articleTableTopRight'>&nbsp;</td>
									</tr>
									<tr><td id='articleTableLeft'>&nbsp;</td>
										<td id='articleTableContent'>
										<table border='0' cellpadding='0' cellspacing='0' width='100%' id='picTable'>
										<tr>
											<td id='tableHeaderCells'>Available pics</td>
											<td id='tableHeaderCells'>Information</td>
											<td id='tableHeaderCells'>Use as thumbnail</td>
										</tr>";
									$count = 1;
									while ($row = mysql_fetch_assoc($result)) {
									echo "
									<tr>
										<td class='centerTD'>
											<table border='0' cellpadding='0' cellspacing='0' width='124' align='center'>
											<tr>
												<td><img width='124' height='84' src='images/articlePics/" . $_GET[articleID] . "/" . $row['imageName'] . "." . $row['imageType'] . "' /></td>
												<td id='articleRight'>$nbsp</td>
											</tr>
											<tr>
												<td id='articleBottom'>&nbsp;</td>
												<td id='articleCorner'>&nbsp;</td>
											</tr>
											</table>
										</td>";
									echo "
										<td><b>Submited date:</b> " . $row['imageSubmitDate'] . "<br />";
									if ($row['imageStatus'] != 2) {
										if ($row['imageStatus'] == 1) {
											echo "<span class='spanBlue'><b>Approved date:</b> " . $row['imageApprovalDate'] . "</span></td>";
										} else {
											echo "<b><span class='spanOrange'>Not moderated yet</span><b></td>";
										}
									} else {
										echo "<b><span class='spanRed'>Image has been rejected. <a href='workarea.php?page=Error&articleID=" . $_GET[articleID] . "'>Click here</a> to view the reason</span></b></td>";
									}
									//echo "<td><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' /></td></tr>";
									if ($row['imageThumb'] == 1) {
										$thumbSelected = 1;
										echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' checked='checked' /></td></tr>";
									} else {
										echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $row['imageName'] . "' /></td></tr>";
									}
								}
								echo "</table></td>
										<td id='articleTableRight'>&nbsp;</td>
									</tr>
									<tr>
										<td id='articleTableBottomLeft'>&nbsp;</td>
										<td id='articleTableBottom'>&nbsp;</td>
										<td id='articleTableBottomRight'>&nbsp;</td>
									</tr>
									</table></div>
								</td></tr>";
							}
							echo "<tr>
							<td id='boldBlackText'>
							Thumb preview:<a id=\"cat5Link\" onclick=\"componentHide('cat5')\"></a>
							</td></tr>
							<tr><td id='picfieldTD'>
								<div id='cat5'>
								<a name='imageAnchor' id='imageAnchor'></a>
								<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td id='articleTableTopLeft'>&nbsp;</td>
									<td id='articleTableTop'>&nbsp;</td>
									<td id='articleTableTopRight'>&nbsp;</td>
								</tr>
								<tr><td id='articleTableLeft'>&nbsp;</td>
									<td id='articleTableContent'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' id='imageTable'>
								<tr>
									<td id='tableHeaderCells'>Select file for upload</td>
									<td id='tableHeaderCells'>Use as thumbnail</td>
								</tr>
								<tr><td class='centerTD'><input type='file' name='" . $_GET[articleID] . "_" . ($imageCount+1) . "' id='formField' size='45' /></td>";
								if($thumbSelected != 1) {	
									echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET[articleID] . "_" . ($imageCount+1) . "' checked='checked' /></td>";
								} else {
									echo "<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET[articleID] . "_" . ($imageCount+2) . "' /></td>";
								}
								echo "</tr>
								<tr>
									<td class='centerTD'><input type='file' name='" . $_GET[articleID] . "_" . ($imageCount+2) . "' id='formField' size='45' /></td>
									<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET[articleID] . "_" . ($imageCount+2) . "' /></td>
								</tr>
								<tr>
									<td class='centerTD'><input type='file' name='" . $_GET[articleID] . "_" . ($imageCount+3) . "' id='formField' size='45' /></td>
									<td class='centerTD'><input name='imageThumb' type='radio' value='" . $_GET[articleID] . "_" . ($imageCount+3) . "' /></td>
								</tr>
								</table></td>
									<td  id='articleTableRight'>&nbsp;</td>
								</tr>
								<tr>
									<td id='articleTableBottomLeft'>&nbsp;</td>
									<td id='articleTableBottom'>&nbsp;</td>
									<td id='articleTableBottomRight'>&nbsp;</td>
								</tr>
								</table>
								<div id='addImage'>
								</div>
								<script language='javascript' type='text/javascript'>
									<!--
										document.getElementById('addImage').innerHTML = \"<span class='articleBlueLink'><a onClick='addField2(" . $_GET[articleID] . ");'>Add more</a></span>\";
									//-->
								</script>
								</div>
							</td></tr>
							<tr><td>
							<noscript>
							<input name='addImage' type='submit' id='blackButton' value='Add Image' />
							</noscript>
							<input name='funcType' type='submit' id='blackButton' value='Publish' />
							<input name='funcType' type='submit' id='blackButton' value='Unfinished' />
							<input type='hidden' name='imageNum' id='imageNum' value='" . ($imageCount+3) . "' />
							<input type='hidden' name='maxFileSize' value='1048576' />
							<input type='hidden' name='validUser' value='".$_SESSION['validuserID']."'>
							<input type='hidden' name='articleID' value='" . $_GET[articleID] . "'>
							</table>
							</form>";
							$countMain =5;	
								mysql_free_result($result);
								} else {
									echo "error";
								}
							}
							mysql_close($conn);
								}
?>