<?php
class w163 extends website {
	public function __construct($url) {
		$this->url = $url;
	//	$this->videoId = $this->getVideoIdByUrl($url);
	}

	public function getTitle() {
	
	}

	public function getVideoIdByUrl() {
		
	}

	public function getVideoDownLoadUrl() {
		$content = file_get_contents($this->url);
		preg_match('#movieDescription=\'([^\']+)\'#', $content, $result);
		if (!$title = $result[1]) {
			preg_match("#<title>(.+)</title>#", $content, $result);	
			$title = $result[1];
		}
		$title = iconv('gb2312//ignore', 'utf-8', $title);
		$this->title = $title;
		preg_match('#<source src="([^"]+)#', $content, $src) or preg_match('#<source type="[^"]+" src="([^"]+)"#', $content, $src);
		$videoSrc = $src[1] ? $src[1] : '';
		if ($videoSrc) {
			preg_match('#(.+)-mobile.mp4#', $videoSrc, $sdUrls);
			$sdUrl = $sdUrls[1] . '.flv';
			$hdUrl = preg_replace('#SD#', 'HD', $sdUrl);
			$curl = new curl();
			$sdHeader = $curl->curlGet302($sdUrl);
			$hdHeader = $curl->curlGet302($hdUrl);
			$sdSize = $curl->getSize($sdHeader);
			$hdSize = $curl->getSize($hdHeader);
			if ($sdSize > $hdSize) {
				$url = $sdUrl;
			} else {
				$url = $hdUrl;
			}
			$this->ext = 'flv';
		} else {
			preg_match('#["\'](.+)-list.m3u8["\']#', $content, $urls) || preg_match('#["\'](.+).m3u8["\']#', $content, $urls);
			$url = $urls[1] . '.mp4';
			$this->ext = 'mp4';
		}
		return $url;
	}

	public function download($urls, $merge = true) {
		if (!$urls) {
			return false;
		}		
		$className = get_class($this);
		$fileName = './video/' . $className . time() . '.' . $this->ext;
		$cmd = "wget -O $fileName $urls";
		system($cmd);
		return $fileName;
	}
}
