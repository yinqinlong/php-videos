<?php
/**
 * @filename main.php
 * 
 * @package 命令行下的处理视频下载的过程
 * @author yql, yin.qinlong@stff.sina.com.cn
 * 创建时间:$$Date$$
 */
/**
ini_set('');
$url = $_GET['url'];
if (!$url || filter_var($url, FILTER_VALIDATE_URL)) {
	return showError('400', '视频地址不正确');
}
if ($delogo = (int)$_GET['delogo']) {
	$logoInfo = $_GET['logoInfo'];
	list($xcoord, $ycoord, $width, $height) = explode(',', $logoInfo);
}
*/
//记录请求日志
//$log->add($_GET);
//分析对应算法
include('./config.php');
$common = new Common();
$url = $argv[1];
$className = $common->urlToClass($url);
$fileName = sprintf("./extractor/%s.php", $className);
if (!empty($className) && is_file($fileName)) {
	include($fileName);
} else {
	exit('不支持抓取该网站的视频,如果需要请联系');
}
$site = new $className($url);
$downloadUrls = $site->getVideoDownloadUrl();
if (count($downloadUrls) == 0) {
	echo "默认的分析器分析失败,将试用flvxz解析\n";	
	//利用外站处理
	$flvSite = new flvxz($url);
	$downloadUrls = $flvSite->getVideoDownloadUrl();
	if (count($downloadUrls) == 0) {
		exit('无效的视频下载地址');
	}
}
if (is_array($downloadUrls)) {
	$downloadUrls = implode(',', $downloadUrls);
}
//下载视频
$fileName = $site->download($downloadUrls);
//上传到服务器
//$site->upload($fileName);
//给vms数据库插入记录
//http://vms.video.sina.com.cn/uploaddemand/get_upload_url
//http://202.108.35.214:8100/upload?uid=4505&type=file&storage=local&callback_url=test&server_filename=20140722103844140599672441145-test.flv
//http://vms.video.sina.com.cn/uploaddemand/save_upload_info
//http://vms.video.sina.com.cn/uploaddemand/update_info
//记录请求结果
//通知转码系统
//写入日志
