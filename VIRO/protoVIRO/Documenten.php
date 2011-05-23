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
  require "Documenten.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Documenten=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Documenten[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                              , 'nr' => @$r['0.'.$i0.'.0']
                              , 'type' => @$r['0.'.$i0.'.1']
                              );
      $Documenten[$i0]['caretaker of case file']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Documenten[$i0]['caretaker of case file'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Documenten[$i0]['area of law']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Documenten[$i0]['area of law'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Documenten[$i0]['type of case']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Documenten[$i0]['type of case'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Documenten=new Documenten($Documenten);
    if($Documenten->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Documenten=new Documenten();
    writeHead("<TITLE>Documents - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Documents</H1>
    <DIV class="Floater Documenten">
      <DIV class="FloaterHeader">Documents</DIV>
      <DIV class="FloaterContent"><?php
          $Documenten = $Documenten->get_Documenten();
          echo '
          <UL>';
          foreach($Documenten as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Letter.php?Letter='.urlencode($v0['id']).'">Letter</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UInr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UItype" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="DocumentType.php?DocumentType='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'caretaker of case file: ';
                echo '
                <UL>';
                foreach($v0['caretaker of case file'] as $i1=>$caretakerofcasefile){
                  echo '
                  <LI CLASS="item UIcaretakerofcasefile" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Organ.php?Organ='.urlencode($caretakerofcasefile).'">'.htmlspecialchars($caretakerofcasefile).'</A>';
                    else echo htmlspecialchars($caretakerofcasefile);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIcaretakerofcasefile" ID="0.'.$i0.'.2.'.count($v0['caretaker of case file']).'">new caretaker of case file</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '
                <UL>';
                foreach($v0['area of law'] as $i1=>$areaoflaw){
                  echo '
                  <LI CLASS="item UIareaoflaw" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($areaoflaw).'">'.htmlspecialchars($areaoflaw).'</A>';
                    else echo htmlspecialchars($areaoflaw);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIareaoflaw" ID="0.'.$i0.'.3.'.count($v0['area of law']).'">new area of law</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '
                <UL>';
                foreach($v0['type of case'] as $i1=>$typeofcase){
                  echo '
                  <LI CLASS="item UItypeofcase" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
                    else echo htmlspecialchars($typeofcase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UItypeofcase" ID="0.'.$i0.'.4.'.count($v0['type of case']).'">new type of case</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Documenten).'">new Documenten</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Documenten
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_type" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>caretaker of case file: <UL><LI CLASS="new UI_caretakerofcasefile" ID="'+id+'.2">new caretaker of case file</LI></UL></DIV>'
             + '<DIV>area of law: <UL><LI CLASS="new UI_areaoflaw" ID="'+id+'.3">new area of law</LI></UL></DIV>'
             + '<DIV>type of case: <UL><LI CLASS="new UI_typeofcase" ID="'+id+'.4">new type of case</LI></UL></DIV>'
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
