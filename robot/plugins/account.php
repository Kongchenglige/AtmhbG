<?php
$pluginsisload = true;

if(!file_exists('users/'.$sender.'.json')){
	echo '您尚未绑定 IaSoC 账户,请先绑定!';
	theexit('');
}
//先拉出来备用
$useraccountinfo = json_decode(file_get_contents('users/'.$sender.'.json'),true);

if($commands[1] == 'info'){
	
	$qqinfo = json_decode(file_get_contents('https://api.toubiec.cn/qq?qq='.$sender),true);

	echo '亲爱的 '.$qqinfo['name'].'('.$sender.') 您好:'.PHP_EOL;
	echo '昵称: '.$useraccountinfo['username'].PHP_EOL;
	echo '您的权限:'.$useraccountinfo['level'].'级('.$useraccountinfo['rank'].')'.PHP_EOL;
}elseif ($commands[1] == 'getglobalaccess') {
	if($useraccountinfo['level'] !== '8'){
		echo '权限不足,执行最低需要 8 级权限';
	}else{
		
		if($isglobaladmin){
			echo '您已经是全局管理员了';
			theexit('');
		}
		
		//载入全局管理员组
		$global_admin = json_decode(file_get_contents('./permission/globaladmin.json'),true);
		//插入当前执行者
		array_push($global_admin,$sender);
		//重新编码为json并写入
		if(file_put_contents('./permission/globaladmin.json',json_encode($global_admin)) === false){
			echo '出现错误,无法写到权限文件';
		}else{
			echo '您已被提升至全局管理员';
		}
		theexit('');
	}
}elseif ($commands[1] == 'getgroupaccess') {
	if($useraccountinfo['level'] < '7'){
		echo '权限不足,执行最低需要 7 级权限';
	}else{
		
		if($isgroupadmin){
			echo '您已经是组管理员了';
			theexit('');
		}
		
		//载入全局管理员组
		$group_p = json_decode(file_get_contents('./permission/'.$group.'.json'),true);
		//插入当前执行者
		array_push($group_p['admins'],$sender);
		//重新编码为json并写入
		if(file_put_contents('./permission/'.$group.'.json',json_encode($group_p)) === false){
			echo '出现错误,无法写到权限文件';
		}else{
			echo '您已被授予组管理员权限';
		}
		theexit('');
	}
}


theexit('');