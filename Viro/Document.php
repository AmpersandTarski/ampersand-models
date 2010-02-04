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
  require "Document.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $type = @$r['0'];
    $zaaksdossier=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $zaaksdossier[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                , 'zorgdrager' => @$r['1.'.$i0.'.0']
                                , 'rechtsgebied' => @$r['1.'.$i0.'.1']
                                , 'proceduresoort' => @$r['1.'.$i0.'.2']
                                );
    }
    $Document=new Document($ID,$type, $zaaksdossier);
    if($Document->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Document='.urlencode($Document->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Document'])){
    if(!$del || !delDocument($_REQUEST['Document']))
      $Document = readDocument($_REQUEST['Document']);
    else $Document = false; // delete was a succes!
  } else if($new) $Document = new Document();
  else $Document = false;
  if($Document){
    writeHead("<TITLE>Document - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Document->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Document->getId()).'" /></P>';
    else echo '<H1>'.$Document->getId().'</H1>';
    ?>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Document->get_type();
          echo '<SPAN CLASS="item UI_type" ID="0">';
          if(!$edit) echo '
          <A HREF="Documenttype.php?Documenttype='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
          else echo htmlspecialchars($type);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zaaksdossier">
      <DIV class="FloaterHeader">zaaksdossier</DIV>
      <DIV class="FloaterContent"><?php
          $zaaksdossier = $Document->get_zaaksdossier();
          echo '
          <UL>';
          foreach($zaaksdossier as $i0=>$v0){
            echo '
            <LI CLASS="item UI_zaaksdossier" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'zorgdrager: ';
                echo '<SPAN CLASS="item UI_zaaksdossier_zorgdrager" ID="1.'.$i0.'.0">';
                if(!$edit) echo '
                <A HREF="Orgaan.php?Orgaan='.urlencode($v0['zorgdrager']).'">'.htmlspecialchars($v0['zorgdrager']).'</A>';
                else echo htmlspecialchars($v0['zorgdrager']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_zaaksdossier_rechtsgebied" ID="1.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_zaaksdossier_proceduresoort" ID="1.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_zaaksdossier" ID="1.'.count($zaaksdossier).'">new zaaksdossier</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in zaaksdossier
      function UI_zaaksdossier(id){
        return '<DIV>zorgdrager: <SPAN CLASS="item UI_zaaksdossier_zorgdrager" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_zaaksdossier_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_zaaksdossier_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Document->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Document=".urlencode($Document->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Document=".urlencode($Document->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Document=".urlencode($Document->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Document is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Document object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Document object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>