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
  require "Clusters.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Clusters=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Clusters[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                            , 'nr' => @$r['0.'.$i0.'.0']
                            , 'naam' => @$r['0.'.$i0.'.1']
                            );
      $Clusters[$i0]['zaken']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Clusters[$i0]['zaken'][$i1] = array( 'id' => @$r['0.'.$i0.'.2.'.$i1.'']
                                            , 'zorgdrager voor dossier' => @$r['0.'.$i0.'.2.'.$i1.'.0']
                                            , 'rechtsgebied' => @$r['0.'.$i0.'.2.'.$i1.'.1']
                                            , 'proceduresoort' => @$r['0.'.$i0.'.2.'.$i1.'.2']
                                            );
      }
    }
    $Clusters=new Clusters($Clusters);
    if($Clusters->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Clusters=new Clusters();
    writeHead("<TITLE>Clusters - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Clusters</H1>
    <DIV class="Floater Clusters">
      <DIV class="FloaterHeader">Clusters</DIV>
      <DIV class="FloaterContent"><?php
          $Clusters = $Clusters->get_Clusters();
          echo '
          <UL>';
          foreach($Clusters as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Cluster.php?Cluster='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UInr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'naam: ';
                echo '<SPAN CLASS="item UInaam" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">zaken</DIV>
                  <DIV class="HolderContent" name="zaken"><?php
                      echo '
                      <UL>';
                      foreach($v0['zaken'] as $i1=>$zaken){
                        echo '
                        <LI CLASS="item UIzaken" ID="0.'.$i0.'.2.'.$i1.'">';
                          if(!$edit){
                            echo '
                          <DIV class="GotoArrow" id="To0.'.$i0.'.2.'.$i1.'">&rArr;</DIV>';
                            echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                            echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($zaken['id']).'">BasisgegevensUC001</A></LI>';
                            echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($zaken['id']).'">Procedure</A></LI>';
                            echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($zaken['id']).'">nieuweProcedure</A></LI>';
                            echo '</UL></DIV>';
                          }
                          echo '
                          <DIV>';
                            echo 'zorgdrager voor dossier: ';
                            echo '<SPAN CLASS="item UIzaken_zorgdragervoordossier" ID="0.'.$i0.'.2.'.$i1.'.0">';
                            if(!$edit) echo '
                            <A HREF="Orgaan.php?Orgaan='.urlencode($zaken['zorgdrager voor dossier']).'">'.htmlspecialchars($zaken['zorgdrager voor dossier']).'</A>';
                            else echo htmlspecialchars($zaken['zorgdrager voor dossier']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'rechtsgebied: ';
                            echo '<SPAN CLASS="item UIzaken_rechtsgebied" ID="0.'.$i0.'.2.'.$i1.'.1">';
                            if(!$edit) echo '
                            <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($zaken['rechtsgebied']).'">'.htmlspecialchars($zaken['rechtsgebied']).'</A>';
                            else echo htmlspecialchars($zaken['rechtsgebied']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'proceduresoort: ';
                            echo '<SPAN CLASS="item UIzaken_proceduresoort" ID="0.'.$i0.'.2.'.$i1.'.2">';
                            if(!$edit) echo '
                            <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($zaken['proceduresoort']).'">'.htmlspecialchars($zaken['proceduresoort']).'</A>';
                            else echo htmlspecialchars($zaken['proceduresoort']);
                            echo '</SPAN>';
                          echo '
                          </DIV>';
                          if($edit) echo '
                          <INPUT TYPE="hidden" name="0.'.$i0.'.2.'.$i1.'.ID" VALUE="'.$zaken['id'].'" />';
                        echo '</LI>';
                      }
                      if($edit) echo '
                        <LI CLASS="new UIzaken" ID="0.'.$i0.'.2.'.count($v0['zaken']).'">new zaken</LI>';
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
            <LI CLASS="new UI" ID="0.'.count($Clusters).'">new Clusters</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Clusters
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>naam: <SPAN CLASS="item UI_naam" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>zaken: <UL><LI CLASS="new UI_zaken" ID="'+id+'.2">new zaken</LI></UL></DIV>'
              ;
      }
      function UIzaken(id){
        return '<DIV>zorgdrager voor dossier: <SPAN CLASS="item UIzaken_zorgdragervoordossier" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rechtsgebied: <SPAN CLASS="item UIzaken_rechtsgebied" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>proceduresoort: <SPAN CLASS="item UIzaken_proceduresoort" ID="'+id+'.2"></SPAN></DIV>'
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