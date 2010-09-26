<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../config.php');
$models = Doctrine_Core::loadModels(MODELS_PATH);
$idExpense = isset($_POST['id']) && $_POST['id'] > 0 ? $_POST['id']:null;
if (isset ($_POST['amount']) && isset ($_POST['category']))
{
    $expenseTable = Doctrine_Core::getTable('Expense');
   
    if ($idExpense === null) {

        $expense = new Expense();
        $expense->addDate = new Doctrine_Expression('NOW()');
        
    } else {

        $expense = $expenseTable->find($idExpense);
        
    }
  
    //$expense->merge($_REQUEST['user']);
    
    $expense->amount = $_POST['amount'];
    $expense->expcategory_id = $_POST['category'];

    
    $expense->save();
    $expense->free();

    //
    echo('ok');
    //header('location: contacts/contacts.html');
}


?>
