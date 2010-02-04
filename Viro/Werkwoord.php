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
  require "Werkwoord.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $artikel=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $artikel[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                           , 'Artikel' => @$r['0.'.$i0.'.0']
                           );
      $artikel[$i0]['tekst']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $artikel[$i0]['tekst'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $handeling=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $handeling[$i0] = @$r['1.'.$i0.''];
    }
    $Werkwoord=new Werkwoord($ID,$artikel, $handeling);
    if($Werkwoord->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Werkwoord='.urlencode($Werkwoord->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Werkwoord'])){
    if(!$del || !delWerkwoord($_REQUEST['Werkwoord']))
      $Werkwoord = readWerkwoord($_REQUEST['Werkwoord']);
    else $Werkwoord = false; // delete was a succes!
  } else if($new) $Werkwoord = new Werkwoord();
  else $Werkwoord = false;
  if($Werkwoord){
    writeHead("<TITLE>Werkwoord - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Werkwoord->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Werkwoord->getId()).'" /></P>';
    else echo '<H1>'.$Werkwoord->getId().'</H1>';
    ?>
    <DIV class="Floater artikel">
      <DIV class="FloaterHeader">artikel</DIV>
      <DIV class="FloaterContent"><?php
          $artikel = $Werkwoord->get_artikel();
          echo '
          <UL>';
          foreach($artikel as $i0=>$v0){
            echo '
            <LI CLASS="item UI_artikel" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Artikel.php?Artikel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Artikel: ';
                echo '<SPAN CLASS="item UI_artikel_Artikel" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Artikel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'tekst: ';
                echo '
                <UL>';
                foreach($v0['tekst'] as $i1=>$tekst){
                  echo '
                  <LI CLASS="item UI_artikel_tekst" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($tekst);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_artikel_tekst" ID="0.'.$i0.'.1.'.count($v0['tekst']).'">new tekst</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_artikel" ID="0.'.count($artikel).'">new artikel</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in artikel
      function UI_artikel(id){
        return '<DIV>Artikel: <SPAN CLASS="item UI_artikel_Artikel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>tekst: <UL><LI CLASS="new UI_artikel_tekst" ID="'+id+'.1">new tekst</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater handeling">
      <DIV class="FloaterHeader">handeling</DIV>
      <DIV class="FloaterContent"><?php
          $handeling = $Werkwoord->get_handeling();
          echo '
          <UL>';
          foreach($handeling as $i0=>$v0){
            echo '
            <LI CLASS="item UI_handeling" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To1.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0).'">HandelingCompact</A></LI>';
                echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0).'">Handeling</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_handeling" ID="1.'.count($handeling).'">new handeling</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Werkwoord->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Werkwoord=".urlencode($Werkwoord->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Werkwoord=".urlencode($Werkwoord->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Werkwoord=".urlencode($Werkwoord->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Werkwoord is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Werkwoord object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Werkwoord object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>