<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" />
<xsl:template match="/">
<xsl:for-each select="//constant">
<xsl:sort select="target/@instance" />
<xsl:if test="not(target/@instance=preceding-sibling::constant/target/@instance)">
[<xsl:value-of select="target/@instance"/>]
</xsl:if>
<xsl:value-of select="substring-after(target/port/@href, '#')"/>=<xsl:value-of select="@value"/>
<xsl:text>
</xsl:text>
</xsl:for-each>
</xsl:template>
</xsl:stylesheet>