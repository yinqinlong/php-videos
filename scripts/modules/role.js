var Role = {
	togglePrivilegeList : function(systemId) {
		$('[data-system]').removeClass("active");
		$('[data-system="'+ systemId +'"]').addClass("active");
		
		$('[data-value]').hide();
		$('[data-value="'+ systemId +'"]').show();
	},
	
	/**
	 * 改变权限
	 */
	privilege : function(element) {
		var privilegeId = $(element).val();
		var checked = $(element).is(':checked');
		console.log(checked);
		
		if(checked == true) {
			Role.grant(privilegeId);
		} else {
			Role.revoke(privilegeId);
		}
	},
	
	/**
	 * 权限赋予
	 */
	grant : function(privilegeId) {
		var privileges = [].concat(navigators, menus, controllers);
		/**
		 * 找到自己
		 * 找到父亲
		 * 找到爷爷
		 * 找到孩子和孙子
		 */
		var myself = null;
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i].privilegeId == privilegeId) {
				myself = privileges[i];
				break;
			}
		}
		
		var parent = null;
		if(myself != null) {
			for(var i = 0; i < privileges.length; i++) {
				if(privileges[i].privilegeId == myself.parentId) {
					parent = privileges[i];
					break;
				}
			}
		}
		
		var grandparent = null;
		if(parent != null) {
			for(var i = 0; i < privileges.length; i++) {
				if(privileges[i].privilegeId == parent.parentId) {
					grandparent = privileges[i];
					break;
				}
			}
		}
		
		var children = [];
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i].parentId == myself.privilegeId) {
				children.push(privileges[i]);
			}
		}
		
		var grandsons = []
		if(children.length > 0) {
			for(var i = 0; i < privileges.length; i++) {
				for(var n = 0; n < children.length; n++) {
					if(children[n].privilegeId == privileges[i].parentId) {
						grandsons.push(privileges[i]);
					}
				}
			}
		}
		
		var privileges = [].concat(myself, parent, grandparent, children, grandsons);
		var privilegeIds = [];
		
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i] != null) {
				privilegeIds.push(privileges[i].privilegeId);
			}
		}
		$.ajax({
			type : 'post',
			url : ajaxGrantURL,
			data : 'privilege_ids='+ privilegeIds.join(','),
			dataType : 'json',
			success : function(response){
				if(response.code == '0') {
					$('input:checkbox[value="'+ privilegeId +'"]').prop('checked', false);
					$('input:checkbox[value="'+ privilegeId +'"]').attr('checked', false);
					$('input:checkbox[value="'+ privilegeId +'"]').removeAttr('checked');
					alert(response.messages);
					return;
				}

				for(var i = 0; i < privilegeIds.length; i++) {
					$('input:checkbox[value="'+ privilegeIds[i] +'"]').attr('checked', true);
					$('input:checkbox[value="'+ privilegeIds[i] +'"]').prop('checked', true);
				}
			}
		});
	},
	
	/**
	 * 权限收回
	 */
	revoke : function(privilegeId) {
		var privileges = [].concat(navigators, menus, controllers);
		/**
		 * 找到自己
		 * 找到孩子和孙子
		 */
		var myself = null;
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i].privilegeId == privilegeId) {
				myself = privileges[i];
				break;
			}
		}
		var children = [];
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i].parentId == myself.privilegeId) {
				children.push(privileges[i]);
			}
		}
		var grandsons = []
		if(children.length > 0) {
			for(var i = 0; i < privileges.length; i++) {
				for(var n = 0; n < children.length; n++) {
					if(children[n].privilegeId == privileges[i].parentId) {
						grandsons.push(privileges[i]);
					}
				}
			}
		}
		
		var privileges = [].concat(myself, children, grandsons);
		var privilegeIds = [];
		
		for(var i = 0; i < privileges.length; i++) {
			if(privileges[i] != null) {
				privilegeIds.push(privileges[i].privilegeId);
			}
		}
		
		$.ajax({
			type : 'post',
			url : ajaxRevokeURL,
			data : 'privilege_ids='+ privilegeIds.join(','),
			dataType : 'json',
			success : function(response){
				if(response.code == '0') {
					$('input:checkbox[value="'+ privilegeId +'"]').attr('checked', true);
					$('input:checkbox[value="'+ privilegeId +'"]').prop('checked', true);
					alert(response.messages);
					return;
				}
				
				for(var i = 0; i < privilegeIds.length; i++) {
					$('input:checkbox[value="'+ privilegeIds[i] +'"]').prop('checked', false);
					$('input:checkbox[value="'+ privilegeIds[i] +'"]').attr('checked', false);
					$('input:checkbox[value="'+ privilegeIds[i] +'"]').removeAttr('checked');
				}
			}
		});
	},
	
	defaults : function(defaults) {
		$('[name="privilege_id[]"]').each(function() {
			var checked = $.inArray(parseInt(this.value), defaults) > -1 ? true : false;
			this.checked = checked;
		});
	},
	
	bindFancybox : function() {
		$('[name="edit"], [name="privilege"]').click(function() {
			$.fancybox({
				'width' : '75%',
				'height' : '90%',
				'autoScale' : false,
				'type' : 'iframe',
				'href' : $(this).attr('data-link')
			});
		});
	}
};