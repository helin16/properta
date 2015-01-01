<?php

require_once 'bootstrap.php';

echo '<pre>';
Core::setUser(UserAccount::get(UserAccount::ID_SYSTEM_ACCOUNT));

try
{
	for($i = 0; $i < 10; $i++)
	{
		$message = Message::create(Person::get(10), Person::get(10), 'test'. $i, 'body' . $i, Message::TYPE_EMAIL);
		var_dump($message);
	}
} catch(Exception $ex)
{
	throw new Exception('<pre>' . $ex->getMessage(). "\n" . $ex->getTraceAsString() . '</pre>');
}

echo 'DONE';

die;