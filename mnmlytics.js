(function (){
	var data = {};
	// if ( ~location.search.indexOf('utm') ){
	// clocation.search.substr(1).split('&').forEach( function(p){
	// 		document.cookie=p
	// 	} );
	// }
	data.href = location.href;
	data.search = location.search;
	data.pathname = location.pathname;
	data.referrer = document.referrer;
	
	
	data.dw = window.screen.width;
	data.dh = window.screen.height;
	data.vw = window.innerWidth;
	data.vh = window.innerHeight;
	
	// var date = new Date();
	data.time = new Date().toTimeString();
	// data.date = new Date().toString();
	
	// console.log(data);
	// var out = [];
	//
	// for (key in data) {
	//     out.push(key + '=' + encodeURIComponent(data[key]));
	// }
	// data = out.join('&');
	
	// function serialize( obj ) {
// 		return Object.keys(obj).reduce(function(a,k){a.push(k+'='+encodeURIComponent(obj[k]));return a},[]).join('&');
// 		return Object.keys(obj).map(k => k + '=' + encodeURIComponent(obj[k])).join('&');// IE?
// 	}
	
	data = Object.keys(data).map( function(k){ return k + '=' + encodeURIComponent(data[k]) } ).join('&');

	// console.log(data);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/wp-json/minimalanalytics/v1/post');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send(data);
})();