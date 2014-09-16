<?php
/**
 *  提供页面，将视频文件下载到客户端
 */
header("Content-type: text/html; charset=utf-8");
include_once('config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("max_execution_time", "1800"); 
if (!$_REQUEST['id']) {
	exit('操作错误');	
} 
$videoId = $_REQUEST['id'];
$common = new Common();
$db = new db();
$table = 'robber';
$condition = array('id' => $videoId);
$video = $db->table($table)->get($condition);
$url = $video['url'];
$className = $common->urlToClass($url);
//需要通过页面下载的网站
$site = new $className($url);

$mime = $site->mime;
clearstatcache();
if ($video['filename']) {
	$file = $video['filename'];
} else {
	$file = 'video/' . $className . '.' . $mime;
}
$fileName = $video['title'] . '.' . $mime;
$size = filesize($file);
$site->downVideoByBrowser($file, $fileName, $mime, $size);
