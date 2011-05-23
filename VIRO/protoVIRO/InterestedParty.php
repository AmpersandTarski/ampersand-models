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
  require "InterestedParty.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $cases=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $cases[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                         , 'nr' => @$r['0.'.$i0.'.0']
                         , 'caretaker of case file' => @$r['0.'.$i0.'.1']
                         , 'area of law' => @$r['0.'.$i0.'.2']
                         , 'type of case' => @$r['0.'.$i0.'.3']
                         );
    }
    $correspondence=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $correspondence[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                  , 'from' => @$r['1.'.$i0.'.0']
                                  , 'remark' => @$r['1.'.$i0.'.2']
                                  , 'sent at' => @$r['1.'.$i0.'.3']
                                  );
      $correspondence[$i0]['to']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $correspondence[$i0]['to'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $InterestedParty=new InterestedParty($ID,$cases, $correspondence);
    if($InterestedParty->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?InterestedParty='.urlencode($InterestedParty->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['InterestedParty'])){
    if(!$del || !delInterestedParty($_REQUEST['InterestedParty']))
      $InterestedParty = readInterestedParty($_REQUEST['InterestedParty']);
    else $InterestedParty = false; // delete was a succes!
  } else if($new) $InterestedParty = new InterestedParty();
  else $InterestedParty = false;
  if($InterestedParty){
    writeHead("<TITLE>InterestedParty - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $InterestedParty->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($InterestedParty->getId()).'" /></P>';
    else echo '<H1>'.$InterestedParty->getId().'</H1>';
    ?>
    <DIV class="Floater cases">
      <DIV class="FloaterHeader">cases</DIV>
      <DIV class="FloaterContent"><?php
          $cases = $InterestedParty->get_cases();
          echo '
          <UL>';
          foreach($cases as $i0=>$v0){
            echo '
            <LI CLASS="item UI_cases" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UI_cases_nr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'caretaker of case file: ';
                echo '<SPAN CLASS="item UI_cases_caretakerofcasefile" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Organ.php?Organ='.urlencode($v0['caretaker of case file']).'">'.htmlspecialchars($v0['caretaker of case file']).'</A>';
                else echo htmlspecialchars($v0['caretaker of case file']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UI_cases_areaoflaw" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '<SPAN CLASS="item UI_cases_typeofcase" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="CaseType.php?CaseType='.urlencode($v0['type of case']).'">'.htmlspecialchars($v0['type of case']).'</A>';
                else echo htmlspecialchars($v0['type of case']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cases" ID="0.'.count($cases).'">new cases</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in cases
      function UI_cases(id){
        return '<DIV>nr: <SPAN CLASS="item UI_cases_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>caretaker of case file: <SPAN CLASS="item UI_cases_caretakerofcasefile" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UI_cases_areaoflaw" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>type of case: <SPAN CLASS="item UI_cases_typeofcase" ID="'+id+'.3"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater correspondence">
      <DIV class="FloaterHeader">correspondence</DIV>
      <DIV class="FloaterContent"><?php
          $correspondence = $InterestedParty->get_correspondence();
          echo '
          <UL>';
          foreach($correspondence as $i0=>$v0){
            echo '
            <LI CLASS="item UI_correspondence" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="Letter.php?Letter='.urlencode($v0['id']).'">Letter</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'from: ';
                echo '<SPAN CLASS="item UI_correspondence_from" ID="1.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.0">';
                  echo htmlspecialchars($v0['from']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['from']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['from']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['from']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['from']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'to: ';
                echo '
                <UL>';
                foreach($v0['to'] as $i1=>$to){
                  echo '
                  <LI CLASS="item UI_correspondence_to" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To1.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($to).'</A>';
                      echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($to).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($to).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($to).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($to);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_correspondence_to" ID="1.'.$i0.'.1.'.count($v0['to']).'">new to</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'remark: ';
                echo '<SPAN CLASS="item UI_correspondence_remark" ID="1.'.$i0.'.2">';
                echo htmlspecialchars($v0['remark']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'sent at: ';
                echo '<SPAN CLASS="item UI_correspondence_sentat" ID="1.'.$i0.'.3">';
                echo htmlspecialchars($v0['sent at']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_correspondence" ID="1.'.count($correspondence).'">new correspondence</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in correspondence
      function UI_correspondence(id){
        return '<DIV>from: <SPAN CLASS="item UI_correspondence_from" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>to: <UL><LI CLASS="new UI_correspondence_to" ID="'+id+'.1">new to</LI></UL></DIV>'
             + '<DIV>remark: <SPAN CLASS="item UI_correspondence_remark" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>sent at: <SPAN CLASS="item UI_correspondence_sentat" ID="'+id+'.3"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($InterestedParty->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?InterestedParty=".urlencode($InterestedParty->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&InterestedParty=".urlencode($InterestedParty->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&InterestedParty=".urlencode($InterestedParty->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The InterestedParty is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No InterestedParty object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No InterestedParty object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>