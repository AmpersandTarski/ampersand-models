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
  require "Magistrates.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Judges=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Judges[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                          , 'name' => @$r['0.'.$i0.'.0']
                          , 'role' => @$r['0.'.$i0.'.2']
                          );
      $Judges[$i0]['court']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Judges[$i0]['court'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $Clerks=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Clerks[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                          , 'name' => @$r['1.'.$i0.'.0']
                          , 'role' => @$r['1.'.$i0.'.2']
                          );
      $Clerks[$i0]['court']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $Clerks[$i0]['court'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $Magistrates=new Magistrates($Judges, $Clerks);
    if($Magistrates->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Magistrates=new Magistrates();
    writeHead("<TITLE>Magistrates - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Magistrates</H1>
    <DIV class="Floater Judges">
      <DIV class="FloaterHeader">Judges</DIV>
      <DIV class="FloaterContent"><?php
          $Judges = $Magistrates->get_Judges();
          echo '
          <UL>';
          foreach($Judges as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Judges" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Judges_name" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '
                <UL>';
                foreach($v0['court'] as $i1=>$court){
                  echo '
                  <LI CLASS="item UI_Judges_court" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
                    else echo htmlspecialchars($court);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Judges_court" ID="0.'.$i0.'.1.'.count($v0['court']).'">new court</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'role: ';
                echo '<SPAN CLASS="item UI_Judges_role" ID="0.'.$i0.'.2">';
                echo htmlspecialchars($v0['role']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Judges" ID="0.'.count($Judges).'">new Judges</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Judges
      function UI_Judges(id){
        return '<DIV>name: <SPAN CLASS="item UI_Judges_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>court: <UL><LI CLASS="new UI_Judges_court" ID="'+id+'.1">new court</LI></UL></DIV>'
             + '<DIV>role: <SPAN CLASS="item UI_Judges_role" ID="'+id+'.2"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Clerks">
      <DIV class="FloaterHeader">Clerks</DIV>
      <DIV class="FloaterContent"><?php
          $Clerks = $Magistrates->get_Clerks();
          echo '
          <UL>';
          foreach($Clerks as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Clerks" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Clerks_name" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '
                <UL>';
                foreach($v0['court'] as $i1=>$court){
                  echo '
                  <LI CLASS="item UI_Clerks_court" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Court.php?Court='.urlencode($court).'">'.htmlspecialchars($court).'</A>';
                    else echo htmlspecialchars($court);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Clerks_court" ID="1.'.$i0.'.1.'.count($v0['court']).'">new court</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'role: ';
                echo '<SPAN CLASS="item UI_Clerks_role" ID="1.'.$i0.'.2">';
                echo htmlspecialchars($v0['role']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Clerks" ID="1.'.count($Clerks).'">new Clerks</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Clerks
      function UI_Clerks(id){
        return '<DIV>name: <SPAN CLASS="item UI_Clerks_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>court: <UL><LI CLASS="new UI_Clerks_court" ID="'+id+'.1">new court</LI></UL></DIV>'
             + '<DIV>role: <SPAN CLASS="item UI_Clerks_role" ID="'+id+'.2"></SPAN></DIV>'
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