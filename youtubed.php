<?php
/**
 *  这个文件用来解决访问youtube受限的问题
 */
$videoId = $argv[1] ? $argv[1] : '8V17ZvggPYI';
$url = 'http://www.youtube.com/get_video_info?video_id=' . $videoId;
$content = file_get_contents($url);
file_put_contents('youtube.ini', $content);
