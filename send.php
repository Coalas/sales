<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="media/css/style.css" media="screen" />
        <title></title>
    </head>
    <body>
        <?php
        include('media/menu.html');
        require_once('config.php');
        $models = Doctrine_Core::loadModels('models');
        if (isset ($_POST['data'])){
            $recipients = explode(',',$_POST['data']);
            $clientTable = Doctrine_Core::getTable('Client');
            $stored = Array();
            $rejected = Array();
            foreach ($recipients as $value) {

                $client = $clientTable->find($value);
                if ($client->email !== null){

                $package= new EmailPackage();
                $package->recipient = $client->name." ".$client->lastName;
                $package->address = $client->email;
                $package->email_id= $_POST['idemail'];
                $package->save();
                $package->free();
                array_push($stored, $client->name." ".$client->lastName);
                } else
                    array_push ($rejected, $client->name." ".$client->lastName);
                $client->free();
            }
          

        }

        
        
       
        ?>
        <div class="content">
	<div id="main">
		<div class="padding">

				<div class="intro">
					<div class="pad">
                                            <?php
                                            echo "Zapisano nastepujacych odbiorców:\n";
          foreach ($stored as $value) {
              echo $value."<br/>";
          }
          echo "Brak adresow email nastepujacych odbiorców:\n";
          
          foreach ($rejected as $value) {
              echo $value."<br/>";
          }
                                            ?>
                                            <p>
          <input id="Back" type="button" class="groovybutton" value="Powrót" onClick="location.href='emails'" />
                                            </p>
					</div>
				</div>



				</div>
			</div>
		</div>
	<div class="clear"></div>

	<div id="footer">

	<br />
	&copy; Copyright 2010
	</div>
    </body>
</html>
