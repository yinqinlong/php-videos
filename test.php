<?php
class A {
	public function retry($url, $times = 10) {
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
}
$a = new A();
$id = $_GET['id'] ? $_GET['id'] : 'N_Ql7PQ_GCE';
$interfaceUrl = sprintf("http://www.youtube.com/get_video_info?video_id=%s", $id);
$content = $a->retry($interfaceUrl);
var_dump($content);
