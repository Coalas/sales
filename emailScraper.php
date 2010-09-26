<?php
$url = Array('http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Zachodniopomorskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Pomorskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Mazowieckie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Dolno%C5%9Bl%C4%85skie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Warmi%C5%84sko-Mazurskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Podkarpackie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Kujawsko-Pomorskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Lubuskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Lubelskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Wielkopolskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22%C5%9Al%C4%85skie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Podlaskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Opolskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22Ma%C5%82opolskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22%C5%81%C3%B3dzkie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/',
    'http://www.pkt.pl/firmy/Wojew%C3%B3dztwo%3A%22%C5%9Awi%C4%99tokrzyskie%22/q_bran%C5%BCa%3A%22Kultura%2C+sztuka+-+o%C5%9Brodki%22/1/' );

$regions = Array("zachodniopomorskie",
"pomorskie",
"mazowieckie",
"dolnośląskie",
"warmińsko-mazurskie",
"podkarpackie",
"kujawsko-pomorskie",
"lubuskie",
"lubelskie",
"wielkopolskie",
"śląskie",
"podlaskie",
"opolskie",
"małopolskie",
"łódzkie",
"świętokrzyskie");

//header('Content-Type: text/html; charset=utf-8');
require_once('simple_html_dom.php');
require_once('config.php');
$models = Doctrine_Core::loadModels('models');
//$text = file_get_contents($url);

function scraping_PKT($url,$region) {
    // create HTML DOM
    $html = file_get_html($url);
    $ret=Array();
    // get title
   // $ret['title'] = $html->find('title', 0)->innertext;

    /*
     $ret['name'] =$html->find('a[class="fn openPreview"]',1)->innertext;
     $ret['zip'] =$html->find('span[class="postal-code"]',1)->innertext;
     $ret['city'] =$html->find('span[class="locality"]',1)->innertext;
     $ret['street'] =$html->find('span[class="street-address"]',1)->innertext;
     $ret['tel'] =$html->find('p[class="tel"]',1)->innertext;
     $ret['email'] =$html->find('p[class="email"]',1)->innertext;
     $ret['www'] =$html->find('p[class="url"]',1)->innertext;
     $ret['slogan'] =$html->find('div[class="slogan"]',1)->innertext;
*/


    //$ret['record'] =$html->find('h2') ;


    foreach($html->find('td[class="vcard"]')  as $element){
    $block=str_get_html($element->innertext);

    $house = new House();
    $house->name=$block->find('a[class="fn openPreview"]',0)->innertext;
    $house->zipCode=$block->find('span[class="postal-code"]',0)->innertext;
    $house->city=$block->find('span[class="locality"]',0)->innertext;
    $house->street=$block->find('span[class="street-address"]',0)->innertext;
    $house->tel=$block->find('p[class="tel"]',0)->innertext;
    $tmp = $block->find('p[class="email"]');
    if (!empty ($tmp))
    $house->email=$tmp[0]->find('a',0)->innertext;

    $tmp = $block->find('p[class="url"]');
    if (!empty ($tmp))
    $house->www=$tmp[0]->find('a',0)->innertext;
    
    $house->slogan=$block->find('div[class="slogan"]',0)->plaintext;
    $house->region=$region;
    $house->save();
    print 'Zapisano: '.$house->name .' '.$house->city ."\n";

    //echo $house->name .'<br>';
   // str_get_html($block)->find('a[class="fn openPreview"]',0)->innertext;
    //array_push ($ret, Array('name'=>str_get_html($element->innertext)->find('a[class="fn openPreview"]',0)->innertext));
    $block->clear();
    //unset($block);
    $house->free();
    }
    
    

    //$next = $html->find('li[class="nextLink"]',0)->innertext;
    //$link=str_get_html($next)->find('a',0)->href;
    
    // get rating
   // $ret['Rating'] = $html->find('div[class="general rating"] b', 0)->innertext;

    // get overview
    /*foreach($html->find('div[class="info"]') as $div) {
        // skip user comments
        if($div->find('h5', 0)->innertext=='User Comments:')
            return $ret;

        $key = '';
        $val = '';

        foreach($div->find('*') as $node) {
            if ($node->tag=='h5')
                $key = $node->plaintext;

            if ($node->tag=='a' && $node->plaintext!='more')
                $val .= trim(str_replace("\n", '', $node->plaintext));

            if ($node->tag=='text')
                $val .= trim(str_replace("\n", '', $node->plaintext));
        }

        $ret[$key] = $val;
    }*/

    $next = $html->find('li[class="nextLink"]');
    if (!empty ($next))
    $link =  $next[0]->find('a',0)->href;
    else $link = "";

    // clean up memory
    $html->clear();
    unset($html);
    
    return $link;
}


// -----------------------------------------------------------------------------
// test it!

for ($i=0; $i<16; $i++) {
    $j=1;
    print 'Wojewodztwo: '. $regions[$i] . ' Strona '.$j."\n";
    $ret = scraping_PKT($url[$i],$i+1);
    
    while ($ret != '') {

/*echo "Czy przetworzyc nastepna strone? y/n ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'y'){
    echo "ABORTING!\n";
    exit;
}
echo "\n";
echo "...\n";
*/

    $j++;
    print "Strona: ".$j ."\n";
    $ret = scraping_PKT($ret,$i+1);
    
}
    
}


//foreach($ret as $k=>$v)
  //  echo '<strong>'.$k.' </strong>'.$v.'<br>';


// parse emails

/* if (!empty($text)) {
  $res = preg_match_all(
    "/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
    $text,
    $matches
  );

  if ($res) {
    foreach(array_unique($matches[0]) as $email) {
      echo $email . "<br />";
    }
  }
  else {
    echo "No emails found.";
  }
}*/

?>
