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
  require "ZaakInplannen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $zitting = @$r['0'];
    $zaak = @$r['1'];
    $ZaakInplannen=new ZaakInplannen($ID,$zitting, $zaak);
    if($ZaakInplannen->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?ZaakInplannen='.urlencode($ZaakInplannen->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['ZaakInplannen'])){
    if(!$del || !delZaakInplannen($_REQUEST['ZaakInplannen']))
      $ZaakInplannen = readZaakInplannen($_REQUEST['ZaakInplannen']);
    else $ZaakInplannen = false; // delete was a succes!
  } else if($new) $ZaakInplannen = new ZaakInplannen();
  else $ZaakInplannen = false;
  if($ZaakInplannen){
    writeHead("<TITLE>ZaakInplannen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $ZaakInplannen->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($ZaakInplannen->getId()).'" /></P>';
    else echo '<H1>'.$ZaakInplannen->getId().'</H1>';
    ?>
    <DIV class="Floater zitting">
      <DIV class="FloaterHeader">zitting</DIV>
      <DIV class="FloaterContent"><?php
          $zitting = $ZaakInplannen->get_zitting();
          echo '<SPAN CLASS="item UI_zitting" ID="0">';
          if(!$edit) echo '
          <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
          else echo htmlspecialchars($zitting);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaak">
      <DIV class="FloaterHeader">zaak</DIV>
      <DIV class="FloaterContent"><?php
          $zaak = $ZaakInplannen->get_zaak();
          echo '<SPAN CLASS="item UI_zaak" ID="1">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To1">';
            echo htmlspecialchars($zaak).'</A>';
            echo '<DIV class="Goto" id="GoTo1"><UL>';
            echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($zaak).'">BasisgegevensUC001</A></LI>';
            echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($zaak).'">Procedure</A></LI>';
            echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($zaak).'">nieuweProcedure</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($zaak);
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($ZaakInplannen->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?ZaakInplannen=".urlencode($ZaakInplannen->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&ZaakInplannen=".urlencode($ZaakInplannen->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&ZaakInplannen=".urlencode($ZaakInplannen->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The ZaakInplannen is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No ZaakInplannen object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No ZaakInplannen object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>