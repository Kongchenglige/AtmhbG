<?php
$pluginsisload = true;
if($isgroupadmin){
	$userpremission = '组管理员';
}
if ($isglobaladmin) {
	$userpremission = '全局管理员';
}
if(!$isglobaladmin){
	if(!$isgroupadmin){
		$userpremission = '用户';
	}
}
theexit('亲爱的'.$userpremission.'哟<br>你要的是搞好事呢<br>还是搞坏事呢<br>还是搞红石呢');