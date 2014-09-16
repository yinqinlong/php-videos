<?php
class ku6 extends website {
	public function __construct($url) {
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl($url);
	}

	public function getTitle() {
	
	}

	public function getVideoIdByUrl() {
		//http://v.ku6.com/show/YYRt7u9PUxKHQTGC.html?st=1_9_2_1&nr=1
		$patterns = array('http://v.ku6.com/special/show_\d+/(.*)\.\.\.html', 'http://v.ku6.com/show/(.*)\.\.\.html', 'http://my.ku6.com/watch\?.*v=(.*)\.\..*', 'http://v.ku6.com/show/(.*)\.html');	
		foreach ($patterns as $url) {
			$pattern = "#$url#";
			if (preg_match($pattern, $this->url, $result)) {
				$vid = $result[1] ? $result[1] : '';
			}
		}
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		$interfaceUrl = sprintf("http://v.ku6.com/fetchVideo4Player/%s...html", $this->videoId);	
		$content = json_decode(file_get_contents($interfaceUrl), true);
		$data = $content['data'];
		$title = $data['t'];
		$f = $data['f'];
		$urls = array();
		!empty($f) && $urls = explode(',', $f);
		$url = current($urls);
		$ext = preg_replace("#.*\.#", '', $url);
		$this->ext = $ext ? $ext: 'mp4';
		$this->title = $title;
		return $urls ? $urls : array();
	}

	public function downloads($urls, $merge = true) {
	
	}
	public function download($urls, $merge = true) {
		if (!$urls) {
			return false;	
		}	
		if (is_array($urls)) {
			$urls = current($urls);
		}
		$extFlag = FALSE; 
		$ext = $this->ext ? $this->ext : 'mp4';
		$className = get_class($this);
		$fileName = './video/' . $className . time() . '.' . $ext;
		$curl = new curl();
	//	$header = $curl->curlGet302($urls);
	//	$cmd = "curl -o $fileName '" . $header. "' -A '"  . 'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0' . "'";
		$cmd = "wget -O $fileName $urls";
		system($cmd);
		return $fileName;
	}
}
