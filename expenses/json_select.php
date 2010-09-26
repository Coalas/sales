<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../config.php');
//require_once('encode.php');
$models = Doctrine_Core::loadModels(MODELS_PATH);
 $q = Doctrine_Query::create()
        ->select('e.idexpcategories, e.name')
        ->from("ExpCategory e")
         ->fetchArray();
$json = array();
foreach ($q as $cat){
            //echo $house->name . ' '.$house->city.' '.$house->Region->name."<br>";
           // array_push($json, array_values($cat));

           }



    echo json_encode($q);
?>
