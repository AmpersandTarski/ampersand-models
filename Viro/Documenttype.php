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
  require "Documenttype.inc.php";
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
                                , 'Document' => @$r['0.'.$i0.'.0']
                                , 'type' => @$r['0.'.$i0.'.1']
                                );
    }
    $Documenttype=new Documenttype($ID,$typeDocument);
    if($Documenttype->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Documenttype='.urlencode($Documenttype->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Documenttype'])){
    if(!$del || !delDocumenttype($_REQUEST['Documenttype']))
      $Documenttype = readDocumenttype($_REQUEST['Documenttype']);
    else $Documenttype = false; // delete was a succes!
  } else if($new) $Documenttype = new Documenttype();
  else $Documenttype = false;
  if($Documenttype){
    writeHead("<TITLE>Documenttype - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Documenttype->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Documenttype->getId()).'" /></P>';
    else echo '<H1>'.$Documenttype->getId().'</H1>';
    ?>
    <DIV class="Floater type Document">
      <DIV class="FloaterHeader">type Document</DIV>
      <DIV class="FloaterContent"><?php
          $typeDocument = $Documenttype->get_typeDocument();
          echo '
          <UL>';
          foreach($typeDocument as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UIDocument" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UItype" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Documenttype.php?Documenttype='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
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
        return '<DIV>Document: <SPAN CLASS="item UI_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_type" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Documenttype->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Documenttype=".urlencode($Documenttype->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Documenttype=".urlencode($Documenttype->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Documenttype=".urlencode($Documenttype->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Documenttype is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Documenttype object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Documenttype object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>