<?php
/**
 * youku 优酷视频抓取类
 * 
 * @uses website
 * @copyright 2014年07月25日 星期五 10时52分19秒 the video group
 * @author 尹秦龙<yinqinlong52@163.com> 
 */
class youku extends website {
	protected $patterns = array(
		'youku.com/v_show/id_([\w=]+)',
		'player.youku.com/player.php/sid/([\w=]+)/v.swf',
		'loader\.swf\?VideoIDS=([\w=]+)',
		);
	protected $streamTypes = array(
        array('id' => 'hd3', 'container' => 'flv', 'video_profile'=> '1080P'),
        array('id'=> 'hd2', 'container'=> 'flv', 'video_profile'=> '超清'),
        array('id'=> 'mp4', 'container'=> 'mp4', 'video_profile'=> '高清'),
        array('id'=> 'flvhd', 'container'=> 'flv', 'video_profile'=> '高清'),
        array('id'=> 'flv', 'container'=> 'flv', 'video_profile'=> '标清'),
        array('id'=> '3gphd', 'container'=> '3gp', 'video_profile'=> '高清（3GP）'),
		);
	protected $interfaceUrl = 'http://v.youku.com/player/getM3U8/vid/%s/type/%s/video.m3u8';
	protected $targetHost = '10.210.208.52';

	public function __construct($url) {
		$stream = 'hd2';	//默认清晰度	
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl(); 
		$this->interfaceUrl = sprintf($this->interfaceUrl, $this->videoId, $stream);
	}	

	/**
	 * getVideoDownloadUrl 获取视频文件真实地址
	 * 
	 * @access public
	 * @return string 
	 */
	public function getVideoDownloadUrl() {
		$content = trim(file_get_contents($this->interfaceUrl));	
		preg_match_all('#(http://[^?]+)\?ts_start=0#is', $content, $result);
		$this->title = $this->getTitle();
		return $result[1];
	}

	/**
	 * getMime 设置视频格式
	 * 
	 * @access public
	 * @return string
	 */
	public function getMime() {
		$this->mime = 'flv';
		return $this->mime;
	}

	/**
	 * getTitle 获取视频文件的title
	 * 
	 * @param mixed $videoId 
	 * @access public
	 * @return string 
	 */
	public function getTitle() {
		$url = sprintf("http://v.youku.com/player/getPlayList/VideoIDS/%s", $this->videoId);
		$content = file_get_contents($url);
		$result = json_decode($content, true);
		$result = current($result['data']);
		return isset($result['title']) ? $result['title'] : 'part';
	}

	/**
	 * download linux下使用下载
	 * 
	 * @param mixed $urls 
	 * @param mixed $merge 
	 * @access public
	 * @return 
	public function download($urls, $merge = TRUE) {
		if (!$urls) {
			return false;
		}	
		$urls = explode(',', $urls);
		$className = get_class($this);

		$mergeFlag = FALSE; 
		$videoName = $this->getTitle(); 
		$this->title = $videoName;
		$mime = $this->getMime();
		$this->mime = $mime;
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
			system("curl -o $fileName $url");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				system("curl -o $videoName $url");
				$mergeFlag = TRUE;
			}
			if ($mergeFlag && $merge) {
				$this->merge($parts, $fileName);
			}
		}
		return $fileName;
	}
	 */

	public function download($urls, $merge = TRUE, $id = 0) {
		if (!$urls) {
			return false;
		}	
		$urls = explode(',', $urls);
		$className = get_class($this);

		$mergeFlag = FALSE; 
		$videoName = $this->getTitle(); 
		$this->title = $videoName;
		$mime = $this->getMime();
		$this->mime = $mime;
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
			system("axel -o $fileName '" . $url . "'");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				system("axel -o $videoName '"  . $url . "'");
				$mergeFlag = TRUE;
			}
			if ($mergeFlag && $merge) {
				$this->merge($parts, $fileName);
			}
		}
		return $fileName;
	}
	/**
	 * getVideoIdByUrl 通过url获取videoId 
	 * 
	 * @access public
	 * @return string
	 */
	public function getVideoIdByUrl() {
		preg_match('#http://v.youku.com/v_show/id_([^\.]+).html#', $this->url, $result);
		$videoId = empty($result[1]) ? '' : $result[1];
		return $videoId;
	}

	/**
	 * upload 利用scp命令将本地视频上传到指定服务器
	 * 
	 * @param mixed $file 
	 * @access public
	 * @return 
	 */
	public function upload($file) {
		if (!is_file($file)) {
			exit('上传失败，文件不存在');
		}
		$uploadConfig = $this->uploadConfig;
		$uploadUser = $uploadConfig['user'];
		$uploadHost = $uploadConfig['host'];
		$uploadPath = $uploadConfig['path'];
		try {
			$cmd = "scp $file $uploadUser@$uploadHost:$uploadPath";
			$return = system($cmd);
		} catch (Exception $e) {
			throw $e->getMessage();	
		}
		return $return;
	}
}
