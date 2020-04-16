<?php

$pluginsisload = true;

$table = array('f','Z','o','d','R','9','X','Q','D','S','U','m','2','1','y','C','k','r','6','z','B','q','i','v','e','Y','a','h','8','b','t','4','x','s','W','p','H','n','J','E','7','j','L','5','V','G','3','g','u','M','T','K','N','P','A','w','c','F');
$tr = array();

for ($i=0; $i<=57; $i++){
	$tr[$table[$i]] = $i;
}

$s = array(11,10,3,8,4,6);
$xor = 177451812;
$add = 8728348608;

function dec($x){
	global $table,$tr,$s,$xor,$add;
	$r = 0;
	for ($i=0; $i<=5; $i++){
		$r+=$tr[$x[$s[$i]]]*58**$i;
	}
	return(($r - $add) ^ $xor);
}

function enc($x){
	if(!is_numeric($x)){
		return('[Bav]只输入数字');
	}
	
	global $table,$tr,$s,$xor,$add;
	$x = ($x ^ $xor) + $add;
	$r = array('B','V','1',' ',' ','4',' ','1',' ','7',' ',' ');
	for ($i=0; $i<=5; $i++){
		$r[$s[$i]] = $table[floor($x/58**$i)%58];
	}
	
	$tmp ='';
	
	foreach($r as $value){
		$tmp = $tmp.$value;
	}
	return($tmp);
}

if($commands[1] == 'toav') {
	echo dec($commands[2]);
	theexit('');
}elseif ($commands[1] == 'tobv') {
	echo enc($commands[2]);
	theexit('');
}
