<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once('config.php');
        $models = Doctrine_Core::loadModels('models');

            $emailTable = Doctrine_Core::getTable('Email');
            $clientTable= Doctrine_Core::getTable('Client');
            $stored=Array();
            $client = $clientTable->find(1);
//            Many to Many
//            $email = new EmailClient();
//            $email->client_id =2;
//            $email->email_id =1;
           
            //$email->Client[] = $client;
            $email->save();
            $email->free();

            $email =$emailTable->find(1);
            print_r($email->Client->toArray());
        
        
       
        ?>
    </body>
</html>
