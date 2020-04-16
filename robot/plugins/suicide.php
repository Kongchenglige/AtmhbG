<?php
$pluginsisload = true;
	
$qqinfo = json_decode(file_get_contents('https://api.toubiec.cn/qq?qq='.$sender),true);

echo $qqinfo['name'].' 结束了他自己的生命.';
theexit('');