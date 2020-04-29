<?php
$pluginsisload = true;

if(!$isglobaladmin){
	if(!$isgroupadmin){
		theexit('void');
	}
}

if($isgroupadmin){
	$userpremission = '组管理员';
	$cando = '	希腊奶~希腊奶~<br>	';
}
if ($isglobaladmin) {
	$userpremission = '全局管理员';
	$cando = '	';
	foreach($plugins as $ltmp){
		$cando = $cando.$ltmp.'<br>	';
	}
	unset($ltmp);
}

if($commands[1] == 'help'){
	echo '可用指令:<br>  info<br>  settx<br>  debug<br>  ignore<br>  user<br>  list';
	theexit('');
}elseif($commands[1] == 'info'){
	echo '您是 '.$userpremission.'<br>';
	echo '您可以使用:<br>';
	echo $cando;
	theexit('');
}elseif($commands[1] == 'settx'){
	theexit("cmd:settx");
}elseif($commands[1] == 'debug'){
	print_r($commands);
	theexit('');
}elseif($commands[1] == 'ignore'){
    $group_p = json_decode(file_get_contents('./permission/'.$group.'.json'),true);
        $group_p['ignores'][] = $commands[2];
		if(file_put_contents('./permission/'.$group.'.json',json_encode($group_p)) === false){
			echo '出现错误,无法写到权限文件';
		}else{
			echo $commands[2].'已在'.$group.'被无视输入';
		}
	theexit('');
}elseif($commands[1] == 'user'){
	if(!$isglobaladmin){
		theexit('您不是全局管理员,没有权限任命或移除群组管理员');
	}
	if($commands[2] == 'add'){
		$group_p = json_decode(file_get_contents('./permission/'.$group.'.json'),true);
		array_push($group_p['admins'],$commands[3]);
		if(file_put_contents('./permission/'.$group.'.json',json_encode($group_p)) === false){
			echo '出现错误,无法写到权限文件';
		}else{
			echo $commands[3].'已被添加至'.$group.'的组管理员';
		}
		theexit('');
	}elseif($commands[2] == 'del'){
		$group_p = json_decode(file_get_contents('./permission/'.$group.'.json'),true);
		
		$result = array_search($commands[3],$group_p['admins']);
		
		if(!is_numeric($result)){
			theexit('无法移除,用户不存在');
		}else{
			unset($group_p['admins'][$result]);
			if(file_put_contents('./permission/'.$group.'.json',json_encode($group_p)) === false){
				echo '出现错误,无法写到权限文件';
			}else{
				echo $commands[3].'已被移除'.$group.'的组管理员权限';
			}
		}
		theexit('');
	}
	theexit('');
}elseif($commands[1] == 'list'){
	$group_p = json_decode(file_get_contents('./permission/'.$group.'.json'),true);
	echo '当前群组可用的管理员有:<br>';
	foreach($group_p['admins'] as $ltmp){
		echo '	'.$ltmp.'<br>';
	}
	unset($ltmp);
	theexit('');
}elseif($commands[1] == 'session'){
	echo 'seesion ID:'.session_id().PHP_EOL;
	var_dump($_SESSION);
	theexit('');
}
theexit('cmd:void');