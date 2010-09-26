  <?php
       require_once('config.php');
       if (isset ($_GET['id'])) {
       $models = Doctrine_Core::loadModels('models');
       //if(isset ($_GET['id'])) {
       $q=Doctrine_Query::create()
           ->select("c.*, a.*")
               ->from("Client c")
               ->innerJoin("c.Address a")
               ->where("c.idclients=?",intval($_GET['id']))
               ->addOrderBy('a.billing DESC')
               ->fetchArray();

        //print_r($q);
         //$target = ($q->target == 1)? "checked":"";

      // }
        $j= json_encode($q[0]);
       
        echo $j;
        
        }
        ?>
