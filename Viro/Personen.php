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
  require "Personen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Gemachtigden=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Gemachtigden[$i0] = @$r['0.'.$i0.''];
    }
    $Rechters=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Rechters[$i0] = @$r['1.'.$i0.''];
    }
    $Griffiers=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Griffiers[$i0] = @$r['2.'.$i0.''];
    }
    $Personen=new Personen($Gemachtigden, $Rechters, $Griffiers);
    if($Personen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Personen=new Personen();
    writeHead("<TITLE>Personen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Personen</H1>
    <DIV class="Floater Gemachtigden">
      <DIV class="FloaterHeader">Gemachtigden</DIV>
      <DIV class="FloaterContent"><?php
          $Gemachtigden = $Personen->get_Gemachtigden();
          echo '
          <UL>';
          foreach($Gemachtigden as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Gemachtigden" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Gemachtigden" ID="0.'.count($Gemachtigden).'">new Gemachtigden</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Rechters">
      <DIV class="FloaterHeader">Rechters</DIV>
      <DIV class="FloaterContent"><?php
          $Rechters = $Personen->get_Rechters();
          echo '
          <UL>';
          foreach($Rechters as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Rechters" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Rechters" ID="1.'.count($Rechters).'">new Rechters</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Griffiers">
      <DIV class="FloaterHeader">Griffiers</DIV>
      <DIV class="FloaterContent"><?php
          $Griffiers = $Personen->get_Griffiers();
          echo '
          <UL>';
          foreach($Griffiers as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Griffiers" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To2.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Griffiers" ID="2.'.count($Griffiers).'">new Griffiers</LI>';
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