<?php
/*
用$Inv_add变量输入数组
*/
//读入背包
$inventory = json_decode(file_get_contents('users/'.$sender.'/inventory.json'),true);
//物品添加状态
$inv_isadd = false;
//查一下有没有这个物品
foreach ($inventory as $tmp_addinv_1=>$tmp_addinv_2){
    //有物品
    if($tmp_addinv_2['name'] == $Inv_add['name']){
        //给物品数量+1
        $tmp_addinv_3 = $inventory[$tmp_addinv_1]['count'] + 1;
        $inventory[$tmp_addinv_1]['count'] = $tmp_addinv_3;
        //物品添加状态 为 真
        $inv_isadd = true;
    }
}
//删掉临时变量
unset($tmp_addinv_1,$tmp_addinv_2,$tmp_addinv_3);
//没物品
if(!$inv_isadd){
    //加一个进去
    $Inv_add['count'] = 1;
    array_push($inventory,$Inv_add);
}
file_put_contents('users/'.$sender.'/inventory.json',json_encode($inventory));