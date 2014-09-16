<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Youtube Downloader</title>
    <meta name="keywords" content="Video downloader, download youtube, video download, youtube video, youtube downloader, download youtube FLV, download youtube MP4, download youtube 3GP, php video downloader" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	 <style type="text/css">
      	body {
	        padding-top: 40px;
	        padding-bottom: 40px;
	        background-color: #f5f5f5;
	}

	.download {
	        max-width: 600px;
	        padding: 19px 29px 29px;
	        margin: 0 auto 20px;
	        background-color: #fff;
	        border: 1px solid #e5e5e5;
	        -webkit-border-radius: 5px;
	           -moz-border-radius: 5px;
	                border-radius: 5px;
	        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }

      .download .download-heading {
      		text-align:center;
        	margin-bottom: 10px;
      }

      .mime, .itag {
      		width: 75px;
		display: inline-block;
      }

      .itag {
      		width: 15px;
      }
      
      .size {
      		width: 20px;
      }

      .userscript {
        	float: right;
       		margin-top: 5px
      }
	  
	  #info {
			padding: 0 0 0 130px;
			position: relative;
			height:100px;
	  }
	  
	  #info img{
			left: 0;
			position: absolute;
			top: 0;
			width:120px;
			height:90px
	  }
    </style>
	</head>
<body>
<span>网络错误，请<a href="<?php echo $_SERVER['REQUEST_URL']?>">重新尝试</a>或者直接使用手动方式尝<br></span>
<p>
	* 请先访问地址<a target="_blank" href="http://www.youtube.com/get_video_info?video_id=<?php echo $videoId;?>">http://www.youtube.com/get_video_info?video_id=<?php echo $videoId;?></a>,之后将下载的文件内容全部粘贴到下列文本框
</p>
<form action="youtube.php" method="post">
下载的编码：
<textarea name='code'>
</textarea>
<input type="hidden" name="url" value="<?php echo $_GET['videoUrl'];?>">
<input type='submit' value="提交">
</form>
</body>	
</html>
