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
  require "Process.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $session = array( 'id' => @$r['0']
                    , 'court' => @$r['0.0']
                    , 'clerk' => @$r['0.2']
                    , 'scheduled' => @$r['0.3']
                    , 'date of occurence' => @$r['0.4']
                    );
    $session['judge']=array();
    for($i0=0;isset($r['0.1.'.$i0]);$i0++){
      $session['judge'][$i0] = @$r['0.1.'.$i0.''];
    }
    $case = array( 'id' => @$r['1']
                 , 'area of law' => @$r['1.0']
                 , 'type of case' => @$r['1.1']
                 );
    $case['session']=array();
    for($i0=0;isset($r['1.2.'.$i0]);$i0++){
      $case['session'][$i0] = @$r['1.2.'.$i0.''];
    }
    $Process=new Process($ID,$session, $case);
    if($Process->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Process='.urlencode($Process->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Process'])){
    if(!$del || !delProcess($_REQUEST['Process']))
      $Process = readProcess($_REQUEST['Process']);
    else $Process = false; // delete was a succes!
  } else if($new) $Process = new Process();
  else $Process = false;
  if($Process){
    writeHead("<TITLE>Process - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Process->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Process->getId()).'" /></P>';
    else echo '<H1>'.$Process->getId().'</H1>';
    ?>
    <DIV class="Floater session">
      <DIV class="FloaterHeader">session</DIV>
      <DIV class="FloaterContent"><?php
          $session = $Process->get_session();
          echo '<DIV CLASS="UI_session" ID="0">';
            if(!$edit){
              echo '
            <A HREF="Session.php?Session='.urlencode($session['id']).'">';
              echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
            }
            echo '
            <DIV>';
              echo 'court: ';
              echo '<SPAN CLASS="item UI_session_court" ID="0.0">';
              if(!$edit) echo '
              <A HREF="Court.php?Court='.urlencode($session['court']).'">'.htmlspecialchars($session['court']).'</A>';
              else echo htmlspecialchars($session['court']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'judge: ';
              echo '
              <UL>';
              foreach($session['judge'] as $i0=>$judge){
                echo '
                <LI CLASS="item UI_session_judge" ID="0.1.'.$i0.'">';
                  if(!$edit){
                    echo '
                  <A class="GotoLink" id="To0.1.'.$i0.'">';
                    echo htmlspecialchars($judge).'</A>';
                    echo '<DIV class="Goto" id="GoTo0.1.'.$i0.'"><UL>';
                    echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($judge).'">Magistrate</A></LI>';
                    echo '<LI><A HREF="Party.php?Party='.urlencode($judge).'">Party</A></LI>';
                    echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($judge).'">InterestedParty</A></LI>';
                    echo '</UL></DIV>';
                  } else echo htmlspecialchars($judge);
                echo '</LI>';
              }
              if($edit) echo '
                <LI CLASS="new UI_session_judge" ID="0.1.'.count($session['judge']).'">new judge</LI>';
              echo '
              </UL>';
            echo '</DIV>
            <DIV>';
              echo 'clerk: ';
              echo '<SPAN CLASS="item UI_session_clerk" ID="0.2">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.2">';
                echo htmlspecialchars($session['clerk']).'</A>';
                echo '<DIV class="Goto" id="GoTo0.2"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($session['clerk']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($session['clerk']).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($session['clerk']).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($session['clerk']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'scheduled: ';
              echo '<SPAN CLASS="item UI_session_scheduled" ID="0.3">';
              echo htmlspecialchars($session['scheduled']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'date of occurence: ';
              echo '<SPAN CLASS="item UI_session_dateofoccurence" ID="0.4">';
              if(isset($session['date of occurence'])){
                echo htmlspecialchars($session['date of occurence']);
              }
              echo '</SPAN>';
            echo '
            </DIV>';
            if($edit) echo '
            <INPUT TYPE="hidden" name="0.ID" VALUE="'.$session['id'].'" />';
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater case">
      <DIV class="FloaterHeader">case</DIV>
      <DIV class="FloaterContent"><?php
          $case = $Process->get_case();
          echo '<DIV CLASS="UI_case" ID="1">';
            if(!$edit){
              echo '
            <A HREF="LegalCase.php?LegalCase='.urlencode($case['id']).'">';
              echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
            }
            echo '
            <DIV>';
              echo 'area of law: ';
              echo '<SPAN CLASS="item UI_case_areaoflaw" ID="1.0">';
              if(!$edit) echo '
              <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($case['area of law']).'">'.htmlspecialchars($case['area of law']).'</A>';
              else echo htmlspecialchars($case['area of law']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'type of case: ';
              echo '<SPAN CLASS="item UI_case_typeofcase" ID="1.1">';
              if(!$edit) echo '
              <A HREF="CaseType.php?CaseType='.urlencode($case['type of case']).'">'.htmlspecialchars($case['type of case']).'</A>';
              else echo htmlspecialchars($case['type of case']);
              echo '</SPAN>';
            echo '</DIV>
            <DIV>';
              echo 'session: ';
              echo '
              <UL>';
              foreach($case['session'] as $i0=>$session){
                echo '
                <LI CLASS="item UI_case_session" ID="1.2.'.$i0.'">';
                  if(!$edit) echo '
                  <A HREF="Session.php?Session='.urlencode($session).'">'.htmlspecialchars($session).'</A>';
                  else echo htmlspecialchars($session);
                echo '</LI>';
              }
              if($edit) echo '
                <LI CLASS="new UI_case_session" ID="1.2.'.count($case['session']).'">new session</LI>';
              echo '
              </UL>';
            echo '
            </DIV>';
            if($edit) echo '
            <INPUT TYPE="hidden" name="1.ID" VALUE="'.$case['id'].'" />';
          echo '</DIV>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Process->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Process=".urlencode($Process->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Process=".urlencode($Process->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Process=".urlencode($Process->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Process is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Process object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Process object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>