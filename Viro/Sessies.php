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
  require "Sessies.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Sessies=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Sessies[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                           , 'nr' => @$r['0.'.$i0.'.0']
                           , 'start' => @$r['0.'.$i0.'.1']
                           , 'einde' => @$r['0.'.$i0.'.2']
                           , 'DigID' => @$r['0.'.$i0.'.3']
                           , 'rol' => @$r['0.'.$i0.'.4']
                           , 'persoon' => @$r['0.'.$i0.'.5']
                           );
    }
    $Sessies=new Sessies($Sessies);
    if($Sessies->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Sessies=new Sessies();
    writeHead("<TITLE>Sessies - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Sessies</H1>
    <DIV class="Floater Sessies">
      <DIV class="FloaterHeader">Sessies</DIV>
      <DIV class="FloaterContent"><?php
          $Sessies = $Sessies->get_Sessies();
          echo '
          <UL>';
          foreach($Sessies as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Sessie.php?Sessie='.urlencode($v0['id']).'">';
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
                echo 'start: ';
                echo '<SPAN CLASS="item UIstart" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['start']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'einde: ';
                if (isset($v0['einde'])){
                  echo '<DIV CLASS="item UIeinde" ID="0.'.$i0.'.2">';
                  echo '</DIV>';
                  if(isset($v0['einde'])){
                    echo htmlspecialchars($v0['einde']);
                  }
                } else echo '<DIV CLASS="new UIeinde" ID="0.'.$i0.'.2"><I>Nothing</I></DIV>';
              echo '</DIV>
              <DIV>';
                echo 'DigID: ';
                echo '<SPAN CLASS="item UIDigID" ID="0.'.$i0.'.3">';
                echo htmlspecialchars($v0['DigID']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '<SPAN CLASS="item UIrol" ID="0.'.$i0.'.4">';
                echo htmlspecialchars($v0['rol']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'persoon: ';
                echo '<SPAN CLASS="item UIpersoon" ID="0.'.$i0.'.5">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.5">';
                  echo htmlspecialchars($v0['persoon']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.5"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['persoon']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['persoon']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['persoon']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['persoon']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Sessies).'">new Sessies</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Sessies
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>start: <SPAN CLASS="item UI_start" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>einde: <DIV CLASS="new UI_einde" ID="'+id+'.2"><I>Nothing</I></DIV></DIV>'
             + '<DIV>DigID: <SPAN CLASS="item UI_DigID" ID="'+id+'.3"></SPAN></DIV>'
             + '<DIV>rol: <SPAN CLASS="item UI_rol" ID="'+id+'.4"></SPAN></DIV>'
             + '<DIV>persoon: <SPAN CLASS="item UI_persoon" ID="'+id+'.5"></SPAN></DIV>'
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