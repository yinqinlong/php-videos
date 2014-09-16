<?php
class w56 extends website {
	public function __construct($url) {
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl($url);
	}

	public function getVideoIdByUrl() {
		$patterns = '#http://www.56.com/u\d+/v_(\w+).html#';	
		preg_match($patterns, $this->url, $result);
		$vid = $result[1] ? $result[1] : ''; 
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		$interfaceUrl = sprintf("http://vxml.56.com/json/%s/?src=site", $this->videoId);	
		$content = json_decode(file_get_contents($interfaceUrl), true);
		$data = $content['info'];
		$this->title = $data['Subject'];
		$hd = $data['hd'];
		$type = array('normal', 'clear', 'super');
		if (!in_array($hd, array(0, 1, 2))) {
			$hd = 0;
		}
		$files = $data['rfiles'][$hd];
		$size = $files['filesize'];
		$url = $files['url'];
		return $url;
	}

	public function download($urls, $merge = true) {
		if (!$urls) {
			return false;
		}		
		preg_match('#\.([^.]+)\?#', $urls, $result);
		$ext = $result[1];
		$className = get_class($this);
		$fileName = './video/' . $className . time() . '.' . $ext;
		$curl = new curl();
	//	$header = $curl->curlGet302($urls);
		//$cmd = "curl -o $fileName '" . $header. "'";
	//	$cmd = "axel -o $fileName '" . $header. "'";
		$cmd = "wget -O $fileName '" . $urls . "'";
		echo $cmd . "\n";
		system($cmd);
		return $fileName;
	}
}
