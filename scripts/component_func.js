	function start(component) {
		for (i=0; i<component.length; ++i) {
			Link = component[i]+"Link";
			currLink = document.getElementById(Link);
			currUser = document.forms['chatForm'].elements['username'].value;
			currComponent = document.getElementById(component[i]);
			cookieValue = getCookie(currUser+"@"+component[i]);
			if (cookieValue == "hide") {
				currLink.innerHTML = "[+]";
				currComponent.style.display = 'none';
			} else {
				currLink.innerHTML = "[-]";
			}
		}
	}

	function setCookie(name, value)
	{
		// no expiration date specified? use this date and it will just be deleted soon.
		expires = new Date();
		expires.setTime(expires.getTime() + 1000 * 60 * 60 * 24 * 30); 
		document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
	}

	function getCookie(name)
	{
		var cookies = document.cookie;
		if (cookies.indexOf(name) != -1)
		{
			var startpos = cookies.indexOf(name)+name.length+1;
			var endpos = cookies.indexOf(";",startpos);
			if (endpos == -1) endpos = cookies.length;
			return unescape(cookies.substring(startpos,endpos));
		}
		else
		{
			return false; // the cookie couldn't be found! it was never set before, or it expired.
		}
	}

	function printStatus(component, status) {
		Link = component+"Link";
		currLink = document.getElementById(Link);
		currLink.innerHTML = status;
	}

	function componentHide(component) {
		currComponent = document.getElementById(component);
		currUser = document.forms['chatForm'].elements['username'].value;
		currStyle = currComponent.style.display;
		if (currStyle == 'none') {
			currComponent.style.display = 'block';
			setCookie(currUser+"@"+component, "show");
			printStatus(component, "[-]");
			if (component == 'comments') {
				resizeCaller();
			}

		} else {
			currComponent.style.display = 'none';
			setCookie(currUser+"@"+component, "hide");
			printStatus(component, "[+]")
		}
	}