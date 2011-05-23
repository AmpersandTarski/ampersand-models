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
  require "Organ.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $currentacts=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $currentacts[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                               , 'act' => @$r['0.'.$i0.'.0']
                               );
      $currentacts[$i0]['prio']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $currentacts[$i0]['prio'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $currentacts[$i0]['usecase']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $currentacts[$i0]['usecase'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $currentacts[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $currentacts[$i0]['rol'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $actions=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $actions[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                           , 'actie' => @$r['1.'.$i0.'.0']
                           , 'subject' => @$r['1.'.$i0.'.1']
                           , 'type' => @$r['1.'.$i0.'.2']
                           );
    }
    $casefiles=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $casefiles[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                             , 'case' => @$r['2.'.$i0.'.0']
                             , 'area of law' => @$r['2.'.$i0.'.1']
                             , 'type of case' => @$r['2.'.$i0.'.2']
                             );
    }
    $Organ=new Organ($ID,$currentacts, $actions, $casefiles);
    if($Organ->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Organ='.urlencode($Organ->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Organ'])){
    if(!$del || !delOrgan($_REQUEST['Organ']))
      $Organ = readOrgan($_REQUEST['Organ']);
    else $Organ = false; // delete was a succes!
  } else if($new) $Organ = new Organ();
  else $Organ = false;
  if($Organ){
    writeHead("<TITLE>Organ - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Organ->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Organ->getId()).'" /></P>';
    else echo '<H1>'.$Organ->getId().'</H1>';
    ?>
    <DIV class="Floater current acts">
      <DIV class="FloaterHeader">current acts</DIV>
      <DIV class="FloaterContent"><?php
          $currentacts = $Organ->get_currentacts();
          echo '
          <UL>';
          foreach($currentacts as $i0=>$v0){
            echo '
            <LI CLASS="item UI_currentacts" ID="0.'.$i0.'">';
              echo '
              <DIV>';
                echo 'act: ';
                echo '<SPAN CLASS="item UI_currentacts_act" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['act']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'prio: ';
                echo '
                <UL>';
                foreach($v0['prio'] as $i1=>$prio){
                  echo '
                  <LI CLASS="item UI_currentacts_prio" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($prio);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_currentacts_prio" ID="0.'.$i0.'.1.'.count($v0['prio']).'">new prio</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'usecase: ';
                echo '
                <UL>';
                foreach($v0['usecase'] as $i1=>$usecase){
                  echo '
                  <LI CLASS="item UI_currentacts_usecase" ID="0.'.$i0.'.2.'.$i1.'">';
                    echo htmlspecialchars($usecase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_currentacts_usecase" ID="0.'.$i0.'.2.'.count($v0['usecase']).'">new usecase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_currentacts_rol" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_currentacts_rol" ID="0.'.$i0.'.3.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_currentacts" ID="0.'.count($currentacts).'">new current acts</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in current acts
      function UI_currentacts(id){
        return '<DIV>act: <SPAN CLASS="item UI_currentacts_act" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>prio: <UL><LI CLASS="new UI_currentacts_prio" ID="'+id+'.1">new prio</LI></UL></DIV>'
             + '<DIV>usecase: <UL><LI CLASS="new UI_currentacts_usecase" ID="'+id+'.2">new usecase</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_currentacts_rol" ID="'+id+'.3">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater actions">
      <DIV class="FloaterHeader">actions</DIV>
      <DIV class="FloaterContent"><?php
          $actions = $Organ->get_actions();
          echo '
          <UL>';
          foreach($actions as $i0=>$v0){
            echo '
            <LI CLASS="item UI_actions" ID="1.'.$i0.'">';
              echo '
              <DIV>';
                echo 'actie: ';
                echo '<SPAN CLASS="item UI_actions_actie" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['actie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'subject: ';
                echo '<SPAN CLASS="item UI_actions_subject" ID="1.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.1">';
                  echo htmlspecialchars($v0['subject']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['subject']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['subject']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['subject']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['subject']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_actions_type" ID="1.'.$i0.'.2">';
                echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_actions" ID="1.'.count($actions).'">new actions</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in actions
      function UI_actions(id){
        return '<DIV>actie: <SPAN CLASS="item UI_actions_actie" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>subject: <SPAN CLASS="item UI_actions_subject" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_actions_type" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater case files">
      <DIV class="FloaterHeader">case files</DIV>
      <DIV class="FloaterContent"><?php
          $casefiles = $Organ->get_casefiles();
          echo '
          <UL>';
          foreach($casefiles as $i0=>$v0){
            echo '
            <LI CLASS="item UI_casefiles" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="CoreDataUC001.php?CoreDataUC001='.urlencode($v0['id']).'">CoreDataUC001</A></LI>';
                echo '<LI><A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">LegalCase</A></LI>';
                echo '<LI><A HREF="newCase.php?newCase='.urlencode($v0['id']).'">newCase</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'case: ';
                echo '<SPAN CLASS="item UI_casefiles_case" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['case']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UI_casefiles_areaoflaw" ID="2.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '<SPAN CLASS="item UI_casefiles_typeofcase" ID="2.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="CaseType.php?CaseType='.urlencode($v0['type of case']).'">'.htmlspecialchars($v0['type of case']).'</A>';
                else echo htmlspecialchars($v0['type of case']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_casefiles" ID="2.'.count($casefiles).'">new case files</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in case files
      function UI_casefiles(id){
        return '<DIV>case: <SPAN CLASS="item UI_casefiles_case" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UI_casefiles_areaoflaw" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type of case: <SPAN CLASS="item UI_casefiles_typeofcase" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Organ->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Organ=".urlencode($Organ->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Organ=".urlencode($Organ->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Organ=".urlencode($Organ->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Organ is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Organ object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Organ object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>