(function (){
	
	var data = 'href=' + encodeURIComponent(location.href);
	data += '&search=' + encodeURIComponent(location.search);
	data += '&pathname=' + location.pathname;
	data += '&referrer=' + encodeURIComponent(document.referrer);
	
	data += '&dw=' + window.screen.width;
	data += '&dh=' + window.screen.height;
	data += '&vw=' + window.innerWidth;
	data += '&vh=' + window.innerHeight;

	// var date = new Date();
	data += '&time=' + new Date().toTimeString();
	// data += '&date='new Date().toString();
	
	console.log(data);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/wp-json/minimalanalytics/v1/post');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(data);
})();