<?php
//未实现完成
class iqiyi extends website{
	public function __construct($url) {
		$this->url = $url;
		$this->videoId = $this->getVideoIdByUrl($url);
	}

	public function getTitle() {
		$content = file_get_contents($this->url);
		preg_match('#<title>(.*)<\/title>#', $content, $result);
		$this->title = $result[1];
	}

	public function getVideoIdByUrl() {
		$content = file_get_contents($this->url);
		preg_match('#data-player-tvid="([^"]+)"#', $content, $result);
		preg_match('#data-player-videoid="([^"]+)"#', $content, $videoResult);
		$tvid = $result[1];
		$videoId = $videoResult[1];
		//$info_url = sprintf("http://cache.video.qiyi.com/vj/%s/%s/", $tvid, $videoId);
		$info_url = sprintf("http://cache.video.qiyi.com/vd/%s/%s/", $tvid, $videoId);
	//	list($argName, $info) = explode('=', file_get_contents($info_url));
		$info = json_decode(file_get_contents($info_url), true);
		//http://data.video.qiyi.com/a1300da1f9b14a82261ee2d4afae1935/videos/v0/20140704/8e/4e/4d2be9e41afbcab74568c2ffa7826faf.f4v?
	}

	public function getVideoDownLoadUrl() {
		$url = "http://data.video.qiyi.com/a1300da1f9b14a82261ee2d4afae1935/videos/v0/20140704/8e/4e/4d2be9e41afbcab74568c2ffa7826faf.f4v?";
	}

	public function download($urls, $merge = true) {
		if (!$urls) {
			return false;	
		}	
		$extFlag = FALSE; 
		$videoName = $this->title; 
		if (count($urls) == 1) {
			$fileName = './video/' . $videoName . '.' . $this->ext;
			$url = current($urls);
			system("axel -o $fileName $url");
		} else {
			foreach ($urls as $key=>$url) {
				$ext = pathinfo($url, PATHINFO_EXTENSION);
				if ($ext == 'ts') {
					$videoName = './video/' . $key . '.flv.download';
					$parts[] = $videoName;
					system("axel -o $videoName $url");
					$extFlag = TRUE;
				}
			}
			if ($extFlag && $merge) {
				$this->merge($parts);
			}
		}
		return $fileName;
	}
}
