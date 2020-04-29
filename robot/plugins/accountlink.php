<?php
//这不是给群用的所以不需要设置激活状态
session_start();
define('OPENAPI_TOKEN', md5('187718771877'));    // 你的 token
$aes = new AES();

if(!empty($group)){
	echo '此插件仅供私聊使用';
	theexit('');
}

if(!empty($_SESSION['referer'])){
	unset($_SESSION['referer']);
	$datar = explode('?data=',$_GET['id']);
	$data = json_decode($aes->decrypt($datar[1], substr(md5(OPENAPI_TOKEN), 0, 16), OPENAPI_TOKEN), true);
	$array = array(
		'username' => $data['username'],
		'email' => $data['email'],
		'level' => $data['lvl'],
		'rank' => $data['rank']
		);
	if(file_put_contents('../users/'.$_SESSION['QQ'].'/permission.json',json_encode($array,JSON_UNESCAPED_UNICODE)) === false){
		exit('出现错误');
	}else{
		echo '<h1>绑定账户 '.$data['username'].'('.$data['email'].') 成功</h1>';
	}
	exit();
}

if(isset($_GET['qq']) and isset($_GET['id'])){
	$QQ = $_GET['qq'];
	$pre_id = md5($_GET['qq'].sha1($_GET['qq'].'nmsl').md5(date('Y/m/d/G')));
	if($pre_id == $_GET['id']){
		session_start();
		$_SESSION['QQ'] = $QQ;
		echo '<script>location=\'/openapi/?action=location\'</script>';
	}else{
		exit('校验失败');
	}
}
if(!empty($sender)){
	if(file_exists('users/'.$sender.'.json')){
		echo '您已经绑定了 IaSoC 账户,无需重复绑定!';
		theexit('');
	}
	
	
	if($commands[0] !== 'link'){
		echo '如果您要连接到 IaSoC 账户的话,请输入"/link"指令,我们将会发送一个链接,请打开链接进行登录';
	}elseif($commands[0] == 'link'){
		echo 'https://hydrangea.iasoc.cn:8085/robot/plugins/accountlink.php?qq='.$sender.'&id='.md5($sender.sha1($sender.'nmsl').md5(date('Y/m/d/G')));
	}
}
// AES-256-CFB 加密类
class AES {
    public function encrypt($str, $localIV, $encryptKey) {
        return openssl_encrypt($str, 'AES-256-CFB', $encryptKey, 0, $localIV);
    }
    public function decrypt($str, $localIV, $encryptKey) {
        return openssl_decrypt($str, 'AES-256-CFB', $encryptKey, 0, $localIV);
    }
}