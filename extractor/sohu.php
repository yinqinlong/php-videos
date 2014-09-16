<?php
class sohu extends website {
	public function __construct($url) {
		$this->url = $url;	
		$this->videoId = $this->getVideoIdByUrl($this->url);
	}

	public function download($urls, $merge = TRUE) {
		if (!$urls) {
			return FALSE;
		}	
		$urls = explode(',', $urls);
		$className = get_class($this);

		$mergeFlag = FALSE; 
		$videoName = $this->title; 
		$mime = $this->mime;
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
			system("axel -o $fileName $url");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				system("axel -o $videoName $url");
				$mergeFlag = TRUE;
			}
			if ($mergeFlag && $merge) {
				$this->merge($parts, $fileName);
			}
		}
		return $fileName;
	}

	public function getVideoIdByUrl() {
		if (preg_match('#http://share.vrs.sohu.com#', $this->url)) {
			preg_match('#id=(\d+)#', $this->url, $result);
			$vid = $result[1];
		} else {
			$content = file_get_contents($this->url);
			preg_match('#\Wvid\s*[\:=]\s*[\'"]?(\d+)[\'"]?#', $content, $result);
			$vid = $result[1];
		}
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		if (preg_match('#http://tv.sohu.com/#', $this->url)) {
		  //不完善
			$interfaceUrl = sprintf("http://hot.vrs.sohu.com/vrs_flash.action?vid=%s", $this->videoId);
			$content = json_decode(file_get_contents($interfaceUrl), true);
		} else {
			$interfaceUrl = sprintf("http://my.tv.sohu.com/play/videonew.do?vid=%s&referer=http://my.tv.sohu.com", $this->videoId);	
			$content = json_decode(file_get_contents($interfaceUrl), true);
			$host = $content['allot'];
			$prot = $content['prot'];
			$data = $content['data'];
			$title = $data['tvName'];
			$this->title = $title;
			$size = array_sum($content['data']['clipsBytes']);
			$urls = array();
			if (count($data['clipsBytes']) == count($data['clipsURL']) && count($data['clipsURL']) == count($data['su'])) {
				foreach ($data['clipsURL'] as $key=>$url) {
					$realUrl = $this->getRealUrl($host, $prot, $url, $data['su'][$key]);	
					array_push($urls, $realUrl);
				}
			} else {
				exit('cuowu');
			}
			return $urls;
		}	
	}

	private function getRealUrl($host, $port, $file, $new) {
		$realUrl = sprintf("http://%s/?prot=%s&file=%s&new=%s", $host, $port, $file, $new);
		$content = file_get_contents($realUrl);
		list($start, $size, $host, $key) = explode('|', $content);
		return sprintf("%s%s?key=%s", substr($start, 0, -1), $new, $key);
	}
}
