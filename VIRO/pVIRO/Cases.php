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
                         );
      $Cases[$i0]['session']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Cases[$i0]['session'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Cases[$i0]['type of case']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Cases[$i0]['type of case'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Cases[$i0]['court']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Cases[$i0]['court'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
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
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
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
                echo '
                <UL>';
                foreach($v0['type of case'] as $i1=>$typeofcase){
                  echo '
                  <LI CLASS="item UItypeofcase" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
                    else echo htmlspecialchars($typeofcase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UItypeofcase" ID="0.'.$i0.'.3.'.count($v0['type of case']).'">new type of case</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '
                <UL>';
                foreach($v0['court'] as $i1=>$court){
                  echo '
                  <LI CLASS="item UIcourt" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
                    else echo htmlspecialchars($court);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIcourt" ID="0.'.$i0.'.4.'.count($v0['court']).'">new court</LI>';
                echo '
                </UL>';
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
             + '<DIV>type of case: <UL><LI CLASS="new UI_typeofcase" ID="'+id+'.3">new type of case</LI></UL></DIV>'
             + '<DIV>court: <UL><LI CLASS="new UI_court" ID="'+id+'.4">new court</LI></UL></DIV>'
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