<?php

/*==========> INFO 
 * CODE     : BY ZLAXTERT
 * SCRIPT   : HASH CRACK
 * VERSION  : 4.0
 * TELEGRAM : t.me/zlaxtert
 * BY       : DARKXCODE
 */

//========> REQUIRE

require_once "function/function.php";
require_once "function/gangbang.php";
require_once "function/threesome.php";

//========> BANNER

echo banner();
echo banner2();

//========> GET FILE

enterlist:
echo "$WH [$GR+$WH] Your file ($YL example.txt $WH) $GR>> $BL";
$listname = trim(fgets(STDIN));
if(empty($listname) || !file_exists($listname)) {
	echo PHP_EOL.PHP_EOL."$WH [$YL!$WH] $RD FILE NOT FOUND$WH [$YL!$WH]$DEF".PHP_EOL.PHP_EOL;
	goto enterlist;
}
$lists = array_unique(explode("\n",str_replace("\r","",file_get_contents($listname))));

//=========> TYPE

type:
echo "
      $WH [$GR+$WH] TYPE [$GR+$WH]
 [$GR 1 $WH] MD2     [$GR 2 $WH] MD4
 [$GR 3 $WH] MD5     [$GR 4 $WH] SHA1

CHOOSE $GR>> $BL";
$type_chose = trim(fgets(STDIN));
if($type_chose == 1){
    $type = 'md2';
}else if($type_chose == 2){
    $type = 'md4';
}else if($type_chose == 3){
    $type = 'md5';
}else if($type_chose == 4){
    $type = 'sha1';
}else{
    echo PHP_EOL.PHP_EOL."$WH [$YL!$WH]$RD TYPE NOT FOUND ($WH TYPE MAX 4 $RD)$WH [$YL!$WH]$DEF".PHP_EOL.PHP_EOL;
    goto type;
}

//=========> GATE

gate:
echo "$WH [$GR+$WH] Gate ($YL Gate1 , Gate2, Gate3 $WH) $GR>> $BL";
$gate = trim(fgets(STDIN));
if($gate > 3){
    echo PHP_EOL.PHP_EOL."$WH [$YL!$WH]$RD GATE NOT FOUND ($WH GATE MAX 3 $RD)$WH [$YL!$WH]$DEF".PHP_EOL.PHP_EOL;
    goto gate;
}


//=========> COUNT

$l = 0;
$d = 0;
$no = 0;
$total = count($lists);
echo "\n\n$WH [$YL!$WH] TOTAL $GR$total$WH LISTS [$YL!$WH]$DEF\n\n";


foreach($lists as $list){
    $no++;
    // EXPLODE
    if(strpos($list, "|") !== false) list($email, $pass) = explode("|", $list);
	else if(strpos($list, ":") !== false) list($email, $pass) = explode(":", $list);
	else $email = $list;
    $email = str_replace(" ", "", $email);
    //API
    $api = "https://darkxcode.com/checker/hash_crack/api.php?submit=1&type=unhash&gate=$gate&unhash=$type&apikey=BNDT-2803654-FREE&list=".$list;
    //CURL
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    //RESPONSE
    $js = json_decode($response, true);
    $stat = $js['data']['status'];
    $type_hash = $js['data']['type'];
    $ress = $js['data']['result'];
    $msg = $js['data']['msg'];
    $jam = Jam();

        //============> COLLOR
        $BL   = collorLine("BL");
        $RD   = collorLine("RD");
        $GR   = collorLine("GR");
        $YL   = collorLine("YL");
        $MG   = collorLine("MG");
        $DEF  = collorLine("DEF");
        $CY   = collorLine("CY");
        $WH   = collorLine("WH");
    
        echo "$WH [$RD$no$DEF/$GR$total$DEF$WH][$YL$jam$WH]";
    if(strpos($response,'"status":"success"')){
        $l++;
        save_file("result/success.txt",$ress);
        echo "$GR LIVE$DEF |$BL ".$ress."$WH [$DEF STATUS:$GR $stat$WH ] [$DEF TYPE:$MG $type_hash$WH ] [$DEF MSG:$YL $msg$WH ] $DEF|";
    }else{
        $d++;
        save_file("result/failed.txt",$list);
        echo "$RD FAILED$DEF |$BL ".$list."$WH [$DEF STATUS:$RD failed$WH ] $DEF|";
    }
    echo "$YL BY $CY./DARKXCODE$WH V.4.0$DEF";
    echo PHP_EOL;

}


//============> END

echo PHP_EOL;
echo "================[DONE]================".PHP_EOL;
echo " DATE          : ".$date.PHP_EOL;
echo " LIVE          : ".$l.PHP_EOL;
echo " DIE           : ".$d.PHP_EOL;
echo " TOTAL         : ".$total.PHP_EOL;
echo "======================================".PHP_EOL;
echo "[+] RATIO VALID => $GR".round(RatioCheck($l, $total))."%$DEF".PHP_EOL.PHP_EOL;
echo "[!] NOTE : CHECK AGAIN FILE 'unknown.txt' and 'error.txt' [!]".PHP_EOL;
echo "This file '".$listname."'".PHP_EOL;
echo "File saved in folder 'result/' ".PHP_EOL.PHP_EOL;

// ==========> FUNCTION

function collorLine($col){
    $data = array(
        "GR" => "\e[32;1m",
        "RD" => "\e[31;1m",
        "BL" => "\e[34;1m",
        "YL" => "\e[33;1m",
        "CY" => "\e[36;1m",
        "MG" => "\e[35;1m",
        "WH" => "\e[37;1m",
        "DEF" => "\e[0m"
    );
    $collor = $data[$col];
    return $collor;
}

?>
