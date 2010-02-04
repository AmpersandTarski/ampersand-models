<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  require "interfaceDef.inc.php";
  require "Partijen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Eisers=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Eisers[$i0] = @$r['0.'.$i0.''];
    }
    $Gedaagden=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Gedaagden[$i0] = @$r['1.'.$i0.''];
    }
    $Gevoegden=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Gevoegden[$i0] = @$r['2.'.$i0.''];
    }
    $Partijen=new Partijen($Eisers, $Gedaagden, $Gevoegden);
    if($Partijen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Partijen=new Partijen();
    writeHead("<TITLE>Partijen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Partijen</H1>
    <DIV class="Floater Eisers">
      <DIV class="FloaterHeader">Eisers</DIV>
      <DIV class="FloaterContent"><?php
          $Eisers = $Partijen->get_Eisers();
          echo '
          <UL>';
          foreach($Eisers as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Eisers" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Eisers" ID="0.'.count($Eisers).'">new Eisers</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Gedaagden">
      <DIV class="FloaterHeader">Gedaagden</DIV>
      <DIV class="FloaterContent"><?php
          $Gedaagden = $Partijen->get_Gedaagden();
          echo '
          <UL>';
          foreach($Gedaagden as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Gedaagden" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Gedaagden" ID="1.'.count($Gedaagden).'">new Gedaagden</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Gevoegden">
      <DIV class="FloaterHeader">Gevoegden</DIV>
      <DIV class="FloaterContent"><?php
          $Gevoegden = $Partijen->get_Gevoegden();
          echo '
          <UL>';
          foreach($Gevoegden as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Gevoegden" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Gevoegden" ID="2.'.count($Gevoegden).'">new Gevoegden</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>