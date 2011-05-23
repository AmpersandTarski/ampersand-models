<?php
// interfaceDef.inc.php
// Generated for ADL vs. 0.8.10-446
// Prototype interface design by Milan van Bruggen (c) Oct 2009

// this file contains large chunks of HTML code to improve code readability and reuse


/**************************************************************\
* writeHead: code to write the page and HTML-document headers. *
* If extra JavaScript is needed, or to get a title,            *
* use the $extraheaders argument to pass extra headers         *
\**************************************************************/
function writeHead($extraHeaders=""){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- jQuery -->
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<!-- Extra Headers -->
<?php echo $extraHeaders; ?>
<!-- Screen Stylesheets -->
<link href="css/reset.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/screen.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<div id="error"></div>
<div id="container">
  <div id="header">
    <div id="logo"><a href="index.html"><img src="images/rechtspraak_logo.jpg" width="122" height="58" alt="de Rechtspraak logo" title="Klik hier om terug te gaan naar de startpagina" /></a></div>
    <!-- End #logo -->
    <div id="decoration"></div>
    <!-- End #decoration -->
  </div>
  <!-- End #header -->
  <div id="menu">
    <div class="primairy">
      <ul>
        <li><a href="Sessies.php" title="Toon alle Sessies" class="menuItem">Sessies</a></li>
        <li><a href="Documenten.php" title="Toon alle Documenten" class="menuItem">Documenten</a></li>
        <li><a href="Clusters.php" title="Toon alle Clusters" class="menuItem">Clusters</a></li>
        <li><a href="Procedures.php" title="Toon alle Procedures" class="menuItem">Procedures</a></li>
        <li><a href="Zittingen.php" title="Toon alle Zittingen" class="menuItem">Zittingen</a></li>
        <li><a href="Partijen.php" title="Toon alle Partijen" class="menuItem">Partijen</a></li>
        <li><a href="Personen.php" title="Toon alle Personen" class="menuItem">Personen</a></li>
        <li><a href="Belanghebbenden.php" title="Toon alle Personen" class="menuItem">Belanghebbenden</a></li>
        <li><a href="Gemachtigden.php" title="Toon alle Personen" class="menuItem">Gemachtigden</a></li>
        <li><a href="RechterlijkeAmbtenaren.php" title="Toon alle Personen" class="menuItem">Rechterlijke ambtenaren</a></li>
        <li><a href="Rolplanning.php" title="Toon de Rolplanning" class="menuItem">Rolplanning</a></li>
        <li><a href="Kamers.php" title="Toon alle Kamers" class="menuItem">Kamers</a></li>
        <li><a href="Machtigingen.php" title="Toon alle Machtigingen" class="menuItem">Machtigingen</a></li>
        <li><a href="Artikelen.php" title="Toon alle Artikelen" class="menuItem">Artikelen</a></li>
	  </ul>
    </div>
    <!-- End .primairy -->
  </div>
  <!-- End #menu -->
  <div id="content">
<?php
}
function writeTail($buttons=""){
?>
  </div>
  <!-- End #content -->
  <div id="buttons">
    <ul><?php echo $buttons; ?></ul>
  </div>
  <!-- End #buttons -->
  <div id="notice">
    <span title="&copy; Sebastiaan JC Joosten 2005-2009, generated with ADL vs. 0.8.10-446">Layout V1.4 alpha</span>
  </div>
  <!-- End #notice -->
<!-- ********** Javascript ********** -->
<!-- Cufon Font Replacement (http://cufon.shoqolate.com/generate)-->
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="fonts/myriad_pro_700.font.js" type="text/javascript"></script>
<script type="text/javascript">
  Cufon.replace('#menu .primairy ul li a, h1, h2, .FloaterHeader, h3, h4, h5, h6', {
    fontFamily: 'Myriad Pro',
	hover: 'true'
  });
</script>
<!-- jQuery -->
<script type="text/javascript">
$(".GotoArrow").hover(
  function () {
	$(this).addClass("GotoArrowHover");
  }, 
  function () {
	$(this).removeClass("GotoArrowHover");
  }
);
</script>
</body>
</html>
<?php
}
function ifaceButton($url,$tag,$descr=""){
return '
  <li><a href="'.$url.'" class="button" title="'.htmlspecialchars($descr).'">
	'.htmlspecialchars($tag).'</a></li>';
}
?>