<?php
	setcookie("voicesuser", "general", time()+60*60*24*30, "/");
	setcookie("userchecksum", sha1("general9e3a8225470fb3b95925da28e9a3f0f077649838"), time()+60*60*24*30, "/");
?>