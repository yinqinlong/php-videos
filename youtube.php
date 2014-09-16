<?php
/**
 *预防youtube视频访问不到，手动支持的方式
 */
header("Content-type: text/html; charset=utf-8");
include_once('config.php');
error_reporting(E_ERROR | E_PARSE);
ini_set("max_execution_time", "1800"); 
if (!$_REQUEST['code']) {
	exit('请输入获取的文件内容');	
} 
$code = $_REQUEST['code'];
$url = $_REQUEST['url'];
$site = new youtube($url);
$site->setCode($code);
$downloadUrls = $site->getVideoDownloadUrl();
$title = ($site->title == 'default' && $site->getTitle()) ? $site->getTitle() : $site->title;
if (count($downloadUrls) == 0) {
	//echo "默认的分析器分析失败,将试用flvxz解析\n";	
	//利用外站处理
	$flvSite = new flvxz($url);
	$title = $flvSite->getTitle();
	$downloadUrls = $flvSite->getVideoDownloadUrl();
	if (count($downloadUrls) == 0) {
		exit('无效的视频下载地址,请联系管理员');
	}
}
$download_urls = '';
if (is_array($downloadUrls)) {
	$download_urls = implode(',', $downloadUrls);
} else {
	$download_urls = $downloadUrls;
}
$db = new db();
$data = array(
	'user' => 'qinlong',
	'url' => $url,
	'download_url' => $download_urls,
	'title' => $title,
	'delogo' => $delogo,
	'status' => 0,
	'merge' => 1,
	'coord' => $coord,
	'createtime' => time(),
	);
$table = 'robber';
$condition = array('url' => $url);
$record = $db->table($table)->get($condition);
if ($record) {
	echo $url . '已在数据库记录,当前状态为' . common::getStatus($record['status']) . '<br>';
	if ($record['status'] == 2) {
		echo $record['vms_url'];
	} else {
		echo '下载地址为' . $record['download_url'];
	}
} else {
	$rows = $db->table($table)->insert($data);
	if ($rows) {
		echo '添加成功，程序将自动下载' . $url . '的视频请耐心等待下载，如果想手动下载可以下载下列地址的视频:<br>';
		foreach (explode(',', $download_urls) as $key=>$val) {
			echo "第".$key."个视频(流):" . "<a href='$val'>" . $val . "</a><br>";		
		}	
	}
}
?>
