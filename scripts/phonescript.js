var GetChaturl = "scripts/getChatData.php";
var SendChaturl = "scripts/sendChatData.php";
var lastID = -1;
var scrollPos = false;
var scrollBox = false;
var scrollSpeed = 30;
var speedup = false;

window.onload = firstTable;
// alert ('Yo');

if(document.images) {
	uprollout = new Image;
	uprollover = new Image;
	downrollout = new Image;
	downrollover = new Image;
	
	uprollout.src = "images/scroll_up.gif"
	uprollover.src = "images/scroll_upRollover.gif"
	downrollout.src = "images/scroll_down.gif"
	downrollover.src = "images/scroll_downRollover.gif"
} else {
	image1=""
	image2= ""
}

function firstTable() {
	var initText = "Welcome, ya all! Feel free to spam. Spamming is good and healthy, so please let it all out! ";
	insertNewContent('Admin', 'Infinito', initText)
	initJavaScript();
}

function initJavaScript() {
	daform = document.getElementById("chatMsg");
	daform.setAttribute ('autocomplete', 'off');
	//checkStatus('');
	receiveChatText(); 
}

function upScroll() {
	document.upArrow.src = uprollover.src;
	//scrollSpeed = 30;
	var scrollObj = document.getElementById("scrollerTXT");
	
	if (scrollBox == scrollObj.scrollHeight) {
		scrollBox = scrollBox - 199;
		scrollObj.scrollTop = scrollBox;
	} else if (scrollBox > (scrollObj.scrollHeight - 192)) {
		scrollBox = scrollObj.scrollHeight;
	} else {
		scrollBox = scrollBox - 3;
		scrollObj.scrollTop = scrollBox;
	}
    scrolldelay = setTimeout('upScroll();',scrollSpeed);
}

function downScroll() {
	document.downArrow.src = downrollover.src;
	//scrollSpeed = 30;
	var scrollObj = document.getElementById("scrollerTXT");
	
	if (scrollBox < 0) {
		scrollBox = 0;
	} else {
		scrollBox = scrollBox + 3;
		scrollObj.scrollTop = scrollBox;
	}
    scrolldelay = setTimeout('downScroll();',scrollSpeed); 
}

function stopScroll(direct) {
	scrollSpeed = 30;
    clearTimeout(scrolldelay);
	if (speedup) {
		clearTimeout(speedup);
	}
	if (direct == "up") {
		document.upArrow.src = uprollout.src;
	} else if (direct == "down") {
		document.downArrow.src = downrollout.src;
	}
}

function fastScroll(scrollSpecific) {
	if (scrollSpeed != scrollSpecific) {
		scrollSpeed = scrollSpecific;
	}
	scrollSpeed--;
	speedup = setTimeout('fastScroll();',200);
	if (scrollSpeed == 10) {
		 clearTimeout(speedup);
	}
}

function slowScroll() {
	scrollSpeed = 30;
	clearTimeout(speedup);
}

function receiveChatText() {
	var httpReceiveChat = getHTTPObject();
	if (httpReceiveChat.readyState == 4 || httpReceiveChat.readyState == 0) {
		//alert (httpReceiveChat.readyState);
 		//alert ("lastID"+lastID);
		httpReceiveChat.open("GET", GetChaturl + '?lastID=' + lastID + '&rand='+Math.floor(Math.random() * 1000000), true);
   	httpReceiveChat.onreadystatechange = function() {handlehHttpReceiveChat(httpReceiveChat);}; 
 		httpReceiveChat.send(null);
	}
}

function handlehHttpReceiveChat(httpReceiveChat) {
	//alert (httpReceiveChat.readyState);
  if (httpReceiveChat.readyState == 4) {
	  //alert (httpReceiveChat.responseText);
    results = httpReceiveChat.responseText.split('---'); 
    if (results.length > 2) {
	    for(i=0;i < (results.length-1);i=i+4) { 
	    	
			insertNewContent(results[i+1], results[i+3], results[i+2]);
			//checkfunct(results[i+1], results[i+3], results[i+2]);
	    }
		lastID = results[results.length-5];
		//alert (lastID);
    }
    setTimeout('receiveChatText();',4000);
  }
}

