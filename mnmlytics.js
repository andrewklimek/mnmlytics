(function (){
	var data = {},
	loc = location,
	win = window,
	xhr = new XMLHttpRequest();

	data.href = loc.href;
	data.search = loc.search;
	data.path = loc.pathname;
	data.refer = document.referrer;
	data.dw = win.screen.width;
	data.dh = win.screen.height;
	data.vw = win.innerWidth;
	data.vh = win.innerHeight;
	data.time = new Date().toTimeString();
		
	xhr.open('POST', '/wp-json/mnmlytics/v1/post');
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(data));
})();