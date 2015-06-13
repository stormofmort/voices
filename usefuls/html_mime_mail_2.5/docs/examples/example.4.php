<?php
/**
* o------------------------------------------------------------------------------o
* | This package is dual licensed as GPL and a commercial license.               |
* | If you use the code commercially (or if you don't want to be restricted by   |
* | the GPL license), you will need the commercial license. It's only £49 (GBP - |
* | roughly $98 depending on the exchange rate) and helps me out a lot. Thanks.  |
* o------------------------------------------------------------------------------o
*
* © Copyright Richard Heyes
*/

        error_reporting(E_ALL);
        require_once('htmlMimeMail.php');

/**
* Example of usage. This example shows
* how to use the class to send Bcc: 
* and/or Cc: recipients.
*
* Create the mail object.
*/
	$mail = new htmlMimeMail();

/**
* We will just send a text email
*/
	$text = $mail->getFile('example.txt');
	$mail->setText($text);

/**
* Send the email using smtp method. The setSMTPParams()
* method simply changes the HELO string to example.com
* as localhost and port 25 are the defaults.
*/
	$mail->setSMTPParams('localhost', 25, 'example.com');
	$mail->setReturnPath('joe@example.com');
	$mail->setBcc('bcc@example.com');
	$mail->setCc('Carbon Copy <cc@example.com>');

	$result = $mail->send(array('postmaster@localhost'), 'smtp');

	// These errors are only set if you're using SMTP to send the message
	if (!$result) {
		print_r($mail->errors);
	} else {
		echo 'Mail sent!';
	}
?>