function insertNewContent(liName, liDate, liText) {
	
	insertO = document.getElementById("chatTXTall");
	//alert (insertO);
	/*colorID = document.forms['chatForm'].elements['colorID'].value;
	alert (colorID);
	if (colorID == 1) {
		document.forms['chatForm'].elements['colorID'].value = 2;
	} else {
		document.forms['chatForm'].elements['colorID'].value = 1;
	}
	*/
	oLi = document.createElement('li');
	oLi.setAttribute ('id', 'chatTXTdata');
	/*oTD = document.createElement('td');
	oTD.setAttribute ('id', 'chatTableHolder');
	oTable = document.createElement('table');
	oTable.setAttribute ('width', '100%');
	oTable.setAttribute ('border', '0');
	oTable.setAttribute ('cellpadding', '0');
	oTable.setAttribute ('cellspacing', '0');
	oTable.setAttribute ('id', 'chatTxtTable');
	iTR1 = document.createElement('tr');
	iTD1I = document.createElement('td');
	iTD1I.setAttribute ('id', 'nameHolder');
	iTD1I.innerHTML = "Submitted by: <b>" + liName + "</b>";
	iTD1II = document.createElement('td');
	iTD1II.setAttribute ('id', 'datetimeHolder');
	iTD1II.innerHTML = "Submitted on: <b>" + liDate + "</b>";
	iTR2 = document.createElement('tr');
	iTD2I = document.createElement('td');
	iTD2I.setAttribute ('id', 'msgHolder');
	iTD2I.setAttribute ('colspan', '2');
	iTD2I.innerHTML = " " + liText + " ";
	oName = document.createTextNode('Submitted by:' + liName);
	oDate = document.createTextNode('Submitted on:' + liDate);
	oText = document.createTextNode(liText);
	iTR1 = document.createElement('tr');
	iTD1I = document.createElement('td');
	iTD1I.setAttribute ('id', 'nameHolder');
	iTD1I.appendChild(oName);
	iTD1II = document.createElement('td');
	iTD1II.setAttribute ('id', 'datetimeHolder');
	iTD1I.appendChild(oDate);
	iTR2 = document.createElement('tr');
	iTD2I = document.createElement('td');
	iTD2I.setAttribute ('id', 'msgHolder');
	iTD2I.setAttribute ('colspan', '2');
	iTD1I.appendChild(oText);
	oTable.appendChild(iTR1);
	oTable.appendChild(iTD1I);
	oTable.appendChild(iTD1II);
	oTable.appendChild(iTR2);
	oTable.appendChild(iTD2I);
	
	oTable.appendChild(iTR1);
	oTable.appendChild(iTD1I, iTR1);
	oTable.appendChild(iTD1II, iTD1I);
	oTable.appendChild(iTR2, iTD1II);
	oTable.appendChild(iTD2I, iTR2);
	//oTable.innerHTML = "<tr><td id=\"nameHolder\">Submitted by: <b>" + liName + "</b></td><td id=\"datetimeHolder\">Submitted on: <b>" + liDate + "</b></td></tr><tr><td id=\"msgHolder\" colspan=\"2\">" + liText + "</td></tr>";
	oTD.appendChild(oTable);
	oTR.appendChild(oTD);
	insertO.insertBefore(oTR, insertO.firstChild);*/
	oLi.innerHTML = "<table width = 100% border = '0' cellpadding = '0' cellspacing = '0' id='chatTxtTable1'><tr><td id='nameHolder'><b>" + liName + ": </b> &nbsp;" + liText + "</td></tr></table>";
	insertO.insertBefore(oLi, insertO.lastChild);
	var objDiv = document.getElementById("scrollerTXT");
	objDiv.scrollTop = objDiv.scrollHeight - 192;
	scrollBox = objDiv.scrollHeight;
	//alert(objDiv.scrollTop);
	//alert(scrollBox);
}

function sendComment() {
	var httpSendChat = getHTTPObject();
	currentChatText = document.forms['chatForm'].elements['chatMsg'].value;
	if (((currentChatText != '') || (currentChatText != ' ')) && (httpSendChat.readyState == 4 || httpSendChat.readyState == 0)) {
		currentName = document.forms['chatForm'].elements['username'].value;
		param = 'n='+ currentName+'&c='+ currentChatText;
		//alert (currentChatText);
		//alert (currentName);
		//alert (param);
		httpSendChat.open("POST", SendChaturl, true);
		httpSendChat.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  	httpSendChat.onreadystatechange = function() {handlehHttpSendChat(httpSendChat);};
  	httpSendChat.send(param);
  	document.forms['chatForm'].elements['chatMsg'].value = '';
	} else {
		setTimeout('sendComment();',1000);
	}
}

function handlehHttpSendChat(httpSendChat) {
	(httpSendChat.readyState);
  if (httpSendChat.readyState == 4) {
  	receiveChatText();
	//var objDiv = document.getElementById("scrollerTXT");
	//objDiv.scrollTop = objDiv.scrollHeight;
  }
}


/*
function checkStatus(focusState) {
	currentChatText = document.forms['chatForm'].elements['chatTXT'];
	oSubmit = document.forms['chatForm'].elements['chatSubmit'];
	if (currentChatText.value != '' || focusState == 'active') {
		oSubmit.disabled = false;
	} else {
		oSubmit.disabled = true;
	}
}
*/

function getHTTPObject() {
	/*var xmlhttp = false;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
		if (xmlhttp.overrideMimeType) {
			xmlhttp.overrideMimeType('text/xml');
		}
	} else if (window.AtiveXObject) {
		try {
			xmlhttp = new ActiveXObject ("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject ("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	
	if (!xmlhttp) {
		alert ('Browser is not supported. Go get Firefox for a change');
		return false;
	}
	return xmlhttp;
	*/
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
				try {
					xmlhttp = new XMLHttpRequest();
				} catch (e) {
					if (!xmlhttp && window.createRequest) {
						try {
							xmlhttp = window.createRequest();
						} catch (e) {
							xmlhttp=false;
							alert ('Browser is not supported go get Firefox');
						}
					}
				}
			} 
		}
	} 
	return xmlhttp;
}