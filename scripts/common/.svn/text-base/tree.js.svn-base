/**
 * 树状结婚展示
 * 此类实现树状展示数据		设置下拉框树状数据
 * 

var data = [];

data.push({id : '1', name : '凤凰网', value : '1', parent : '0',  operate: '[<a href="/index.php/department/edit/department_id:1">编辑</a> | <a href="/index.php/department/delete/department_id:1" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '2', name : '广告部', value : '2', parent : '1', operate: '[<a href="/index.php/department/edit/department_id:2">编辑</a> | <a href="/index.php/department/delete/department_id:2" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '3', name : '总监', value : '3', parent : '2', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '4', name : '副总监', value : '4', parent : '3', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});

data.push({id : '5', name : '新浪', value : '5', parent : '0', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '6', name : '新浪广告部', value : '6', parent : '5', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});

data.push({id : '7', name : '新浪总监', value : '7', parent : '6', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '8', name : '腾迅', value : '8', parent : '0', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});

data.push({id : '9', name : '腾迅广告部', value : '9', parent : '8', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});
data.push({id : '10', name : '腾迅总监 ', value : '10', parent : '9', operate: '[<a href="/index.php/department/edit/department_id:3">编辑</a> | <a href="/index.php/department/delete/department_id:3" onclick="return confirm(\'确定删除吗？\');">删除</a>]'});

var t = new Tree('department', data);
t.display('2');

 */

function Tree(container, data) {
	this.container = container;
	this.data = data;
	this.level = 1;
	this.currentLevel = 0;
};

Tree.prototype = {
	/**
	 * 获取树状HTML代码
	 */
	getHtml : function(parent) {
		var data = this.data;
		var length = data.length;
		var html = '';
		var childHtml = '';
		
		this.currentLevel++;
		
		for(var i = 0; i < length; i++) {
			if(data[i].parent != parent) {
				continue;
			}
			
			if(this.currentLevel >= this.level) {
				html += '<li><span>' + data[i].name + data[i].operate + '</span>';
			} else {
				//html += '<li>' + data[i].name + data[i].operate;
			}
			
			childHtml = this.getHtml(data[i].id);
			
			if(childHtml) {
				html += '<ul>' + childHtml + '</ul>';
			}
			html += '</li>';
		}
		
		this.currentLevel--;
		
		return html;
	},
	
	/**
	 * 展示某一层级的树
	 */
	display : function(level) {
		this.level = level < 1 ? 1 : level;
		$('#' + this.container).empty();
		
		var html = this.getHtml(0);
		
		$('#' + this.container).html(html);
		
		//阻止链接的click 事件冒泡
		$('#' + this.container + ' a').bind('click', function(event) {
			event.stopPropagation();
		});
		
		$("#" + this.container).treeview({
			animated: 'fast',
			persist: 'location',
			//cookieId: 'ntree',
			collapsed: true
		});
	}
};

