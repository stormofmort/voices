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
* how to use the class to send a plain
* text email with an attachment. No html,
* or embedded images.
*
* Create the mail object.
*/
	$mail = new htmlMimeMail();
	
/**
* Read the file test.zip into $attachment.
*/
	$attachment = $mail->getFile('example.zip');

/**
* Since we're sending a plain text email,
* we only need to read in the text file.
*/
	$text = $mail->getFile('example.txt');

/**
* To set the text body of the email, we
* are using the setText() function. This
* is an alternative to the setHtml() function
* which would obviously be inappropriate here.
*/	
	$mail->setText($text);

/**
* This is used to add an attachment to
* the email.
*/
	$mail->addAttachment($attachment, 'example.zip', 'application/zip');

/**
* Sends the message.
*/
	$mail->setFrom('Joe <joe@example.com>');
	$result = $mail->send(array('"Richard" <postmaster@localhost>'));
	
	echo $result ? 'Mail sent!' : 'Failed to send mail';
?>