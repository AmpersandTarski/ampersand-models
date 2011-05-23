<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  require "interfaceDef.inc.php";
  require "Cases.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Cases=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Cases[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                         , 'nr' => @$r['0.'.$i0.'.0']
                         , 'area of law' => @$r['0.'.$i0.'.2']
                         , 'type of case' => @$r['0.'.$i0.'.3']
                         , 'caretaker voor dossier' => @$r['0.'.$i0.'.4']
                         );
      $Cases[$i0]['session']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Cases[$i0]['session'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Cases[$i0]['court']=array();
      for($i1=0;isset($r['0.'.$i0.'.5.'.$i1]);$i1++){
        $Cases[$i0]['court'][$i1] = @$r['0.'.$i0.'.5.'.$i1.''];
      }
      $Cases[$i0]['clusters']=array();
      for($i1=0;isset($r['0.'.$i0.'.6.'.$i1]);$i1++){
        $Cases[$i0]['clusters'][$i1] = array( 'id' => @$r['0.'.$i0.'.6.'.$i1.'']
                                            );
        $Cases[$i0]['clusters'][$i1]['cases']=array();
        for($i2=0;isset($r['0.'.$i0.'.6.'.$i1.'.0.'.$i2]);$i2++){
          $Cases[$i0]['clusters'][$i1]['cases'][$i2] = @$r['0.'.$i0.'.6.'.$i1.'.0.'.$i2.''];
        }
      }
    }
    $Cases=new Cases($Cases);
    if($Cases->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Cases=new Cases();
    writeHead("<TITLE>Cases - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Cases</H1>
    <DIV class="Floater Cases">
      <DIV class="FloaterHeader">Cases</DIV>
      <DIV class="FloaterContent"><?php
          $Cases = $Cases->get_Cases();
          echo '
          <UL>';
          foreach($Cases as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="CoreDataUC001.php?CoreDataUC001='.urlencode($v0['id']).'">CoreDataUC001</A></LI>';
                echo '<LI><A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">LegalCase</A></LI>';
                echo '<LI><A HREF="newCase.php?newCase='.urlencode($v0['id']).'">newCase</A></LI>';
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
                echo 'session: ';
                echo '
                <UL>';
                foreach($v0['session'] as $i1=>$session){
                  echo '
                  <LI CLASS="item UIsession" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Session.php?Session='.urlencode($session).'">'.htmlspecialchars($session).'</A>';
                    else echo htmlspecialchars($session);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIsession" ID="0.'.$i0.'.1.'.count($v0['session']).'">new session</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UIareaoflaw" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '<SPAN CLASS="item UItypeofcase" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="CaseType.php?CaseType='.urlencode($v0['type of case']).'">'.htmlspecialchars($v0['type of case']).'</A>';
                else echo htmlspecialchars($v0['type of case']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'caretaker voor dossier: ';
                echo '<SPAN CLASS="item UIcaretakervoordossier" ID="0.'.$i0.'.4">';
                if(!$edit) echo '
                <A HREF="Organ.php?Organ='.urlencode($v0['caretaker voor dossier']).'">'.htmlspecialchars($v0['caretaker voor dossier']).'</A>';
                else echo htmlspecialchars($v0['caretaker voor dossier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '
                <UL>';
                foreach($v0['court'] as $i1=>$court){
                  echo '
                  <LI CLASS="item UIcourt" ID="0.'.$i0.'.5.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
                    else echo htmlspecialchars($court);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIcourt" ID="0.'.$i0.'.5.'.count($v0['court']).'">new court</LI>';
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
                            echo 'cases: ';
                            echo '
                            <UL>';
                            foreach($clusters['cases'] as $i2=>$cases){
                              echo '
                              <LI CLASS="item UIclusters" ID="0.'.$i0.'.6.'.$i1.'.0.'.$i2.'">';
                                if(!$edit){
                                  echo '
                                <A class="GotoLink" id="To0.'.$i0.'.6.'.$i1.'.0.'.$i2.'">';
                                  echo htmlspecialchars($cases).'</A>';
                                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.6.'.$i1.'.0.'.$i2.'"><UL>';
                                  echo '<LI><A HREF="CoreDataUC001.php?CoreDataUC001='.urlencode($cases).'">CoreDataUC001</A></LI>';
                                  echo '<LI><A HREF="LegalCase.php?LegalCase='.urlencode($cases).'">LegalCase</A></LI>';
                                  echo '<LI><A HREF="newCase.php?newCase='.urlencode($cases).'">newCase</A></LI>';
                                  echo '</UL></DIV>';
                                } else echo htmlspecialchars($cases);
                              echo '</LI>';
                            }
                            if($edit) echo '
                              <LI CLASS="new UIclusters" ID="0.'.$i0.'.6.'.$i1.'.0.'.count($clusters['cases']).'">new cases</LI>';
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
            <LI CLASS="new UI" ID="0.'.count($Cases).'">new Cases</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Cases
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>session: <UL><LI CLASS="new UI_session" ID="'+id+'.1">new session</LI></UL></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UI_areaoflaw" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>type of case: <SPAN CLASS="item UI_typeofcase" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>caretaker voor dossier: <SPAN CLASS="item UI_caretakervoordossier" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>court: <UL><LI CLASS="new UI_court" ID="'+id+'.5">new court</LI></UL></DIV>'
             + '<DIV>clusters: <UL><LI CLASS="new UI_clusters" ID="'+id+'.6">new clusters</LI></UL></DIV>'
              ;
      }
      function UIclusters(id){
        return '<DIV>cases: <UL><LI CLASS="new UIclusters_cases" ID="'+id+'.0">new cases</LI></UL></DIV>'
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