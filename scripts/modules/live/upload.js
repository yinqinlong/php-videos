var upload = {
	logoUpload : function(inputFileId){
		this.loading(inputFileId);
		$.ajaxFilesUpload({
			url: '/live/provider/logoImage',
			type: 'post',
			secureuri: false, //一般设置为false
			fileElementId: inputFileId, // 上传文件的id、name属性名
			dataType: 'json', //返回值类型，一般设置为json
			
			success: function(data, status) {
				if(data.code == 1) {
					var imageHtml = upload.pieceImageHtml(data.data);
					upload.uploadSuccess(inputFileId, data.data.source, imageHtml);
				} else {
					upload.uploadError(inputFileId, data.messages);
				}
			},
			error: function(data, status, e){ 
				alert(e);
			}
		});
	},
	
	// 节目图图片上传
	programImageUpload : function(inputFileId) {
		this.loading(inputFileId);
		$.ajaxFilesUpload({
			url: '/live/program/imageUpload',
			type: 'post',
			secureuri: false, //一般设置为false
			fileElementId: inputFileId, // 上传文件的id、name属性名
			dataType: 'json', //返回值类型，一般设置为json
			
			success: function(data, status){
				if(data.code == 1) {
					var imageHtml = upload.pieceImageHtml(data.data);
					upload.uploadSuccess(inputFileId, data.data.source, imageHtml);
				} else {
					upload.uploadError(inputFileId, data.messages);
				}
			},
			error: function(data, status, e){ 
				alert(e);
			}
		});
	},
	
	imageUpload : function(inputFileId){
		this.loading(inputFileId);
		$.ajaxFilesUpload({
			url: '/live/provider/uploadImage',
			type: 'post',
			secureuri: false, //一般设置为false
			fileElementId: inputFileId, // 上传文件的id、name属性名
			dataType: 'json', //返回值类型，一般设置为json
			
			success: function(data, status){
				if(data.code == 1) {
					var imageHtml = upload.pieceImageHtml(data.data);
					upload.uploadSuccess(inputFileId, data.data.imageUrl, imageHtml);
				} else {
					upload.uploadError(inputFileId, data.messages);
				}
			},
			error: function(data, status, e){ 
				alert(e);
			}
		});
	},
	
	checkImage : function(inputFileId) {
		var element = document.getElementById(inputFileId);
		var fileImage = element.files[0];
		if (!fileImage.type.match(/image.*/)) {
			alert('文件必须为图片');
			return 0;
		}
		return 1;
	},
	
	loading : function(inputFileId){
		var loadHtml = "<img width=35 height=35 src='/resource/images/loading.gif'/>";
		$('#' + inputFileId + '_loading').html(loadHtml);
	},
	
	pieceImageHtml : function(data) {
		var img = "";
		for(var key in data) {
			img += "<img src='"+data[key]+"' /> ";
		}
		return img;
	},
	
	uploadSuccess : function(inputFileId, imageUrl, imageHtml) {
		this.cancelLoading(inputFileId);
		$("input[name="+inputFileId+"]").val(imageUrl);
		$('#' + inputFileId + '_loading').html('<span style="color:red"> 恭喜您！图片上传成功</span>');
		$("#"+inputFileId+"UploadBox").html(imageHtml);
	},
	uploadError : function(inputFileId, message) {
		$('#' + inputFileId + '_loading').html('');
		$('#' + inputFileId + '_loading').html('<span style="color:red"> '+ message +'</span>');
	},
	cancelLoading : function(inputFileId){
		$('#' + inputFileId + '_loading').html('');
	},
};

