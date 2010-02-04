<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  require "interfaceDef.inc.php";
  require "Kamers.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Kamers=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Kamers[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                          , 'kamer' => @$r['0.'.$i0.'.0']
                          , 'gerecht' => @$r['0.'.$i0.'.1']
                          , 'sector' => @$r['0.'.$i0.'.2']
                          );
      $Kamers[$i0]['bezetting']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Kamers[$i0]['bezetting'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $Kamers=new Kamers($Kamers);
    if($Kamers->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Kamers=new Kamers();
    writeHead("<TITLE>Kamers - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Kamers</H1>
    <DIV class="Floater Kamers">
      <DIV class="FloaterHeader">Kamers</DIV>
      <DIV class="FloaterContent"><?php
          $Kamers = $Kamers->get_Kamers();
          echo '
          <UL>';
          foreach($Kamers as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Kamer.php?Kamer='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'kamer: ';
                echo '<SPAN CLASS="item UIkamer" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '<SPAN CLASS="item UIgerecht" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['gerecht']).'">'.htmlspecialchars($v0['gerecht']).'</A>';
                else echo htmlspecialchars($v0['gerecht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'sector: ';
                echo '<SPAN CLASS="item UIsector" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Sector.php?Sector='.urlencode($v0['sector']).'">'.htmlspecialchars($v0['sector']).'</A>';
                else echo htmlspecialchars($v0['sector']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'bezetting: ';
                echo '
                <UL>';
                foreach($v0['bezetting'] as $i1=>$bezetting){
                  echo '
                  <LI CLASS="item UIbezetting" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.3.'.$i1.'">';
                      echo htmlspecialchars($bezetting).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.3.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($bezetting).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($bezetting).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($bezetting).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($bezetting);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIbezetting" ID="0.'.$i0.'.3.'.count($v0['bezetting']).'">new bezetting</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Kamers).'">new Kamers</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Kamers
      function UI(id){
        return '<DIV>kamer: <SPAN CLASS="item UI_kamer" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gerecht: <SPAN CLASS="item UI_gerecht" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>sector: <SPAN CLASS="item UI_sector" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>bezetting: <UL><LI CLASS="new UI_bezetting" ID="'+id+'.3">new bezetting</LI></UL></DIV>'
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