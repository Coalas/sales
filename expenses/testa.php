  <?php
       require_once('../config.php');
       if (isset ($_GET['id'])) {
       $models = Doctrine_Core::loadModels(MODELS_PATH);
       //if(isset ($_GET['id'])) {
       $q=Doctrine_Query::create()
           ->select("e.*")
               ->from("Expense e")
               //->innerJoin("c.Address a")
               ->where("e.idexpenses=?",intval($_GET['id']))
               //->addOrderBy('a.billing DESC')
               ->fetchArray();

        //print_r($q);
         //$target = ($q->target == 1)? "checked":"";

      // }
        $j= json_encode($q[0]);
       
        echo $j;
        
        }
        ?>
