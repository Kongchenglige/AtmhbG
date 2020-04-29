<?php
$canfisheditems = '
{
 "0":{
     "name":"[鱼获]鲈鱼",
     "rare":"N",
     "display":"不是鱼露,是鲈鱼哦"
 },
 "1":{
     "name":"[鱼获]罗非鱼",
     "rare":"N",
     "display":"冷冻罗非鱼有奇效!"
 },
 "2":{
     "name":"[鱼获]河豚",
     "rare":"R",
     "display":"第二律者西琳(笑)"
 },
 "3":{
     "name":"[鱼获]海龙",
     "rare":"SR",
     "display":"金星平原稀有产出物,Warframe天下第..<<!>>网络连接无响应"
 }
}
';
$canfisheditems = json_decode($canfisheditems,true);
if(mt_rand(0,1) == 1){
    //随机物品
    $itemrd = mt_rand(0,1);
}else{
    if(mt_rand(1,10) > 7){
        $itemrd = 3;
    }else{
        $itemrd = 2;
    }
}
//显示提示
echo '恭喜 '.$QQname.' 钓到了 ';
echo $canfisheditems[$itemrd]['name'].' ('.$canfisheditems[$itemrd]['rare'].') !'.PHP_EOL;
echo $canfisheditems[$itemrd]['display'];
$Inv_add = $canfisheditems[$itemrd];
include_once('data/addinventory.php');
exit();