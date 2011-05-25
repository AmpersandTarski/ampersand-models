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
  require "Schedule.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Process=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Process[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                           , 'nr' => @$r['0.'.$i0.'.0']
                           , 'session' => @$r['0.'.$i0.'.1']
                           , 'case' => @$r['0.'.$i0.'.2']
                           , 'scheduled' => @$r['0.'.$i0.'.3']
                           );
    }
    $Schedule=new Schedule($Process);
    if($Schedule->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Schedule=new Schedule();
    writeHead("<TITLE>Schedule - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Schedule</H1>
    <DIV class="Floater Process">
      <DIV class="FloaterHeader">Process</DIV>
      <DIV class="FloaterContent"><?php
          $Process = $Schedule->get_Process();
          echo '
          <UL>';
          foreach($Process as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Process.php?Process='.urlencode($v0['id']).'">Process</A></LI>';
                echo '<LI><A HREF="ScheduleProcess.php?ScheduleProcess='.urlencode($v0['id']).'">ScheduleProcess</A></LI>';
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
                echo '<SPAN CLASS="item UIsession" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Session.php?Session='.urlencode($v0['session']).'">'.htmlspecialchars($v0['session']).'</A>';
                else echo htmlspecialchars($v0['session']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'case: ';
                echo '<SPAN CLASS="item UIcase" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="LegalCase.php?LegalCase='.urlencode($v0['case']).'">'.htmlspecialchars($v0['case']).'</A>';
                else echo htmlspecialchars($v0['case']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'scheduled: ';
                echo '<SPAN CLASS="item UIscheduled" ID="0.'.$i0.'.3">';
                echo htmlspecialchars($v0['scheduled']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Process).'">new Process</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Process
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>session: <SPAN CLASS="item UI_session" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>case: <SPAN CLASS="item UI_case" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>scheduled: <SPAN CLASS="item UI_scheduled" ID="'+id+'.3"></SPAN></DIV>'
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