<?php
header('Content-Type: text/html; charset=utf-8');
// AES-256-CFB 加密类
class AES {
    public function encrypt($str, $localIV, $encryptKey) {
        return openssl_encrypt($str, 'AES-256-CFB', $encryptKey, 0, $localIV);
    }
    public function decrypt($str, $localIV, $encryptKey) {
        return openssl_decrypt($str, 'AES-256-CFB', $encryptKey, 0, $localIV);
    }
}
//随机字符串
function randomkeys($length){   
   $output='';   
   for ($a = 0; $a<$length; $a++) {   
       $output .= chr(mt_rand(33, 126));    //生成php随机数   
    }   
    return $output;   
}   

//随机一个key
$random_key = md5(sha1(md5(microtime()).sha1(randomkeys(32)).microtime().md5(mt_rand())).randomkeys(32));

$aes = new AES();

//提交了key
if(isset($_GET['key'])){
//解出来key和filename
$key = json_decode(base64_decode($_GET['key']),true);
//拿出来key作为解密用
$crypt_token = $key['key'];
//取出文件内容并解密
$fileinfo = $aes->decrypt(@file_get_contents('./files/'.$key['filename'].'.file'), substr(md5($crypt_token), 0, 16), $crypt_token);
if(empty($fileinfo)){
	$fileinfo = '信息已被销毁';
}
//销毁文件并删除post变量避免误触发
@unlink('./files/'.$key['filename'].'.file');
unset($_POST['content']);
}

//提交了数据
if(!empty($_POST['content'])){
	//定义秘钥
	$crypt_token = $random_key;
	//随机个名字出去
	$filename = md5(randomkeys(128));
	//加个密,写入
	file_put_contents('./files/'.$filename.'.file',$aes->encrypt($_POST['content'], substr(md5($crypt_token), 0, 16), $crypt_token));
	//把文件名和秘钥改成json然后变base64
	$display_info = base64_encode(
		json_encode(
			array(//key结构
				'filename' => $filename,
				'key' => $crypt_token
			)
		)
	);
}
?>
<html lang="zh">
<head>
<meta charset="UTF-8">
<title>阅后即焚</title>
<style>
.container {
  width: 310px;
  margin: 100px auto;
}
.contain{
	margin: 30px auto;
	padding: 18px 20px;
	width: 240px auto;
	font-family: Arial, Verdana;
	font-size: 16px;
	line-height: 18px;
	border-radius: 6px;
	border: 1px solid rgba(0,0,0,0.3);
	box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	background: #ffffff;
}
.title {
	display: block;
	width: 290px;
	height: 60px;
	margin: 10px 0;
    padding: 0 10px;
	border:1px solid #c8cccf;
	border-radius: 5px;
	padding: 0 10px;
	outline: none;
	background: white;
	color: #6a6f77;
	font-size: 10 auto;
}
input {
  display: block;
  width: 310px;
  line-height: 40px;
  margin: 10px 0;
  padding: 0 10px;
  outline: none;
  border:1px solid #c8cccf;
  border-radius: 4px;
  color:#6a6f77;
}
#msg {
  width: 100%;
  line-height: 40px;
  font-size: 14px;
  text-align: center;
}
a:link,a:visited,a:hover,a:active {
  margin-left: 100px;
  color: #0366D6;
}
body{
	background-image: url('77233542_p0.jpg');
	background-repeat:no-repeat;
	background-size:100% 100%;
	-moz-background-size:100% 100%;
}
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #1F4788;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 10px;
  padding: 20px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
  position: relative;
  text-align: center;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '»';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
.bottom{
	clear:both;
	margin:10px auto;
	text-align:center;
	padding:10px 0;
	line-height:25px;
	color:#666;
	position:absolute;
	bottom: 0px;
	border-top:#ddd 1px solid;
}
#editor {
    max-height: 250px;
    height: 200px;
    font-size: 25px;
    line-height: 25px;
    background-color: white;
    border-collapse: separate;
    border: 1px solid rgb(204, 204, 204);
    outline: none;
}
.infodisplay{
	margin: 100px auto;
	padding: 18px 20px;
	width: 510px;
	height: auto;
	color: black;
	font-family: Arial, Verdana;
	font-size: 16px;
	line-height: 18px;
	border-radius: 6px;
	border: 1px solid rgba(0,0,0,0.3);
	box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	background: #ffffff;
}
</style>
</head>
<body>
<!-- 背景图: https://www.pixiv.net/artworks/77233542-->
<div class="container">
<br><br>
<h2 style="text-align:center;color:#1F4788;"><?php
//显示标题
if(isset($display_info)){
	echo '创建完成';
}elseif (!isset($display_info) and !isset($_GET['key'])) {
	echo '创建内容';
}elseif(isset($fileinfo)){
	echo '文件内容';
}
echo '</h2>
<br>';

if(isset($display_info)){
	echo '<div>
	<p style="text-align:center;color:#1F4788;">您的URL:</p>
	<input value="'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?key='.$display_info.'" />
</div>';
}

if(isset($fileinfo)){
	
	echo '<span class="infodisplay" readonly="readonly">'.htmlspecialchars($fileinfo).'</span>';
}

if (!isset($display_info) and !isset($_GET['key'])) {
	echo '<form action="" method="POST" style="display:inline" autocomplete="off">

<textarea name="content" placeholder="请输入" id="editor" class="form-control" style="margin: 0px; height: 164px; width: 309px;border-radius:5px;resize:none"></textarea>

<br><br>
<input type="submit" style="" value="提交">
</form>';
}
?>
<br><br>
</div>
<div class="bottom">
Powered by IaSoC Studio<br>
Burn after reading
</div>
<div style="text-align: right;position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;cursor: pointer;line-height: 0;display:block;">
这里什么也没
</div>
</body>
</html>