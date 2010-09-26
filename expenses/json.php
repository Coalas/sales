<?php
       require_once('../config.php');
       //require_once('encode.php');
       $models = Doctrine_Core::loadModels(MODELS_PATH);
       $aColumns = array( 'idexpenses', 'name', 'amount' , 'addDate', 'idexpenses' );

        //$houseTable = Doctrine_Core::getTable('House');
       // echo $houseTable->findAll();
      // $q = Doctrine_Query::create()
      //      ->select('h.idhouses, h.name, r.*')
       //     ->from('House h')
       //     ->innerJoin('h.Region r')
       //     ->limit(20);      
        $q = Doctrine_Query::create()
        ->select('e.idexpenses, e.addDate, e.amount, c.name')
        ->from("Expense e")
        ->innerJoin("e.ExpCategory c");
        
        /* Stronicowanie */
	$limit = 0;
        $offset = 0;
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$limit =  $_GET['iDisplayLength'];
		$offset = $_GET['iDisplayStart'];
	}

        /*
	 * Sortowanie
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
                            if ($_GET['iSortCol_'.$i] == '1')
                                $q->addOrderBy('c.name '.$_GET['sSortDir_'.$i]); else
                      
                                $q->addOrderBy('e.'.$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".$_GET['sSortDir_'.$i]);
				//$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."".$_GET['sSortDir_'.$i].", ";
                            
			}
		}	
	}
        
       /*
        * Filtrowanie
        */
       
        if ( $_GET['sSearch'] != "" )
	{
               
                $q->addWhere('e.amount LIKE ? ', $_GET['sSearch'].'%');
		//$q->orWhere('c.name LIKE ? ', $_GET['sSearch'].'%');
	}
         if ( $_GET['sSearch_0'] != "" ){
            
              $q->addWhere('YEAR(e.addDate)=?', $_GET['sSearch_0'].'');
                
        }
        
        $q->offset($offset)
          ->limit($limit);
        $iFilteredTotal=$q->count();

        $houses=$q->fetchArray();
        
        $q->free();

        $q = Doctrine_Query::create()
        ->select('e.idexpenses')
        ->from("Expense e");
        $iTotal=$q->count();
        $q->free();
        
        /*
        $q = Doctrine_Query::create()
            ->select('h.idhouses, h.name, h.city, h.tel, h.email, h.www')
            ->from('House h')
            ->orderBy('h.idhouses')
            ->offset($offset)
            ->limit($limit);
       //echo $q->getSqlQuery();
       $houses=$q->fetchArray();
       */
           // $usersWithAddresses = $em->createQuery("select u, a from MyProject
          //  \Domain\User join u.addresses a")->getArrayResult();
           // $json = json_encode($usersWithAddresses);
            
           //print_r($houses[0]);
           $arrValues = Array();
           //$json = json_encode($houses[0]);
           
          
          foreach ($houses as $house){
            //echo $house->name . ' '.$house->city.' '.$house->Region->name."<br>";
            array_push($arrValues, array_values($house));
              
           }
          // print_r($arrValues);
           foreach($arrValues as $key=>$arrValue) {
               
               $category = $arrValue[3]['name'];

               //$arrValues[$key][1] = $arrValues[$key][2].' '.$arrValues[$key][1];
               $arrValues[$key][3] = $category;
               //array_pop($arrValues[$key]);
               //array_splice($arrValues[$key], 2, 1);
               //array_push($arrValues[$key],$category[1].'<br/>'.$category[2].'<br/>'.$category[3]);
              // print_r();
               // = array_values($arrValue[6][0]);
               //array_push($arrValues[$key], "<a href=\"../edit.php?id=".$arrValues[$key][0]."\">Edytuj</a> <a href=\"../delete.php?id=".$arrValues[$key][0]."\">Usuń</a>");
               array_push($arrValues[$key], "<a class=\"modalForm\" href=\"../edit.php\" id=\"".$arrValues[$key][0]."\"><img border=\"0\" src=\"../media/images/ico.edit.gif\" /></a> <a href=\"\" id=\"".$arrValues[$key][0]."\"  class=\"deleteRow\" ><img border=\"0\" src=\"../media/images/delete.png\"/></a>");
               //print_r($arrValues[$key]);


           }
           //print_r($arrValues);
   

        //     foreach($houses as $key => $value) {
       //   array_push($arrValues, array_values($value));
          //$array[$key] = $value->toArray();
         // print_r (array_values($value));


     //  }
      
           $sOutput = '{';
           $sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
           $sOutput .= '"iTotalRecords": '.$iTotal.', ';
           $sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
           $sOutput .= '"aaData": ';
           $sOutput .= json_encode($arrValues);
           $sOutput .= ' }';
              
      echo $sOutput;

        
 ?>