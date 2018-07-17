(function($) {
	/*
	Start with a date of 1940 and a time of 12:00
	because I'm bored of changing it back to these.
	*/
	if (parseFloat($('#aa').val()) > 1945) {
		$('#aa').val('1940');
		$('#hh').val('12');
		$('#mn').val('00');
	}
}(window.jQuery));
