<table id="componentTable" width="100%" border="0" cellpadding="0" cellspacing="0"><form enctype="multipart/form-data" id="optForm" name="optForm" action="options.php" method="post">
  <tr>
    <td colspan="3"><table id="componentTable2" width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php
				if ( $agreeCheck > 0 ) {
					echo "<tr>
						<td id='notice_bad' colspan='4'>You must agree to the Terms of Use (below)</td>
					</tr>";
				}
			?>
      <tr>
        <td id="boldBlackText" colspan="3">General Login Info<a href="pages/regHelp.php?focus=Login"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight">Username: </td>
        <td id=""><?php echo $userDetails['userName']; ?></td>
        <td id="error"><?php if ($userNameCheck > 0 && $userNameCheck < 4) { echo "<a href='pages/regHelp.php?focus=username&error=$userNameCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <?php
				if ( $userNameCheck == 4 ) {
					echo "<tr>
						<td id='smallGreenText' colspan='4' align='center'>That username has already been taken</td>
					</tr>";
				}
			?>
      <tr>
        <td id="normalTextRight">Password: </td>
        <td id='boldBlueText'><a href='pages/passwordReset.php'>Click here to change you password</a></td>
        <td id="error"><?php if ($password1Check > 0) { echo "<a href='pages/regHelp.php?focus=password1&error=$password1Check'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <?php
				if ( isset($passMatchCheck) && $passMatchCheck > 0 ) {
					echo "<tr>
						<td id='notice_bad' colspan = '4'>Your passwords don't match</td>
					</tr>";
				}
			?>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Profile Style:</td>
        <td><select id="styleList" name="profileStyle">
            <option value="1" <?php if ($_POST['profileStyle'] == 1) { echo "Selected"; } ?> >Miminum</option>
            <option value="2" <?php if ($_POST['profileStyle'] == 2) { echo "Selected"; } ?> >Show Personal Info</option>
            <option value="3" <?php if ($_POST['profileStyle'] == 3) { echo "Selected"; } ?> >Show Location</option>
            <option value="4" <?php if ($_POST['profileStyle'] == 4) { echo "Selected"; } ?> >Show Contact Info</option>
            <option value="5" <?php if ($_POST['profileStyle'] == 5) { echo "Selected"; } ?> >Show Address</option>
        </select></td>
        <td id="error">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText"colspan="3">Security Info<a href="pages/regHelp.php?focus=Security"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Hidden Question</td>
        <td><input id="userInput" type="text" name="hiddenQ" maxlength="100" value="<?php echo $_POST['hiddenQ']; ?>" /></td>
        <td id="error"><?php if ($hiddenQCheck > 0) { echo "<a href='pages/regHelp.php?focus=hiddenQ&error=$hiddenQCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Hidden Answer</td>
        <td><input id="userInput" type="text" name="hiddenA" maxlength="100" value="<?php echo $_POST['hiddenA']; ?>" /></td>
        <td id="error"><?php if ($hiddenACheck > 0) { echo "<a href='pages/regHelp.php?focus=hiddenA&error=$hiddenACheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>      
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText" colspan="3">Personal Info<a href="pages/regHelp.php?focus=Personal"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight">First Name:</td>
        <td><input id="userInput" type='text' name="firstName" maxlength="40" value="<?php echo $_POST['firstName']; ?>" /></td>
        <td id="error"><?php if ($firstNameCheck > 0) { echo "<a href='pages/regHelp.php?focus=firstName&error=$firstNameCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Last Name:</td>
        <td><input id="userInput" type='text' name="lastName" maxlength="40" value="<?php echo $_POST['lastName']; ?>" /></td>
        <td id="error"><?php if ($lastNameCheck > 0) { echo "<a href='pages/regHelp.php?focus=lastName&error=$lastNameCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Sex:</td>
        <td><select id="sex" name="sex">
            <option value="Male" <?php if ($_POST['sex'] == 'Male') { echo "Selected"; } ?> >Male</option>
            <option value="Female" <?php if ($_POST['sex'] == 'Female') { echo "Selected"; } ?> >Female</option>
            <option value="Unspecified" <?php if ($_POST['sex'] == 'Unspecified') { echo "Selected"; } ?> >Unspecified</option>
        </select></td>
        <td id="error">&nbsp;</td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Date of Birth:</td>
        <td><?php $n = printDate($userDetails['userDOB'], "n"); ?><input id="day" type="text" name="day" maxlength="2" value="<?php echo printDate($userDetails['userDOB'], "d"); ?>" />
            <select name="monthList" id="monthList">
              <option value="1" <?php if ($n == 1) { echo "Selected"; } ?> >January</option>
              <option value="2" <?php if ($n == 2) { echo "Selected"; } ?> >February</option>
              <option value="3" <?php if ($n == 3) { echo "Selected"; } ?> >March</option>
              <option value="4" <?php if ($n == 4) { echo "Selected"; } ?> >April</option>
              <option value="5" <?php if ($n == 5) { echo "Selected"; } ?> >May</option>
              <option value="6" <?php if ($n == 6) { echo "Selected"; } ?> >June</option>
              <option value="7" <?php if ($n == 7) { echo "Selected"; } ?> >July</option>
              <option value="8" <?php if ($n == 8) { echo "Selected"; } ?> >August</option>
              <option value="9" <?php if ($n == 9) { echo "Selected"; } ?> >September</option>
              <option value="10" <?php if ($n == 10) { echo "Selected"; } ?> >October</option>
              <option value="11" <?php if ($n == 11) { echo "Selected"; } ?> >November</option>
              <option value="12" <?php if ($n == 12) { echo "Selected"; } ?> >December</option>
            </select>
            <input id="year" type="text" name="year" maxlength="4" value="<?php echo printDate($userDetails['userDOB'], "Y"); ?>" />        </td>
        <td id="error"><?php if ($DOBCheck > 0) { echo "<a href='pages/regHelp.php?focus=DOB&error=$DOBCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText" colspan="3">Contact Info<a href="pages/regHelp.php?focus=Contact"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight">Home Phone:</td>
        <td><input id="userInput" type='text' name="homePhone" maxlength="20" value="<?php echo $_POST['homePhone']; ?>" /></td>
        <td id="error"><?php if ($homePhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=homePhoneCheck&error=$homePhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Work Phone:</td>
        <td><input id="userInput" type='text' name="workPhone" maxlength="20" value="<?php echo $_POST['workPhone']; ?>" /></td>
        <td id="error"><?php if ($workPhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=workPhone&error=$workPhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Mobile Phone:</td>
        <td><input id="userInput" type='text' name="mobilePhone" maxlength="20" value="<?php echo $_POST['mobilePhone']; ?>" /></td>
        <td id="error"><?php if ($mobilePhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=mobilePhone&error=$mobilePhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>eMail Address:</td>
        <td><input id="userInput" type='text' name="email" maxlength="100" value="<?php echo $_POST['email']; ?>" /></td>
        <td id="error"><?php if ($emailCheck > 0) { echo "<a href='pages/regHelp.php?focus=email&error=$emailCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText" colspan="3">Address and Location<a href="pages/regHelp.php?focus=Address"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight">Address:</td>
        <td><input id="userInput" type="text" name="address" maxlength="100" value="<?php echo $_POST['address']; ?>" /></td>
        <td id="error"><?php if ($addressCheck > 0) { echo "<a href='pages/regHelp.php?focus=address&error=$addressCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Street:</td>
        <td><input id="userInput" type="text" name="street" maxlength="100" value="<?php echo $_POST['street']; ?>" /></td>
        <td id="error"><?php if ($streetCheck > 0) { echo "<a href='pages/regHelp.php?focus=street&error=$streetCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">City:</td>
        <td><input id="userInput" type="text" name="city" maxlength="100" value="<?php echo $_POST['city']; ?>" /></td>
        <td id="error"><?php if ($cityCheck > 0) { echo "<a href='pages/regHelp.php?focus=city&error=$cityCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Country:</td>
        <td><input id="userInput" type="text" name="country" maxlength="100" value="<?php echo $_POST['country']; ?>" /></td>
        <td id="error"><?php if ($countryCheck > 0) { echo "<a href='pages/regHelp.php?focus=country&error=$countryCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">ZIP Code:</td>
        <td><input id="userInput" type="text" name="ZIPCode" maxlength="10" value="<?php echo $_POST['ZIPCode']; ?>" /></td>
        <td id="error"><?php if ($ZIPCodeCheck > 0) { echo "<a href='pages/regHelp.php?focus=ZIPCode&error=$ZIPCodeCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><hr /></td>
  </tr>
  <tr>
        <td id="boldBlackText" colspan="3">Avatar<a href="pages/regHelp.php?focus=Avatar"><img style="border:none" src="images/help.jpg"</a></td>
  </tr>
  <tr>
    <td colspan="3"><table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td colspan="3">Choose an Avatar (After registering you can customize your avatar in the preferences page)</td>
      </tr><tr>
      	<td align="center">
        	<table border="0">
          	<tr>
              <td align="center"><input type="radio" name="avatarGroup" value="default_01.png" id="avatarGroup_0" <?php if ( $_POST['avatarGroup'] == 'default_01.png' ) { echo "checked='checked'"; } ?> /></td>
              <td align="center"><input type="radio" name="avatarGroup" value="default_02.png" id="avatarGroup_0" <?php if ( $_POST['avatarGroup'] == 'default_02.png' ) { echo "checked='checked'"; } ?> /></td>
              <td align="center"><input type="radio" name="avatarGroup" value="default_03.png" id="avatarGroup_0" <?php if ( $_POST['avatarGroup'] == 'default_03.png' ) { echo "checked='checked'"; } ?> /></td>
              <td align="center"><input type="radio" name="avatarGroup" value="default_04.png" id="avatarGroup_0" <?php if ( $_POST['avatarGroup'] == 'default_04.png' ) { echo "checked='checked'"; } ?> /></td>
              <?php
								$avatar_dir = "images/avatars";
								$curr_dir = opendir($avatar_dir);
								while ( $file = readdir($curr_dir) ) {
									$file = strtolower($file);
									if ( $file == strtolower($_SESSION['validuser']).".jpeg" || $file == strtolower($_SESSION['validuser']).".jpg" || $file == strtolower($_SESSION['validuser']).".png" || $file == strtolower($_SESSION['validuser']).".gif" ) {
										$currCustomAvatar = $file;
										if ( isset($newCustomAvatar) && isset($currCustomAvatar) ) {
											break;
										}
									}
									if ( $file == strtolower($_SESSION['validuser'])."_new.jpeg" || $file == strtolower($_SESSION['validuser'])."_new.jpg" || $file == strtolower($_SESSION['validuser'])."_new.png" || $file == strtolower($_SESSION['validuser'])."_new.gif" ) {
										$newCustomAvatar = $file;
										if ( isset($newCustomAvatar) && isset($currCustomAvatar) ) {
											break;
										}
									}
								}
								closedir($curr_dir);
								
								if ( isset($currCustomAvatar) ) {
									$_SESSION['currCustomAvatar'] = $currCustomAvatar;
									echo "<td align='center'>
										<input type='radio' name='avatarGroup' value='".$currCustomAvatar."' id='avatar_0'"; 
									if ( $_POST['avatarGroup'] == $currCustomAvatar ) {
										echo "checked='checked'";
									}
									echo " />
									</td>";
								}
							?>
            </tr>
            <tr>
              <td <?php if ( $_POST['avatarGroup'] == 'default_01.png' ) { echo "id='currentAvatar'"; } ?> valign="middle"><img width="100" height="100" src="images/avatars/default_01.png" /></td>
              <td <?php if ( $_POST['avatarGroup'] == 'default_02.png' ) { echo "id='currentAvatar'"; } ?> valign="middle"><img width="100" height="100" src="images/avatars/default_02.png" /></td>
              <td <?php if ( $_POST['avatarGroup'] == 'default_03.png' ) { echo "id='currentAvatar'"; } ?> valign="middle"><img width="100" height="100" src="images/avatars/default_03.png" /></td>
              <td <?php if ( $_POST['avatarGroup'] == 'default_04.png' ) { echo "id='currentAvatar'"; } ?> valign="middle"><img width="100" height="100" src="images/avatars/default_04.png" /></td>
              <?php
              	if ( isset($currCustomAvatar) ) {
									echo "<td ";
									if ( $_POST['avatarGroup'] == $currCustomAvatar ) {
										echo "id='currentAvatar'";
									}
									echo " valign='middle'><img width='100' height='100' src='images/avatars/$currCustomAvatar' /></td>";
								}
							?>
            </tr>
          </table>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><hr /></td>
  </tr>
  <tr>
    <td colspan="3" align="center" width="100%"><input id="blackButton" type="submit" value="Update Profile" /></td>
  </tr>
</form>
</table>
<?php
	if ( isset($newCustomAvatar) ) {
		echo "<form name='setNewAvatar' action='pages/avatarCustomUpdate.php' method='POST'>
			<table cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td id='boldBlackText' colspan='2'>Uploaded custom Avatar</td>
				</tr>
				<tr>
					<td valign='middle'><img width='100' height='100' src='images/avatars/$newCustomAvatar' /></td>
					<td>";
					if ( isset($currCustomAvatar) ) {
						echo "<input type='hidden' name='currCustomAvatar' value='$currCustomAvatar' />";
					}
					echo "<input type='hidden' name='newCustomAvatar' value='$newCustomAvatar' />
						<input type='hidden' name='user' value='".strtolower($_SESSION['validuser'])."' />
						<input type='hidden' name='userID' value='".$_SESSION['validuserID']."' />
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' value='Use as Avatar' id='blackButton' />
					</td>
				</tr>
			</table>
		</form>
		<hr />";
	}
?>
<table id="componentTable" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" id="boldBlackText">..or upload your own avatar</td>
  </tr>
	<form name="avatarUpload.php" action="pages/avatarUpload.php" method="post" enctype="multipart/form-data">
  <tr>
  	<td colspan="3">
    	  <input type="hidden" name="maxFileSize" value="1048576" />
        <input type="hidden" name="newFileName" value="<?php echo strtolower($_SESSION['validuser']); ?>"  />
    	  <input type="file" name="newAvatar" size="65" />
    </td>
  </tr>
  <tr>
  	<td colspan="3" align="center"><input id='blackButton' type="submit" value="Upload" /></td>
  </tr>
 	</form>
</table>