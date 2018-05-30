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

// url encode - object
// (function (){
// 	var data = {};
// 	data.href = location.href;
// 	data.search = location.search;
// 	data.pathname = location.pathname;
// 	data.referrer = document.referrer;
// 	data.dw = window.screen.width;
// 	data.dh = window.screen.height;
// 	data.vw = window.innerWidth;
// 	data.vh = window.innerHeight;
// 	data.time = new Date().toTimeString();
// 	data = Object.keys(data).map( function(k){ return k + '=' + encodeURIComponent(data[k]) } ).join('&');
// 	var xhr = new XMLHttpRequest();
// 	xhr.open('POST', '/wp-json/mnmlytics/v1/post');
// 	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
// 	xhr.send(data);
// })();

// url encode - string
// (function (){
// 	var data = 'href=' + encodeURIComponent(location.href);
// 	data += '&search=' + encodeURIComponent(location.search);
// 	data += '&pathname=' + location.pathname;
// 	data += '&referrer=' + encodeURIComponent(document.referrer);
// 	data += '&dw=' + window.screen.width;
// 	data += '&dh=' + window.screen.height;
// 	data += '&vw=' + window.innerWidth;
// 	data += '&vh=' + window.innerHeight;
// 	data += '&time=' + new Date().toTimeString();
// 	var xhr = new XMLHttpRequest();
// 	xhr.open('POST', '/wp-json/mnmlytics/v1/post');
// 	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
// 	xhr.send(data);
// })();