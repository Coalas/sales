<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');
$models = Doctrine_Core::loadModels('../models');
$idEmail = isset($_POST['id']) && $_POST['id'] > 0 ? $_POST['id']:null;
if (isset ($_POST['emailbody']))
{
    $emailTable = Doctrine_Core::getTable('Email');
    if ($idEmail === null) {
        $email = new Email();
    } else {
        $email = $emailTable->find($idEmail);
    }
  
    //$email->merge($_REQUEST['user']);
    
    $email->subject = $_POST['subject'];
    $email->body = $_POST['emailbody'];
    $email->addDate = new Doctrine_Expression('NOW()');
    //$email->city = $_POST['city'];
    //$email->zipCode = $_POST['zipCode'];
    //$email->street = $_POST['street'];
    //$email->tel = $_POST['tel'];
    //$email->email = $_POST['email'];
    //$email->www = $_POST['www'];
    //if (isset($_POST['target']))
    //    $email->target = 1; else {
    //    $email->target = 0;

    //}
    $email->save();
    //
    
    header('location:/sales/emails');
}


?>
