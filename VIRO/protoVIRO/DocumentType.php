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
  require "DocumentType.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $typeDocument=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $typeDocument[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                , 'nr' => @$r['0.'.$i0.'.0']
                                );
    }
    $DocumentType=new DocumentType($ID,$typeDocument);
    if($DocumentType->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?DocumentType='.urlencode($DocumentType->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['DocumentType'])){
    if(!$del || !delDocumentType($_REQUEST['DocumentType']))
      $DocumentType = readDocumentType($_REQUEST['DocumentType']);
    else $DocumentType = false; // delete was a succes!
  } else if($new) $DocumentType = new DocumentType();
  else $DocumentType = false;
  if($DocumentType){
    writeHead("<TITLE>DocumentType - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $DocumentType->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($DocumentType->getId()).'" /></P>';
    else echo '<H1>'.$DocumentType->getId().'</H1>';
    ?>
    <DIV class="Floater type Document">
      <DIV class="FloaterHeader">type Document</DIV>
      <DIV class="FloaterContent"><?php
          $typeDocument = $DocumentType->get_typeDocument();
          echo '
          <UL>';
          foreach($typeDocument as $i0=>$v0){
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
                echo '<SPAN CLASS="item UI" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($typeDocument).'">new type Document</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in type Document
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($DocumentType->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?DocumentType=".urlencode($DocumentType->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&DocumentType=".urlencode($DocumentType->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&DocumentType=".urlencode($DocumentType->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The DocumentType is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No DocumentType object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No DocumentType object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>