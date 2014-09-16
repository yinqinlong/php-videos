<?php
class ifeng extends website {
	protected $interfaceUrl;
	public function __construct($url) {
		$stream = 'hd2';	//默认清晰度	
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl(); 
	}

	/**
	 * getVideoIdByUrl 通过url获取videoId 
	 * 
	 * @access public
	 * @return string
	 */
	public function getVideoIdByUrl() {
		$pattern = '#([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})\.shtml$#';
		preg_match($pattern, $this->url, $result);	
		$videoId = empty($result[1]) ? '' : $result[1];
		return $videoId;
	}

	public function getVideoDownloadUrl() {
		$interfaceUrl = sprintf('http://v.ifeng.com/video_info_new/%s/%s/%s.xml', substr($this->videoId, -2, 1), substr($this->videoId, -2), $this->videoId);
		$content = trim(file_get_contents($interfaceUrl));
		$url = preg_match('#VideoPlayUrl="([^"]+)"#', $content, $result);
		return $result[1];
	}

	public function getTitle() {
		$interfaceUrl = sprintf('http://v.ifeng.com/video_info_new/%s/%s/%s.xml', substr($this->videoId, -2, 1), substr($this->videoId, -2), $this->videoId);
		$content = trim(file_get_contents($interfaceUrl));
		preg_match('#Name="([^"]+)"#', $content, $result);
		$this->title = $result[1];
		return $this->title;
	}

	public function download($urls, $merge = TRUE) {
		if (!$urls) {
			return false;
		}	
		$urls = explode(',', $urls);
		$className = get_class($this);

		$mergeFlag = FALSE; 
		$videoName = $this->title; 
		$videoUrlInfo = is_array($urls)? pathinfo(current($urls)) : pathinfo($urls);
		$mime = $videoUrlInfo['extension'];
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
			system("wget -O $fileName $url");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				system("wget -O $fileName $urls");
				$mergeFlag = TRUE;
			}
			if ($mergeFlag && $merge) {
				$this->merge($parts, $fileName);
			}
		}
		return $fileName;
	}
}
