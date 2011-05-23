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
  require "Parties.inc.php";
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
                                     );
      $Interestedparties[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Interestedparties[$i0]['rol'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $Representatives=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $Representatives[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                                   , 'name' => @$r['1.'.$i0.'.0']
                                   );
      $Representatives[$i0]['rol']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $Representatives[$i0]['rol'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $Judges=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $Judges[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                          , 'name' => @$r['2.'.$i0.'.0']
                          );
      $Judges[$i0]['rol']=array();
      for($i1=0;isset($r['2.'.$i0.'.1.'.$i1]);$i1++){
        $Judges[$i0]['rol'][$i1] = @$r['2.'.$i0.'.1.'.$i1.''];
      }
    }
    $Clerks=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $Clerks[$i0] = array( 'id' => @$r['3.'.$i0.'.0']
                          , 'name' => @$r['3.'.$i0.'.0']
                          );
      $Clerks[$i0]['rol']=array();
      for($i1=0;isset($r['3.'.$i0.'.1.'.$i1]);$i1++){
        $Clerks[$i0]['rol'][$i1] = @$r['3.'.$i0.'.1.'.$i1.''];
      }
    }
    $Parties=new Parties($Interestedparties, $Representatives, $Judges, $Clerks);
    if($Parties->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Parties=new Parties();
    writeHead("<TITLE>Parties - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Persons</H1>
    <DIV class="Floater Interested parties">
      <DIV class="FloaterHeader">Interested parties</DIV>
      <DIV class="FloaterContent"><?php
          $Interestedparties = $Parties->get_Interestedparties();
          echo '
          <UL>';
          foreach($Interestedparties as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Interestedparties" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['id']).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Interestedparties_name" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Interestedparties_rol" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Interestedparties_rol" ID="0.'.$i0.'.1.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Interestedparties" ID="0.'.count($Interestedparties).'">new Interested parties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Interested parties
      function UI_Interestedparties(id){
        return '<DIV>name: <SPAN CLASS="item UI_Interestedparties_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Interestedparties_rol" ID="'+id+'.1">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Representatives">
      <DIV class="FloaterHeader">Representatives</DIV>
      <DIV class="FloaterContent"><?php
          $Representatives = $Parties->get_Representatives();
          echo '
          <UL>';
          foreach($Representatives as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Representatives" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['id']).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Representatives_name" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Representatives_rol" ID="1.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Representatives_rol" ID="1.'.$i0.'.1.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Representatives" ID="1.'.count($Representatives).'">new Representatives</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Representatives
      function UI_Representatives(id){
        return '<DIV>name: <SPAN CLASS="item UI_Representatives_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_Representatives_rol" ID="'+id+'.1">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Judges">
      <DIV class="FloaterHeader">Judges</DIV>
      <DIV class="FloaterContent"><?php
          $Judges = $Parties->get_Judges();
          echo '
          <UL>';
          foreach($Judges as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Judges" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['id']).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Judges_name" ID="2.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Judges_rol" ID="2.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Judges_rol" ID="2.'.$i0.'.1.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Judges" ID="2.'.count($Judges).'">new Judges</LI>';
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
             + '<DIV>rol: <UL><LI CLASS="new UI_Judges_rol" ID="'+id+'.1">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater Clerks">
      <DIV class="FloaterHeader">Clerks</DIV>
      <DIV class="FloaterContent"><?php
          $Clerks = $Parties->get_Clerks();
          echo '
          <UL>';
          foreach($Clerks as $i0=>$v0){
            echo '
            <LI CLASS="item UI_Clerks" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To3.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['id']).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_Clerks_name" ID="3.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_Clerks_rol" ID="3.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_Clerks_rol" ID="3.'.$i0.'.1.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="3.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_Clerks" ID="3.'.count($Clerks).'">new Clerks</LI>';
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
             + '<DIV>rol: <UL><LI CLASS="new UI_Clerks_rol" ID="'+id+'.1">new rol</LI></UL></DIV>'
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
