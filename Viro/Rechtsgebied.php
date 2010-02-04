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
  require "Rechtsgebied.inc.php";
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
                              , 'proceduresoort' => @$r['0.'.$i0.'.1']
                              , 'zorgdrager dossier' => @$r['0.'.$i0.'.2']
                              );
    }
    $Rechtsgebied=new Rechtsgebied($ID,$Procedures);
    if($Rechtsgebied->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Rechtsgebied='.urlencode($Rechtsgebied->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rechtsgebied'])){
    if(!$del || !delRechtsgebied($_REQUEST['Rechtsgebied']))
      $Rechtsgebied = readRechtsgebied($_REQUEST['Rechtsgebied']);
    else $Rechtsgebied = false; // delete was a succes!
  } else if($new) $Rechtsgebied = new Rechtsgebied();
  else $Rechtsgebied = false;
  if($Rechtsgebied){
    writeHead("<TITLE>Rechtsgebied - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rechtsgebied->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rechtsgebied->getId()).'" /></P>';
    else echo '<H1>'.$Rechtsgebied->getId().'</H1>';
    ?>
    <DIV class="Floater Procedures">
      <DIV class="FloaterHeader">Procedures</DIV>
      <DIV class="FloaterContent"><?php
          $Procedures = $Rechtsgebied->get_Procedures();
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
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UIproceduresoort" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
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
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_proceduresoort" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Rechtsgebied->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Rechtsgebied=".urlencode($Rechtsgebied->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Rechtsgebied=".urlencode($Rechtsgebied->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Rechtsgebied=".urlencode($Rechtsgebied->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rechtsgebied is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rechtsgebied object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Rechtsgebied object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>