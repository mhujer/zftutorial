<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
    xmlns:d="http://docbook.org/ns/docbook" exclude-result-prefixes="d">
    <xsl:import href="file:///c:/Program Files (x86)/Oxygen XML Editor 12/frameworks/docbook/xsl/xhtml/docbook.xsl"/>

    <xsl:import href="file:///c:/Program Files (x86)/Oxygen XML Editor 12/frameworks/docbook/xsl/oxygen_custom_html.xsl"/>
    
    <xsl:output indent="yes" />
    
    <!-- Programlisting si generuju do texy bloků, které se pak zpracují přes PHP -->
    <xsl:template match="d:programlisting" name="prg">
<programkod id="{generate-id(.)}">
/---code <xsl:value-of select="@language"/>
<xsl:text>
</xsl:text>
<xsl:value-of select="." disable-output-escaping="yes"/>
\---
</programkod>
    </xsl:template>

</xsl:stylesheet>
