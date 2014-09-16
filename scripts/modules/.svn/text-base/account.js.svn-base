var Account = {
	
	/**
	 * 填充部门
	 * @param element
	 * @param data
	 */
	fillDepartments : function(element, departments) {
		element = $('#'+ element);
		element.html();
		element.css('width', '240px');
		
		for(var i = 0; i < departments.length; i++) {
			var department = departments[i];
			var pack = '';
			for(var n = 0; n < (department.depth - 1) * 4; n++) {
				pack += '&nbsp;';
			}
			element.append('<option value="'+ department.departmentId +'">'+ pack + department.name +'</option>');
		}
	},
	
	/**
	 * 部门默认值
	 * @param defaults
	 */
	departmentDefault : function(element, departmentDefaults) {
		element = $('#'+ element);
		
		for(var i = 0; i < departmentDefaults.length; i++) {
			element.find('option[value="'+ departmentDefaults[i] +'"]').attr('selected', true);
		}
	},
	
	/**
	 * 填充角色
	 * @param element
	 * @param departments
	 * @param roles
	 */
	fillRoles : function(element, departments, roles) {
		element = $('#'+ element);
		element.html();
		element.css('width', '240px');
		
		for(var i = 0; i < departments.length; i++) {
			var department = departments[i];
			var pack = '';
			for(var n = 0; n < (department.depth - 1) * 4; n++) {
				pack += '&nbsp;';
			}
			var group = $('<optgroup label="'+ pack + department.name +'"></optgroup>');
			for(var n = 0; n < roles.length; n++) {
				var role = roles[n];
				
				if(role.departmentId == department.departmentId) {
					group.append('<option value="'+ role.roleId +'">'+ role.name +'</option>');
				}
			}
			element.append(group);
		}
	},
	
	/**
	 * 角色默认值
	 * @param element
	 * @param roleDefaults
	 */
	roleDefault : function(element, roleDefaults) {
		element = $('#'+ element);
		
		for(var i = 0; i < roleDefaults.length; i++) {
			element.find('option[value="'+ roleDefaults[i] +'"]').attr('selected', true);
		}
	}
};