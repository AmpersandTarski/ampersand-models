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
  require "Article.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $text=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $text[$i0] = @$r['0.'.$i0.''];
    }
    $act=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $act[$i0] = @$r['1.'.$i0.''];
    }
    $organ=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $organ[$i0] = @$r['2.'.$i0.''];
    }
    $verb=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $verb[$i0] = @$r['3.'.$i0.''];
    }
    $objecttype=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $objecttype[$i0] = @$r['4.'.$i0.''];
    }
    $Article=new Article($ID,$text, $act, $organ, $verb, $objecttype);
    if($Article->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Article='.urlencode($Article->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Article'])){
    if(!$del || !delArticle($_REQUEST['Article']))
      $Article = readArticle($_REQUEST['Article']);
    else $Article = false; // delete was a succes!
  } else if($new) $Article = new Article();
  else $Article = false;
  if($Article){
    writeHead("<TITLE>Article - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Article->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Article->getId()).'" /></P>';
    else echo '<H1>'.$Article->getId().'</H1>';
    ?>
    <DIV class="Floater text">
      <DIV class="FloaterHeader">text</DIV>
      <DIV class="FloaterContent"><?php
          $text = $Article->get_text();
          echo '
          <UL>';
          foreach($text as $i0=>$v0){
            echo '
            <LI CLASS="item UI_text" ID="0.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_text" ID="0.'.count($text).'">new text</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater act">
      <DIV class="FloaterHeader">act</DIV>
      <DIV class="FloaterContent"><?php
          $act = $Article->get_act();
          echo '
          <UL>';
          foreach($act as $i0=>$v0){
            echo '
            <LI CLASS="item UI_act" ID="1.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_act" ID="1.'.count($act).'">new act</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater organ">
      <DIV class="FloaterHeader">organ</DIV>
      <DIV class="FloaterContent"><?php
          $organ = $Article->get_organ();
          echo '
          <UL>';
          foreach($organ as $i0=>$v0){
            echo '
            <LI CLASS="item UI_organ" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Organ.php?Organ='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_organ" ID="2.'.count($organ).'">new organ</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater verb">
      <DIV class="FloaterHeader">verb</DIV>
      <DIV class="FloaterContent"><?php
          $verb = $Article->get_verb();
          echo '
          <UL>';
          foreach($verb as $i0=>$v0){
            echo '
            <LI CLASS="item UI_verb" ID="3.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_verb" ID="3.'.count($verb).'">new verb</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater object type">
      <DIV class="FloaterHeader">object type</DIV>
      <DIV class="FloaterContent"><?php
          $objecttype = $Article->get_objecttype();
          echo '
          <UL>';
          foreach($objecttype as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objecttype" ID="4.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objecttype" ID="4.'.count($objecttype).'">new object type</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Article->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Article=".urlencode($Article->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Article=".urlencode($Article->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Article=".urlencode($Article->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Article is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Article object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Article object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>