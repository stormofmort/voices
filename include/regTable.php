<table id="componentTable" width="100%" border="0" cellpadding="0" cellspacing="0"><form enctype="multipart/form-data" id="regForm" name="regForm" action="register.php" method="post">
  <tr>
    <td colspan="3"><table id="componentTable2" width="100%" border="0" cellpadding="0" cellspacing="0">
      <?php
				if ( $error > 0) {
					echo "<tr>
						<td id='notice_bad' colspan='4'><p>Some errors have occured. An exclamation mark appears near the fields where the errors were encountered. Please correct them.</p>
							<p>NOTE: You will need to re-enter your passwords and the anti-spam word verification.</p></td>
					</tr>";
				}
			?>
      <tr>
        <td id="boldBlackText" colspan="3">General Login Info<a href="pages/regHelp.php?focus=Login"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Username: </td>
        <td><input id="userInput" type="text" name="userName" maxlength="20" value="<?php echo $_POST['userName']; ?>"/></td>
        <td id="error"><?php if ($userNameCheck > 0 ) { echo "<a href='pages/regHelp.php?focus=username&error=$userNameCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <?php
				if ( $userNameCheck == 4 ) {
					echo "<tr>
						<td id='smallGreenText' colspan='4' align='center'>That username has already been taken</td>
					</tr>";
				}
			?>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Password: </td>
        <td><input id="userInput" type="password" name="password1" maxlength="20" /></td>
        <td id="error"><?php if ($password1Check > 0) { echo "<a href='pages/regHelp.php?focus=password1&error=$password1Check'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>Repeat Password: </td>
        <td><input id="userInput" type="password" name="password2" maxlength="20" /></td>
        <td id="error"><?php if ($password2Check > 0) { echo "<a href='pages/regHelp.php?focus=password2&error=$password2Check'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
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
        <td><input id="day" type="text" name="day" maxlength="2" value="<?php echo $_POST['day']; ?>" />
            <select name="monthList" id="monthList">
              <option value="1" <?php if ($_POST['monthList'] == 1) { echo "Selected"; } ?> >January</option>
              <option value="2" <?php if ($_POST['monthList'] == 2) { echo "Selected"; } ?> >February</option>
              <option value="3" <?php if ($_POST['monthList'] == 3) { echo "Selected"; } ?> >March</option>
              <option value="4" <?php if ($_POST['monthList'] == 4) { echo "Selected"; } ?> >April</option>
              <option value="5" <?php if ($_POST['monthList'] == 5) { echo "Selected"; } ?> >May</option>
              <option value="6" <?php if ($_POST['monthList'] == 6) { echo "Selected"; } ?> >June</option>
              <option value="7" <?php if ($_POST['monthList'] == 7) { echo "Selected"; } ?> >July</option>
              <option value="8" <?php if ($_POST['monthList'] == 8) { echo "Selected"; } ?> >August</option>
              <option value="9" <?php if ($_POST['monthList'] == 9) { echo "Selected"; } ?> >September</option>
              <option value="10" <?php if ($_POST['monthList'] == 10) { echo "Selected"; } ?> >October</option>
              <option value="11" <?php if ($_POST['monthList'] == 11) { echo "Selected"; } ?> >November</option>
              <option value="12" <?php if ($_POST['monthList'] == 12) { echo "Selected"; } ?> >December</option>
            </select>
            <input id="year" type="text" name="year" maxlength="4" value="<?php echo $_POST['year']; ?>" />        </td>
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
        <td><input id="userInput" type='text' name="homePhone" maxlength="15" value="<?php echo $_POST['homePhone']; ?>" /></td>
        <td id="error"><?php if ($homePhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=homePhoneCheck&error=$homePhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Work Phone:</td>
        <td><input id="userInput" type='text' name="workPhone" maxlength="15" value="<?php echo $_POST['workPhone']; ?>" /></td>
        <td id="error"><?php if ($workPhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=workPhone&error=$workPhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight">Mobile Phone:</td>
        <td><input id="userInput" type='text' name="mobilePhone" maxlength="15" value="<?php echo $_POST['mobilePhone']; ?>" /></td>
        <td id="error"><?php if ($mobilePhoneCheck > 0) { echo "<a href='pages/regHelp.php?focus=mobilePhone&error=$mobilePhoneCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td id="normalTextRight"><span style="color:#FF0000">*</span>eMail Address:</td>
        <td><input id="userInput" type='text' name="email" maxlength="100" value="<?php echo $_POST['email']; ?>" /></td>
        <td id="error"><?php if ($emailCheck > 0) { echo "<a href='pages/regHelp.php?focus=email&error=$emailCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <?php
			echo $$emailCheck;
				if ( $emailCheck == 4 ) {
					echo "<tr>
						<td id='smallGreenText' colspan='4' align='center'>That email has already been taken</td>
					</tr>";
				}
			?>
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
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText" colspan="3">Avatar<a href="pages/regHelp.php?focus=Avatar"><img style="border:none" src="images/help.jpg"</a></td>
      </tr>
      <tr>
        <td colspan="3" align="center"><table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td colspan="3">Choose an Avatar (After registering you can customize your avatar in the preferences page)</td>
          </tr>
          <tr>
            <td align="center"><input type="radio" name="avatarGroup" value="default_01.png" id="avatarGroup_0" <?php if ($_POST['avatarGroup'] == 'default_01.png') { echo "checked='checked'"; } ?> /></td>
            <td align="center"><input type="radio" name="avatarGroup" value="default_02.png" id="avatarGroup_0" <?php if ($_POST['avatarGroup'] == 'default_02.png') { echo "checked='checked'"; } ?> /></td>
            <td align="center"><input type="radio" name="avatarGroup" value="default_03.png" id="avatarGroup_0" <?php if ($_POST['avatarGroup'] == 'default_03.png') { echo "checked='checked'"; } ?> /></td>
            <td align="center"><input type="radio" name="avatarGroup" value="default_04.png" id="avatarGroup_0" <?php if ($_POST['avatarGroup'] == 'default_04.png') { echo "checked='checked'"; } ?> /></td>
          </tr>
          <tr>
            <td valign="middle"><img width="100" height="100" src="images/avatars/default_01.png" /></td>
            <td valign="middle"><img width="100" height="100" src="images/avatars/default_02.png" /></td>
            <td valign="middle"><img width="100" height="100" src="images/avatars/default_03.png" /></td>
            <td valign="middle"><img width="100" height="100" src="images/avatars/default_04.png" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td id="boldBlackText" colspan="3">Type the characters you see in the picture below.</td>
      </tr>
      <tr>
        <td colspan="2"><img src="scripts/antiSpamImage.php" /><input type="text" name="AntiSpamCode" maxlength="6" /></td>
        <td id='error'><?php if ($spamCheck > 0) { echo "<a href='pages/regHelp.php?focus=spam&error=$spamCheck'>&nbsp;</a>"; } else { echo "&nbsp;"; } ?></td>
      </tr>
      <tr>
        <td colspan="3"><hr /></td>
      </tr>
      <tr>
        <td colspan="3" id="boldBlackText">TERMS OF USE. By registereing you are agreeing to the terms stated below.</td>
      </tr>
      <tr>
        <td colspan="3"><textarea name="textarea" cols="70" rows="10"><?php include_once('include/agreement.txt'); ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3"><input id="blackButton" type="submit" value="REGISTER" /></td>
      </tr>
    </table></td>
  </tr>
</form>
</table>
