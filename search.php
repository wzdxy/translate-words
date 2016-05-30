<?php
class Translate{
    var $props=array();
    var $means=array();
    public function addProps($p)
    {
        array_push($this->props,$p);
    }    
    public function addAcceptation($a)
    {
        array_push($this->means,$a);
    }
}
class Airticle{
    var $words=array();
    var $sentences=array();    
    var $translations=array();
    var $text="";
    public function getWords()
    {        
        $this->sentences=explode(".",$this->text);
        print_r($this->sentences);
        foreach ($this->sentences as $key => $value) {
            var_dump($value);
            if($value!=''){
                array_push($this->words,explode(" ",$value));    
            }            
        }
    }
    public function getTranslations()
    {
        foreach ($this->words as $key => $value) {
            foreach ($value as $key => $aword) {
                $xml=$this->requireApi($aword);
                print_r($xml);
            }
        }
    }
    
    public function requireApi($word){
        $key="60351920E1FA715DE11FBF918DEDF4FB";
        $url="http://dict-co.iciba.com/api/dictionary.php?w=".$word."&key=".$key;
        if ($word) {
            $xml=simplexml_load_file($url);
            return $xml;    
        }else{
            return 0;
        }
    }
}
$texts=$_POST["airticle-texts"];
$airt=new Airticle;
$airt->text=$texts;
$airt->getWords();
var_dump($airt->words);
$airt->getTranslations();
return 0;
$key="60351920E1FA715DE11FBF918DEDF4FB";
$url="http://dict-co.iciba.com/api/dictionary.php?w=".$word."&key=".$key;
//var_dump($url);
// $r = file_get_contents($url);
// $xml=simplexml_load_file($r);
$xml=simplexml_load_file($url);
$tran=new Translate;
//var_dump($tran);
foreach ($xml->pos as $key => $value) {
    $tran->addProps($value);
}
foreach ($xml->acceptation as $key => $value) {
    $tran->addAcceptation($value);
}
//var_dump($tran);
print_r($tran);
print($tran->means[1]);
?>