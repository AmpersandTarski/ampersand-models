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
  require "Objecttype.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $objectHandeling=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $objectHandeling[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                   , 'Handeling' => @$r['0.'.$i0.'.0']
                                   );
      $objectHandeling[$i0]['door']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $objectHandeling[$i0]['door'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $objectHandeling[$i0]['prio']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $objectHandeling[$i0]['prio'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $objectHandeling[$i0]['usecase']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $objectHandeling[$i0]['usecase'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $objectHandeling[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $objectHandeling[$i0]['rol'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $wet=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $wet[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                       , 'Artikel' => @$r['1.'.$i0.'.0']
                       );
      $wet[$i0]['tekst']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $wet[$i0]['tekst'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $typeDing=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $typeDing[$i0] = @$r['2.'.$i0.''];
    }
    $Objecttype=new Objecttype($ID,$objectHandeling, $wet, $typeDing);
    if($Objecttype->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Objecttype='.urlencode($Objecttype->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Objecttype'])){
    if(!$del || !delObjecttype($_REQUEST['Objecttype']))
      $Objecttype = readObjecttype($_REQUEST['Objecttype']);
    else $Objecttype = false; // delete was a succes!
  } else if($new) $Objecttype = new Objecttype();
  else $Objecttype = false;
  if($Objecttype){
    writeHead("<TITLE>Objecttype - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Objecttype->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Objecttype->getId()).'" /></P>';
    else echo '<H1>'.$Objecttype->getId().'</H1>';
    ?>
    <DIV class="Floater object Handeling">
      <DIV class="FloaterHeader">object Handeling</DIV>
      <DIV class="FloaterContent"><?php
          $objectHandeling = $Objecttype->get_objectHandeling();
          echo '
          <UL>';
          foreach($objectHandeling as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objectHandeling" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['id']).'">HandelingCompact</A></LI>';
                echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['id']).'">Handeling</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Handeling: ';
                echo '<SPAN CLASS="item UI_objectHandeling_Handeling" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Handeling']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'door: ';
                echo '
                <UL>';
                foreach($v0['door'] as $i1=>$door){
                  echo '
                  <LI CLASS="item UI_objectHandeling_door" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Orgaan.php?Orgaan='.urlencode($door).'">'.htmlspecialchars($door).'</A>';
                    else echo htmlspecialchars($door);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_objectHandeling_door" ID="0.'.$i0.'.1.'.count($v0['door']).'">new door</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'prio: ';
                echo '
                <UL>';
                foreach($v0['prio'] as $i1=>$prio){
                  echo '
                  <LI CLASS="item UI_objectHandeling_prio" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Moscow.php?Moscow='.urlencode($prio).'">'.htmlspecialchars($prio).'</A>';
                    else echo htmlspecialchars($prio);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_objectHandeling_prio" ID="0.'.$i0.'.2.'.count($v0['prio']).'">new prio</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'usecase: ';
                echo '
                <UL>';
                foreach($v0['usecase'] as $i1=>$usecase){
                  echo '
                  <LI CLASS="item UI_objectHandeling_usecase" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($usecase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_objectHandeling_usecase" ID="0.'.$i0.'.3.'.count($v0['usecase']).'">new usecase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_objectHandeling_rol" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Rol.php?Rol='.urlencode($rol).'">'.htmlspecialchars($rol).'</A>';
                    else echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_objectHandeling_rol" ID="0.'.$i0.'.4.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objectHandeling" ID="0.'.count($objectHandeling).'">new object Handeling</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in object Handeling
      function UI_objectHandeling(id){
        return '<DIV>Handeling: <SPAN CLASS="item UI_objectHandeling_Handeling" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>door: <UL><LI CLASS="new UI_objectHandeling_door" ID="'+id+'.1">new door</LI></UL></DIV>'
             + '<DIV>prio: <UL><LI CLASS="new UI_objectHandeling_prio" ID="'+id+'.2">new prio</LI></UL></DIV>'
             + '<DIV>usecase: <UL><LI CLASS="new UI_objectHandeling_usecase" ID="'+id+'.3">new usecase</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_objectHandeling_rol" ID="'+id+'.4">new rol</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater wet">
      <DIV class="FloaterHeader">wet</DIV>
      <DIV class="FloaterContent"><?php
          $wet = $Objecttype->get_wet();
          echo '
          <UL>';
          foreach($wet as $i0=>$v0){
            echo '
            <LI CLASS="item UI_wet" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Artikel.php?Artikel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Artikel: ';
                echo '<SPAN CLASS="item UI_wet_Artikel" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['Artikel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'tekst: ';
                echo '
                <UL>';
                foreach($v0['tekst'] as $i1=>$tekst){
                  echo '
                  <LI CLASS="item UI_wet_tekst" ID="1.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($tekst);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_wet_tekst" ID="1.'.$i0.'.1.'.count($v0['tekst']).'">new tekst</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_wet" ID="1.'.count($wet).'">new wet</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in wet
      function UI_wet(id){
        return '<DIV>Artikel: <SPAN CLASS="item UI_wet_Artikel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>tekst: <UL><LI CLASS="new UI_wet_tekst" ID="'+id+'.1">new tekst</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater type Ding">
      <DIV class="FloaterHeader">type Ding</DIV>
      <DIV class="FloaterContent"><?php
          $typeDing = $Objecttype->get_typeDing();
          echo '
          <UL>';
          foreach($typeDing as $i0=>$v0){
            echo '
            <LI CLASS="item UI_typeDing" ID="2.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Ding.php?Ding='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_typeDing" ID="2.'.count($typeDing).'">new type Ding</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Objecttype->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Objecttype=".urlencode($Objecttype->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Objecttype=".urlencode($Objecttype->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Objecttype=".urlencode($Objecttype->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Objecttype is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Objecttype object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Objecttype object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>