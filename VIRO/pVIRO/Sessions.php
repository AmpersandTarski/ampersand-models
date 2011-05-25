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
  require "Sessions.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Sessions=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Sessions[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                            , 'nr' => @$r['0.'.$i0.'.0']
                            , 'panel' => @$r['0.'.$i0.'.1']
                            , 'court' => @$r['0.'.$i0.'.2']
                            , 'city' => @$r['0.'.$i0.'.3']
                            , 'clerk' => @$r['0.'.$i0.'.5']
                            , 'scheduled' => @$r['0.'.$i0.'.6']
                            , 'date of occurence' => @$r['0.'.$i0.'.7']
                            );
      $Sessions[$i0]['judge']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Sessions[$i0]['judge'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Sessions=new Sessions($Sessions);
    if($Sessions->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Sessions=new Sessions();
    writeHead("<TITLE>Sessions - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Sessions</H1>
    <DIV class="Floater Sessions">
      <DIV class="FloaterHeader">Sessions</DIV>
      <DIV class="FloaterContent"><?php
          $Sessions = $Sessions->get_Sessions();
          echo '
          <UL>';
          foreach($Sessions as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Session.php?Session='.urlencode($v0['id']).'">';
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
                echo 'panel: ';
                echo '<SPAN CLASS="item UIpanel" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Panel.php?Panel='.urlencode($v0['panel']).'">'.htmlspecialchars($v0['panel']).'</A>';
                else echo htmlspecialchars($v0['panel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '<SPAN CLASS="item UIcourt" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Court.php?Court='.urlencode($v0['court']).'">'.htmlspecialchars($v0['court']).'</A>';
                else echo htmlspecialchars($v0['court']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'city: ';
                echo '<SPAN CLASS="item UIcity" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="City.php?City='.urlencode($v0['city']).'">'.htmlspecialchars($v0['city']).'</A>';
                else echo htmlspecialchars($v0['city']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'judge: ';
                echo '
                <UL>';
                foreach($v0['judge'] as $i1=>$judge){
                  echo '
                  <LI CLASS="item UIjudge" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.4.'.$i1.'">';
                      echo htmlspecialchars($judge).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.4.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($judge).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($judge).'">Party</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($judge);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIjudge" ID="0.'.$i0.'.4.'.count($v0['judge']).'">new judge</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'clerk: ';
                echo '<SPAN CLASS="item UIclerk" ID="0.'.$i0.'.5">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.5">';
                  echo htmlspecialchars($v0['clerk']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.5"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['clerk']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['clerk']).'">Party</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['clerk']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'scheduled: ';
                echo '<SPAN CLASS="item UIscheduled" ID="0.'.$i0.'.6">';
                echo htmlspecialchars($v0['scheduled']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'date of occurence: ';
                echo '<SPAN CLASS="item UIdateofoccurence" ID="0.'.$i0.'.7">';
                if(isset($v0['date of occurence'])){
                  echo htmlspecialchars($v0['date of occurence']);
                }
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Sessions).'">new Sessions</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Sessions
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>panel: <SPAN CLASS="item UI_panel" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>court: <SPAN CLASS="item UI_court" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>city: <SPAN CLASS="item UI_city" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>judge: <UL><LI CLASS="new UI_judge" ID="'+id+'.4">new judge</LI></UL></DIV>'
             + '<DIV>clerk: <SPAN CLASS="item UI_clerk" ID="'+id+'.5"></SPAN></DIV>'
             + '<DIV>scheduled: <SPAN CLASS="item UI_scheduled" ID="'+id+'.6"></SPAN></DIV>'
             + '<DIV>date of occurence: <DIV CLASS="new UI_dateofoccurence" ID="'+id+'.7"><I>Nothing</I></DIV></DIV>'
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