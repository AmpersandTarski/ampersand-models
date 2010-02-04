<?php // generated with ADL vs. 0.8.10-451
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
  require "Acties.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Acties=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Acties[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                          , 'nr' => @$r['0.'.$i0.'.0']
                          , 'subject Persoon' => @$r['0.'.$i0.'.1']
                          , 'type Handeling' => @$r['0.'.$i0.'.2']
                          );
    }
    $Acties=new Acties($Acties);
    if($Acties->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Acties=new Acties();
    writeHead("<TITLE>Acties - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Acties</H1>
    <DIV class="Floater Acties">
      <DIV class="FloaterHeader">Acties</DIV>
      <DIV class="FloaterContent"><?php
          $Acties = $Acties->get_Acties();
          echo '
          <UL>';
          foreach($Acties as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Actie.php?Actie='.urlencode($v0['id']).'">';
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
                echo 'subject Persoon: ';
                echo '<SPAN CLASS="item UIsubjectPersoon" ID="0.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.1">';
                  echo htmlspecialchars($v0['subject Persoon']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['subject Persoon']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['subject Persoon']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['subject Persoon']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['subject Persoon']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type Handeling: ';
                echo '<SPAN CLASS="item UItypeHandeling" ID="0.'.$i0.'.2">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.2">';
                  echo htmlspecialchars($v0['type Handeling']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2"><UL>';
                  echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['type Handeling']).'">HandelingCompact</A></LI>';
                  echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['type Handeling']).'">Handeling</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['type Handeling']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Acties).'">new Acties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Acties
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>subject Persoon: <SPAN CLASS="item UI_subjectPersoon" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type Handeling: <SPAN CLASS="item UI_typeHandeling" ID="'+id+'.2"></SPAN></DIV>'
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