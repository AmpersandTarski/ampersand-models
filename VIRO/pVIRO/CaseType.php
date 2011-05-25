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
  require "CaseType.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Cases=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Cases[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                         , 'nr' => @$r['0.'.$i0.'.0']
                         , 'area of law' => @$r['0.'.$i0.'.1']
                         );
    }
    $CaseType=new CaseType($ID,$Cases);
    if($CaseType->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?CaseType='.urlencode($CaseType->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['CaseType'])){
    if(!$del || !delCaseType($_REQUEST['CaseType']))
      $CaseType = readCaseType($_REQUEST['CaseType']);
    else $CaseType = false; // delete was a succes!
  } else if($new) $CaseType = new CaseType();
  else $CaseType = false;
  if($CaseType){
    writeHead("<TITLE>CaseType - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $CaseType->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($CaseType->getId()).'" /></P>';
    else echo '<H1>'.$CaseType->getId().'</H1>';
    ?>
    <DIV class="Floater Cases">
      <DIV class="FloaterHeader">Cases</DIV>
      <DIV class="FloaterContent"><?php
          $Cases = $CaseType->get_Cases();
          echo '
          <UL>';
          foreach($Cases as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UInr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UIareaoflaw" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Cases).'">new Cases</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Cases
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UI_areaoflaw" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($CaseType->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?CaseType=".urlencode($CaseType->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&CaseType=".urlencode($CaseType->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&CaseType=".urlencode($CaseType->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The CaseType is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No CaseType object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No CaseType object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>