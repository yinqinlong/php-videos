<?php
abstract class website {
	//输入网站地址
	public $url;
	//视频id
	public $videoId;
	//视频标题
	public $title = 'default';
	//视频格式
	public $mime = 'flv';
	public $ext = 'flv';
	//是否在浏览器里展示列表以供选择
	public $downloadList = FALSE;
	//上传服务器配置
	public $uploadConfig = array(
			'user' => 'qinlong',
			'host' => '10.210.208.52',
			'path' => '/usr/home/qinlong/video/',
			);
	public $videoFormat = array(
			'avi' => 'video/avi',	
			'm2v' => 'video/x-mpeg',
			'm4e' => 'video/mpeg4',
			'mp4' => 'video/mpeg4',
			'mpeg' => 'video/mpg',
			'wmv' => 'video/x-ms-wmv',
			'rmvb' => 'application/vnd.rn-realmedia-vbr',
			'flv' => 'application/octet-stream',
			'webm' => 'video/webm',
			'txt' => 'text/plain',
			);

	public function getTitle() {
	
	}

	abstract public function getVideoIdByUrl();

	abstract public function getVideoDownloadUrl();

	/**
	 * merge 将多个流视频合并成一个视频
	 * 
	 * @param mixed $files 
	 * @param string $fileName 输出的视频名称
	 * @param string $ext 视频格式
	 * @access public
	 * @return boolean
	 */
	public function merge($files, $fileName, $ext = 'flv') {
	//	$outFile = './video/' . $fileName. '.' . $ext;
		$outFile = $fileName;
		if (is_file($outFile)) {
			unlink($outFile);
		}
		$str = '';
		foreach ($files as $key=>$file) {
			$file = basename($file);
			$str .= "file $file\n";
		}
		$mergeFile = sprintf("video/%s.txt", basename($fileName));
		file_put_contents($mergeFile, $str);
		system("ffmpeg -f concat -i $mergeFile -c copy $outFile");
		//重命名
		//清空
		foreach ($files as $key=>$file) {
			unlink($file);
		}
		return true;
	}

	/**
	 * getAttachment 通过附件的形式下载
	 * 
	 * @param mixed $urls 
	 * @param mixed $mime 
	 * @param mixed $merge 
	 * @access public
	 * @return 
	 */
	public function getAttachmentByUrl($urls, $name, $mime = 'mp4', $size = 0) {
		if (!in_array($mime, array_keys($this->videoFormat))) {
			$mime = 'mp4';
		}
		$mime = $this->videoFormat[$mime];
		header('Content-Type: "' . $mime . '"');
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		$size && header('Content-Length: '.$size);
		header('Pragma: no-cache');

		file_put_contents('/tmp/w56.txt', $name. $url . $mime);
		readfile($url);
	}

	public function downVideoByBrowser($file, $name, $mime = 'mp4', $size = 0) {
		if (!in_array($mime, array_keys($this->videoFormat))) {
			$mime = 'mp4';
		}
		$mimeType = $this->videoFormat[$mime];
		header('Content-Type: "' . $mimeType . '"');
		header('Content-Disposition: attachment; filename="' . $name . '"');
	//	header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		$size && header('Content-Length: '.$size);
		header('Pragma: no-cache');
		readfile($file);
	}

	protected function uploadVideo() {
		$skey = '22705ac7436fe4515946e835bab87dcf';
		define('APPNAME', 'vms');
		$skey = md5(APPNAME.$skey.$_SERVER['HTTP_USER_AGENT']);
		
		$_POST['appname'] = APPNAME;
		$_POST['skey'] = $skey;
		$_POST['account_id'] = 21;
		
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, 'http://s.video.sina.com.cn/video/create');
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handler, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($handler, CURLOPT_POST, TRUE);
		curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($_POST));
		$response = curl_exec($handler);
		curl_close($handler);
		
		echo $response;
		exit();
	}

	protected function saveVideo() {
	
	}
	
	/**public function upload($file) {
		//http://vms.video.sina.com.cn/uploaddemand/get_upload_url
		//http://202.108.35.214:8100/upload?uid=4505&type=file&storage=local&callback_url=test&server_filename=20140716153035140549583554294-test.flv
		$title = $this->getTitle();	
		//上传文件
		$curl->postVideo();
		//保存文件
		//http://vms.video.sina.com.cn/uploaddemand/update_info
		$curl->saveVideo();
	}**/

	public function __get($key) {
		$method = 'get' . ucfirst($key);
		if (is_callable($this, $method)) {
			return call_user_func(array($this, $method));
		} else {
			return NULL;
		}	
	}

	/**
	 * __set 自动设置属性
	 * 
	 * @param mixed $key 
	 * @param mixed $value 
	 * @access public
	 * @return 
	 */
	public function __set($key, $value) {
		$method = 'set' . ucfirst($key);
		if (is_callable($this, $method)) {
			return call_user_func(array($this, $method), $value);
		} else {
			$this->$key = $value;
		}
	}
}
