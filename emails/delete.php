<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');
$models = Doctrine_Core::loadModels(MODELS_PATH);
$idEmails = isset($_GET['id']) && $_GET['id'] > 0 ? $_GET['id']:null;
if ($idEmails === null) {
       //header('location: contacts/contacts.html');
    } else {
        $emailTable = Doctrine_Core::getTable('Email');
        $email = $emailTable->find($idEmails);
        $email->delete();
        $email->free();
        echo 'ok';
        }
   // header('location: /sales/emails');
?>
