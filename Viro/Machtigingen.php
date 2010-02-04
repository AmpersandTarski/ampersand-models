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
  require "Machtigingen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Machtigingen=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Machtigingen[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                , 'stuk' => @$r['0.'.$i0.'.0']
                                , 'door' => @$r['0.'.$i0.'.2']
                                );
      $Machtigingen[$i0]['inzake']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Machtigingen[$i0]['inzake'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Machtigingen[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Machtigingen[$i0]['gemachtigde'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $Machtigingen=new Machtigingen($Machtigingen);
    if($Machtigingen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Machtigingen=new Machtigingen();
    writeHead("<TITLE>Machtigingen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Machtigingen</H1>
    <DIV class="Floater Machtigingen">
      <DIV class="FloaterHeader">Machtigingen</DIV>
      <DIV class="FloaterContent"><?php
          $Machtigingen = $Machtigingen->get_Machtigingen();
          echo '
          <UL>';
          foreach($Machtigingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'stuk: ';
                echo '<SPAN CLASS="item UIstuk" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['stuk']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'inzake: ';
                echo '
                <UL>';
                foreach($v0['inzake'] as $i1=>$inzake){
                  echo '
                  <LI CLASS="item UIinzake" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($inzake).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($inzake).'">BasisgegevensUC001</A></LI>';
                      echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($inzake).'">Procedure</A></LI>';
                      echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($inzake).'">nieuweProcedure</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($inzake);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIinzake" ID="0.'.$i0.'.1.'.count($v0['inzake']).'">new inzake</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'door: ';
                echo '<SPAN CLASS="item UIdoor" ID="0.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.2">';
                  echo htmlspecialchars($v0['door']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($v0['door']).'">RechterlijkeAmbtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['door']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['door']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['door']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UIgemachtigde" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.3.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.3.'.$i1.'"><UL>';
                      echo '<LI><A HREF="RechterlijkeAmbtenaar.php?RechterlijkeAmbtenaar='.urlencode($gemachtigde).'">RechterlijkeAmbtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIgemachtigde" ID="0.'.$i0.'.3.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Machtigingen).'">new Machtigingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Machtigingen
      function UI(id){
        return '<DIV>stuk: <SPAN CLASS="item UI_stuk" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>inzake: <UL><LI CLASS="new UI_inzake" ID="'+id+'.1">new inzake</LI></UL></DIV>'
             + '<DIV>door: <SPAN CLASS="item UI_door" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_gemachtigde" ID="'+id+'.3">new gemachtigde</LI></UL></DIV>'
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