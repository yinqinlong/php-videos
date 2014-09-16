<?php
//没实现
class qq extends website {
	public $downloadUrls;
	public function __construct($url) {
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl();
	}

	public function getVideoIdByUrl() {
		if (preg_match('#http://v.qq.com/([^\?]+)\?vid#', $this->url, $result)) {
			$aid = $result[1];
			preg_match('#http://v.qq.com/[^\?]+\?vid=(\w+)#', $this->url, $vids);
			$vid = $vids[1];
			$url = sprintf('http://sns.video.qq.com/tvideo/fcgi-bin/video?vid=%s', $vid);
		}
		if (preg_match('#http://y.qq.com/([^\?]+)\?vid#', $this->url, $result)) {
			preg_match('#http://static.video.qq.com/.*vid=(\w+)#', $this->url, $result);
			$vid = $result[1];
			$url = sprintf("http://v.qq.com/page/%s.html", $vid);
			$content = file_get_contents($url);
			preg_match('#<meta http-equiv="refresh" content="0;url=([^"]*)#', $content, $result);
			if ($rurl = $result[1]) {
				preg_match('#(.*)\.html#', $rurlResult);
				$aid = $rurlResult[1];
				$url = sprintf("%s/%s.html", $aid, $vid);
			}
		}
		if (preg_match('#http://static.video.qq.com/.*vid=#', $this->url)) {
			preg_match('#http://static.video.qq.com/.*vid=(\w+)#', $this->url, $result);	
			$vid = $result[1];
			$url = sprintf("http://v.qq.com/page/%s.html", $vid);
		}
		if (preg_match('#http://v.qq.com/cover/.*\.html#', $this->url)) {
			$content = file_get_contents($this->url);
			preg_match('#vid:"([^"]+)"#', $content, $vidResult);
			$vid = $vidResult[1];
			$url = sprintf("http://sns.video.qq.com/tvideo/fcgi-bin/video?vid=%s", $vid);
		}
		$this->downloadUrls = $url;
		$htmls = file_get_contents($url);
		preg_match('#<title>(.+?)</title>#', $htmls, $result);
		$title = $result[1];
		$this->title = $title;
		$this->mime = 'mp4';
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		$interfaceUrl = sprintf("http://vv.video.qq.com/getinfo?vids=%s", $this->videoId);
		$contents = file_get_contents($interfaceUrl);
		$xml = new SimpleXMLElement($contents);	
		$vi = current($xml->xpath('vl/vi'));
		$ui = current($vi->xpath('ul/ui'));
		$fn = $vi->xpath('fn');
		$fvkey = $vi->xpath('fvkey');
		$fclip = $vi->xpath('fclip');
		foreach ($ui as $key => $val) {
			if ($key == 'url')
			  $host = $val;
		}
		foreach ($fn as $key=>$val) {
			$fn = $val;
		}
		foreach ($fvkey as $key=>$val) {
			$fvkey = $val;
		}
		foreach ($fclip as $key=>$val) {
			$fclip = $val;
		}	
		if ($fclip > 0) {
			$fn = substr($fn, 0, -4) . '.' . $fclip . substr($fn, -4);
		}
		$url = $host . $fn . '?vkey=' . $fvkey;
		return $url;
	}

	public function download($urls, $merge = true) {
		if (!$urls) {
			return false;
		}	
		$urls = explode(',', $urls);
		$className = get_class($this);

	//	echo "开始下载" .$className . "视频，请稍等......<br>";

		$mergeFlag = FALSE; 
		$videoName = $this->title; 
		$mime = $this->mime;
		$fileName = './video/' . $className . time() . '.' . $mime;
		if (count($urls) == 1) {
			$url = current($urls);
	//		echo "文件" . $fileName, "地址" . $url . "下载中...\n";
			system("wget -O $fileName $url");
	//		echo "文件" . $fileName. "下载完成...\n";
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = 'video/' . $key . $className . '.flv.download';
				$parts[] = $videoName;
				system("wget -O $fileName $urls");
				$mergeFlag = TRUE;
			}
			if ($mergeFlag && $merge) {
				$this->merge($parts, $className);
			}
		}
		return $fileName;
	}
}
