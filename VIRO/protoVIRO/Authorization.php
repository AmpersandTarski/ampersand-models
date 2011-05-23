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
  require "Authorization.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $authorization = @$r['0'];
    $for=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $for[$i0] = @$r['1.'.$i0.''];
    }
    $by = @$r['2'];
    $representative=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $representative[$i0] = @$r['3.'.$i0.''];
    }
    $legalauthorization=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $legalauthorization[$i0] = array( 'id' => @$r['4.'.$i0.'.0']
                                      , 'Document' => @$r['4.'.$i0.'.0']
                                      , 'type' => @$r['4.'.$i0.'.1']
                                      );
    }
    $Authorization=new Authorization($ID,$authorization, $for, $by, $representative, $legalauthorization);
    if($Authorization->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Authorization='.urlencode($Authorization->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Authorization'])){
    if(!$del || !delAuthorization($_REQUEST['Authorization']))
      $Authorization = readAuthorization($_REQUEST['Authorization']);
    else $Authorization = false; // delete was a succes!
  } else if($new) $Authorization = new Authorization();
  else $Authorization = false;
  if($Authorization){
    writeHead("<TITLE>Authorization - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Authorization->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Authorization->getId()).'" /></P>';
    else echo '<H1>'.$Authorization->getId().'</H1>';
    ?>
    <DIV class="Floater authorization">
      <DIV class="FloaterHeader">authorization</DIV>
      <DIV class="FloaterContent"><?php
          $authorization = $Authorization->get_authorization();
          echo '<SPAN CLASS="item UI_authorization" ID="0">';
          echo htmlspecialchars($authorization);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater for">
      <DIV class="FloaterHeader">for</DIV>
      <DIV class="FloaterContent"><?php
          $for = $Authorization->get_for();
          echo '
          <UL>';
          foreach($for as $i0=>$v0){
            echo '
            <LI CLASS="item UI_for" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_for" ID="1.'.count($for).'">new for</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater by">
      <DIV class="FloaterHeader">by</DIV>
      <DIV class="FloaterContent"><?php
          $by = $Authorization->get_by();
          echo '<SPAN CLASS="item UI_by" ID="2">';
          if(!$edit){
            echo '
          <A class="GotoLink" id="To2">';
            echo htmlspecialchars($by).'</A>';
            echo '<DIV class="Goto" id="GoTo2"><UL>';
            echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($by).'">Magistrate</A></LI>';
            echo '<LI><A HREF="Party.php?Party='.urlencode($by).'">Party</A></LI>';
            echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($by).'">InterestedParty</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($by);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater representative">
      <DIV class="FloaterHeader">representative</DIV>
      <DIV class="FloaterContent"><?php
          $representative = $Authorization->get_representative();
          echo '
          <UL>';
          foreach($representative as $i0=>$v0){
            echo '
            <LI CLASS="item UI_representative" ID="3.'.$i0.'">';
              if(!$edit){
                echo '
              <A class="GotoLink" id="To3.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo3.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0).'">Party</A></LI>';
                echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0).'">InterestedParty</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_representative" ID="3.'.count($representative).'">new representative</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater legal authorization">
      <DIV class="FloaterHeader">legal authorization</DIV>
      <DIV class="FloaterContent"><?php
          $legalauthorization = $Authorization->get_legalauthorization();
          echo '
          <UL>';
          foreach($legalauthorization as $i0=>$v0){
            echo '
            <LI CLASS="item UI_legalauthorization" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To4.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo4.'.$i0.'"><UL>';
                echo '<LI><A HREF="Letter.php?Letter='.urlencode($v0['id']).'">Letter</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UI_legalauthorization_Document" ID="4.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_legalauthorization_type" ID="4.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="DocumentType.php?DocumentType='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_legalauthorization" ID="4.'.count($legalauthorization).'">new legal authorization</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in legal authorization
      function UI_legalauthorization(id){
        return '<DIV>Document: <SPAN CLASS="item UI_legalauthorization_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_legalauthorization_type" ID="'+id+'.1"></SPAN></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Authorization->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Authorization=".urlencode($Authorization->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Authorization=".urlencode($Authorization->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Authorization=".urlencode($Authorization->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Authorization is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Authorization object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Authorization object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>