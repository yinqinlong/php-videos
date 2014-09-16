<?php
class youtube extends website {
	//是否展示下载列表
	public $downloadList = true;
	public $code;
	protected $ytCodes = array(
				array('itag'=> 38, 'container'=> 'MP4', 'video_resolution'=> '3072p', 'video_encoding'=> 'H.264', 'video_profile'=> 'High', 'video_bitrate'=> '3.5-5', 'audio_encoding'=> 'AAC', 'audio_bitrate'=>      '192'),
				array('itag'=> 46, 'container'=> 'WebM', 'video_resolution'=> '1080p', 'video_encoding'=> 'VP8', 'video_profile'=> '', 'video_bitrate'=> '', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '192'),
				array('itag'=> 37, 'container'=> 'MP4', 'video_resolution'=> '1080p', 'video_encoding'=> 'H.264', 'video_profile'=> 'High', 'video_bitrate'=> '3-4.3', 'audio_encoding'=> 'AAC', 'audio_bitrate'=>      '192'),
#array('itag'=> 102, 'container'=> 'WebM', 'video_resolution'=> '720p', 'video_encoding'=> 'VP8', 'video_profile'=> '3D', 'video_bitrate'=> '', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '192'),
				array('itag'=> 45, 'container'=> 'WebM', 'video_resolution'=> '720p', 'video_encoding'=> 'VP8', 'video_profile'=> '', 'video_bitrate'=> '2', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '192'),
#array('itag'=> 84, 'container'=> 'MP4', 'video_resolution'=> '720p', 'video_encoding'=> 'H.264', 'video_profile'=> '3D', 'video_bitrate'=> '2-3', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> '192'),    array('itag'=> 22, 'container'=> 'MP4', 'video_resolution'=> '720p', 'video_encoding'=> 'H.264', 'video_profile'=> 'High', 'video_bitrate'=> '2-3', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> '192'),
				array('itag'=> 120, 'container'=> 'FLV', 'video_resolution'=> '720p', 'video_encoding'=> 'H.264', 'video_profile'=> 'Main@L3.1', 'video_bitrate'=> '2', 'audio_encoding'=> 'AAC', 'audio_bitrate'=>     '128'),
				array('itag'=> 44, 'container'=> 'WebM', 'video_resolution'=> '480p', 'video_encoding'=> 'VP8', 'video_profile'=> '', 'video_bitrate'=> '1', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '128'),    array('itag'=> 35, 'container'=> 'FLV', 'video_resolution'=> '480p', 'video_encoding'=> 'H.264', 'video_profile'=> 'Main', 'video_bitrate'=> '0.8-1', 'audio_encoding'=> 'AAC', 'audio_bitrate'=>       '128'),
#array('itag'=> 101, 'container'=> 'WebM', 'video_resolution'=> '360p', 'video_encoding'=> 'VP8', 'video_profile'=> '3D', 'video_bitrate'=> '', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '192'),    #array('itag'=> 100, 'container'=> 'WebM', 'video_resolution'=> '360p', 'video_encoding'=> 'VP8', 'video_profile'=> '3D', 'video_bitrate'=> '', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '128'),
				array('itag'=> 43, 'container'=> 'WebM', 'video_resolution'=> '360p', 'video_encoding'=> 'VP8', 'video_profile'=> '', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'Vorbis', 'audio_bitrate'=> '128'),    array('itag'=> 34, 'container'=> 'FLV', 'video_resolution'=> '360p', 'video_encoding'=> 'H.264', 'video_profile'=> 'Main', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> '128'),
#array('itag'=> 82, 'container'=> 'MP4', 'video_resolution'=> '360p', 'video_encoding'=> 'H.264', 'video_profile'=> '3D', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> '96'),    array('itag'=> 18, 'container'=> 'MP4', 'video_resolution'=> '270p/360p', 'video_encoding'=> 'H.264', 'video_profile'=> 'Baseline', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'AAC',                 'audio_bitrate'=> '96'),    array('itag'=> 6, 'container'=> 'FLV', 'video_resolution'=> '270p', 'video_encoding'=> 'Sorenson H.263', 'video_profile'=> '', 'video_bitrate'=> '0.8', 'audio_encoding'=> 'MP3', 'audio_bitrate'=>     '64'),    #array('itag'=> 83, 'container'=> 'MP4', 'video_resolution'=> '240p', 'video_encoding'=> 'H.264', 'video_profile'=> '3D', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> '96'),
				array('itag'=> 13, 'container'=> '3GP', 'video_resolution'=> '', 'video_encoding'=> 'MPEG-4 Visual', 'video_profile'=> '', 'video_bitrate'=> '0.5', 'audio_encoding'=> 'AAC', 'audio_bitrate'=> ''),    array('itag'=> 5, 'container'=> 'FLV', 'video_resolution'=> '240p', 'video_encoding'=> 'Sorenson H.263', 'video_profile'=> '', 'video_bitrate'=> '0.25', 'audio_encoding'=> 'MP3', 'audio_bitrate'=>    '64'),    array('itag'=> 36, 'container'=> '3GP', 'video_resolution'=> '240p', 'video_encoding'=> 'MPEG-4 Visual', 'video_profile'=> 'Simple', 'video_bitrate'=> '0.175', 'audio_encoding'=> 'AAC',              'audio_bitrate'=> '36'),
				array('itag'=> 17, 'container'=> '3GP', 'video_resolution'=> '144p', 'video_encoding'=> 'MPEG-4 Visual', 'video_profile'=> 'Simple', 'video_bitrate'=> '0.05', 'audio_encoding'=> 'AAC',               'audio_bitrate'=> '24'),
				);

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
		$extFlag = FALSE; 
		$videoName = $this->getTitle(); 
		$fileName = './video/' . $className . time() . '.' . $this->mime;
		if (count($urls) == 1) {
			$url = current($urls);
			system("axel -o $fileName '" . $url . "'");
		} else {
			foreach ($urls as $key=>$url) {
				$videoName = './video/' . $key . $className . '.' . $this->mime. '.download';
				$parts[] = $videoName;
				system("axel -o $videoName '" . $url . "'");
				$extFlag = TRUE;
			}
			if ($extFlag && $merge) {
				$outFile = $this->title . '.' . $this->mime;
				$this->merge($parts, $outFile);
			}
		}
		return $fileName;
	}

	public function getVideoIdByUrl() {
		$vid = '';
		if (preg_match('#youtu.be/([^/]+)#', $this->url, $result)) {
			$vid = $result[1];
		} elseif (preg_match('#youtube.com/embed/([^/]+)#', $this->url, $result)) {
			$vid = $result[1];
		} elseif (preg_match('#https?://www.youtube.com/watch\?v=#', $this->url)) {
			$urlArgs = parse_url($this->url, PHP_URL_QUERY);
			parse_str($urlArgs);
			$vid = $v;
			//测试，是否是https的下载要验证，看下https和http是否都能访问
			$this->url = 'http://www.youtube.com/watch?v=' . $vid;
		} else {
			//其他页面暂未实现获取规则
		}
		return $vid;
	}

	public function getVideoDownLoadUrl() {
		$interfaceUrl = sprintf("http://www.youtube.com/get_video_info?video_id=%s", $this->videoId);
		system('php youtubed.php ' . $this->videoId);
		$content = file_get_contents('youtube.ini');
	//	$content = $this->retry($interfaceUrl);
		if(empty($content)) {
			if ($this->code) {
				$content = $this->code;	
			} else {
				$videoId = $this->videoId;
				$template = 'view/youtube.php';
				include($template);
				exit;
			}
		}
		parse_str($content, $info);
		if ($info['status'] == 'ok' && strtolower($info['use_cipher_signature']) == 'false') {
			$title = $this->title = $info['title'];
			$stream_list = explode(',', $info['url_encoded_fmt_stream_map']);
		} else {
			$videoPageContent = file_get_contents($this->url);		
			preg_match('#ytplayer.config\s*=\s*([^\n]+});#', $videoPageContent, $playerConfig);
		}
		$data = array();
	//	$urlResult = array();
		foreach ($stream_list as $key=>$stream) {
			parse_str($stream, $streamResult);	
			//sid规则不一定正确 测试
			if ($streamResult['sid']) {
				$sig = $streamResult['sid'];	
				$streamResult['url'] .= '&signature=' . $sig;
			}
			$data[$streamResult['itag']] = $streamResult;
		}
		foreach ($this->ytCodes as $code) {
			foreach ($data as $itag => $stream) {
				if ($code['itag'] == $itag) {
					$type = $code['container'];
					$urlResult[$type] = $stream;
				}
			}	
		}
		$choseVideo = $this->choseVideo($urlResult);
		return $choseVideo['url'];
	}

	private function getRealUrl($host, $port, $file, $new) {
		$realUrl = sprintf("http://%s/?prot=%s&file=%s&new=%s", $host, $port, $file, $new);
		$content = file_get_contents($realUrl);
		list($start, $size, $host, $key) = explode('|', $content);
		return sprintf("%s%s?key=%s", substr($start, 0, -1), $new, $key);
	}

	public function choseVideo($videos) {
		$qualitys = array('hight', 'medium', 'small');
		if (!is_array($videos)) 
		   return $videos;	
		$choseVideo = '';
		foreach ($qualitys as $quality) {
			foreach ($videos as $video) {
				if (in_array($video['type'], $this->videoFormat)) {
					continue;
				}
				if ($video['quality'] == $quality) {
					$choseVideo = $video;
					break;
				}	
			}	
			if (!empty($choseVideo['url'])) {
				break;
			}
		}
		$this->ext = array_search($choseVideo['type'], $this->videoFormat);
		$this->mime = array_search($choseVideo['type'], $this->videoFormat);
		return $choseVideo;
	}

	/**
	 * retry 重试
	 * 
	 * @param int $times 
	 * @access private
	 * @return array
	 */
	private function retry($url, $times = 10) {
		$i++;
		$content = '';
		while (empty($content) && $i < $times) {
			ob_start();	
			system('curl -i ' . $url);
			$data = ob_get_contents();
			ob_end_clean();
			$info = explode(' ', $data);
			if ($info[1] == 200) {
				$content = $data;	
			}
		}
		return $content;
	}

	public function setCode($code) {
		$this->code = $code;
	}

	public function getCode() {
		return $this->code;
	}
}
