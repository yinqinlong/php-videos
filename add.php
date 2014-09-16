<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>视频下载助手</title>
    <meta name="keywords" content="Video downloader, download youtube, video download, youtube video, youtube downloader, download youtube FLV, download youtube MP4, download youtube 3GP, php video downloader" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	 <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-download {
        max-width: 500px;
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
      .form-download .form-download-heading,
      .form-download .checkbox {
        margin-bottom: 10px;
        text-align: center;
      }
      .form-download input[type="text"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .userscript {
        float: right;
        margin-top: 5px
      }

    </style>
	</head>
<body>

<div class="form-download"  id="download">
	<div>
		<form  method="get" action="getvideo.php">
			<h1 class="form-download-heading">视频下载助手</h1>

		<small><span style="color:red">(由于网络受限,下载youtube的视频需要存在本地硬盘，下载后还需要再手动上传到vms系统中)</span></small><p>
			<span>视频地址:</span>
			<input type="text" name="videoUrl" id="videoUrl" size="100" placeholder="http://www.youtube.com/watch?v=Fw-BM-Mqgeg" />
			<p>
			<span>是否遮印:</span>
			<input type="radio" name="delogo" value="1" size="40"/><span>是</span>
			<input type="radio" name="delogo" value="0" checked size="40"/><span>否</span>
			<p>
			<span>自动合并下载视频:</span>
			<input type="radio" name="merge" value="1" checked size="40"/><span>是</span>
			<input type="radio" name="merge" value="0" size="40"/><span>否</span>
			<small>(自动下载合并视频可能会花费比较长的时间)</small>
			<p>
			<span>水印位置:</span>
			<input type="text" name="coord" value="" size="40" placeholder="50,60,180,68"/>
			<small disable="disable">(请输入视频中水印的坐标及大小，用','隔开,顺序依次为logo左上角的x坐标，y坐标,宽,高)</small>
			<br>
			<input class="btn btn-primary" type="submit" name="type" id="type" value="Download" /> 

		<!-- @TODO: Prepend the base URI -->
	  </form>

  </div>
</div>
</body>
</html>
