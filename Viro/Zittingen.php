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
  require "Zittingen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Zittingen=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Zittingen[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                             , 'nr' => @$r['0.'.$i0.'.0']
                             , 'kamer' => @$r['0.'.$i0.'.1']
                             , 'gerecht' => @$r['0.'.$i0.'.2']
                             , 'plaats' => @$r['0.'.$i0.'.3']
                             , 'griffier' => @$r['0.'.$i0.'.5']
                             , 'geagendeerd' => @$r['0.'.$i0.'.6']
                             , 'feitelijkedatum' => @$r['0.'.$i0.'.7']
                             );
      $Zittingen[$i0]['rechter']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Zittingen[$i0]['rechter'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Zittingen=new Zittingen($Zittingen);
    if($Zittingen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Zittingen=new Zittingen();
    writeHead("<TITLE>Zittingen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Zittingen</H1>
    <DIV class="Floater Zittingen">
      <DIV class="FloaterHeader">Zittingen</DIV>
      <DIV class="FloaterContent"><?php
          $Zittingen = $Zittingen->get_Zittingen();
          echo '
          <UL>';
          foreach($Zittingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Zitting.php?Zitting='.urlencode($v0['id']).'">';
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
                echo 'kamer: ';
                echo '<SPAN CLASS="item UIkamer" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Kamer.php?Kamer='.urlencode($v0['kamer']).'">'.htmlspecialchars($v0['kamer']).'</A>';
                else echo htmlspecialchars($v0['kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '<SPAN CLASS="item UIgerecht" ID="0.'.$i0.'.2">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['gerecht']).'">'.htmlspecialchars($v0['gerecht']).'</A>';
                else echo htmlspecialchars($v0['gerecht']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'plaats: ';
                echo '<SPAN CLASS="item UIplaats" ID="0.'.$i0.'.3">';
                if(!$edit) echo '
                <A HREF="Plaats.php?Plaats='.urlencode($v0['plaats']).'">'.htmlspecialchars($v0['plaats']).'</A>';
                else echo htmlspecialchars($v0['plaats']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rechter: ';
                echo '
                <UL>';
                foreach($v0['rechter'] as $i1=>$rechter){
                  echo '
                  <LI CLASS="item UIrechter" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.4.'.$i1.'">';
                      echo htmlspecialchars($rechter).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.4.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($rechter).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($rechter);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrechter" ID="0.'.$i0.'.4.'.count($v0['rechter']).'">new rechter</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'griffier: ';
                echo '<SPAN CLASS="item UIgriffier" ID="0.'.$i0.'.5">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.5">';
                  echo htmlspecialchars($v0['griffier']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.5"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['griffier']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['griffier']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['griffier']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['griffier']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'geagendeerd: ';
                echo '<SPAN CLASS="item UIgeagendeerd" ID="0.'.$i0.'.6">';
                echo htmlspecialchars($v0['geagendeerd']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'feitelijkedatum: ';
                if (isset($v0['feitelijkedatum'])){
                  echo '<DIV CLASS="item UIfeitelijkedatum" ID="0.'.$i0.'.7">';
                  echo '</DIV>';
                  if(isset($v0['feitelijkedatum'])){
                    echo htmlspecialchars($v0['feitelijkedatum']);
                  }
                } else echo '<DIV CLASS="new UIfeitelijkedatum" ID="0.'.$i0.'.7"><I>Nothing</I></DIV>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Zittingen).'">new Zittingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Zittingen
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>kamer: <SPAN CLASS="item UI_kamer" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>gerecht: <SPAN CLASS="item UI_gerecht" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>plaats: <SPAN CLASS="item UI_plaats" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>rechter: <UL><LI CLASS="new UI_rechter" ID="'+id+'.4">new rechter</LI></UL></DIV>'
             + '<DIV>griffier: <SPAN CLASS="item UI_griffier" ID="'+id+'.5"></SPAN></DIV>'
             + '<DIV>geagendeerd: <SPAN CLASS="item UI_geagendeerd" ID="'+id+'.6"></SPAN></DIV>'
             + '<DIV>feitelijkedatum: <DIV CLASS="new UI_feitelijkedatum" ID="'+id+'.7"><I>Nothing</I></DIV></DIV>'
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