<?php
abstract class EmailSenderAbstract
{
	/**
	 * Send an email out via smtp
	 * @param array  $tos
	 * @param string $subject
	 * @param string $body
	 * @param string $alertBody
	 * @param string $from
	 * @param string $fromName
	 * @param string isHTML        Whether the emaill be send as html
	 * @param array  $attachments  The Attachments
	 * @param array  $ccs          The CC's 
	 * @param array  $bccs         The BCC's
	 * @param number $wordWrap     The Set word wrap to number of characters
	 * 
	 * @throws Exception
	 */
	public static function sendEmail(array $tos, $subject, $body, $alterBody = '', $from = '', $fromName = '', $isHTML = true, array $attachments = array(), array $ccs = array(), array $bccs = array(), $wordWrap = 100)
	{
		if(is_string($tos))
			$tos = array($tos);
		$mail = new PHPMailer();
		$mail->isSMTP();                                      		  // Set mailer to use SMTP
		$mail->Host       = Config::get('MailServer', 'host');        // Specify main and backup SMTP servers
		$mail->SMTPAuth   = Config::get('MailServer', 'SMTPAuth');    // Enable SMTP authentication
		$mail->Username   = Config::get('MailServer', 'Username');    // SMTP username
		$mail->Password   = Config::get('MailServer', 'Password');    // SMTP password
		$mail->SMTPSecure = Config::get('MailServer', 'SMTPSecure');  // Enable TLS encryption, `ssl` also accepted
		$mail->Port       = Config::get('MailServer', 'port');        // TCP port to connect to
		$mail->WordWrap   = $wordWrap;                                // Set word wrap to 50 characters
		$mail->Subject    = $subject;
		$mail->Body       = $body;
		$mail->AltBody    = $alterBody;
		$mail->isHTML($isHTML);                                       // Set email format to HTML
		
		$mail->From = trim($from) !== '' ? trim($from) : trim(Config::get('MailServer', 'default_from_addr'));
		$mail->FromName = trim($fromName) !== '' ? trim($fromName) : trim(Config::get('MailServer', 'default_from_name'));
		foreach($tos as $toAddr => $toName) {
			if(is_numeric($toAddr))
				$mail->addAddress($toName);
			else
				$mail->addAddress($toAddr, $toName);                      // Add a recipient
		}
		foreach($ccs as $addr => $name) {
			if(is_numeric($addr))
				$mail->addAddress($name);
			else
				$mail->addCC($addr, $name);                      		  // Add a cc
		}
		foreach($bccs as $addr => $name) {
			if(is_numeric($addr))
				$mail->addAddress($name);
			else
				$mail->addBCC($addr, $name);                      		  // Add a bcc
		}
		//attachments
		foreach($attachments as $path => $name) {
			if(is_numeric($path))
				$mail->addAttachment($name);
			else
				$mail->addAttachment($path, $name);                       // Optional name
		}
		//send the message
		if(!$mail->send()) {
			$msg = 'Message could not be sent.';
			$msg .= 'Mailer Error: ' . $mail->ErrorInfo;
			throw new Exception('Error: ' . $msg);
		}
		return true;
	}
}