<?php
class vimeo extends website {
	protected $stream;
	public function __construct($url) {
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl($url);
		$opts = array(
				'http'=>array(
					'header'=>"Accept-language: en\r\n" . "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0",
					)
				);
		$this->stream =  stream_context_create($opts);
	}

	public function getTitle() {
	
	}

	public function getVideoIdByUrl() {
		//https://vimeo.com/37701488
		$patterns = '#https?://[\w.]*vimeo.com[/\w]*/(\d+)$#';	
		preg_match($patterns, $this->url, $result);
		$vid = $result[1] ? $result[1] : '';
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		$interfaceUrl = sprintf("http://player.vimeo.com/video/%s", $this->videoId);	
		$content = @file_get_contents($interfaceUrl);
		if (!$content) {
			exit('访问' . $interfaceUrl . '出错');
		}
		preg_match('#<title>([^<]+)</title>#', $content, $titles);
		$title = $titles[1];
		$this->title = $title;
		preg_match_all('#"([^"]+)":\{[^{]+"url":"([^"]+)"#', $content, $result);
		var_dump($result);exit;
		$url = current(end($result));
		return $url;
	}

	public function download($urls, $merge = true) {
		$fileName = 'vimeo.mp4';
		$cmd = "curl -o $fileName $urls";
		system($cmd);
		$fileName = './video/' . $this->title . '.mp4';	
		$mvCmd = "mv $fileName ";
		system($fileName);
	}
}
