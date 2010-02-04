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
  require "Procedures.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Procedures=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Procedures[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                              , 'nr' => @$r['0.'.$i0.'.0']
                              , 'rechtsgebied' => @$r['0.'.$i0.'.2']
                              , 'proceduresoort' => @$r['0.'.$i0.'.3']
                              , 'zorgdrager voor dossier' => @$r['0.'.$i0.'.4']
                              );
      $Procedures[$i0]['zitting']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Procedures[$i0]['zitting'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Procedures[$i0]['gerecht']=array();
      for($i1=0;isset($r['0.'.$i0.'.5.'.$i1]);$i1++){
        $Procedures[$i0]['gerecht'][$i1] = @$r['0.'.$i0.'.5.'.$i1.''];
      }
      $Procedures[$i0]['clusters']=array();
      for($i1=0;isset($r['0.'.$i0.'.6.'.$i1]);$i1++){
        $Procedures[$i0]['clusters'][$i1] = array( 'id' => @$r['0.'.$i0.'.6.'.$i1.'']
                                                 );
        $Procedures[$i0]['clusters'][$i1]['zaken']=array();
        for($i2=0;isset($r['0.'.$i0.'.6.'.$i1.'.0.'.$i2]);$i2++){
          $Procedures[$i0]['clusters'][$i1]['zaken'][$i2] = @$r['0.'.$i0.'.6.'.$i1.'.0.'.$i2.''];
        }
      }
    }
    $Procedures=new Procedures($Procedures);
    if($Procedures->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Procedures=new Procedures();
    writeHead("<TITLE>Procedures - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Procedures</H1>
    <DIV class="Floater Procedures">
      <DIV class="FloaterHeader">Procedures</DIV>
      <DIV class="FloaterContent"><?php
          $Procedures = $Procedures->get_Procedures();
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
                echo 'nr: ';
                echo '<SPAN CLASS="item UInr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zitting: ';
                echo '
                <UL>';
                foreach($v0['zitting'] as $i1=>$zitting){
                  echo '
                  <LI CLASS="item UIzitting" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Zitting.php?Zitting='.urlencode($zitting).'">'.htmlspecialchars($zitting).'</A>';
                    else echo htmlspecialchars($zitting);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIzitting" ID="0.'.$i0.'.1.'.count($v0['zitting']).'">new zitting</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '<SPAN CLASS="item UIrechtsgebied" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($v0['rechtsgebied']).'">'.htmlspecialchars($v0['rechtsgebied']).'</A>';
                else echo htmlspecialchars($v0['rechtsgebied']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '<SPAN CLASS="item UIproceduresoort" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($v0['proceduresoort']).'">'.htmlspecialchars($v0['proceduresoort']).'</A>';
                else echo htmlspecialchars($v0['proceduresoort']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zorgdrager voor dossier: ';
                echo '<SPAN CLASS="item UIzorgdragervoordossier" ID="0.'.$i0.'.4">';
                if(!$edit) echo '
                <A HREF="Orgaan.php?Orgaan='.urlencode($v0['zorgdrager voor dossier']).'">'.htmlspecialchars($v0['zorgdrager voor dossier']).'</A>';
                else echo htmlspecialchars($v0['zorgdrager voor dossier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '
                <UL>';
                foreach($v0['gerecht'] as $i1=>$gerecht){
                  echo '
                  <LI CLASS="item UIgerecht" ID="0.'.$i0.'.5.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Gerecht.php?Gerecht='.urlencode($gerecht).'">'.htmlspecialchars($gerecht).'</A>';
                    else echo htmlspecialchars($gerecht);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIgerecht" ID="0.'.$i0.'.5.'.count($v0['gerecht']).'">new gerecht</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">clusters</DIV>
                  <DIV class="HolderContent" name="clusters"><?php
                      echo '
                      <UL>';
                      foreach($v0['clusters'] as $i1=>$clusters){
                        echo '
                        <LI CLASS="item UIclusters" ID="0.'.$i0.'.6.'.$i1.'">';
                          if(!$edit){
                            echo '
                          <A HREF="Cluster.php?Cluster='.urlencode($clusters['id']).'">';
                            echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                          }
                          echo '
                          <DIV>';
                            echo 'zaken: ';
                            echo '
                            <UL>';
                            foreach($clusters['zaken'] as $i2=>$zaken){
                              echo '
                              <LI CLASS="item UIclusters" ID="0.'.$i0.'.6.'.$i1.'.0.'.$i2.'">';
                                if(!$edit){
                                  echo '
                                <A class="GotoLink" id="To0.'.$i0.'.6.'.$i1.'.0.'.$i2.'">';
                                  echo htmlspecialchars($zaken).'</A>';
                                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.6.'.$i1.'.0.'.$i2.'"><UL>';
                                  echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($zaken).'">BasisgegevensUC001</A></LI>';
                                  echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($zaken).'">Procedure</A></LI>';
                                  echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($zaken).'">nieuweProcedure</A></LI>';
                                  echo '</UL></DIV>';
                                } else echo htmlspecialchars($zaken);
                              echo '</LI>';
                            }
                            if($edit) echo '
                              <LI CLASS="new UIclusters" ID="0.'.$i0.'.6.'.$i1.'.0.'.count($clusters['zaken']).'">new zaken</LI>';
                            echo '
                            </UL>';
                          echo '
                          </DIV>';
                          if($edit) echo '
                          <INPUT TYPE="hidden" name="0.'.$i0.'.6.'.$i1.'.ID" VALUE="'.$clusters['id'].'" />';
                        echo '</LI>';
                      }
                      if($edit) echo '
                        <LI CLASS="new UIclusters" ID="0.'.$i0.'.6.'.count($v0['clusters']).'">new clusters</LI>';
                      echo '
                      </UL>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
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
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>zitting: <UL><LI CLASS="new UI_zitting" ID="'+id+'.1">new zitting</LI></UL></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UI_rechtsgebied" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UI_proceduresoort" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>zorgdrager voor dossier: <SPAN CLASS="item UI_zorgdragervoordossier" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>gerecht: <UL><LI CLASS="new UI_gerecht" ID="'+id+'.5">new gerecht</LI></UL></DIV>'
             + '<DIV>clusters: <UL><LI CLASS="new UI_clusters" ID="'+id+'.6">new clusters</LI></UL></DIV>'
              ;
      }
      function UIclusters(id){
        return '<DIV>zaken: <UL><LI CLASS="new UIclusters_zaken" ID="'+id+'.0">new zaken</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>