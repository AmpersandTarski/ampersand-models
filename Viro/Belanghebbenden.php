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
  require "Belanghebbenden.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Belanghebbenden=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Belanghebbenden[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                   , 'naam' => @$r['0.'.$i0.'.0']
                                   );
      $Belanghebbenden[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Belanghebbenden[$i0]['rol'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Belanghebbenden[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Belanghebbenden[$i0]['gemachtigde'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $Belanghebbenden=new Belanghebbenden($Belanghebbenden);
    if($Belanghebbenden->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Belanghebbenden=new Belanghebbenden();
    writeHead("<TITLE>Belanghebbenden - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Belanghebbenden</H1>
    <DIV class="Floater Belanghebbenden">
      <DIV class="FloaterHeader">Belanghebbenden</DIV>
      <DIV class="FloaterContent"><?php
          $Belanghebbenden = $Belanghebbenden->get_Belanghebbenden();
          echo '
          <UL>';
          foreach($Belanghebbenden as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['id']).'">RechterlijkeAmbtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['id']).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['id']).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'naam: ';
                echo '<SPAN CLASS="item UInaam" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UIrol" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrol" ID="0.'.$i0.'.1.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UIgemachtigde" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($gemachtigde).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIgemachtigde" ID="0.'.$i0.'.2.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Belanghebbenden).'">new Belanghebbenden</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Belanghebbenden
      function UI(id){
        return '<DIV>naam: <SPAN CLASS="item UI_naam" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_rol" ID="'+id+'.1">new rol</LI></UL></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_gemachtigde" ID="'+id+'.2">new gemachtigde</LI></UL></DIV>'
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