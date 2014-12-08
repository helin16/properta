<?php
return array(
	'Database' => array(
			'Driver' => 'mysql',
			'DBHost' => 'localhost',
			'DB' => 'properta',
			'Username' => 'root',
			'Password' => ''
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
		'Password' => 'TEST@websiteforyou.com.au',
		'SMTPSecure' => 'ssl',
		'default_from_addr' => 'noreplay@properta.com.au',
		'default_from_name' => 'PropertA'               
	)
);

?>