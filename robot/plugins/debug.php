<?php
$pluginsisload = true;

if(!$isglobaladmin){
		theexit('void');
}

echo '函数载入成功<br>';
echo '使用者:'.$sender.'<br>';
echo '是否为全局管理员:'.$isglobaladmin.PHP_EOL;
echo '是否为组管理员:'.$isgroupadmin.PHP_EOL;
echo '来源群:'.$group.'<br>';
if($isglobaladmin){
	echo '脚本起始于:'.$time_start.PHP_EOL;
	echo '原始信息:<br>';
	print_r($commands);
	echo '该条指令位于:';
	echo $backcout;
	echo PHP_EOL;
	echo '本群组拥有的权限:';
	echo $group_premission;
	echo PHP_EOL;
	echo '已安装的插件:'.PHP_EOL;
	print_r($plugins);
}
theexit('');