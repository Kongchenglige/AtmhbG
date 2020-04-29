<?php
$pluginsisload = true;
echo '可用命令:<br>';
$plugin_can_use = explode(',',$group_premission);
foreach ($plugin_can_use as $k => $tmp){
    if($k == 0){
        echo '  '.$tmp;
    }else{
        echo PHP_EOL.'  '.$tmp;
    }
}
theexit('');