<?php
/**
 *  该程序是脚本程序，不对浏览器请求，是执行自动下载的程序
 */
//header("Content-type: text/html; charset=utf-8");
include_once('config.php');
$db = new db();
$table = 'robber';
$common = new Common();
$upload = new Upload();
while (1) {
	$condition = array('status' => 0);
	$waitDownVideos = $db->table($table)->getList($condition);
	if ($waitDownVideos) {
		foreach ($waitDownVideos as $key=>$video) {
			if (!$video['url']) {
				continue;	
			} else {
				$url = $video['url'];
				$className = $common->urlToClass($url);
				$site = new $className($url);
				$filename = $site->download($video['download_url']);
				if ($filename && file_exists($filename)) {
					$condition = array('status' => 1, 'filename' => $filename);
					$result = $db->table($table)->update($video['id'], $condition);
					$log = $url . "下载成功\n";
					file_put_contents('/tmp/download.txt', $log, FILE_APPEND);
					//自动遮标
					if (AUTODELOGO && $video['status'] && isset($video['coord'])) {
						$delogoCmd = "ffmpeg -i " . $filename . ' -vf mp=delogo=' . $video['coord'] . ' -vcodec ... -acodec ... -f flv -y OUT.FLV';	
	//					system($delogoCmd);
					}
					//自动上传视频到vms
					if (AUTOUPLOAD && $videoId = $upload->execute($filename)) {
						$vms_url = $videoId;
						$condition =  array('status' => 2, 'vms_url' => $videoId);	
						$result = $db->table($table)->update($video['id'], $condition);
					}
				}else {
					$condition = array('status' => -1);
					$result = $db->table($table)->update($video['id'], $condition);
					$log = $url . "下载失败\n";
					file_put_contents('/tmp/download.txt', $log, FILE_APPEND);
				}
			}
		}
		unset($waitDownVideos);
	} else {
		sleep(10);
	}
} 
/**
 * upload 自动上传视频
 * 
 * @param mixed $fileName 
 * @access public
 * @return boolean
 */
function upload($fileName) {
	$result = $upload->execute($fileName);
}
