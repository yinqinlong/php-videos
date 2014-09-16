<?php
/**
 * curl curl类
 * 
 * @author yinqinlong <yinqinlong52@163.com> 
 */
class curl {
	public function curlGet($URL) {
		$ch = curl_init();
		$timeout = 3;
		curl_setopt( $ch , CURLOPT_URL , $URL );
		curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
		$tmp = curl_exec( $ch );
		curl_close( $ch );
		return $tmp;
	}  

	/* 
	 * function to use cUrl to get the headers of the file 
	 */ 
	public function get_location($url) {
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL,$url);
		curl_setopt($my_ch, CURLOPT_HEADER,         true);
		curl_setopt($my_ch, CURLOPT_NOBODY,         true);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
		$r = curl_exec($my_ch);
		foreach(explode("\n", $r) as $header) {
			if(strpos($header, 'Location: ') === 0) {
				return trim(substr($header,10)); 
			}
		}
		return '';
	}

	public function getSize($url) {
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL,$url);
		curl_setopt($my_ch, CURLOPT_HEADER,         true);
		curl_setopt($my_ch, CURLOPT_NOBODY,         true);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
		$r = curl_exec($my_ch);
		foreach(explode("\n", $r) as $header) {
			if(strpos($header, 'Content-Length:') === 0) {
				return trim(substr($header,16)); 
			}
		}
		return '';
	}
	
	public function get_description($url) {
	$fullpage = curlGet($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($fullpage);
	$xpath = new DOMXPath($dom); 
	$tags = $xpath->query('//div[@class="info-description-body"]');
	foreach ($tags as $tag) {
		$my_description .= (trim($tag->nodeValue));
	}	
	
	return utf8_decode($my_description);
	}

	public function postVideo($url, $file) {
		if (!$url) {
			exit('请输入视频地址');
		}
		if (!file_exists($file)) {
			exit('文件不存在');	
		}
		$ch = curl_init();
		$post = array('file' => '@' . $file);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		curl_close($ch);
		$info = json_decode($result, true);
		if ($info['state'] == 'success') {
			return TRUE;
		}
		return FALSE;
	}

	public function curlGet302($url, $max = 10) {
		static $i;
		$i++;
		$ch = curl_init();
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,  $url);
		curl_setopt($ch,  CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
		//	curl_setopt($ch,  CURLOPT_POSTFIELDS, $vars);
		$data = curl_exec($ch);
		$headers =  curl_getinfo($ch);
		curl_close($ch);
		if ($headers['http_code'] == 302) {
			$forwardUrl = $headers['url'];
			echo $forwardUrl . "\n";
			if ($forwardUrl != $url && $i < $max) {
				$this->curlGet302($forwardUrl);	
			}
		} elseif ($headers['http_code'] == 200) {
			$finalUrl = $headers['url'];	
			return $finalUrl;
		} else {
			return false;
		}
	}

	public function getHead($url){
		$oCurl = curl_init();
		// 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
		$header[] = "Content-type: application/x-www-form-urlencoded";
		//	$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
		$user_agent = "Mozilla/5.0 (Windows NT 6.1)";

		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
		// 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
		curl_setopt($oCurl, CURLOPT_HEADER, true);
		// 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文
		curl_setopt($oCurl, CURLOPT_NOBODY, true);
		// 使用上面定义的 ua
		curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		// 不用 POST 方式请求, 意思就是通过 GET 请求
		curl_setopt($oCurl, CURLOPT_POST, false);

		$sContent = curl_exec($oCurl);
		// 获得响应结果里的：头大小
		$headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
		// 根据头大小去获取头信息内容
		$header = substr($sContent, 0, $headerSize);

		curl_close($oCurl);

		return $header;
	}
}
?>
