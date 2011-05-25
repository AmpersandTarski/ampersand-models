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
  require "Correspondence.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $case=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $case[$i0] = @$r['0.'.$i0.''];
    }
    $type = @$r['1'];
    $remark=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $remark[$i0] = @$r['2.'.$i0.''];
    }
    if(@$r['3']!=''){
      $sentat = @$r['3'];
    }else $sentat=null;
    if(@$r['4']!=''){
      $receivedat = @$r['4'];
    }else $receivedat=null;
    $Correspondence=new Correspondence($ID,$case, $type, $remark, $sentat, $receivedat);
    if($Correspondence->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Correspondence='.urlencode($Correspondence->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Correspondence'])){
    if(!$del || !delCorrespondence($_REQUEST['Correspondence']))
      $Correspondence = readCorrespondence($_REQUEST['Correspondence']);
    else $Correspondence = false; // delete was a succes!
  } else if($new) $Correspondence = new Correspondence();
  else $Correspondence = false;
  if($Correspondence){
    writeHead("<TITLE>Correspondence - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Correspondence->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Correspondence->getId()).'" /></P>';
    else echo '<H1>'.$Correspondence->getId().'</H1>';
    ?>
    <DIV class="Floater case">
      <DIV class="FloaterHeader">case</DIV>
      <DIV class="FloaterContent"><?php
          $case = $Correspondence->get_case();
          echo '
          <UL>';
          foreach($case as $i0=>$v0){
            echo '
            <LI CLASS="item UI_case" ID="0.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_case" ID="0.'.count($case).'">new case</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Correspondence->get_type();
          echo '<SPAN CLASS="item UI_type" ID="1">';
          if(!$edit) echo '
          <A HREF="DocumentType.php?DocumentType='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
          else echo htmlspecialchars($type);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater remark">
      <DIV class="FloaterHeader">remark</DIV>
      <DIV class="FloaterContent"><?php
          $remark = $Correspondence->get_remark();
          echo '
          <UL>';
          foreach($remark as $i0=>$v0){
            echo '
            <LI CLASS="item UI_remark" ID="2.'.$i0.'">';
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_remark" ID="2.'.count($remark).'">new remark</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater sent at">
      <DIV class="FloaterHeader">sent at</DIV>
      <DIV class="FloaterContent"><?php
          $sentat = $Correspondence->get_sentat();
          echo '<SPAN CLASS="item UI_sentat" ID="3">';
          if(isset($sentat)){
            echo htmlspecialchars($sentat);
          }
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater received at">
      <DIV class="FloaterHeader">received at</DIV>
      <DIV class="FloaterContent"><?php
          $receivedat = $Correspondence->get_receivedat();
          echo '<SPAN CLASS="item UI_receivedat" ID="4">';
          if(isset($receivedat)){
            echo htmlspecialchars($receivedat);
          }
          echo '</SPAN>';
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Correspondence->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Correspondence=".urlencode($Correspondence->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Correspondence=".urlencode($Correspondence->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Correspondence=".urlencode($Correspondence->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Correspondence is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Correspondence object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Correspondence object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>