<?php
require_once('require/header.php');

$动画 = $_GET['p'];
if(is_null($动画)){
	$邀踢动画->错误('请输入影片页面或动画编号');
}
if(intval($动画) / pow(10, strlen($动画)) < 0.1){
	//不是数字，查询该动画的编号
	按地址查询动画(trim($动画));
	
}


//读取数据库
$动画编号 = intval($动画);
//$语句 = "SELECT 源页面,投递人,添加时间,播放数,标题,说明,
//			(SELECT COUNT(编号) FROM 弹幕 WHERE 动画编号=动画.编号) AS 弹幕数 
//			FROM 动画 WHERE 编号=$动画编号";
$语句 = "SELECT sourcepage,postername,addtime,hits,title,description,
			(SELECT COUNT(id) FROM popsub WHERE id=video.id) AS popsub_count
			FROM video WHERE id=$动画编号";
$结果 = $数据库->查询($语句);
if(!$结果) $邀踢动画->错误("编号为 $动画编号 的动画不存在，可能已经被和谐了");

//==========！简单地增加播放数，这个以后要修改，现在只是为了好看
$语句 = "UPDATE video SET hits=hits+1 WHERE id=$动画编号";
$数据库->查询($语句);
//==========！简单地增加播放数，这个以后要修改，现在只是为了好看

$动画标题 = htmlspecialchars($结果[0]['title']);
$投递人 = htmlspecialchars($结果[0]['postername']);
$投递时间 = date('Y-n-j G:i:s', $结果[0]['addtime']);
$播放数 = $结果[0]['hits'];
$弹幕数 = $结果[0]['popsub_count'];
$来源页面 = $源页面 = $结果[0]['sourcepage'];

//判断来源网站
$语句 = 'SELECT sitename,domain FROM source_site';
$源网站集合 = $数据库->查询($语句);
for($i = 0; $i < count($源网站集合); $i++){
	if(strpos($源页面, $源网站集合[$i]['domain'])){
		$来源网站 = $源网站集合[$i]['sitename'];
	}
}

输出页面();

//=========================

function 按地址查询动画($源页面){
	global $邀踢动画;
	global $数据库;

	$语句 = "SELECT id FROM video WHERE sourcepage='" . $数据库->查询语句转义($源页面) . "'";
	$结果 = $数据库->查询($语句);

	if(!$结果){
		$结果 = $邀踢动画->新建动画数据('', '', $源页面, '');
		if(!$结果) $邀踢动画->错误('这个影片不能播放');
	}
	else{
		$结果 = $数据库->查询($语句);
	}

	header('Location: /dh' . $结果[0]['id']);
	exit();
}


function 输出页面(){
	global $动画编号;
	global $动画标题;
	global $投递人;
	global $投递时间;
	global $播放数;
	global $弹幕数;
	global $来源网站;
	global $来源页面;

	$输出 = ytp_file_get_contents('模板/播放.html');
	$输出 = str_replace('{$动画编号}', $动画编号, $输出);
	$输出 = str_replace('{$动画标题}', $动画标题, $输出);
	$输出 = str_replace('{$投递人}', $投递人, $输出);
	$输出 = str_replace('{$投递时间}', $投递时间, $输出);
	$输出 = str_replace('{$播放数}', $播放数, $输出);
	$输出 = str_replace('{$弹幕数}', $弹幕数, $输出);
	$输出 = str_replace('{$来源网站}', $来源网站, $输出);
	$输出 = str_replace('{$来源页面}', $来源页面, $输出);
	//$输出 = mb_convert_encoding($输出, 'utf-8', 'gbk');
	//ob_clean();
	//header('Content-Type: xml/xhtml; charset=gb2312');
	echo $输出;
}

?>