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
  require "Cluster.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $naam = @$r['0'];
    $grond=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $grond[$i0] = @$r['1.'.$i0.''];
    }
    $Procedureofcluster=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Procedureofcluster[$i0] = array( 'id' => @$r['2.'.$i0.'']
                                      , 'zorgdrager voor dossier' => @$r['2.'.$i0.'.0']
                                      , 'rechtsgebied' => @$r['2.'.$i0.'.1']
                                      , 'proceduresoort' => @$r['2.'.$i0.'.2']
                                      );
    }
    $Cluster=new Cluster($ID,$naam, $grond, $Procedureofcluster);
    if($Cluster->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Cluster='.urlencode($Cluster->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Cluster'])){
    if(!$del || !delCluster($_REQUEST['Cluster']))
      $Cluster = readCluster($_REQUEST['Cluster']);
    else $Cluster = false; // delete was a succes!
  } else if($new) $Cluster = new Cluster();
  else $Cluster = false;
  if($Cluster){
    writeHead("<TITLE>Cluster - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Cluster->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Cluster->getId()).'" /></P>';
    else echo '<H1>'.$Cluster->getId().'</H1>';
    ?>
    <DIV class="Floater naam">
      <DIV class="FloaterHeader">naam</DIV>
      <DIV class="FloaterContent"><?php
          $naam = $Cluster->get_naam();
          echo '<SPAN CLASS="item UI_naam" ID="0">';
          echo htmlspecialchars($naam);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater grond">
      <DIV class="FloaterHeader">grond</DIV>
      <DIV class="FloaterContent"><?php
          $grond = $Cluster->get_grond();
          echo '
          <UL>';
          foreach($grond as $i0=>$v0){
            echo '
            <LI CLASS="item UI_grond" ID="1.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_grond" ID="1.'.count($grond).'">new grond</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater Procedure_of_cluster">
      <DIV class="FloaterHeader">Procedure_of_cluster</DIV>
      <DIV class="FloaterContent"><?php
          $Procedureofcluster = $Cluster->get_Procedureofcluster();
          echo '
          <UL>';
          foreach($Procedureofcluster as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Procedureofcluster" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['id']).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['id']).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['id']).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'zorgdrager voor dossier: ';
                echo '<SPAN CLASS="item UI_Procedureofcluster_zorgdragervoordossier" ID="2.'.$i0.'.0">';
                if(!$edit) echo '
                <A HREF="Orgaan.php?Orgaan='.urlencode($v0['zorgdrager voor dossier']).'">'.htmlspecialchars($v0['zorgdrager voor dossier']).'</A>';
                else echo htmlspecialchars($v0['zorgdrager voor dossier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UI_Procedureofcluster_rechtsgebied" ID="2.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UI_Procedureofcluster_proceduresoort" ID="2.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Procedureofcluster" ID="2.'.count($Procedureofcluster).'">new Procedure_of_cluster</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Procedure_of_cluster
      function UI_Procedureofcluster(id){
        return '<DIV>zorgdrager voor dossier: <SPAN CLASS="item UI_Procedureofcluster_zorgdragervoordossier" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_Procedureofcluster_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_Procedureofcluster_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Cluster->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Cluster=".urlencode($Cluster->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Cluster=".urlencode($Cluster->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Cluster=".urlencode($Cluster->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Cluster is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Cluster object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Cluster object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>