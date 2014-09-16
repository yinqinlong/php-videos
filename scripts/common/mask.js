var Mask = {
	//position: absolute; top: 0px; filter: alpha(opacity=60); background-color: #777;  
	//z-index: 1002; left: 0px;  
	//opacity:0.5; -moz-opacity:0.5;
	
	maskLayer : 'MaskLayer',
	
	maskContentLayer : 'MaskContentLayer',
	
	show : function(content) {
		var maskElement = $('<div></div>');
		maskElement.attr('id', Mask.maskLayer);
		maskElement.css('position', 'absolute')
			.css('top', '0')
			.css('left', '0')
			.css('filter', 'alpha(opacity=70)')
			.css('background', '#777')
			.css('z-index', '999')
			.css('opacity', '0.7')
			.css('-moz-opacity', '0.7')
			.css('width', $(document).width())
			.css('height', $(document).height());
		$(document.body).append(maskElement);
		
		var contentElement = $('<div class="widget-box"></div>');
		contentElement.attr('id', Mask.maskContentLayer);
		contentElement.css('position', 'absolute')
				.css('top', ($(document).scrollTop() + 120) +'px')
				.css('left', ($(document.body).width() - 600) / 2)
				.css('z-index', '1000')
				.css('background', '#fff')
				.css('width', '600px')
				.css('padding', '20px')
				.css('text-align', 'center');
		contentElement.append(content);
		$(document.body).append(contentElement);
	},
	
	close : function() {
		$('#'+ Mask.maskLayer).remove();
		$('#'+ Mask.maskContentLayer).remove();
	}
};