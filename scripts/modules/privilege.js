var Privilege = {
	toggle : function(systemId) {
		$('[data-system]').removeClass("active");
		$('[data-system="'+ systemId +'"]').addClass("active");
		
		$('[data-value]').hide();
		$('[data-value="'+ systemId +'"]').show();
	}
};