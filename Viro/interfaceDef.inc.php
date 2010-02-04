<?php
  // interfaceDef.inc.php
  // Generated with ADL vs. 0.8.10-452
  // Prototype interface design by Sebastiaan JC Joosten (c) Aug 2009
  
  // this file contains large chunks of HTML code to improve code readability and reuse
  
  
  /**************************************************************\
  * writeHead: code to write the page and HTML-document headers. *
  * If extra JavaScript is needed, or to get a title,            *
  * use the $extraheaders argument to pass extra headers         *
  \**************************************************************/
  function writeHead($extraHeaders=""){
    ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <HTML><HEAD>
    <script type="text/javascript" src="jquery-1.3.2.min.js"></script>
    <?php echo $extraHeaders; ?>
    <link rel="stylesheet" type="text/css" href="style.css" />
    </HEAD><BODY STYLE="height:100%;width:100%;" marginwidth="0" marginheight="0">
    <DIV class="menuDiv"><UL class="menu">
      <LI><A HREF="Sessies.php" TITLE="Show all Sessies objects" class="menuItem" >
        Sessies
      </A></LI>
      <LI><A HREF="Documenten.php" TITLE="Show all Documenten objects" class="menuItem" >
        Documenten
      </A></LI>
      <LI><A HREF="Handelingen.php" TITLE="Show all Handelingen objects" class="menuItem" >
        Handelingen
      </A></LI>
      <LI><A HREF="Acties.php" TITLE="Show all Acties objects" class="menuItem" >
        Acties
      </A></LI>
      <LI><A HREF="Clusters.php" TITLE="Show all Clusters objects" class="menuItem" >
        Clusters
      </A></LI>
      <LI><A HREF="Procedures.php" TITLE="Show all Procedures objects" class="menuItem" >
        Procedures
      </A></LI>
      <LI><A HREF="Zittingen.php" TITLE="Show all Zittingen objects" class="menuItem" >
        Zittingen
      </A></LI>
      <LI><A HREF="Partijen.php" TITLE="Show all Partijen objects" class="menuItem" >
        Partijen
      </A></LI>
      <LI><A HREF="Personen.php" TITLE="Show all Personen objects" class="menuItem" >
        Personen
      </A></LI>
      <LI><A HREF="Rolplanning.php" TITLE="Show all Rolplanning objects" class="menuItem" >
        Rolplanning
      </A></LI>
      <LI><A HREF="Kamers.php" TITLE="Show all Kamers objects" class="menuItem" >
        Kamers
      </A></LI>
      <LI><A HREF="Artikelen.php" TITLE="Show all Artikelen objects" class="menuItem" >
        Artikelen
      </A></LI>
      <LI><A HREF="Machtigingen.php" TITLE="Show all Machtigingen objects" class="menuItem" >
        Machtigingen
      </A></LI>
    </UL></DIV>
    <DIV class="content">
    <!-- content -->
    <?php
  }
  function writeTail($buttons=""){
    ?>
    <!-- tail -->
    </DIV>
    <UL class="buttons">
    <!--buttons (if any)-->
    <?php echo $buttons; ?>
    </UL>
    <div class="cNotice"><center><a title="&copy; Sebastiaan JC Joosten 2005-2009, generated with ADL vs. 0.8.10-452">Layout V1.4 alpha</A></center></div>
    </BODY></HTML><?php
  }
  function ifaceButton($url,$tag,$descr=""){
    return '
      <LI><A HREF="'.$url.'" class="button" title="'.htmlspecialchars($descr).'">
        '.htmlspecialchars($tag).'
      </A></LI>';
  }
?>
