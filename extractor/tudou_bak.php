<?php
/**
 * tudou 土豆视频分析类
 * 
 * @uses website
 * @copyright 2014年07月28日 星期一 10时28分17秒 the video group
 * @author 尹秦龙<yinqinlong52@163.com> 
 */
class tudou extends website {
	protected $type;
	protected $iid;
	public function __construct($url) {
		$this->url = $url;	
		$this->videoId = $this->getVideoIdByUrl($this->url);
	}

	public function download($urls, $merge = TRUE) {
		if (!$urls || !is_array($urls)) {
			return FALSE;
		}	
		$extFlag = FALSE; 
		$videoName = $this->title; 
		if (count($urls) == 1) {
			$fileName = './video/' . $videoName . '.mp4';
			$url = current($urls);
			system("curl -o $fileName $url");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = './video/' . $key . 'tudou.mp4.download';
				$parts[] = $videoName;
				system("curl -o $videoName $url");
				$extFlag = TRUE;
			}
			if ($extFlag && $merge) {
				$outFile = $this->title . '.mp4';
				$this->merge($parts, 'tudou', $this->ext);
			}
		}
		return $fileName;
	}

	public function getVideoIdByUrl() {
		if (preg_match('#http://www.tudou.com/v/([^/]+)/#', $this->url, $result)) {
			$vid = $result[1];
			$this->type = 'vid';
			return $vid;
		} 
		$content = file_get_contents($this->url);
		preg_match('#kw\s*[:=]\s*[\'\"]([^\']+?)[\'\"]#', $content, $titles);
		$title = $titles[1];
		preg_match("#vcode\s*[:=]\s*\'([^\']+)\'#", $content, $vcodes);
		$vcode = isset($vcodes[1]) ? $vcodes[1] : '';
		if($vcode) {
			$vid = $vcode;
			$this->type = 'youku';
		} else {
			$content = file_get_contents($this->url);
			preg_match('#iid\s*[:=]\s*(\d+)#', $content, $result);
			$vid = $result[1];
			$this->type = 'iid';
			if (!$vid) {
				$vid = '';
				$this->type = 'list';
			}
		}
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		switch ($this->type) {
			case 'vid':
				$urls = $this->getVideoDownloadUrlsByVid();
				break;
			case 'youku':
				$urls = $this->getVideoDownloadUrlsByYouku();
				break;
			case 'list':
				$urls = $this->getVideodownloadUrlsByList();
				break;
			case 'iid':
				$urls = $this->getVideodownloadUrlsByIid();
				break;
		}
		return $urls;
	}

	private function getRealUrl($host, $port, $file, $new) {
		$realUrl = sprintf("http://%s/?prot=%s&file=%s&new=%s", $host, $port, $file, $new);
		$content = file_get_contents($realUrl);
		list($start, $size, $host, $key) = explode('|', $content);
		return sprintf("%s%s?key=%s", substr($start, 0, -1), $new, $key);
	}

	private function getVideoDownloadUrslByVid() {
		$interfaceUrl = sprintf("http://www.tudou.com/programs/view/%s/", $this->vid);	
		$content = file_get_contents($interfaceUrl);
		preg_match('#id\s*[:=]\s*(\S+)#', $content, $iids);
		$iid = $iids[1];
		$this->videoId = $iid;
		preg_match('#kw\s*[:=]\s*[\'\"]([^\']+?)[\'\"]#', $content, $titles);
		$title = $title[1];
		$this->title = $title;
		$urls = $this->getVideoDownloadUrlsByIid();
		return $urls;
	}

	private function getVideoDownloadUrlsByYouku() {
		$youku = new Youku();	
		//未实现
	}

	private function getVideoDownloadUrlsByList() {
		preg_match('#http://www.tudou.com/playlist/p/a(\d+)(?:i\d+)?\.html#', $this->url, $aids);	
		$aid = $aids[1];
		$content = file_get_contents($this->url);
		if (!$aid) {
			preg_match("#aid\s*[:=]\s*'(\d+)'#", $content, $aids);
			$aid = $aids[1];
		}
		if (preg_match('#http://www.tudou.com/albumcover/#', $this->url)) {
			preg_match("#title\s*:\s*'([^']+)'#", $content, $atitles);
			$atitle = $atitles[1];
		} elseif (preg_match("#http://www.tudou.com/playlist/p/#", $this->url)) {
			preg_match('#atitle\s*=\s*"([^"]+)"#', $content, $atitles);
			$atitle = $atitles[1];
		} else {
			throw '为实现的页面';
		}
		$interfaceUrl = 'http://www.tudou.com/playlist/service/getAlbumItems.html?aid=' . $aid;
		$videos = json_decode(file_get_contents($interfaceUrl), true);
		$message = $videos['message'];
		$this->videoId = $message['vid'];
		return $this->getVideoDownLoadUrlsByIid();
	}

	private function getVideoDownloadUrlsByIid() {
		$interfaceUrl = sprintf("http://www.tudou.com/outplay/goto/getItemSegs.action?iid=%s", $this->videoId);	
		$content = json_decode(file_get_contents($interfaceUrl), true);
		$vids = array();
		foreach ($content as $key=>$val) {
			if (count($val)>0) {
				array_push($vids, $val[0]['k']);	
			}
		}
		sort($vids);
		$vid = end($vids);
		$xmlContent = file_get_contents(sprintf("http://ct.v2.tudou.com/f?id=%s", $vid));
		$urls = htmlspecialchars_decode(strip_tags($xmlContent));
		return $urls;
	}
}
