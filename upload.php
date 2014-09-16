<?php
class Upload {
	private $skey = '22705ac7436fe4515946e835bab87dcf';
	private $proxy;
	const APPNAME = 'vms';
	public function __construct() {
		$this->proxy = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0';
	}
	public function getVideoId() {
	//	$skey = md5(self::APPNAME.$this->skey.$_SERVER['HTTP_USER_AGENT']);
		$skey = md5(self::APPNAME.$this->skey.$this->proxy);

		$_POST = array('appname' => self::APPNAME, 'skey' => $skey);
		
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, 'http://s.video.sina.com.cn/video/getVideoId');
		curl_setopt($handler, CURLOPT_USERAGENT, $this->proxy);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handler, CURLOPT_POST, TRUE);
		curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($_POST));
		$response = curl_exec($handler);
		curl_close($handler);
		
		return $response;
	}

	public function create($data) {
		$skey = md5(self::APPNAME.$this->skey.$this->proxy);
		$_POST = $data;
		$_POST['appname'] = self::APPNAME;
		$_POST['skey'] = $skey;
		$_POST['account_id'] = 21;
		
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, 'http://s.video.sina.com.cn/video/create');
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handler, CURLOPT_USERAGENT, $this->proxy);
		curl_setopt($handler, CURLOPT_POST, TRUE);
		curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($_POST));
		$response = curl_exec($handler);
		curl_close($handler);
		
		return $response;
	}

	/**
	 * execute 执行具体的上传操作
	 * 
	 * @param mixed $file 
	 * @access public
	 * @return int
	 */
	public function execute($file) {
		$videos = json_decode($this->getVideoId(), true);
		$data['video_id'] = $videos['data']['video_id'];
		$data['token'] = $videos['data']['token'];
		$data['channel_id'] = 1052;
		$data['category_id'] = 2;
		$data['media_program_id'] = 27791011;
		$data['media_id'] = 779;
		$data['logo'] = 0;
		$data['position'] = 0;
		$data['title'] = basename($file);
		$data['file_size'] = filesize($file);
		$uploadUrls = json_decode($this->create($data), true);
		$stateUrl = $uploadUrls['data']['upload_url'];
		@$content = file_get_contents($stateUrl);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $stateUrl);
		$fp = fopen($file, 'rb');
		$block = 1048576;
		$header = array(
					"X-Session-ID:$data[video_id]",
	//				"Content-Type:application/octet-stream",
	//				"Content-Disposition:attachment",
					);
		$post = array('file'=>'@' . $file);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		fclose($fp);
		curl_close($ch);
		$info = json_decode($result, true);
		return $info['state'] == 'success' ? $data['video_id'] : 0;
	}

	public function cross() {
		$stateURL = isset($_GET['stateURL']) ? $_GET['stateURL'] : '';
		try {
			$content = @file_get_contents($stateURL);
			echo $content;
		} catch(Exception $e) {
		
		}
	}
}
/**
$upload = new Upload();
$fileName = 'video/a.mp4';
$videoId = $upload->execute($fileName);
echo $videoId;
**/
