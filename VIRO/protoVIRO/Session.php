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
  require "Session.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $court = @$r['0'];
    $panel = @$r['1'];
    $city = @$r['2'];
    $judge=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $judge[$i0] = @$r['3.'.$i0.''];
    }
    $clerk = @$r['4'];
    $scheduled = @$r['5'];
    if(@$r['6']!=''){
      $dateofoccurence = @$r['6'];
    }else $dateofoccurence=null;
    $cases=array();
    for($i0=0;isset($r['7.'.$i0]);$i0++){
      $cases[$i0] = array( 'id' => @$r['7.'.$i0.'.0']
                         , 'nr' => @$r['7.'.$i0.'.0']
                         );
      $cases[$i0]['plaintiff']=array();
      for($i1=0;isset($r['7.'.$i0.'.1.'.$i1]);$i1++){
        $cases[$i0]['plaintiff'][$i1] = @$r['7.'.$i0.'.1.'.$i1.''];
      }
      $cases[$i0]['defendant']=array();
      for($i1=0;isset($r['7.'.$i0.'.2.'.$i1]);$i1++){
        $cases[$i0]['defendant'][$i1] = @$r['7.'.$i0.'.2.'.$i1.''];
      }
    }
    $Session=new Session($ID,$court, $panel, $city, $judge, $clerk, $scheduled, $dateofoccurence, $cases);
    if($Session->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Session='.urlencode($Session->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Session'])){
    if(!$del || !delSession($_REQUEST['Session']))
      $Session = readSession($_REQUEST['Session']);
    else $Session = false; // delete was a succes!
  } else if($new) $Session = new Session();
  else $Session = false;
  if($Session){
    writeHead("<TITLE>Session - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Session->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Session->getId()).'" /></P>';
    else echo '<H1>'.$Session->getId().'</H1>';
    ?>
    <DIV class="Floater court">
      <DIV class="FloaterHeader">court</DIV>
      <DIV class="FloaterContent"><?php
          $court = $Session->get_court();
          echo '<SPAN CLASS="item UI_court" ID="0">';
          if(!$edit) echo '
          <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
          else echo htmlspecialchars($court);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater panel">
      <DIV class="FloaterHeader">panel</DIV>
      <DIV class="FloaterContent"><?php
          $panel = $Session->get_panel();
          echo '<SPAN CLASS="item UI_panel" ID="1">';
          if(!$edit) echo '
          <A HREF="Panel.php?Panel='.urlencode($panel).'">'.htmlspecialchars($panel).'</A>';
          else echo htmlspecialchars($panel);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater city">
      <DIV class="FloaterHeader">city</DIV>
      <DIV class="FloaterContent"><?php
          $city = $Session->get_city();
          echo '<SPAN CLASS="item UI_city" ID="2">';
          if(!$edit) echo '
          <A HREF="City.php?City='.urlencode($city).'">'.htmlspecialchars($city).'</A>';
          else echo htmlspecialchars($city);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater judge">
      <DIV class="FloaterHeader">judge</DIV>
      <DIV class="FloaterContent"><?php
          $judge = $Session->get_judge();
          echo '
          <UL>';
          foreach($judge as $i0=>$v0){
            echo '
            <LI CLASS="item UI_judge" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_judge" ID="3.'.count($judge).'">new judge</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater clerk">
      <DIV class="FloaterHeader">clerk</DIV>
      <DIV class="FloaterContent"><?php
          $clerk = $Session->get_clerk();
          echo '<SPAN CLASS="item UI_clerk" ID="4">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To4">';
            echo htmlspecialchars($clerk).'</A>';
            echo '<DIV class="Goto" id="GoTo4"><UL>';
            echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($clerk).'">Magistrate</A></LI>';
            echo '<LI><A HREF="Party.php?Party='.urlencode($clerk).'">Party</A></LI>';
            echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($clerk).'">InterestedParty</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($clerk);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater scheduled">
      <DIV class="FloaterHeader">scheduled</DIV>
      <DIV class="FloaterContent"><?php
          $scheduled = $Session->get_scheduled();
          echo '<SPAN CLASS="item UI_scheduled" ID="5">';
          echo htmlspecialchars($scheduled);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater date of occurence">
      <DIV class="FloaterHeader">date of occurence</DIV>
      <DIV class="FloaterContent"><?php
          $dateofoccurence = $Session->get_dateofoccurence();
          echo '<SPAN CLASS="item UI_dateofoccurence" ID="6">';
          if(isset($dateofoccurence)){
            echo htmlspecialchars($dateofoccurence);
          }
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater cases">
      <DIV class="FloaterHeader">cases</DIV>
      <DIV class="FloaterContent"><?php
          $cases = $Session->get_cases();
          echo '
          <UL>';
          foreach($cases as $i0=>$v0){
            echo '
            <LI CLASS="item UI_cases" ID="7.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UI_cases_nr" ID="7.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'plaintiff: ';
                echo '
                <UL>';
                foreach($v0['plaintiff'] as $i1=>$plaintiff){
                  echo '
                  <LI CLASS="item UI_cases_plaintiff" ID="7.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To7.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($plaintiff).'</A>';
                      echo '<DIV class="Goto" id="GoTo7.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($plaintiff).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($plaintiff).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($plaintiff).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($plaintiff);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cases_plaintiff" ID="7.'.$i0.'.1.'.count($v0['plaintiff']).'">new plaintiff</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'defendant: ';
                echo '
                <UL>';
                foreach($v0['defendant'] as $i1=>$defendant){
                  echo '
                  <LI CLASS="item UI_cases_defendant" ID="7.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To7.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($defendant).'</A>';
                      echo '<DIV class="Goto" id="GoTo7.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($defendant).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($defendant).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($defendant).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($defendant);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cases_defendant" ID="7.'.$i0.'.2.'.count($v0['defendant']).'">new defendant</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="7.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cases" ID="7.'.count($cases).'">new cases</LI>';
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
             + '<DIV>plaintiff: <UL><LI CLASS="new UI_cases_plaintiff" ID="'+id+'.1">new plaintiff</LI></UL></DIV>'
             + '<DIV>defendant: <UL><LI CLASS="new UI_cases_defendant" ID="'+id+'.2">new defendant</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Session->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Session=".urlencode($Session->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Session=".urlencode($Session->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Session=".urlencode($Session->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Session is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Session object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Session object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>