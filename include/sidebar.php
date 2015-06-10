<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><form id="searchBar" action="results.php" method="GET">
      <table id="searchTable" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td id="componentNameSidebar">Search</td>
          <td id="searchBar" align="right"><input id="searchField" name="searchText" type="text" /></td>
          <td id="searchSubmit"><input id="searchSubmit" value="O" type="submit" /><input type="hidden" value="simple" name="searchType" /></td>
        </tr>
        <tr>
          <td id="blueText" colspan="3"><a href="advanced_search.php">[Advanced Search]</a></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td><table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td id="componentNameSidebar">Chat <a id="chatLink" onClick="componentHide('chat')"></a></td>
      </tr>
      <tr>
        <td id="componentContainer">
          <div id="chat"><form id="chatForm" method="post" action="home.php">
            <input name="username" type="hidden" value="<?php if(!$_SESSION['validuser']) { echo "guest"; } else { echo $_SESSION['validuser']; } ?>" />
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td id="cornerTL2">&nbsp;</td>
                <td id="lineT2">&nbsp;</td>
                <td id="cornerTR2">&nbsp;</td>
              </tr>
              <tr>
                <td id="lineL2">&nbsp;</td>
                <td id="chatboxMsgbox">
                  <div id="scrollerTXT">
                    <ul id="chatTXTall">
                      <li id="chatTXTdata"><noscript>Please Enable Javascript</noscript></li>
                    </ul>
                  </div>
                  <a href="#" onMouseOver="upScroll();" onMouseOut="stopScroll('up');"  onmousedown="fastScroll(25);" onMouseUp="slowScroll();">
                    <img src="images/scroll_up.gif" name="upArrow" width="12" height="12" border="0" id="upArrow" />
                  </a>
                  <a href="#" onMouseOver="downScroll();" onMouseOut="stopScroll('down');" onMouseDown="fastScroll(25);" onMouseUp="slowScroll();">
                    <img src="images/scroll_down.gif" name="downArrow" width="12" height="12" border="0" id="downArrow" />
                  </a>
                </td>
                <td id="lineR2">&nbsp;</td>
              </tr>
              <tr>
                <td id="cornerBL2">&nbsp;</td>
                <td id="lineB2">&nbsp;</td>
                <td id="cornerBR2">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td id="cornerTL2">&nbsp;</td>
                <td id="lineT2" colspan="2">&nbsp;</td>
                <td id="cornerTR2">&nbsp;</td>
              </tr>
              <tr>
                <td id="lineL2">&nbsp;</td>
                <td bgcolor="#FFFFFF"><textarea name="chatMsg" id="chatMsg" wrap="virtual" onKeyDown="if(event.keyCode==13) sendComment();"<?php buttondisabler(); ?>><?php textwrite();?></textarea></td>
                <td id="sendChat"><input id="sendButton" type="button" value="SEND" onclick='sendComment()' <?php buttonDisabler(); ?> /></td>
                <td id="lineR2">&nbsp;</td>
              </tr>
              <tr>
                <td id="cornerBL2">&nbsp;</td>
                <td id="lineB2" colspan="2">&nbsp;</td>
                <td id="cornerBR2">&nbsp;</td>
              </tr>
            </table></form>
          </div>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td id="componentNameSidebar">Calendar <a id="calendarLink" onClick="componentHide('calendar')"></a></td>
      </tr>
      <tr>
        <td id="componentContainer">
          <div id="calendar">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td id="cornerTL3">&nbsp;</td>
              <td id="lineT3">&nbsp;</td>
              <td id="cornerTR3">&nbsp;</td>
             </tr>
             <tr>
              <td id="lineL3">&nbsp;</td>
              <td><iframe src="pages/calendar.php" frameborder="0" scrolling="no" width="100%" height="176"></iframe></td>
              <td id="lineR3">&nbsp;</td>
            </tr>
            <tr>
              <td id="cornerBL3">&nbsp;</td>
              <td id="lineB3">&nbsp;</td>
              <td id="cornerBR3">&nbsp;</td>
            </tr>
          </table>
          </div>
        </td>
      </tr>
    </table><table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td id="componentNameSidebar">Publications <a id="publicationsLink" onClick="componentHide('publications')"></a></td>
      </tr>
      <tr>
        <td id="componentContainer">
          <div id="publications"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center">
                <img src="images/Issue2.jpg" /><img src="images/Issue1.jpg" /><img src="images/Issue3.jpg" />
              </td>
            </tr>
          </table>
          </div>
        </td>
      </tr>
    </table><table id="componentTable" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td id="componentNameSidebar">Sponsors <a id="sponsorsLink" onClick="componentHide('sponsors')"></a></td>
      </tr>
      <tr>
        <td id="componentContainer">
          <div id="sponsors"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center">
                <img src="images/Sponsor1.jpg" />
                <img src="images/Sponsor2.jpg" />
              </td>
            </tr>
          </table>
          </div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>