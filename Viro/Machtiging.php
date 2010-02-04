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
  require "Machtiging.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $machtiging = @$r['0'];
    $inzake=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $inzake[$i0] = @$r['1.'.$i0.''];
    }
    $door = @$r['2'];
    $gemachtigde=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $gemachtigde[$i0] = @$r['3.'.$i0.''];
    }
    $schriftelijkemachtiging=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $schriftelijkemachtiging[$i0] = array( 'id' => @$r['4.'.$i0.'.0']
                                           , 'Document' => @$r['4.'.$i0.'.0']
                                           , 'type' => @$r['4.'.$i0.'.1']
                                           );
    }
    $Machtiging=new Machtiging($ID,$machtiging, $inzake, $door, $gemachtigde, $schriftelijkemachtiging);
    if($Machtiging->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Machtiging='.urlencode($Machtiging->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Machtiging'])){
    if(!$del || !delMachtiging($_REQUEST['Machtiging']))
      $Machtiging = readMachtiging($_REQUEST['Machtiging']);
    else $Machtiging = false; // delete was a succes!
  } else if($new) $Machtiging = new Machtiging();
  else $Machtiging = false;
  if($Machtiging){
    writeHead("<TITLE>Machtiging - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Machtiging->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Machtiging->getId()).'" /></P>';
    else echo '<H1>'.$Machtiging->getId().'</H1>';
    ?>
    <DIV class="Floater machtiging">
      <DIV class="FloaterHeader">machtiging</DIV>
      <DIV class="FloaterContent"><?php
          $machtiging = $Machtiging->get_machtiging();
          echo '<SPAN CLASS="item UI_machtiging" ID="0">';
          echo htmlspecialchars($machtiging);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater inzake">
      <DIV class="FloaterHeader">inzake</DIV>
      <DIV class="FloaterContent"><?php
          $inzake = $Machtiging->get_inzake();
          echo '
          <UL>';
          foreach($inzake as $i0=>$v0){
            echo '
            <LI CLASS="item UI_inzake" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0).'">BasisgegevensUC001</A></LI>';
                echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0).'">Procedure</A></LI>';
                echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0).'">nieuweProcedure</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_inzake" ID="1.'.count($inzake).'">new inzake</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater door">
      <DIV class="FloaterHeader">door</DIV>
      <DIV class="FloaterContent"><?php
          $door = $Machtiging->get_door();
          echo '<SPAN CLASS="item UI_door" ID="2">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To2">';
            echo htmlspecialchars($door).'</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($door).'">Gerechtelijkeambtenaar</A></LI>';
            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($door).'">Persoon</A></LI>';
            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($door).'">Belanghebbende</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($door);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater gemachtigde">
      <DIV class="FloaterHeader">gemachtigde</DIV>
      <DIV class="FloaterContent"><?php
          $gemachtigde = $Machtiging->get_gemachtigde();
          echo '
          <UL>';
          foreach($gemachtigde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gemachtigde" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gemachtigde" ID="3.'.count($gemachtigde).'">new gemachtigde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater schriftelijke machtiging">
      <DIV class="FloaterHeader">schriftelijke machtiging</DIV>
      <DIV class="FloaterContent"><?php
          $schriftelijkemachtiging = $Machtiging->get_schriftelijkemachtiging();
          echo '
          <UL>';
          foreach($schriftelijkemachtiging as $i0=>$v0){
            echo '
            <LI CLASS="item UI_schriftelijkemachtiging" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To4.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo4.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UI_schriftelijkemachtiging_Document" ID="4.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_schriftelijkemachtiging_type" ID="4.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Documenttype.php?Documenttype='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_schriftelijkemachtiging" ID="4.'.count($schriftelijkemachtiging).'">new schriftelijke machtiging</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in schriftelijke machtiging
      function UI_schriftelijkemachtiging(id){
        return '<DIV>Document: <SPAN CLASS="item UI_schriftelijkemachtiging_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_schriftelijkemachtiging_type" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Machtiging->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Machtiging=".urlencode($Machtiging->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Machtiging=".urlencode($Machtiging->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Machtiging=".urlencode($Machtiging->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Machtiging is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Machtiging object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Machtiging object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>