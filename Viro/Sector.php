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
  require "Sector.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $sectorKamer=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $sectorKamer[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                               , 'Kamer' => @$r['0.'.$i0.'.0']
                               , 'gerecht' => @$r['0.'.$i0.'.1']
                               );
    }
    $Sector=new Sector($ID,$sectorKamer);
    if($Sector->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Sector='.urlencode($Sector->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Sector'])){
    if(!$del || !delSector($_REQUEST['Sector']))
      $Sector = readSector($_REQUEST['Sector']);
    else $Sector = false; // delete was a succes!
  } else if($new) $Sector = new Sector();
  else $Sector = false;
  if($Sector){
    writeHead("<TITLE>Sector - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Sector->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Sector->getId()).'" /></P>';
    else echo '<H1>'.$Sector->getId().'</H1>';
    ?>
    <DIV class="Floater sector Kamer">
      <DIV class="FloaterHeader">sector Kamer</DIV>
      <DIV class="FloaterContent"><?php
          $sectorKamer = $Sector->get_sectorKamer();
          echo '
          <UL>';
          foreach($sectorKamer as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Kamer.php?Kamer='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'Kamer: ';
                echo '<SPAN CLASS="item UIKamer" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Kamer']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gerecht: ';
                echo '<SPAN CLASS="item UIgerecht" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Gerecht.php?Gerecht='.urlencode($v0['gerecht']).'">'.htmlspecialchars($v0['gerecht']).'</A>';
                else echo htmlspecialchars($v0['gerecht']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($sectorKamer).'">new sector Kamer</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in sector Kamer
      function UI(id){
        return '<DIV>Kamer: <SPAN CLASS="item UI_Kamer" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gerecht: <SPAN CLASS="item UI_gerecht" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Sector->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Sector=".urlencode($Sector->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Sector=".urlencode($Sector->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Sector=".urlencode($Sector->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Sector is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Sector object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Sector object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>