<?php
/**
* flvxz 
* 利用flvxz.com下载视频
* 
*/
class flvxz extends website {
	public $className;
	public $allow = array('youku', 'tudou', 'ku6', 'letv', 'sohu', 'iqiyi', 'pps', 'qq', 'pptv');
	public function __construct($url) {
		$this->url = $url;
		$this->className = $this->getClassName($url);
		$this->videoId = $this->getVideoIdByUrl(); 
	}	

	/**
	 * getVideoDownloadUrl 获取视频文件真实地址
	 * 
	 * @access public
	 * @return string 
	 */
	public function getVideoDownloadUrl() {
		$site = strtolower($this->className);
		if(!in_array($site, $this->allow)) {
			exit('不支持的网站，请联系管理员');	
		}
		$interfaceUrl = sprintf("http://api.flvxz.com/site/%s/vid/%s", $site, $this->videoId);
		$xml = simplexml_load_file($interfaceUrl);
		$video = current($xml->xpath('video'));
		$this->title = current($video->xpath('site'));
		$files = $video->xpath('files/file');	
		$urls = array();
		foreach ($files as $key=>$val) {
			$urls[] = $val->furl->__tostring();
			$this->type = (string)$val->ftype;
		}
		$this->title || $this->title = 'default';
		return $urls;
	}

	/**
	 * getMime 设置视频格式
	 * 
	 * @access public
	 * @return string
	 */
	public function getMime() {
		return $this->type;
	}

	/**
	 * getTitle 获取视频文件的title
	 * 
	 * @param mixed $videoId 
	 * @access public
	 * @return string 
	 */
	public function getTitle() {
		$content = file_get_contents($this->url);
		preg_match('#<title>(.*)<\/title>#', $content, $result);
		$title = $result[1];
		$codeType = mb_detect_encoding($title, array('utf-8', 'gbk', 'gb2312', 'cp936'));
		$title = mb_convert_encoding($title, 'utf-8', $codeType);
		return $title ? $title : $this->className;
	}

	/**
	 * download linux下使用下载
	 * 
	 * @param mixed $urls 
	 * @param mixed $merge 
	 * @access public
	 * @return 
	 */
	public function download($urls, $merge = TRUE) {
		if (!$urls) {
			return false;
		}	
		$urls = explode(',', $urls);
		$className = $this->className;

		$mergeFlag = FALSE; 
		$videoName = $this->getTitle(); 
		$this->title = $videoName;
		$mime = $this->getMime();
		$this->mime = $mime;
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
			$cmd = "wget -O $fileName '" . $url . "'";
			system($cmd);
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				$cmd = "wget -O $videoName '" . $urls . "'";
				system($cmd);
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
		$vid = 0;
		$class = new $this->className($this->url);
		switch($this->className) {
			case 'iqiyi':
				$vid = $this->_getiQiYiVideoIdByUrl();
				break;
			case 'youku':
				$vid = $this->_getYoukuVideoIdByUrl($class);
				break;
			default:
				$vid = $this->_getDefaultVideoIdByUrl($class);
				break;
		}
		return $vid;
	}

	private function _getiQiYiVideoIdByUrl() {
		$content = file_get_contents($this->url);
		preg_match('#data-player-tvid="([^"]+)"#', $content, $result);
		preg_match('#data-player-videoid="([^"]+)"#', $content, $videoResult);
		$tvid = $result[1];
		$videoId = $videoResult[1];
		return $videoId;
	}

	private function _getYoukuVideoIdByUrl($object) {
		$vid = $object->getVideoIdByUrl();
		return $vid;
	}

	/**
	 * _getDefaultVideoIdByUrl 获取默认的videoId
	 * 
	 * @param mixed $object 
	 * @access private
	 * @return 
	 */
	private function _getDefaultVideoIdByUrl($object) {
		$vid = $object->videoId;
		return $vid;
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

	private function getClassName($url) {
		$className = '';
		preg_match('#https?://([^/]+)/#', $url, $videoHost);
		if (empty($videoHost[1])) {
			return '';	
		}
		if (strpos('.com.cn', $videoHost[1])) {
			$videoHost[1] = substr($videoHost[1], 0, -3);
		}
		preg_match('#(\.[^.]+\.[^.]+)$#', $videoHost[1], $domain);
		if ($domain) {
			preg_match('#([^.]+)#', $domain[1], $domain);
			$domain = end($domain);
			if (empty($domain)) {
				return '';
			}
		} else {
			preg_match('#([^.]+)\.[^.]+$#', $videoHost[1], $result);
			$domain = $result[1];
		}
		$className = Common::$relation[$domain];
		return $className;
	}
}
