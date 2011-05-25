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
  require "Panels.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Panels=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Panels[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                          , 'panel' => @$r['0.'.$i0.'.0']
                          , 'court' => @$r['0.'.$i0.'.1']
                          );
      $Panels[$i0]['members']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Panels[$i0]['members'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $Panels=new Panels($Panels);
    if($Panels->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Panels=new Panels();
    writeHead("<TITLE>Panels - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Panels</H1>
    <DIV class="Floater Panels">
      <DIV class="FloaterHeader">Panels</DIV>
      <DIV class="FloaterContent"><?php
          $Panels = $Panels->get_Panels();
          echo '
          <UL>';
          foreach($Panels as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Panel.php?Panel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'panel: ';
                echo '<SPAN CLASS="item UIpanel" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['panel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'court: ';
                echo '<SPAN CLASS="item UIcourt" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Court.php?Court='.urlencode($v0['court']).'">'.htmlspecialchars($v0['court']).'</A>';
                else echo htmlspecialchars($v0['court']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'members: ';
                echo '
                <UL>';
                foreach($v0['members'] as $i1=>$members){
                  echo '
                  <LI CLASS="item UImembers" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($members).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($members).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($members).'">Party</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($members);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UImembers" ID="0.'.$i0.'.2.'.count($v0['members']).'">new members</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Panels).'">new Panels</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Panels
      function UI(id){
        return '<DIV>panel: <SPAN CLASS="item UI_panel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>court: <SPAN CLASS="item UI_court" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>members: <UL><LI CLASS="new UI_members" ID="'+id+'.2">new members</LI></UL></DIV>'
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