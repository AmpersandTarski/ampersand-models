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
  require "Authorizations.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Authorizations=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Authorizations[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                  , 'document' => @$r['0.'.$i0.'.0']
                                  , 'by' => @$r['0.'.$i0.'.2']
                                  );
      $Authorizations[$i0]['for']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Authorizations[$i0]['for'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Authorizations[$i0]['representative']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Authorizations[$i0]['representative'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $Authorizations=new Authorizations($Authorizations);
    if($Authorizations->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Authorizations=new Authorizations();
    writeHead("<TITLE>Authorizations - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Authorizations</H1>
    <DIV class="Floater Authorizations">
      <DIV class="FloaterHeader">Authorizations</DIV>
      <DIV class="FloaterContent"><?php
          $Authorizations = $Authorizations->get_Authorizations();
          echo '
          <UL>';
          foreach($Authorizations as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Authorization.php?Authorization='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'document: ';
                echo '<SPAN CLASS="item UIdocument" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'for: ';
                echo '
                <UL>';
                foreach($v0['for'] as $i1=>$for){
                  echo '
                  <LI CLASS="item UIfor" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="LegalCase.php?LegalCase='.urlencode($for).'">'.htmlspecialchars($for).'</A>';
                    else echo htmlspecialchars($for);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIfor" ID="0.'.$i0.'.1.'.count($v0['for']).'">new for</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'by: ';
                echo '<SPAN CLASS="item UIby" ID="0.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.2">';
                  echo htmlspecialchars($v0['by']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['by']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['by']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['by']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['by']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UIrepresentative" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.3.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.3.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($representative).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrepresentative" ID="0.'.$i0.'.3.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Authorizations).'">new Authorizations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Authorizations
      function UI(id){
        return '<DIV>document: <SPAN CLASS="item UI_document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>for: <UL><LI CLASS="new UI_for" ID="'+id+'.1">new for</LI></UL></DIV>'
             + '<DIV>by: <SPAN CLASS="item UI_by" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_representative" ID="'+id+'.3">new representative</LI></UL></DIV>'
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