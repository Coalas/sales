<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('config.php');
require_once 'lib/swift/lib/swift_required.php';
$models = Doctrine_Core::loadModels('models');


//$packageTable = Doctrine_Core::getTable('Package');
//  $package=Doctrine_Query::create()
//           ->select("p.idpackages, h.email")
//               ->from("Package p")
//               ->innerJoin("p.House h")
//               ->where("p.status=?",0)
//               ->limit(100)
//               ->fetchArray();
  $firstEmail = Doctrine_Query::create()
                ->select("email_id")
                ->from("EmailPackage")
                ->offset(0)
                ->limit(1)
                ->fetchOne();

  echo "emailID ".$firstEmail->email_id;

  $package = Doctrine_Query::create()
           ->select("e.idemailpackage, e.address, e.recipient, e.email_id")
               ->from("EmailPackage e")
               //->innerJoin("p.House h")
               ->where("e.address <> ''")
            ->andWhere("e.email_id=?",$firstEmail->email_id)
            ->offset(0)
            ->limit(100)
            ->fetchArray();

 
  $arrk= array();
  $arrv=array();
  $arrid= array();

  foreach ($package as $value) {
  array_push($arrk, $value['address'])  ;
  array_push($arrv, $value['recipient']);
  array_push($arrid, $value['idemailpackage']);
  }

  $arr = array_combine($arrk, $arrv);
  print_r($arr);
  print_r($arrid);

  $message = Swift_Message::newInstance();


  
  $q = Doctrine_Query::create()
       ->delete("EmailPackage")
          ->whereIn("idemailpackage",$arrid);
  
  $deleted = $q->execute();
  
/*
  //Give the message a subject
  $message->setSubject('Piosenki Leonarda Cohena')

  //Set the From address with an associative array
  ->setFrom(array('w.gesicki@o2.pl'=>'Wojtek Gęsicki'))

  //Set the To addresses with an associative array
  ->setTo($arr)

  //And optionally an alternative body
  //->addPart('<q>Here is the message itself</q><br/><strong>ok</strong>', 'text/html')
  ->setReadReceiptTo('w.gesicki@o2.pl');
    $message->setBody(
   '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;
      charset=ISO-8859-2">
    <meta content="MSHTML 6.00.2900.3157" name="GENERATOR">
    <style></style>
  </head>
  <body link="#0000ee" text="#000000" vlink="#551a8b" alink="#ee0000"
    bgcolor="#f5f1cb">
    <div><br>
      <b>Szanowni Panstwo</b><br>
      <br>
          Serdecznie zapraszam do zapoznania sie z moja oferta <b>koncertu






        poezji spiewanej</b>,  w repertuarze piosenki<b> </b>kanadyjskiego




      poety<b> Leonarda Cohena</b>...<br>
      <br>
      <div align="center"><br>
      </div>
      <div align="center"><a
          href="http://www.wojtekgesicki.pl/index.php?st=5">'.'<img src="' . //Embed the file
        $message->embed(Swift_Image::fromPath('media/images/poster.jpeg')) .
        '" alt="Obrazek" />' .'<br>
      </div>
      <br>
      <br>
      <a
        href="http://www.przeklej.pl/plik/prawo-zaj-mp3-00201jba3b5c2j6">Posluchaj
        online</a><br>
      __________________________<br>
      <br>
      Zapraszam do kontaktu <br>
      <br>
      Wojtek Gęsicki<br>
      <br>
      tel.: 0 502 281 107<br>
      <a href="http://www.wojtekgesicki.pl">www.wojtekgesicki.pl</a> </div>
  </body>

</html>',
    'text/html' //Mark the content-type as HTML
);
// $message->attach(Swift_Attachment::fromPath('media/Piosenki_Leonarda_Cohena.pdf'));
// $message->attach(Swift_Attachment::fromPath('media/prawo_zaj.mp3'));

  //Create the Transport
$transport = Swift_SmtpTransport::newInstance('poczta.o2.pl', 587)
  ->setUsername('w.gesicki')
  ->setPassword('Laguna')
  ;

/*
You could alternatively use a different transport such as Sendmail or Mail:

//Sendmail
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

//Mail
$transport = Swift_MailTransport::newInstance();
*/

//Create the Mailer using your created Transport
//$mailer = Swift_Mailer::newInstance($transport);

//Send the message
//$c = $mailer->batchSend($message, $failures);

//print_r($failures);

//echo $c;

/*
You can alternatively use batchSend() to send the message

$result = $mailer->batchSend($message);
*/

    //$house->merge($_REQUEST['user']);
 
//    $house->name = $_POST['name'];
//    $house->city = $_POST['city'];
//    $house->zipCode = $_POST['zipCode'];
//    $house->street = $_POST['street'];
//    $house->tel = $_POST['tel'];
//    $house->email = $_POST['email'];
//    $house->www = $_POST['www'];
//    $house->target = $_POST['target'];
//    $house->save();
    //
    //echo($house->idhouses);
   



?>
