<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
$models = Doctrine_Core::loadModels('models');
$idClient = isset($_POST['id']) && $_POST['id'] > 0 ? $_POST['id']:null;
if (isset ($_POST['name']) && isset ($_POST['city']) && isset ($_POST['zipCode']) && isset ($_POST['street']))
{
    $clientTable = Doctrine_Core::getTable('Client');
    $addressTable = Doctrine_Core::getTable('Address');
    if ($idClient === null) {
        $client = new Client();
        $addr = new Address();
        $client->Address[0] = $addr;
    } else {
        $client = $clientTable->find($idClient);
        $addr = $client->Address[0];
    }
  
    //$client->merge($_REQUEST['user']);
    
    $client->name = $_POST['name'];
    $client->lastName = $_POST['lastName'];
    $client->tel = $_POST['tel'];
    $client->email = $_POST['email'];
    $client->www = $_POST['www'];
    if (isset($_POST['target']))
        $client->target = 1; else {
        $client->target = 0;

    }
    
    $addr->city = $_POST['city'];
    $addr->zipCode = $_POST['zipCode'];
    $addr->street = $_POST['street'];
    $addr->billing = 1;

    //$client->Address[0] = $addr;
    if (isset ($_POST['secondaddr']) && $_POST['secondaddr']=='on')
    {
      if (count($client->Address->toArray())>1)
              $addr = $client->Address[1]; else
              {$addr = new Address();

              $client->Address[1] = $addr;
              }
      $addr->city = $_POST['city2'];
      $addr->zipCode = $_POST['zipCode2'];
      $addr->street = $_POST['street2'];
      $addr->billing = 0;
      
    } else {                                        // jesli wyl dodatk. adres
    if (count($client->Address->toArray())>1) {

        $addr = $client->Address[1];
        $del = $addressTable->find($addr->idaddress);
        //print_r($del);
        $del->delete();
    }}
    $client->save();
    $client->free();
    $addr->free();
    //
    echo('ok');
    //header('location: contacts/contacts.html');
}


?>
