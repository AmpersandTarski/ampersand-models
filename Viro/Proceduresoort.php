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
  require "Proceduresoort.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Procedures=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Procedures[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                              , 'Procedure' => @$r['0.'.$i0.'.0']
                              , 'rechtsgebied' => @$r['0.'.$i0.'.1']
                              , 'zorgdrager dossier' => @$r['0.'.$i0.'.2']
                              );
    }
    $Proceduresoort=new Proceduresoort($ID,$Procedures);
    if($Proceduresoort->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Proceduresoort='.urlencode($Proceduresoort->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Proceduresoort'])){
    if(!$del || !delProceduresoort($_REQUEST['Proceduresoort']))
      $Proceduresoort = readProceduresoort($_REQUEST['Proceduresoort']);
    else $Proceduresoort = false; // delete was a succes!
  } else if($new) $Proceduresoort = new Proceduresoort();
  else $Proceduresoort = false;
  if($Proceduresoort){
    writeHead("<TITLE>Proceduresoort - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Proceduresoort->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Proceduresoort->getId()).'" /></P>';
    else echo '<H1>'.$Proceduresoort->getId().'</H1>';
    ?>
    <DIV class="Floater Procedures">
      <DIV class="FloaterHeader">Procedures</DIV>
      <DIV class="FloaterContent"><?php
          $Procedures = $Proceduresoort->get_Procedures();
          echo '
          <UL>';
          foreach($Procedures as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Procedure: ';
                echo '<SPAN CLASS="item UIProcedure" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Procedure']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UIrechtsgebied" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zorgdrager dossier: ';
                echo '<SPAN CLASS="item UIzorgdragerdossier" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Orgaan.php?Orgaan='.urlencode($v0['zorgdrager dossier']).'">'.htmlspecialchars($v0['zorgdrager dossier']).'</A>';
                else echo htmlspecialchars($v0['zorgdrager dossier']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Procedures).'">new Procedures</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Procedures
      function UI(id){
        return '<DIV>Procedure: <SPAN CLASS="item UI_Procedure" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>zorgdrager dossier: <SPAN CLASS="item UI_zorgdragerdossier" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Proceduresoort->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Proceduresoort=".urlencode($Proceduresoort->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Proceduresoort=".urlencode($Proceduresoort->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Proceduresoort=".urlencode($Proceduresoort->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Proceduresoort is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Proceduresoort object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Proceduresoort object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>