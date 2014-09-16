<html>
<body>
<link rel="stylesheet" href="/css/bootstrap.css" />
<link rel="stylesheet" href="/css/bootstrap-theme.css" />
<link rel="stylesheet" href="/css/content-style.css" />
<link rel="stylesheet" href="/css/jquery.fancybox.css" />
<style type="text/css">
table.two
{
table-layout: fixed
}
span 
{
	margin-left:3px
}
</style>
<table class="two" border="1" width="100%">
	<caption>【下载列表】</caption>
<tr bgcolor="#cccccc" style="word-wrap:break-word;text-align:center">
	<th width="2%">id</th>
	<th width="8%">标题</th>
	<th width="10%">url</th>
	<th width="33%">视频文件地址</th>
	<th width="33%">vms_url</th>
	<th width="3%">状态</th>
	<th width="4%">操作</th>
	<th width="7%">时间</th>
	</tr>
	<?php
	foreach ($videoList as $video) {
?>	
	<tr style="word-wrap:break-word;text-align:center">
	<td width="2%"><?php echo $video['id'];?></td>
	<td width="8%"><?php echo $video['title'] ? $video['title'] : '';?></td>
	<td width="10%"><?php echo $video['url'];?></td>
	<td width="60%"  style="word-wrap:break-word;"><?php echo $video['download_url'];?></td>
	<td width="10%"><?php echo $video['vms_url'] ? $video['vms_url'] : '';?></td>
	<td width="3%"><?php 
		if ($video['status'] == 0) {
			echo "<a href='javascript:void(0)'>待下载</a>";	
		} elseif ($video['status'] == 1) {
			echo "<a href='downvideo.php?id=".$video['id'] ."'>下载</a>";	
		} elseif ($video['status'] == 2) {
			echo "<a href=''>已上传</a>";	
		} elseif ($video['status'] == -1) {
			echo "下载失败";
		}
	?></td>
	<td width="7%"> 
	<!--<a data-link="http://p.you.video.sina.com.cn/swf/opPlayer20140624_V1_0_0_2.swf?continuePlayer=0&video_id=247347498" name="preview">-->
	<!--<a data-link="http://p.you.video.sina.com.cn/swf/opPlayer20140624_V1_0_0_2.swf?continuePlayer=0&video_id=247347498" name="preview">
	<a data-link="http://p.you.video.sina.com.cn/swf/opPlayer20140624_V1_0_0_2.swf?continuePlayer=0&video_id=201463685" name="preview">	
	<a data-link="http://p.you.video.sina.com.cn/swf/opPlayer20140624_V1_0_0_2.swf?continuePlayer=0&video_id=201463685" name="preview">-->	
	<a data-link="http://p.you.video.sina.com.cn/swf/opPlayer20140624_V1_0_0_2.swf?continuePlayer=0&video_id=<?php echo $_GET[video_id];?>" name="preview">
	<i class="glyphicon glyphicon-check">预览</i>
	</a>
	</td>
	<td width="7%"><?php echo date('Y-m-d H:m:s', $video['createtime']);?></td>
	</tr>
	<?php }?>
	<tr style="align:center">
		<td colspan="7" align="center">
<?php
		if ($totalPages > 1) {
		echo "<span><a href='/list.php?page=" .   max(1, $page - 1) . " '>上一页</a></span>";
				if ($totalPages < 10) {
					for($i = 1; $i<= $totalPages; $i++ ) {
						echo "<span><a href='/list.php?page=$i'>$i </span>";	
					}
				} elseif ($page > 5) {
					echo "<span><a href='/list.php?page=1' >1</a></span>";
					echo "<span>...</span>";
					echo  "<span><a href='javascript(viod(0))' >$page</a></span>";
					echo "<span>...</span>";
					echo "<span><a href='/list.php?page='>$totalPages</a></span>";
				} elseif ($page < 5) {
					for($i = 1; $i<=5; $i++) {
						echo "<span><a href='/list.php?page=$i'>$i </span>";	
					}
					echo "<span>...</span>";
					echo "<span><a href='/list.php?page='>$totalPages</a></span>";
				} 
		echo "<span><a href='/list.php?page=" .  min($totalPages, $page + 1) . "'>下一页</a></span>";
		}
?>
		</td>
	</tr>
</table>
<script type="text/javascript" src="/scripts/jquery/jquery.js"></script>
<script type="text/javascript" src="/scripts/jquery/jquery.fancybox.js"></script>
<script type="text/javascript" src="/scripts/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="/scripts/modules/video.js"></script>
<script type="text/javascript">
	Video.bindFancybox();
</script>
</body>
</html>
