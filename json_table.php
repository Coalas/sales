<?php
/* 
 * select  c.name, sum(e.amount) from
 *  expenses e left join expcategories c on
 *  expcategory_id=idexpcategories  group by expcategory_id;

 */

require_once('config.php');
//require_once('encode.php');
$models = Doctrine_Core::loadModels(MODELS_PATH);
 $q = Doctrine_Query::create()
        ->select('DISTINCT c.name, e.addDate, SUM(e.amount) as summary')
         //->addSelect('c.name')
        ->from("Expense e")
        ->leftJoin('e.ExpCategory c')
        ->where('YEAR(e.addDate) = YEAR(NOW())')
        ->groupBy('e.expcategory_id')
         ->orderBy('summary')
        ->fetchArray();
 
 
 //echo $q->getSqlQuery();

 $json = array();
foreach ($q as $key=>$exp){
             //echo $house->name . ' '.$house->city.' '.$house->Region->name."<br>";
             // array_push($json, array_values($exp));
                array_push($json, array($exp['ExpCategory']['name'],$exp['summary']));
           }
            //print_r($json);
foreach ($q as $cat){
           

           }



    echo json_encode($json);
?>
