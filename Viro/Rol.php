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
  require "Rol.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $vervultPersoon=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $vervultPersoon[$i0] = @$r['0.'.$i0.''];
    }
    $magHandeling=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $magHandeling[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                                , 'Handeling' => @$r['1.'.$i0.'.0']
                                );
      $magHandeling[$i0]['door']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $magHandeling[$i0]['door'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
      $magHandeling[$i0]['prio']=array();
      for($i1=0;isset($r['1.'.$i0.'.2.'.$i1]);$i1++){
        $magHandeling[$i0]['prio'][$i1] = @$r['1.'.$i0.'.2.'.$i1.''];
      }
      $magHandeling[$i0]['usecase']=array();
      for($i1=0;isset($r['1.'.$i0.'.3.'.$i1]);$i1++){
        $magHandeling[$i0]['usecase'][$i1] = @$r['1.'.$i0.'.3.'.$i1.''];
      }
      $magHandeling[$i0]['rol']=array();
      for($i1=0;isset($r['1.'.$i0.'.4.'.$i1]);$i1++){
        $magHandeling[$i0]['rol'][$i1] = @$r['1.'.$i0.'.4.'.$i1.''];
      }
    }
    $Rol=new Rol($ID,$vervultPersoon, $magHandeling);
    if($Rol->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Rol='.urlencode($Rol->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rol'])){
    if(!$del || !delRol($_REQUEST['Rol']))
      $Rol = readRol($_REQUEST['Rol']);
    else $Rol = false; // delete was a succes!
  } else if($new) $Rol = new Rol();
  else $Rol = false;
  if($Rol){
    writeHead("<TITLE>Rol - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rol->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rol->getId()).'" /></P>';
    else echo '<H1>'.$Rol->getId().'</H1>';
    ?>
    <DIV class="Floater vervult Persoon">
      <DIV class="FloaterHeader">vervult Persoon</DIV>
      <DIV class="FloaterContent"><?php
          $vervultPersoon = $Rol->get_vervultPersoon();
          echo '
          <UL>';
          foreach($vervultPersoon as $i0=>$v0){
            echo '
            <LI CLASS="item UI_vervultPersoon" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0).'">Gerechtelijkeambtenaar</A></LI>';
                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0).'">Persoon</A></LI>';
                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0).'">Belanghebbende</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_vervultPersoon" ID="0.'.count($vervultPersoon).'">new vervult Persoon</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater mag Handeling">
      <DIV class="FloaterHeader">mag Handeling</DIV>
      <DIV class="FloaterContent"><?php
          $magHandeling = $Rol->get_magHandeling();
          echo '
          <UL>';
          foreach($magHandeling as $i0=>$v0){
            echo '
            <LI CLASS="item UI_magHandeling" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To1.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo1.'.$i0.'"><UL>';
                echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['id']).'">HandelingCompact</A></LI>';
                echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['id']).'">Handeling</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Handeling: ';
                echo '<SPAN CLASS="item UI_magHandeling_Handeling" ID="1.'.$i0.'.0">';
                echo htmlspecialchars($v0['Handeling']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'door: ';
                echo '
                <UL>';
                foreach($v0['door'] as $i1=>$door){
                  echo '
                  <LI CLASS="item UI_magHandeling_door" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Orgaan.php?Orgaan='.urlencode($door).'">'.htmlspecialchars($door).'</A>';
                    else echo htmlspecialchars($door);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_magHandeling_door" ID="1.'.$i0.'.1.'.count($v0['door']).'">new door</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'prio: ';
                echo '
                <UL>';
                foreach($v0['prio'] as $i1=>$prio){
                  echo '
                  <LI CLASS="item UI_magHandeling_prio" ID="1.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Moscow.php?Moscow='.urlencode($prio).'">'.htmlspecialchars($prio).'</A>';
                    else echo htmlspecialchars($prio);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_magHandeling_prio" ID="1.'.$i0.'.2.'.count($v0['prio']).'">new prio</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'usecase: ';
                echo '
                <UL>';
                foreach($v0['usecase'] as $i1=>$usecase){
                  echo '
                  <LI CLASS="item UI_magHandeling_usecase" ID="1.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($usecase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_magHandeling_usecase" ID="1.'.$i0.'.3.'.count($v0['usecase']).'">new usecase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UI_magHandeling_rol" ID="1.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Rol.php?Rol='.urlencode($rol).'">'.htmlspecialchars($rol).'</A>';
                    else echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_magHandeling_rol" ID="1.'.$i0.'.4.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_magHandeling" ID="1.'.count($magHandeling).'">new mag Handeling</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in mag Handeling
      function UI_magHandeling(id){
        return '<DIV>Handeling: <SPAN CLASS="item UI_magHandeling_Handeling" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>door: <UL><LI CLASS="new UI_magHandeling_door" ID="'+id+'.1">new door</LI></UL></DIV>'
             + '<DIV>prio: <UL><LI CLASS="new UI_magHandeling_prio" ID="'+id+'.2">new prio</LI></UL></DIV>'
             + '<DIV>usecase: <UL><LI CLASS="new UI_magHandeling_usecase" ID="'+id+'.3">new usecase</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_magHandeling_rol" ID="'+id+'.4">new rol</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Rol->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Rol=".urlencode($Rol->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Rol=".urlencode($Rol->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Rol=".urlencode($Rol->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rol is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rol object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Rol object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>