<?php
$moduleRoot=dirname(__FILE__);
require($moduleRoot.'/class.phpmailer.php');
require($moduleRoot.'/class.newsletter.php');
require($moduleRoot.'/easy-mysql-class.php');

$mysql= new mysql('localhost' , 'mysqlUser', 'mysqlPass', 'mysqlDB' );
$mysql->connect();

$newsletter= new newsletter();
$newsletter->addMysqlObg($mysql);

$sendAttempt=$newsletter->Sendmail();
if ($sendAttempt===false) echo $newsletter->errorMsg;
else {
	echo $newsletter->emailSent.' mailuri trimise.';
}

?>