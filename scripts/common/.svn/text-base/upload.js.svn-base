function Upload() {

	var instance = this;
	
	/**
	 * 视频id
	 */
	var videoId = 0;
	
	/**
	 * 待传文件
	 */
	var uploadFile = null;

	/**
	 * 上传地址
	 */
	var uploadURL = '';
	
	/**
	 * 跨域中转地址
	 */
	var crossURL = '';
	
	/**
	 * 传输状态地址
	 */
	var stateURL = '';
	
	/**
	 * 更新信息地址
	 */
	var infoURL = '';

	/**
	 * Wrapper Element
	 */
	var wrapperId = '';
	
	/**
	 * 事件开始
	 */
	var onStart = null;
	
	/**
	 * 事件完成
	 */
	var onComplete = null;
	
	/**
	 * 事件继续
	 */
	var onContinue = null;
	
	/**
	 * 事件取消
	 */
	var onAbort = null;
	
	/**
	 * XMLHttpRequest
	 */
	var xhr = null;
	
	/**
	 * FileReader
	 */
	var reader = null;
	
	/**
	 * 一次传送得字节数
	 */
	var packet = 1024 * 1024;

	/**
	 * 会话标识
	 */
	var sessionName = '';
	
	/**
	 * 已传输字节（临时计算）
	 */
	var bufferByteLoaded = 0;
	/**
	 * 已传输字节数
	 */
	var byteLoaded = 0;
	
	/**
	 * 总字节数
	 */
	var byteTotal = 0;
	
	function createStandardXHR() {
		try {
			return new window.XMLHttpRequest();
		} catch( e ) {}
	}

	function createActiveXHR() {
		try {
			return new window.ActiveXObject("Microsoft.XMLHTTP");
		} catch( e ) {}
	}
	
	/**
	 *  得到blob对象
	 *  @param File file
	 *  @param Object position
	 *  @return blob
	 */
	function getBlob(start, end) {
		if(uploadFile.slice){
			return uploadFile.slice(start, end);
        }
		if(uploadFile.webkitSlice) {
			return uploadFile.webkitSlice(start, end);
        }
		if(uploadFile.mozSlice) {
			return uploadFile.mozSlice(start, end);
        }
		return null;
	};
	
	/**
	 * 发送数据
	 */
	function startSend() {
		//事件开始
		if(onStart != null) {
			eval('onStart(instance)');
		}
		
		byteLoaded = 0;
		byteTotal = uploadFile.size;
		sendFile(0);
	};
	
	/**
	 * 续传数据
	 */
	function resumeSend() {
		var ixhr = window.ActiveXObject ? createActiveXHR() : createStandardXHR();
		ixhr.onreadystatechange = function() {
			if(ixhr.readyState == 4 && ixhr.status == 200) {
				var lines = ixhr.responseText;
				if(!lines) {
					startSend();
					return;
				}
				
				var ranges = lines.split("\r\n");
				if(ranges.length == 0) {
					startSend();
					return;
				}
				
				var range = ranges[ranges.length - 1].split("/");
				var positions = range[0].split("-");
				
				position = parseInt(positions[1]) + 1;
				byteLoaded = position;
				byteTotal = uploadFile.size;
				sendFile(position);
				
				return;
		    }
		};
		
		var url;
		if(crossURL) {
			url = crossURL +'?stateURL='+ stateURL + videoId +'.state';
		} else {
			url = stateURL + videoId +'.state';
		}
		
		//事件继续
		if(onContinue != null) {
			eval('onContinue(instance)');
		}
		
		ixhr.open('GET', url, true);
		ixhr.send(null);
	};
	
	/**
	 * http发送，结束回调
	 */
	function sendFile(position) {
		
		if(position > uploadFile.size) {
			changeContainerStatus('loaded');
			console.log('Done.');
			return;
		}
		
		var start = position;
		var end = (position + packet) > uploadFile.size ? uploadFile.size : (position + packet);
		
		position += packet;
		
		var blob = getBlob(start, end);

		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4 && xhr.status == 200) {
				byteLoaded = byteTotal;
				handleProcess();
				localStorage.removeItem(sessionName);
				changeContainerStatus('loaded');
				
				//事件完成
				if(onComplete != null) {
					eval('onComplete(instance)');
				}
				
				console.log('Done');
		    }
			if(xhr.readyState == 4 && xhr.status == 201) {
				changeContainerStatus('loading');
				sendFile(position);
		    }
		};
		xhr.open('POST', uploadURL, true);
		
		xhr.setRequestHeader("X-Session-ID", videoId);
		xhr.setRequestHeader("Content-Type", "application/octet-stream");
		xhr.setRequestHeader("Content-Disposition", "attachment; name=\"file\"; filename=\""+ uploadFile.name +"\"");
		xhr.setRequestHeader("X-Content-Range", "bytes "+ start +"-"+ (end - 1) +"/"+ uploadFile.size);
		//xhr.setRequestHeader("Content-Length", reader.result.length);

		reader.readAsBinaryString(blob);
	};
	
	function xhrUploadAbort() {
		
	};
	
	function xhrUploadLoadStart(ev) {
		
	};
	
	function xhrUploadLoad(ev) {
	};
	
	function xhrUploadLoadEnd(ev) {
		bufferByteLoaded = 0;
		byteLoaded += ev.loaded;
	};
	
	function xhrUploadProgress(ev) {
		bufferByteLoaded = ev.loaded;
		handleProcess();
	};
	
	function xhrUploadError() {
		
	};
	
	function xhrUploadTimeout() {
		
	};
	
	
	function readerLoadStart(ev) {
	};
	
	function readerLoad(ev) {
		xhr.sendAsBinary(reader.result);
	};
	
	function readerLoadEnd(ev) {
	};
	
	function readerAbort() {
		
	};
	
	function readerProgress(ev) {
	};
	
	function readerError() {
		
	};
	
	/**
	 * 终止上传
	 */
	function abort() {
		xhr.abort();
		reader.abort();
		
		//事件取消
		if(onAbort != null) {
			eval('onAbort(instance)');
		}
	};
	
	/**
	 * 继续上传
	 */
	function continuing() {
		if(byteLoaded < byteTotal) {
			resumeSend();
		}
	};
	
	/**
	 * 修改信息（标题、简介）
	 */
	function info() {
		
	};
	
	function handleProcess() {
		var progress = (byteLoaded + bufferByteLoaded) / byteTotal * 100;
		$('#'+ sessionName +' [name="Progress"]').attr('aria-valuenow', progress.toFixed(2)).css('width', progress.toFixed(2) +'%');
		$('#'+ sessionName +' [name="Number"]').html(progress.toFixed(2) +'%');
	};
	
	/**
	 * 创建容器
	 */
	function createContainer() {
		var container = document.createElement('div');
		$(container).attr('id', sessionName).attr('status', 'loading').css('width', '500px').css('display', 'block').css('clear', 'both');
		return $(container);
	};
	
	/**
	 * 回收容器
	 */
	function removeContainer() {
		$('#'+ sessionName).remove();
	};
	
	/**
	 * 创建InfoBar
	 */
	function createInfoBar(infoURL) {
		var infoBar = document.createElement('div');
		$(infoBar).attr('name', 'Info').css('display', 'block');
		
		var fileInfo = document.createElement('span');
		$(fileInfo).attr('id', 'name-'+ videoId).css('font-size', '14px').css('font-weight', '700').html(uploadFile.name);
		
		var abortButton = document.createElement('span');
		$(abortButton).attr('id', 'abort-'+ videoId).addClass('label label-primary').css('cursor', 'pointer').css('margin-left', '3px').html(' 取消 ');
		$(abortButton).bind('click', abort);

		var continueButton = document.createElement('span');
		$(continueButton).attr('id', 'continue-'+ videoId).addClass('label label-primary').css('cursor', 'pointer').css('margin-left', '3px').html(' 继续 ');
		$(continueButton).bind('click', continuing);
		
		var infoButton = document.createElement('span');
		$(infoButton).attr('id', 'edit-'+ videoId).addClass('label label-info').css('cursor', 'pointer').css('margin-left', '3px').html(' <a data-link="'+ infoURL +'?video_id='+ videoId +'" rel="fancybox" style="color:#fff;">修改</a> ');
		$(infoButton).bind('click', info);
		
		$(fileInfo).appendTo(infoBar);
		$(abortButton).appendTo(infoBar);
		$(continueButton).appendTo(infoBar);
		$(infoButton).appendTo(infoBar);
		
		return $(infoBar);
	};
	
	function changeContainerStatus(status) {
		$('#v'+ videoId).attr('status', status);
	};
	
	/**
	 * 创建LoadingBar
	 */
	function createLoadingBar() {
		var loadingBarContainer = document.createElement('div');

		var loadingBar = document.createElement('div');
//		$(loadingBar).attr('name', 'Bar').css('width', '450px').css('height', '4px').css('border', '1px solid #ccc').css('overflow', 'hidden').css('margin', '5px 2px').css('float', 'left').css('display', 'block');
		$(loadingBar).attr('name', 'Bar').addClass('progress').css('margin-top', '10px').css('height', '12px');
		var loadingBackground = document.createElement('div');
//		$(loadingBackground).attr('name', 'Progress').css('width', '0').css('height', '2px').css('background', '#1e66b7').css('display', 'block');
		$(loadingBackground).attr('name', 'Progress').addClass('progress-bar').attr('aria-valuemax', '100').attr('aria-valuemin', '0').attr('aria-valuenow', '0').attr('role', 'progressbar');
		
		var loadingNumber = document.createElement('span');
		$(loadingNumber).attr('name', 'Number').css('float', 'right').css('margin-right', '10px').css('font-size', '9px').css('line-height', '12px');
		
		$(loadingBackground).appendTo($(loadingBar));
		$(loadingBar).appendTo($(loadingBarContainer));
//		$(loadingNumber).appendTo($(loadingBarContainer));
		$(loadingNumber).appendTo($(loadingBackground));
		
		$(loadingNumber).html('0.00%');
		
		return $(loadingBarContainer);
	};
	
	function beforeUnload(ev) {
		var bars = $('#'+ wrapperId).find('[status]');
		for(var i = 0; i < bars.length; i++) {
			var status = $(bars[i]).attr('status');
			if(status == 'loading') {
				try {
					ev.returnValue = '离开本页面将终止正在上传的文件，确定离开本页吗？';
				} catch(e){
					
				}
				return;
			}
			console.log(status);
		}
	};

	this.videoId = function(id) {
		videoId = id;
		return this;
	};
	
	/**
	 * 上传地址
	 * @param string url
	 * @return Upload
	 */
	this.url = function(url) {
		uploadURL = url;
		return this;
	};
	
	/**
	 * 传输状态地址
	 */
	this.state = function(url) {
		stateURL = url;
		return this;
	};
	
	/**
	 * 跨域中转地址
	 */
	this.cross = function(url) {
		crossURL = url;
		return this;
	};
	
	this.info = function(url) {
		infoURL = url;
		return this;
	}

	/**
	 * 添加上传文件
	 * @param string file
	 * @return Upload
	 */
	this.file = function(localFile) {
		uploadFile = localFile;
		return this;
	};
	
	this.wrapper = function(elementId) {
		wrapperId = elementId;
		return this;
	};
	
	this.onStart = function(fn) {
		onStart = fn;
		return this;
	};
	
	this.onComplete = function(fn) {
		onComplete = fn;
		return this;
	};
	
	this.onContinue = function(fn) {
		onContinue = fn;
		return this;
	};
	
	this.onAbort = function(fn) {
		onAbort = fn;
		return this;
	};
	
	this.getFile = function() {
		return uploadFile;
	};
	
	this.getWrapper = function() {
		return $('#'+ wrapperId);
	};
	
	this.getSessionName = function() {
		return sessionName;
	};

	/**
	 * 执行上传
	 */
	this.execute = function() {
		
		sessionName = md5(uploadFile.name);
		if($('#'+ sessionName).length) {
			return;
		}
		
		//patch webkit
		if(!XMLHttpRequest.prototype.sendAsBinary) {
			XMLHttpRequest.prototype.sendAsBinary = function (data) {
				var bytes = data.length, unit8Data = new Uint8Array(bytes);
				for (var index = 0; index < bytes; index++) {
					unit8Data[index] = data.charCodeAt(index) & 0xff;
				}
				/* send as ArrayBufferView...: */
				this.send(unit8Data);
				/* ...or as ArrayBuffer (legacy)...: this.send(ui8Data.buffer); */
			};
		}
		xhr = window.ActiveXObject ? createActiveXHR() : createStandardXHR();
		xhr.upload.onloadstart = xhrUploadLoadStart;
		xhr.upload.onload = xhrUploadLoad;
		xhr.upload.onloadend = xhrUploadLoadEnd;
		xhr.upload.onabort = xhrUploadAbort;
		xhr.upload.onprogress = xhrUploadProgress;
		xhr.upload.onerror = xhrUploadError;
		xhr.upload.ontimeout = xhrUploadTimeout;
		
		reader = new FileReader();
		reader.onloadstart = readerLoadStart;
		reader.onload = readerLoad;
		reader.onloadend = readerLoadEnd;
		reader.onprogress = readerProgress;
		reader.onabort = readerAbort;
		reader.onerror = readerError;
		
		var container = createContainer();
		var infoBar = createInfoBar(infoURL);
		var loadingBar = createLoadingBar();
		
		infoBar.appendTo(container);
		loadingBar.appendTo(container);
		container.appendTo($('#'+ wrapperId));
		
		window.onbeforeunload = beforeUnload;
		
		var session = localStorage.getItem(sessionName);
		if(session != null) {
			session = $.parseJSON(session);
			videoId = session.videoId;
			resumeSend();
		} else {
			localStorage.setItem(sessionName, '{"videoId":"'+ videoId +'"}');
			startSend();
		}
	};
};