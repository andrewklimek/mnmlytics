(function(){var d={},l=location,w=window,x=new XMLHttpRequest;d.href=l.href,d.search=l.search,d.path=l.pathname,d.refer=document.referrer,d.dw=w.screen.width,d.dh=w.screen.height,d.vw=w.innerWidth,d.vh=w.innerHeight,d.time=(new Date).toTimeString(),x.open("POST","/wp-json/mnmlytics/v1/post"),x.setRequestHeader("Content-Type","application/json"),x.send(JSON.stringify(d))})();