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
    var $enWords=array();
    var $enSentences=array();
    var $cnWords=array();
    
    
    var $translations=array();
    var $text="";
    var $responses="";
    public function getWords()
    {        
        $this->enSentences=explode(".",$this->text);
        //print_r($this->enSentences);
        foreach ($this->enSentences as $key => $value) {
            //var_dump($value);
            if($value!=''){
                array_push($this->enWords,explode(" ",$value));    
            }            
        }
    }
    public function getTranslations()
    {
        //遍历句子数组，获得单句
        foreach ($this->enWords as $key => $value) {
            $cnSentences=array();
            //遍历句子，逐词翻译
            foreach ($value as $key => $aword) {
                $xml=$this->requireApi(strtolower($aword));                
                $r=array($aword,$xml->pos,$xml->acceptation);       //将结果编成数组
                array_push($cnSentences,$r);                    //写入最终数据
                //print_r($xml->pos);
                //print_r($xml->acceptation);
                //print($aword."___________+__++_+++_++_+_+");
            }
            array_push($this->translations,$cnSentences);
            //print_r($this->translations);
        }
        foreach ($this->translations as $key => $sentence) {
            $sentenceItem='<div class="sentence">';
            foreach ($sentence as $key => $word) {
                //$wordItem='<ul class="worditem"><li class="enwords">'.$word[0].'</li>';
                $wordItem='<ul class="worditem"><li class="enwords">'.$word[0].'</li>';
                $wordItem.='<li class="minen">'.'<em>'.$word[1][0].'</em>  '.explode('；',$word[2][0])[0].'</li>';
                for ($i=0; $i < count($word[1]); $i++) {                     
                    $wordItem.='<li class="cnwords cnwords'.$i.'">'.'<em>'.$word[1][$i].'</em>'.' '.$word[2][$i].'</li>';
                    //print_r(explode('；',$word[2][$i])[0]);
                    //$wordItem.='<li class="cnwords cnwords'.$i.'">'.'<em>'.$word[1][$i].'</em>'.' '.'<span class="minen">'.explode($word[1][$i],'；')[0].'</span><span class="allen">'.$word[2][$i].'<span></li>';
                }
                $wordItem.='</ul>';
                //print_r('我是worditem:'.$wordItem.'</br>');
                $sentenceItem.=$wordItem;
            }
            $sentenceItem.='<div class="clear"></div></div>';
            $this->responses.=$sentenceItem;                                     
        }                
        echo $this->responses;
        //print_r( $this->translations );
        
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
//var_dump($airt->cnwords);
$airt->getTranslations();
// return 0;
// $key="60351920E1FA715DE11FBF918DEDF4FB";
// $url="http://dict-co.iciba.com/api/dictionary.php?w=".$word."&key=".$key;
// //var_dump($url);
// // $r = file_get_contents($url);
// // $xml=simplexml_load_file($r);
// $xml=simplexml_load_file($url);
// $tran=new Translate;
// //var_dump($tran);
// foreach ($xml->pos as $key => $value) {
//     $tran->addProps($value);
// }
// foreach ($xml->acceptation as $key => $value) {
//     $tran->addAcceptation($value);
// }
// //var_dump($tran);
// print_r($tran);
// print($tran->means[1]);
?>