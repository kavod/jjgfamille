<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
	<channel>
		<title>{CHANNEL_TITLE}</title>
		<link>{SITE_URL}</link>
		<description>{DESCRIPTION}</description>
		<language>fr-fr</language>
		<copyright>Copyright © 2006 famille Musik</copyright>
		<lastBuildDate>{DATE}</lastBuildDate>
		<managingEditor>webmaster@jjgfamille.com</managingEditor>
		<webMaster>webmaster@jjgfamille.com</webMaster>
		<ttl>60</ttl>
		<image>
			<url>http://www.jjgfamille.com/templates/jjgfamille/images/site/ban.png</url>
			<title>jjgfamille.com, croisons nos vies de temps en temps !</title>
			<link>http://www.jjgfamille.com/</link>
			<description>Le site consacré à l'oeuvre de Jean-Jacques Goldman</description>
			<width>486</width>
			<height>60</height>
		</image>
<!-- BEGIN item -->
		<item>
			<title>{item.TITLE}</title>
			<link>{item.URL}</link>
			<description>{item.DESCRIPTION}</description>
			<author>{item.AUTHOR}</author>
			<guid>{item.URL}</guid>
			<pubDate>{item.DATE}</pubDate>
			<source url="http://www.jjgfamille.com/rss/maj.xml">jjgfamille.com</source>
		</item>
<!-- END item -->
	</channel>
</rss>