<?php // generated with ADL vs. 0.8.10-451
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
  require "Ding.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $typeObjecttype=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $typeObjecttype[$i0] = @$r['0.'.$i0.''];
    }
    $objectActie=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $objectActie[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                               , 'Actie' => @$r['1.'.$i0.'.0']
                               , 'subject' => @$r['1.'.$i0.'.1']
                               , 'type' => @$r['1.'.$i0.'.2']
                               );
    }
    $Ding=new Ding($ID,$typeObjecttype, $objectActie);
    if($Ding->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Ding='.urlencode($Ding->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Ding'])){
    if(!$del || !delDing($_REQUEST['Ding']))
      $Ding = readDing($_REQUEST['Ding']);
    else $Ding = false; // delete was a succes!
  } else if($new) $Ding = new Ding();
  else $Ding = false;
  if($Ding){
    writeHead("<TITLE>Ding - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Ding->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Ding->getId()).'" /></P>';
    else echo '<H1>'.$Ding->getId().'</H1>';
    ?>
    <DIV class="Floater type Objecttype">
      <DIV class="FloaterHeader">type Objecttype</DIV>
      <DIV class="FloaterContent"><?php
          $typeObjecttype = $Ding->get_typeObjecttype();
          echo '
          <UL>';
          foreach($typeObjecttype as $i0=>$v0){
            echo '
            <LI CLASS="item UI_typeObjecttype" ID="0.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Objecttype.php?Objecttype='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_typeObjecttype" ID="0.'.count($typeObjecttype).'">new type Objecttype</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater object Actie">
      <DIV class="FloaterHeader">object Actie</DIV>
      <DIV class="FloaterContent"><?php
          $objectActie = $Ding->get_objectActie();
          echo '
          <UL>';
          foreach($objectActie as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objectActie" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Actie.php?Actie='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Actie: ';
                echo '<SPAN CLASS="item UI_objectActie_Actie" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['Actie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'subject: ';
                echo '<SPAN CLASS="item UI_objectActie_subject" ID="1.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.1">';
                  echo htmlspecialchars($v0['subject']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['subject']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['subject']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['subject']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['subject']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_objectActie_type" ID="1.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.2">';
                  echo htmlspecialchars($v0['type']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['type']).'">HandelingCompact</A></LI>';
                  echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['type']).'">Handeling</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objectActie" ID="1.'.count($objectActie).'">new object Actie</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in object Actie
      function UI_objectActie(id){
        return '<DIV>Actie: <SPAN CLASS="item UI_objectActie_Actie" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>subject: <SPAN CLASS="item UI_objectActie_subject" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_objectActie_type" ID="'+id+'.2"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Ding->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Ding=".urlencode($Ding->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Ding=".urlencode($Ding->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Ding=".urlencode($Ding->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Ding is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Ding object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Ding object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>