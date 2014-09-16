var Video = {
	
	Channel : {
		
		maxLevel : 4,
		
		selectedChannelIds : [],
		
		fill : function(parentId, level) {
			if(level >= this.maxLevel) {
				return;
			}
		
			for(var i = 0; i < this.maxLevel;  i++) {
				if(i >= level) {
					$('[name="channel"][level="'+ (i + 1) +'"]').children().remove();
				}
			}
			
			var element = $('div[name="channel"][level="'+ (level + 1) +'"]');
			var storedChannelIds = localStorage.getItem('channelIds');
			storedChannelIds = $.parseJSON(storedChannelIds);
			
			if(level == 0 && $.isArray(storedChannelIds) && storedChannelIds.length > 0) {
				for(var i = channels.length - 1; i >= 0; i--) {
					var channel = channels[i];
					if($.inArray(channel.channelId, storedChannelIds) != -1) {
						$('<a name="channel" level="'+ level +'" data="'+ channel.channelId +'" class="list-group-item" onclick="Video.Channel.select('+ channel.channelId +'); Video.Channel.fill('+ channel.channelId +', '+ (level + 1) +');">'+ channel.name +'</a>').appendTo(element);
					}
				}
				$('<a name="channel" class="list-group-item center" style="height:3px;padding:0;border-top:1px dashed;">&nbsp;</a>').appendTo(element);
			}
		
			for(var i = channels.length - 1; i >= 0; i--) {
				var channel = channels[i];
				if(level == 0 && $.inArray(channel.channelId, storedChannelIds) != -1) {
					continue;
				}
				if(channel.parentId == parentId) {
					$('<a name="channel" level="'+ level +'" data="'+ channel.channelId +'" class="list-group-item" onclick="Video.Channel.select('+ channel.channelId +'); Video.Channel.fill('+ channel.channelId +', '+ (level + 1) +');">'+ channel.name +'</a>').appendTo(element);
				}
			}
		},
		
		select : function(channelId) {
			var channelOption = $('[name="channel"][data="'+ channelId +'"]').get(0);
			var channelLevel = $(channelOption).attr('level');
			for(var level = this.maxLevel; level >= channelLevel; level--) {
				$('[name="channel"][level="'+ level +'"]').removeClass('active');
			}
			
			$('[name="channel"][data='+ channelId +']').addClass('active');
			$('#channel_id').val(channelId);
		}
	},
	
	Category : {
		
		maxLevel : 3,
		
		selectedCategoryIds : [],
		
		fill : function(parentId, level) {
			if(level >= this.maxLevel) {
				return;
			}
		
			for(var i = 0; i < this.maxLevel;  i++) {
				if(i >= level) {
					$('[name="category"][level="'+ (i + 1) +'"]').children().remove();
				}
			}
			
			var element = $('div[name="category"][level="'+ (level + 1) +'"]');
			var storedCategoryIds = localStorage.getItem('categoryIds');
			storedCategoryIds = $.parseJSON(storedCategoryIds);
			
			if(level == 0 && $.isArray(storedCategoryIds) && storedCategoryIds.length > 0) {
				for(var i = categories.length - 1; i >= 0; i--) {
					var category = categories[i];
					if($.inArray(category.categoryId, storedCategoryIds) != -1) {
						$('<a name="category" level="'+ level +'" data="'+ category.categoryId +'" class="list-group-item" onclick="Video.Category.select('+ category.categoryId +'); Video.Category.fill('+ category.categoryId +', '+ (level + 1) +');">'+ category.name +'</a>').appendTo(element);
					}
				}
				$('<a name="category" class="list-group-item center" style="height:3px;padding:0;border-top:1px dashed;">&nbsp;</a>').appendTo(element);
			}
			
			
			for(var i = categories.length - 1; i >= 0; i--) {
				var category = categories[i];
				if(level == 0 && $.inArray(category.categoryId, storedCategoryIds) != -1) {
					continue;
				}
				if(category.parentId == parentId) {
					$('<a name="category" level="'+ level +'" data="'+ category.categoryId +'" class="list-group-item" onclick="Video.Category.select('+ category.categoryId +'); Video.Category.fill('+ category.categoryId +', '+ (level + 1) +');">'+ category.name +'</a>').appendTo(element);
				}
			}
		},
		
		select : function(categoryId) {
			var categoryOption = $('[name="category"][data='+ categoryId +']').get(0);
			var categoryLevel = $(categoryOption).attr('level');
			for(var level = this.maxLevel; level >= categoryLevel; level--) {
				$('[name="category"][level="'+ level +'"]').removeClass('active');
			}
			
			$('[name="category"][data="'+ categoryId +'"]').addClass('active');
			
			$('#category_id').val(categoryId);
		}
	},
	
	Media : {
		autoComplete : function(elementBind, elementTarget) {
			var event = arguments.callee.caller.arguments[0] || window.event;
			if(-1 != $.inArray(event.keyCode, [9, 13, 37, 38, 39, 40])) {
				return;
			}
			
			function mapIsOutSide(isOutSide) {
				var text;
				//1：是，2：否
				switch(isOutSide) {
					case '1':
						text = '可以外引';
						break;
					case '2':
						text = '不可外引';
						break;
					default:
						text = '';
						break;
				}
				return text;
			};
			
			function mapFilterIp(filterIp) {
				var text;
				//0：无限制，1：仅大陆，2：国外和港台，9：世界杯限制
				switch(filterIp) {
					case '0':
						text = '无IP限制';
						break;
					case '1':
						text = '仅限于大陆IP';
						break;
					case '2':
						text = '仅限于国外和港台IP';
						break;
					case '9':
						text = '世界杯限制';
						break;
					default:
						text = '';
						break;
				}
				return text;
			};

			function mapDownloadTerminal(downloadTerminal) {
				var text;
				//1：都不可下载，2：都可下载，3：PC可下载，4：PAD可下载，5：移动端可下载
				switch(downloadTerminal) {
					case '1':
						text = '不可下载';
						break;
					case '2':
						text = '可以下载';
						break;
					case '3':
						text = '只PC可下载';
						break;
					case '4':
						text = '只PAD可下载';
						break;
					case '5':
						text = '只移动端可下载';
						break;
					default:
						text = '';
						break;
				}
				return text;
			};
			
			function mapChargeTerminal(chargeTerminal) {
				var text;
				//1：都不收费，2：都收费，3：PC端收费，4：PAD端收费，5：移动端收费
				switch(chargeTerminal) {
					case '1':
						text = '不收费';
						break;
					case '2':
						text = '收费';
						break;
					case '3':
						text = '只PC端收费';
						break;
					case '4':
						text = '只PAD端收费';
						break;
					case '5':
						text = '只移动端收费';
						break;
					default:
						text = '';
						break;
				}
				return text;
			};
			
			$.ajax({
				type : 'POST',
				url : '/vod/video/ajaxLoadMedias',
				data : 'keyword='+ $('#'+ elementBind).val(),
				async : true,
				success : function(response) {
					var medias;
					var sources = [];
					
					if(!response) {
						return;
					}
					
					medias = eval('(' + response + ')');
					
					for(var i = 0; i < medias.length; i++) {
						var media = medias[i];
						sources.push(media.name);
					}
					
					$('#'+ elementBind).autocomplete({
						maxRows : 10,
						source : sources,
						autoFocus : true,
						select : function(event, ui) {
							for(var i = 0; i < medias.length; i++) {
								var media = medias[i];
								if(media.name == ui.item.value) {
									var restrictTexts = [''];
									restrictTexts.push(mapIsOutSide(media['is_outside']));
									restrictTexts.push(mapFilterIp(media['filter_ip']));
									restrictTexts.push(mapDownloadTerminal(media['download_terminal']));
									restrictTexts.push(mapChargeTerminal(media['charge_terminal']));
									
									$('#'+ elementTarget).val(media['media_id']);
									$('#RestrictText').html(restrictTexts.join(' ◼ '));
									$('#RestrictTextWrapper').show();
									
									Video.Program.fill(media['media_id']);
									return;
								}
							}
						}
					});
					
					$('#'+ elementBind).autocomplete('search', null);
				}
			});
		}
	},
	
	Program : {
		
		fill : function(mediaId) {
			
			var element = $('#media_program_id');
			element.html('<option value="">请选择栏目</option>');
			
			$.ajax({
				type : 'POST',
				url : '/vod/video/ajaxLoadMediaProgramsByMediaId',
				data : 'media_id='+ mediaId,
				success : function(response) {
					if(!response) {
						return;
					}
					mediaPrograms = eval('(' + response + ')');
					for(var i = 0; i < mediaPrograms.length; i++) {
						var mediaProgram = mediaPrograms[i];
						element.append('<option value="'+ mediaProgram['media_program_id'] +'">'+ mediaProgram['full_name'] +'</option>');
					}
				}
			});
		}
	},
	
	Brand : {
		check : function(element, value) {
			
			$('.logo').css('border', '5px solid #fff');
			
			if($('#logo').val() != value) {
				$(element).css('border', '5px solid #3e8acc');
				$('#logo').val(value);
				$('#position').show();
			} else {
				$('#logo').val('');
				$('#position').hide();
				$('[name="position"]').attr('checked', false);
			}
		}
	},
	
	List : {
		changeRow : function(values) {
			var videoId = 0;
			var title = '';
			
			for(var i = 0; i < values.length; i++) {
				var item = values[i];
				if(item.name == 'video_id') {
					videoId = item.value;
				}
				if(item.name == 'title') {
					title = item.value;
				}
			}
			$('[data-row="'+ videoId +'"] td strong a').html(title);
		}
	},
	
	Upload : {
		
		values : {},
		
		data : {},
		
		updateInfo : function(values) {
			var videoId = 0;
			var title = '';
			
			for(var i = 0; i < values.length; i++) {
				var item = values[i];
				if(item.name == 'video_id') {
					videoId = item.value;
				}
				if(item.name == 'title') {
					title = item.value;
				}
			}
			$('#name-'+ videoId).html(title);
		},
		
		execute : function() {
			var element = document.getElementById('file');
			
			try {
				this.before();
			} catch(e) {
				console.log(e.message);
				alert(e.message);
				return;
			}

			for(var i = 0; i < element.files.length; i++) {
				var file = element.files[i];
				try {
					this.request(this, file);
				} catch(e) {
					console.log(e.message);
					alert(e.message);
					return;
				}
			}
		},
	
		before : function() {
			var errors = [];
			
			var channelId = Number($('#channel_id').val());
			var categoryId = Number($('#category_id').val());
			var mediaId = Number($('#media_id').val());
			var mediaProgramId = Number($('#media_program_id').val());
			var logo = Number($('#logo').val());
			var position = Number($('#position').val());
			
			var channel;
			for(var i = 0; i < channels.length; i++) {
				if(channels[i].channelId == channelId) {
					channel = channels[i];
					break;
				}
			}
			if(typeof(channel) == 'undefined') {
				errors.push('请选择频道');
			} else if(channel.path.split(',').length == 1) {
				for(var i = 0; i < channels.length; i++) {
					if(channels[i].parentId == channel.channelId) {
						errors.push('请选择二级频道');
						break;
					}
				}
			} else {
				//
			}
			
			var category;
			for(var i = 0; i < categories.length; i++) {
				if(categories[i].categoryId == categoryId) {
					category = categories[i];
					break;
				}
			}
			
			if(typeof(category) == 'undefined') {
				errors.push('请选择分类');
			} else if(category.path.split(',').length == 1) {
				for(var i = 0; i < categories.length; i++) {
					if(categories[i].parentId == category.categoryId) {
						errors.push('请选择二级分类');
						break;
					}
				}
			} else {
				//
			}
			
			if(mediaId == NaN || mediaId == 0) {
				errors.push('请选择媒体');
			}
			
			//ungraceful
			if($('#media_program_id').children().length > 1 && (mediaProgramId == NaN || mediaProgramId == 0)) {
				errors.push('请选择栏目');
			}
			
			if(errors.length > 0) {
				console.log(errors);
				throw new Error(errors.join("\n"));
				return;
			}
			
			this.data = {'channel_id' : channelId, 'category_id' : categoryId, 'media_id' : mediaId, 'media_program_id' : mediaProgramId, 'logo' : logo, 'position' : position};
			
			
			//store channelId
			var storeChannelIds = [];
			var selectChannelId;
			for(var i = 0; i < channels.length; i++) {
				if(channels[i].channelId == channelId) {
					var path = channels[i].path;
					var pairs = path.split(',');
					selectChannelId = pairs[0];
					break;
				}
			}

			var storedChannelIds = localStorage.getItem('channelIds');
			storedChannelIds = storedChannelIds == null || storedChannelIds == '' ? [] : $.parseJSON(storedChannelIds);
			
			//重新储存数组。只5个，硬编码
			for(var i = storedChannelIds.length - 1; i >= 0; i--) {
				if(storedChannelIds[i] == selectChannelId) {
					continue;
				}
				if(storeChannelIds.length >= 4) {
					break;
				}
				storeChannelIds.push(storedChannelIds[i]);
			}
			storeChannelIds.push(selectChannelId);
			
			
			//store categoryId
			var storeCategoryIds = [];
			var selectCategoryId;
			for(var i = 0; i < categories.length; i++) {
				if(categories[i].categoryId == categoryId) {
					var path = categories[i].path;
					var pairs = path.split(',');
					selectCategoryId = pairs[0];
					break;
				}
			}
			
			var storedCategoryIds = localStorage.getItem('categoryIds');
			storedCategoryIds = storedCategoryIds == null || storedCategoryIds == '' ? [] : $.parseJSON(storedCategoryIds);
			for(var i = storedCategoryIds.length - 1; i >= 0; i--) {
				if(storedCategoryIds[i] == selectCategoryId) {
					continue;
				}
				if(storeCategoryIds.length >= 4) {
					break;
				}
				storeCategoryIds.push(storedCategoryIds[i]);
			}
			storeCategoryIds.push(selectCategoryId);
			
			localStorage.setItem('channelIds', $.toJSON(storeChannelIds));
			localStorage.setItem('categoryIds', $.toJSON(storeCategoryIds));
		},
		
		request : function(self, file) {
			$.ajax({
				async : false,
				url : '/vod/video/getVideoId',
				data : {},
				type : 'get',
				dataType : 'json',
				success : function(response) {
					self.create(self, file, response.data['video_id'], response.data['token']);
				}
			});
		},
		
		create : function(self, file, videoId, token) {
			values = self.data;
			values.title = file.name;
			values.video_id = videoId;
			values.token = token;
			values.file_size = file.size;
			
			$.ajax({
				async : false,
				url : '/vod/video/create',
				data : values,
				type : 'post',
				dataType : 'json',
				success : function(response) {
					if(response.code != 'A0001') {
						throw new Error(response.message);
					}
					var uploadURL = response.data.upload_url;
					var uploadId = response.data.upload_id;
					var stateURL = response.data.state_url;
					self.send(self, videoId, file, uploadId, uploadURL, stateURL);
				},
				error : function(xhr, status, message) {
					console.log(message);
					console.log(status);
				}
			});
		},
		
		send : function(self, videoId, file, uploadId, uploadURL, stateURL) {
			var wrapper = 'UploadBox';
			var crossURL = '/vod/video/cross';
			var infoURL = '/vod/video/edit';
			
			try {
				new Upload()
					.file(file)
					.videoId(videoId)
					.url(uploadURL)
					.state(stateURL)
					.cross(crossURL)
					.info(infoURL)
					.wrapper(wrapper)
					.execute();
			} catch(e) {
				console.log(e.message);
			}
		},
		
		reset : function() {
			if(confirm('确定要重置信息么？')) {
				$('#channel_id').val('');
				$('#category_id').val('');
				$('#media_id').val('');
				$('#media_program_id').val('');
				$('#media_name').val('');
				$('#logo').val('');
				$('[name="position"]').attr('checked', false);
				$('.logo').css('border', '5px solid #fff');
				$('#position').hide();
				$('#RestrictTextWrapper').hide();
				
				Video.Channel.fill(0, 0);
				Video.Category.fill(0, 0);
			}
		}
	},

	bindFancybox : function() {
		$('[name="info"]').click(function() {
			$.fancybox({
				'width' : '85%',
				'height' : '90%',
				'autoScale' : false,
				'type' : 'iframe',
				'href' : $(this).attr('data-link')
			});
			return false;
		});
		
		$('[name="edit"]').each(function() {
			$(this).fancybox({
				'afterLoad' : function() {
					try {
						var iframe = $('.fancybox-iframe').get(0);
						$(iframe.contentWindow).ready(function() {
							var iForm = $(iframe.contentWindow).get(0).Form;
							iForm.callback = 'parent.Video.List.changeRow';
							iForm.inFancybox = true;
						});
					} catch(e) {
						console.log(e.message);
					}
				},
				
				'width' : '90%',
				'height' : '60%',
				'autoScale' : false,
				'type' : 'iframe',
				'href' : $(this).attr('data-link')
			});
		});
		
		
		$('[name="tags"]').click(function() {
			$.fancybox({
				'width' : '90%',
				'height' : '30%',
				'autoScale' : false,
				'type' : 'iframe',
				'href' : $(this).attr('data-link')
			});
			return false;
		});
		
		$('[name="preview"]').click(function() {
			$.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none',
				'title'			: 'test',
				'width'			: 800,
				'height'		: 600,
				'href'			: $(this).attr('data-link'),
				'type'			: 'swf',
				'swf'			: {
					'wmode'				: 'transparent',
					'allowfullscreen'	: 'true'
				}
			});
			return false;
		});
		
		$(document).on('click', '[rel="fancybox"]', function() {
			$.fancybox({
				'afterLoad' : function() {
					try {
						var iframe = $('.fancybox-iframe').get(0);
						$(iframe.contentWindow).ready(function() {
							var iForm = $(iframe.contentWindow).get(0).Form;
							iForm.callback = 'parent.Video.Upload.updateInfo';
							iForm.inFancybox = true;
						});
					} catch(e) {
						console.log(e.message);
					}
				},
				
				'width' : '90%',
				'height' : '60%',
				'autoScale' : false,
				'type' : 'iframe',
				'href' : $(this).attr('data-link')
			});
		});
	}
};
