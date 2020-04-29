<?php
$pluginsisload = true;
//最高10连
if($commands[1] > 10){
    theexit('输入值过大');
}
//没配置创建一个
if(!file_exists('users/'.$sender.'/lottery.json')){
   file_put_contents('users/'.$sender.'/lottery.json',json_encode(array('cancount'=>100,'time'=>0)));
}
//取得文件内容
$lottery_count = json_decode(file_get_contents('users/'.$sender.'/lottery.json'),true);
//今天开始的时间戳时间
$time_now = time();
$today_start_time = mktime(0,0,0,date("m",$time_now),date("d",$time_now),date("Y",$time_now));
//已经是昨天的次数了
if($lottery_count['time'] < $today_start_time){
    //给爷看权限
    if(file_exists('users/'.$sender.'/permission.json')){
        //权限拉出来
        $useraccountinfo = json_decode(file_get_contents('users/'.$sender.'/permission.json'),true);
        $tier = $useraccountinfo['level'];
    }else{
        $tier = 1;
    }
    //超级加倍然后重置时间塞回去
   file_put_contents('users/'.$sender.'/lottery.json',json_encode(array('cancount'=>$tier * 100,'time'=>$time_now)));
   //刷新文件内容
   $lottery_count = json_decode(file_get_contents('users/'.$sender.'/lottery.json'),true);
}

if($commands[1] > $lottery_count['cancount']){
    //抽不了
    //还有多少发
    if($lottery_count['cancount'] > 0){
        //减一下
        $tmp_lottery_1 = $commands[1] - $lottery_count['cancount'];
        //负数归正
        $commands[1] = $tmp_lottery_1 * -1;
    }else{
        theexit('您已用尽今日次数');
    }
}

//减去次数
$lottery_count['cancount'] = $lottery_count['cancount'] - $commands[1];
//置入
file_put_contents('users/'.$sender.'/lottery.json',json_encode($lottery_count));

//N,R,SR,SSR,UR
//解码
$items = json_decode(file_get_contents('data/lotteryitems.json'),true);

/*稀有度
    'UR' => 0.001,
    'SSR' => 0.01,
    'SR' => 0.089,
    'R' => 0.4,
    'N' => 0.5
*/

//输出
if($commands[1] == 1){
    echo '恭喜 '.$QQname.' 获得 ';
}else{
    echo '恭喜 '.$QQname.' 获得了:'.PHP_EOL; 
}
for ($x=1; $x<=$commands[1]; $x++) {
    //概率计算
    if(mt_rand(0,1) == 1){//0.5几率
        $itemtype = 'N';
    }else{
        if(mt_rand(1,10) < 5){//0.4几率
            $itemtype = 'R';
        }else{
            if(mt_rand(1,100) < 90){//0.089几率 大概
                $itemtype = 'SR';
            }else{
                if(mt_rand(1,10) > 3){//0.07几率
                    $itemtype = 'SSR';
                }else{
                    if(mt_rand(1,10) == 10){//0.001几率
                        $itemtype = 'UR';
                    }else{//欧极必反
                        $itemtype = 'N';
                    }
                }
            }
        }
    }
    //随机物品
    $itemrd = array_rand($items[$itemtype]);
    if($commands[1] == 1){//单抽出示描述
        echo $items[$itemtype][$itemrd]['name'].' ('.$itemtype.') !'.PHP_EOL;
        echo $items[$itemtype][$itemrd]['display'];
    }else{
        if($x == $commands[1]){
            echo $items[$itemtype][$itemrd]['name'].'('.$itemtype.')';
        }else{
            echo $items[$itemtype][$itemrd]['name'].'('.$itemtype.')'.PHP_EOL;
        }
    }
    $Inv_add = $items[$itemtype][$itemrd];
    $Inv_add['rare'] = $itemtype;
    include('data/addinventory.php');
}
exit();