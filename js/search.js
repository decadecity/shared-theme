(function() {
	if (window.yg_mustard_cut) {
		if (document.readyState !== 'loading') {
			readyRunner();
		} else {
			document.addEventListener('DOMContentLoaded', readyRunner, false);
		}
		function readyRunner() {
			var search = document.querySelector('#search-box-toggle-holder');
			if (!search) {
				return;
			}
			search.innerHTML = '<button id="search-box-toggle">Search</button>';
			var toggle = document.querySelector('#search-box-toggle');
			toggle.addEventListener('click', function() {
				document.querySelector('#search-box').classList.add('shown');
				toggle.remove();
			});
		}
	}
}());
