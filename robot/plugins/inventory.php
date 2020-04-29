<?php
$pluginsisload = true;
$inventory = json_decode(file_get_contents('users/'.$sender.'/inventory.json'),true);

if($commands[1] == 'help'){
    echo '可用命令:<br>  list<br>  info<br>  use';
    theexit('');
}elseif ($commands[1] == 'list') {
    echo $QQname.' 的库存:'.PHP_EOL;
    foreach ($inventory as $tmp_inv_1=>$tmp_inv_2){
        echo $tmp_inv_1.'.'.$tmp_inv_2['name'].' ('.$tmp_inv_2['rare'].') x'.$tmp_inv_2['count'].PHP_EOL;
    }
    echo '输入/inventory info <物品ID> 查看物品描述<br>';
    exit();
}elseif($commands[1] == 'info'){
    
    if(empty($inventory[$commands[2]])){
        exit('物品不存在');
    }
    
    echo '物品名称:'.$inventory[$commands[2]]['name'].PHP_EOL;
    echo '稀有度:'.$inventory[$commands[2]]['rare'].PHP_EOL;
    echo '物品描述:'.$inventory[$commands[2]]['display'];
    exit();
}elseif($commands[1] == 'use'){
    
    if(empty($inventory[$commands[2]])){
        exit('物品不存在');
    }
    
    if(!file_exists('data/itemaction/'.$inventory[$commands[2]]['name'].'.php')){
        theexit('物品 '.$inventory[$commands[2]]['name'].' 无法被使用');
    }
    echo $QQname.' 使用了物品 '.$inventory[$commands[2]]['name'].PHP_EOL;
    include_once('data/itemaction/'.$inventory[$commands[2]]['name'].'.php');
}