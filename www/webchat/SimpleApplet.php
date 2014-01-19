<html>
<head>
<title>IRCApplet</title>
</head>
<body>
<h1>Chat JJGfamille.com</h1><hr>
<applet code=IRCApplet.class archive="irc.jar,pixx.jar" width=640 height=400>
<param name="CABINETS" value="irc.cab,securedirc.cab,pixx.cab">

<param name="nick" value="<? echo $_POST['Nickname']; ?>">
<param name="name" value="<? echo $_POST['Nickname']; ?>">
<param name="alternatenick" value="<? echo $_POST['Nickname']; ?>1">
<param name="fullname" value="famillien">
<param name="host" value="irc.worldnet.net">
<param name="gui" value="pixx">
<param name="language" value="french">
<param name="soundbeep" value="snd/bell2.au">
<param name="soundquery" value="snd/ding.au">
<param name="authorizedjoinlist" value="none+#ensemble+#famille">
<param name="command1" value="/nickserv identify <? echo $_POST['irc']; ?>">
<param name="command2" value="/join #ensemble">
</applet>

<hr></body>
</html>

