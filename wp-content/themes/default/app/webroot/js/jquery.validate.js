(function($) {
	$.fn.validator = function(settings) {
		var config = $.extend({
			clss       : '.need',
			attr       : 'title',
			hasDefault : false,
			onFail     : null
		}, settings || {});

		return this.each(function() {
			var msg = [];

			$(this).submit(function(e) { 
				$(this).find(config.clss).each(function() {
					if ( $(this).val() == "" || ( config.hasDefault && $(this).val() == $(this).attr(config.attr) ) ) {
						msg.push("- O campo " + $(this).attr(config.attr) + " deve ser preenchido"); 
					}
				});

				if (msg.length > 0) {
					str = '';
					for (var i in msg) {
						str += msg[i] + "\n";
					}

					msg = [];
					if (typeof(config.onFail) === "function") {
						config.onFail();
					}
					
					e.preventDefault();
					alert(str);
				}
			});
		});
	}
})(jQuery);