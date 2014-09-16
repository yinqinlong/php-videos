<?PHP
/**
 *  获取youtube网站缩略图,其他需要可在实现
 */
$my_id = $_GET['videoid'];

$thumbnail_url="http://i1.ytimg.com/vi/".$my_id."/default.jpg"; // make image link
header("Content-Type: image/jpeg"); // set headers
readfile($thumbnail_url); // show image
?>
