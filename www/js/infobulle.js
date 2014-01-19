<!--
	// Pour etre compatible W3C, oncontextmenu et ondragstart ne doivent pas être dans la balise <body>
	document.oncontextmenu = function() {return false;};
	document.ondragstart = function() {return false;};
	document.onselectstart = function() {return false;};
/*
	domok = document.getElementById;
	if (domok)
	{
		skn = document.getElementById("topdecklink").style;
		if(navigator.appName.substring(0,3) == "Net")
			document.captureEvents(Event.MOUSEMOVE);
		document.onmousemove = get_mouse;
	}
	function poplink(msg)
	{
		var content = msg;
		if (domok)
		{
			document.getElementById("topdecklink").innerHTML = content;
			document.getElementById("topdecklink").style.visibility = "visible";
		}
	}
	function get_mouse(e)
	{
		var x = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
		var y = (navigator.appName.substring(0,3) == "Net") ? e.pageY : event.y+document.body.scrollTop;
		document.getElementById("topdecklink").style.left = (x + 20).toString()+'px';
		document.getElementById("topdecklink").style.top = (y + 0).toString()+'px';
	}
	function killlink()
	{
		if (domok) document.getElementById("topdecklink").style.visibility = "hidden";
	}*/
//-->