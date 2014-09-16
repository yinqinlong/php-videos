<?php
/**
 * Common 提供一般方法
 * 
 * @date 2014-7-14 15:40:28
 * @author yinqinlong <qinlong@staff.sina.com.cn> 
 */
class Common {
	public static $relation = array(
				'youtube' => 'youtube',
				'youtu' => 'youtube',
				'youku' => 'youku',
				'tudou' => 'tudou',
				'qq' => 'qq',
				'ifeng' => 'ifeng',
				'sohu' => 'sohu',
				'56' => 'w56',
				'ku6' => 'ku6',
				'163' => 'w163',
				'vimeo' => 'vimeo',
				'iqiyi' => 'iqiyi',
				'vimeo' => 'vimeo',
				);
	//暂时分析不出下载规则的网站
	public $flvxz = array('iqiyi', 'cntv', 'wasu', 'bbc', 'vimeo', 'hulu');

	/**
	 * urlToClass 从url获取到执行下载的类
	 * 
	 * @param mixed $url 
	 * @access public
	 * @return string
	 */
	public function urlToClass($url) {
		$className = '';
		preg_match('#https?://([^/]+)/#', $url, $videoHost);
		if (empty($videoHost[1])) {
			return '';	
		}
		if (strpos('.com.cn', $videoHost[1])) {
			$videoHost[1] = substr($videoHost[1], 0, -3);
		}
		preg_match('#(\.[^.]+\.[^.]+)$#', $videoHost[1], $domain);
		if ($domain) {
			preg_match('#([^.]+)#', $domain[1], $domain);
			$domain = end($domain);
			if (empty($domain)) {
				return '';
			}
		} else {
			preg_match('#([^.]+)\.[^.]+$#', $videoHost[1], $result);
			$domain = $result[1];
		}
		$className = self::$relation[$domain];
		if (in_array($className, $this->flvxz)) {
			$className = 'flvxz';
		}
		return $className;
	}

	/**
	 * autoLoad 
	 * 
	 * @param mixed $class 
	 * @static
	 * @access public
	 * @return 
	 */
	public static function autoLoad($class) {
		$class = strtolower($class);
		$className = sprintf("./extractor/%s.php", $class);
		if (is_file($className)) {
			include_once $className;
		} elseif (is_file("./$class.php")) {
			include_once("./$class.php");	
		}
	}

	public function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	public function formatBytes($bytes, $precision = 2) { 
		$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'); 
		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision) . '' . $units[$pow]; 
	} 
	public function is_chrome(){
		$agent=$_SERVER['HTTP_USER_AGENT'];
		if( preg_match("/like\sGecko\)\sChrome\//", $agent) ){	// if user agent is google chrome
			if(!strstr($agent, 'Iron')) // but not Iron
			  return true;
		}
		return false;	// if isn't chrome return false
	}
	public static function getStatus($status) {
		$statuses = array(
				'0' => '待下载',
				1 => '已下载，待上传',
				2 => '已上传',
			); 
	}
}
