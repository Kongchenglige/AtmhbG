<?php
echo 1;
$pluginsisload = true;


if(!$isglobaladmin){
	if(!$isgroupadmin){
		theexit('void');
	}
}

if($isgroupadmin){
	$userpremission = '组管理员';
	$cando = '	未指派<br>	';
}
if ($isglobaladmin) {
	$userpremission = '全局管理员';
	$cando = '	';
	foreach($plugins as $ltmp){
		$cando = $cando.$ltmp.'<br>	';
	}
	unset($ltmp);
}

echo 't';
switch ($commands[1]) {
	case 'help':
		echo '这是管理员的帮助菜单';
		break;
	case 'info':
		echo '您是 '.$userpremission.'<br>';
		echo '您可以使用:<br>';
		echo $cando;
		break;
	case 'settx':
		theexit("cmd:settx");
		break;
	/*case 'user':
		if($commands[2] == 'add') {
				echo 'add';
		}elseif ($commands[2] == 'del') {
				echo 'del';
		}
		break;
	*/
	case 'debug':
		print_r($commands);
		theexit('');
		break;
	default:
		theexit('void');
		break;
}
theexit('');