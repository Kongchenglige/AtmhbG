<?php
//$commands[3] 可供选择项
if(empty($_SESSION['item']['Cursed_doll'])){
    //初次游玩 
    echo '判定中...判定失败';
    $_SESSION['item']['Cursed_doll']['played'] = true;
}else{
    if($_SESSION['item']['Cursed_doll']['colddown'] > time()){
       $colddown =  $_SESSION['item']['Cursed_doll']['colddown'] - time();
        theexit('剩余冷却时间: '.$colddown.'s');
    }
    echo '判定中...判定成功'.PHP_EOL;
    echo '物品名:被诅咒的玩偶'.PHP_EOL;
    echo '物品描述:*******************(编不下去)'.PHP_EOL;
    echo '[系统]物品当前将暂时无法使用.';
    $_SESSION['item']['Cursed_doll']['colddown'] = time() + 60;
}

//$Inv_add = $canfisheditems[$itemrd];
//include_once('data/addinventory.php');
exit();