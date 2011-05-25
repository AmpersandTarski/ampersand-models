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
  require "Document.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $type = @$r['0'];
    $case=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $case[$i0] = array( 'id' => @$r['1.'.$i0.'']
                        , 'area of law' => @$r['1.'.$i0.'.0']
                        );
      $case[$i0]['type of case']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $case[$i0]['type of case'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $Document=new Document($ID,$type, $case);
    if($Document->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Document='.urlencode($Document->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Document'])){
    if(!$del || !delDocument($_REQUEST['Document']))
      $Document = readDocument($_REQUEST['Document']);
    else $Document = false; // delete was a succes!
  } else if($new) $Document = new Document();
  else $Document = false;
  if($Document){
    writeHead("<TITLE>Document - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Document->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Document->getId()).'" /></P>';
    else echo '<H1>'.$Document->getId().'</H1>';
    ?>
    <DIV class="Floater type">
      <DIV class="FloaterHeader">type</DIV>
      <DIV class="FloaterContent"><?php
          $type = $Document->get_type();
          echo '<SPAN CLASS="item UI_type" ID="0">';
          if(!$edit) echo '
          <A HREF="DocumentType.php?DocumentType='.urlencode($type).'">'.htmlspecialchars($type).'</A>';
          else echo htmlspecialchars($type);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater case">
      <DIV class="FloaterHeader">case</DIV>
      <DIV class="FloaterContent"><?php
          $case = $Document->get_case();
          echo '
          <UL>';
          foreach($case as $i0=>$v0){
            echo '
            <LI CLASS="item UI_case" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UI_case_areaoflaw" ID="1.'.$i0.'.0">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '
                <UL>';
                foreach($v0['type of case'] as $i1=>$typeofcase){
                  echo '
                  <LI CLASS="item UI_case_typeofcase" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
                    else echo htmlspecialchars($typeofcase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_case_typeofcase" ID="1.'.$i0.'.1.'.count($v0['type of case']).'">new type of case</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_case" ID="1.'.count($case).'">new case</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in case
      function UI_case(id){
        return '<DIV>area of law: <SPAN CLASS="item UI_case_areaoflaw" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type of case: <UL><LI CLASS="new UI_case_typeofcase" ID="'+id+'.1">new type of case</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Document->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Document=".urlencode($Document->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Document=".urlencode($Document->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Document=".urlencode($Document->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Document is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Document object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Document object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>