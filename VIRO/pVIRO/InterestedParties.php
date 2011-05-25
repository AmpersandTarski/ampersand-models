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
  require "InterestedParties.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Interestedparties=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Interestedparties[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                     , 'name' => @$r['0.'.$i0.'.0']
                                     , 'role' => @$r['0.'.$i0.'.1']
                                     );
      $Interestedparties[$i0]['representative']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Interestedparties[$i0]['representative'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $InterestedParties=new InterestedParties($Interestedparties);
    if($InterestedParties->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $InterestedParties=new InterestedParties();
    writeHead("<TITLE>InterestedParties - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>InterestedParties</H1>
    <DIV class="Floater Interested parties">
      <DIV class="FloaterHeader">Interested parties</DIV>
      <DIV class="FloaterContent"><?php
          $Interestedparties = $InterestedParties->get_Interestedparties();
          echo '
          <UL>';
          foreach($Interestedparties as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
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
                echo '<SPAN CLASS="item UIname" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'role: ';
                echo '<SPAN CLASS="item UIrole" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['role']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UIrepresentative" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrepresentative" ID="0.'.$i0.'.2.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Interestedparties).'">new Interested parties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Interested parties
      function UI(id){
        return '<DIV>name: <SPAN CLASS="item UI_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>role: <SPAN CLASS="item UI_role" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_representative" ID="'+id+'.2">new representative</LI></UL></DIV>'
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