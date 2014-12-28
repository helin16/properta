<?php
return array(
	'Database' => array(
			'Driver' => 'mysql',
			'DBHost' => 'localhost',
			'DB' => 'properta',
			'Username' => 'root',
			'Password' => 'root'
		)
	,'Application' => array(
		'name' => 'PropertA'
		,'version' => '1.0.0'
	)
	,'MailServer' =>  array (
		'host' => 'mail.websiteforyou.com.au',
		'port' => 465,
		'SMTPAuth' => true,
		'Username' => 'test@websiteforyou.com.au',
		'Password' => 'test@websiteforyou.com.au',
		'SMTPSecure' => 'ssl',
		'default_from_addr' => 'noreply@properta.com.au',
		'default_from_name' => 'PropertA'            
	)
	,'google' => array(
		'reCaptcha' => array (
			'public-key' => '6LfRuf8SAAAAAMtF2EOsFKkAK2-FKKkOppvWgIAp', 
			'verify-url' => 'https://www.google.com/recaptcha/api/siteverify',
			'secret-key' => '6LfRuf8SAAAAAH7AH6Gc0kpi81Ynrh_ogUTBrhiB'
		)
	)
	,'contact-us' => array (
		'tos' => array('helin16@gmail.com' => 'PropertA Web Contact')
	)
);

?>