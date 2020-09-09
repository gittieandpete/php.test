<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<xsl:template match="/">
<h1><xsl:value-of select="/rss/channel/title"/></h1>
<h2><a><xsl:attribute name="href"><xsl:value-of select="/rss/channel/link"/></xsl:attribute> 
<xsl:value-of select="/rss/channel/link"/></a></h2>
<h3><xsl:value-of select="/rss/channel/description"/></h3>
<hr/>
<ul>
<xsl:for-each select="/rss/channel/item">
<li>
<a><xsl:attribute name="href"><xsl:value-of select="link"/></xsl:attribute> 
<xsl:value-of select="title"/></a>
 - <xsl:value-of select="description"/></li>
</xsl:for-each>
</ul>
</xsl:template>
</xsl:stylesheet>