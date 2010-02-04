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
  require "nieuweProcedure.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $zorgdragervoordossier = @$r['0'];
    $rechtsgebied = @$r['1'];
    $proceduresoort = @$r['2'];
    $nieuweProcedure=new nieuweProcedure($ID,$zorgdragervoordossier, $rechtsgebied, $proceduresoort);
    if($nieuweProcedure->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?nieuweProcedure='.urlencode($nieuweProcedure->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['nieuweProcedure'])){
    if(!$del || !delnieuweProcedure($_REQUEST['nieuweProcedure']))
      $nieuweProcedure = readnieuweProcedure($_REQUEST['nieuweProcedure']);
    else $nieuweProcedure = false; // delete was a succes!
  } else if($new) $nieuweProcedure = new nieuweProcedure();
  else $nieuweProcedure = false;
  if($nieuweProcedure){
    writeHead("<TITLE>nieuweProcedure - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $nieuweProcedure->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($nieuweProcedure->getId()).'" /></P>';
    else echo '<H1>'.$nieuweProcedure->getId().'</H1>';
    ?>
    <DIV class="Floater zorgdrager voor dossier">
      <DIV class="FloaterHeader">zorgdrager voor dossier</DIV>
      <DIV class="FloaterContent"><?php
          $zorgdragervoordossier = $nieuweProcedure->get_zorgdragervoordossier();
          echo '<SPAN CLASS="item UI_zorgdragervoordossier" ID="0">';
          if(!$edit) echo '
          <A HREF="Orgaan.php?Orgaan='.urlencode($zorgdragervoordossier).'">'.htmlspecialchars($zorgdragervoordossier).'</A>';
          else echo htmlspecialchars($zorgdragervoordossier);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater rechtsgebied">
      <DIV class="FloaterHeader">rechtsgebied</DIV>
      <DIV class="FloaterContent"><?php
          $rechtsgebied = $nieuweProcedure->get_rechtsgebied();
          echo '<SPAN CLASS="item UI_rechtsgebied" ID="1">';
          if(!$edit) echo '
          <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($rechtsgebied).'">'.htmlspecialchars($rechtsgebied).'</A>';
          else echo htmlspecialchars($rechtsgebied);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater proceduresoort">
      <DIV class="FloaterHeader">proceduresoort</DIV>
      <DIV class="FloaterContent"><?php
          $proceduresoort = $nieuweProcedure->get_proceduresoort();
          echo '<SPAN CLASS="item UI_proceduresoort" ID="2">';
          if(!$edit) echo '
          <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($proceduresoort).'">'.htmlspecialchars($proceduresoort).'</A>';
          else echo htmlspecialchars($proceduresoort);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($nieuweProcedure->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?nieuweProcedure=".urlencode($nieuweProcedure->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&nieuweProcedure=".urlencode($nieuweProcedure->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&nieuweProcedure=".urlencode($nieuweProcedure->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The nieuweProcedure is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No nieuweProcedure object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No nieuweProcedure object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>