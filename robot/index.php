<?php
header('Content-Type: text/html; charset=utf-8');//输出头,虽然说反而坑的还得转换一次吧
//error_reporting(0);//不输出报错

function microtime_float()//脚本启动时间计算
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();//开始时间保存

function theexit($input){
	global $time_start;
	if($input == 'void'){
		exit('cmd:void');
	}else{
	if(!empty($input)){
		exit($input);
	}
	$time_end = microtime_float();
	$time = $time_end - $time_start;

	echo "<br>脚本运行了 $time 秒";
	exit();
}}

//暂停业务
//exit('void');

//预处理部分

if(empty($_GET)){//是否为空输入
	header('HTTP/1.1 404 Not Found');
	exit(file_get_contents('404b.txt'));
	//没东西找我干啥,404丢给你!
}

$sender = $_GET['fromQQ'];//转换变量
$msg = base64_decode($_GET['msg']);//解个码

if(isset($_GET['fromG'])){//是否为群组信息
	$group = $_GET['fromG'];
	$isgroup = true;//置个判断用的变量
}else{
	$group = '';
	$isgroup = false;//同上
}

if($msg == ''){//空信息退出 输入为"/"
	theexit('void');//void不发送消息
}

$commands = explode(' ',$msg);//切割输入 把输入的指令切开

//莫名其妙的BUG,最后会附带一个换行符?,这里修复一下

foreach ($commands as $key => $value) {
    $cmd_last_type = base64_encode(substr($commands[$key],strlen($commands[$key])-1,1));//切了最后一个字符
	if($cmd_last_type == 'AA=='){//妈个鸡,不知道到底是啥,直接用base64code吧
		$commands[$key] = substr($commands[$key],0,strlen($commands[$key])-1);//切割掉最后一个字符
	}
}


//插件扫描
$plugins_raw = scandir('plugins');
unset($plugins_raw[0],$plugins_raw[1]);
$plugins_pre = array_merge($plugins_raw);
unset($plugins_raw);

foreach($plugins_pre as $key=>$tmp[0]){
	$tmp[1] = explode('.',$tmp[0]);
	$plugins[$key] = $tmp[1][0];
}
unset($tmp,$key,$plugins_pre);

//主要逻辑部分
if($isgroup){//是否为群组信息 如否 切换至私聊发送模式

$globaladmins = json_decode(@file_get_contents('permission/globaladmin.json'),true);

if(is_numeric(array_search($sender,$globaladmins))){//是不是全局管理员
	$isglobaladmin = true;
}else{
	$isglobaladmin = false;
}


$group_premission = json_decode(@file_get_contents('permission/'.$group.'.json'),true);
if(empty($group_premission)){//如果提取不到就是没登记
	theexit('void');
} 
$tmp = $group_premission['permission'];//权限拉出来

$tmp2 = $group_premission['admins'];//管理员也拉出来
if(is_numeric(array_search($sender,$tmp2))){//是不是群管理员
	$isgroupadmin = true;
}else{
	$isgroupadmin = false;
}

unset($group_premission,$tmp2);
$group_premission = $tmp;
unset($tmp);



//匹配一下是不是能用这个指令
$backcout =  array_search($commands[0],explode(',',$group_premission));
//没有或者匹配到的和指令不同就退出
if(!is_numeric($backcout)){
	theexit('cmd:void');
}


//引入插件
@include_once('plugins/'.$commands[0].'.php');

if(!$pluginsisload){//是否成功加载
	echo '指令不存在';
	theexit('');
}


theexit('void');
}else{//私聊部分
echo '抱歉,现在仅支持群组聊天';
theexit('');
}
theexit('void');
//退出