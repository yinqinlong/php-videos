/**
 * 调整工作区尺寸
 */
function resizeContentHeight() {
	var mainHeight = document.body.clientHeight - 98;
	$('#mainIframe').height(mainHeight);
}

/**
 * 初始化导航
 * @param navigators
 */
function initializeNavigator(navigators) {
	var navigatorBox = $('#NavigatorBox');
	navigatorBox.children().remove();

	for(var i = 0; i < navigators.length; i++) {
		var navigator = navigators[i];
		var navigatorId = navigator.privilegeId;
		var HTML = '<li data-navigator="'+ navigatorId +'"><a onclick="loadMenu('+ navigatorId +');"><span class="'+ navigator.icon +'"></span> <span class="text">'+ navigator.name +'</span></a></li>';
		navigatorBox.append(HTML);
	}
}

/**
 * 初始化菜单
 * @param menus
 */
function initializeMenu(navigatorId) {
	var menuBox = $('#MenuBox');
	menuBox.children().remove();
	
	for(var i = 0; i < menus.length; i++) {
		var menu = menus[i];

		var controllerHTML = '';
		for(var n = 0; n < controllers.length; n++) {
			var controller = controllers[n];
			if(controller.parentId != menu.privilegeId) {
				continue;
			}
			controllerHTML += '<li><a href="'+ controller.target +'" target="mainContent"><span class="glyphicon glyphicon-th-list btn-xs"></span><span class="text">'+ controller.name +'</span></a></li>';
		}
		controllerHTML = '<ul class="collapse" id="Menu'+ menu.privilegeId +'">'+ controllerHTML +'</ul>';
		
		var menuHTML = '<li class="accordion-group" data-navigator="'+ menu.parentId +'"><a href="#Menu'+ menu.privilegeId +'" data-parent="#MenuBox" data-toggle="collapse"><span class="'+ menu.icon +' btn-xs"></span><span class="text">'+ menu.name +'</span></a>'+ controllerHTML +'</li>';
		menuBox.append(menuHTML);
		menuBox.find('[data-navigator]').hide();
	}
	
}

function loadMenu(navigatorId) {
	var navigatorBox = $('#NavigatorBox');
	var menuBox = $('#MenuBox');
	
	navigatorBox.find('[data-navigator]').removeClass('active');
	navigatorBox.find('[data-navigator="'+ navigatorId +'"]').addClass('active');
	
	menuBox.find('[data-navigator]').hide();
	menuBox.find('[data-navigator="'+ navigatorId +'"]').show();
}


$(window).load(function() {
		resizeContentHeight();
});

$(window).resize(function() {
		resizeContentHeight();
});

$(window).load(function() {
	
	initializeNavigator(navigators);
	initializeMenu(menus);
	loadMenu(defaultNavigator);
	
	// Side Bar Toggle
	$('.hide-sidebar').click(function() {
		$('.sidebar').hide('fast', function() {
			$('#main').removeClass('main');
			$('#main').addClass('main-full');
			$('.hide-sidebar').hide();
			$('.show-sidebar').show();
		});
	});

	$('.show-sidebar').click(function() {
		$('#main').removeClass('main-full');
		$('#main').addClass('main');
		$('.show-sidebar').hide();
		$('.hide-sidebar').show();
		$('.sidebar').show('fast');
	});

	$('#MenuBox > li > a').click(function() {
		var li = $(this).parent('li');
		var lis = li.siblings();
		var ul = lis.children();
		li.addClass('active');
		lis.removeClass('active');
		ul.removeClass('in');
	});

	$('#MenuBox > li > ul > li > a').click(function() {
		var li = $(this).parent('li');
		var span = li.parent().siblings('a').children(':eq(1)');
		var name = li.text().trim();
		var pname = span.text().trim();
		var html = '<li>'+pname+'</li><li>'+name+'</li>';
		$('.breadcrumb li:gt(0)').remove();
		$('.breadcrumb li').after(html);
	});
});
