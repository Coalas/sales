<?php
$moduleRoot=dirname(__FILE__);
require($moduleRoot.'class.phpmailer.php');
require($moduleRoot.'class.newsletter.php');
require($moduleRoot.'easy-mysql-class.php');

$mysql= new mysql('localhost' , 'mysqlUser', 'mysqlPassw', 'mysqlDB' );
$mysql->connect();

$newsletter= new newsletter();
$newsletter->addMysqlObg($mysql);

    	$data=array('method'   		=> 'SMTP',
    				'From'     		=> 'myadress@domain.com',
    				'FromName' 		=> 'My Name',
    				'Host'     		=> 'mail.domain.com',
    				'SMTPAuth' 		=> true,
    				'Username' 		=> 'myadress@domain.com',
    				'Password' 		=> 'password',
    				'recepientMail' => 'joe@yahoo.com',
    				'recepientName' => 'Joe Silva',
    				'subject'       => 'Hello friend',
    				'body'          => 'How are you !',
    				'ContentType'   => 'text/html',
    				'priority'      => '3',
    				'SendDate'      => time(),
    				);
$add=$newsletter->addMail($data);
if ($add===false) echo $newsletter->errorMsg;

?>