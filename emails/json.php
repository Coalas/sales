<?php
       require_once('../config.php');
       //require_once('encode.php');
       $models = Doctrine_Core::loadModels(MODELS_PATH);
       $aColumns = array( 'idemails', 'subject', 'addDate', 'idemails');

        //$houseTable = Doctrine_Core::getTable('House');
       // echo $houseTable->findAll();
      // $q = Doctrine_Query::create()
      //      ->select('h.idhouses, h.name, r.*')
       //     ->from('House h')
       //     ->innerJoin('h.Region r')
       //     ->limit(20);

       
        $q = Doctrine_Query::create()
        ->select('e.idemails, e.subject, e.addDate')
        ->from("Email e");
        //->innerJoin("c.Address a WITH a.billing = 1");
        
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

                $q->addWhere('e.subject LIKE ?', $_GET['sSearch'].'%');
		
	}
        
        $q->offset($offset)
          ->limit($limit);
        $iFilteredTotal=$q->count();

        $emails=$q->fetchArray();
        
        $q->free();
        $q = Doctrine_Query::create()
        ->select('e.idemails')
        ->from("Email e");
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
       $email=$q->fetchArray();
       */
           // $usersWithAddresses = $em->createQuery("select u, a from MyProject
          //  \Domain\User join u.addresses a")->getArrayResult();
           // $json = json_encode($usersWithAddresses);
            
           //print_r($email[0]);
           $arrValues = Array();
           //$json = json_encode($email[0]);
           //print_r( $arrValues);
          
          foreach ($emails as $email){
            //echo $house->name . ' '.$house->city.' '.$house->Region->name."<br>";
              array_push($arrValues, array_values($email));
              
           }
           //print_r($arrValues);
           foreach($arrValues as $key=>$arrValue) {

            
               //$address = array_values($arrValue[6][0]);
              // $arrValues[$key][1] = $arrValues[$key][2].' '.$arrValues[$key][1];
              // $arrValues[$key][2] = $address[1].' '.$address[2].'<br/>'.$address[3];
               //array_pop($arrValues[$key]);
               //array_splice($arrValues[$key], 2, 1);
               //array_push($arrValues[$key],$address[1].'<br/>'.$address[2].'<br/>'.$address[3]);
              // print_r();
               // = array_values($arrValue[6][0]);
               //array_push($arrValues[$key], "<a href=\"../edit.php?id=".$arrValues[$key][0]."\">Edytuj</a> <a href=\"../delete.php?id=".$arrValues[$key][0]."\">Usuń</a>");
               array_push($arrValues[$key], "<a class=\"modalForm\" href=\"clients.php?id=".$arrValues[$key][0]."\" ><img border=\"0\" src=\"../media/images/email.png\" /></a> <a class=\"modalForm\" href=\"edit.php?id=".$arrValues[$key][0]."\" ><img border=\"0\" src=\"../media/images/ico.edit.gif\" /></a> <a href=\"\" id=\"".$arrValues[$key][0]."\"  class=\"deleteRow\" ><img border=\"0\" src=\"../media/images/delete.png\"/></a>");
               //print_r($arrValues[$key]);


           }
          // print_r($arrValues);
   

        //     foreach($email as $key => $value) {
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