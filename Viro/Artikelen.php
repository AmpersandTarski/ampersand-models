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
  require "Artikelen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Artikelen=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Artikelen[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                             , 'artikel' => @$r['0.'.$i0.'.0']
                             );
      $Artikelen[$i0]['handeling']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Artikelen[$i0]['handeling'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Artikelen[$i0]['orgaan']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Artikelen[$i0]['orgaan'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Artikelen[$i0]['werkwoord']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Artikelen[$i0]['werkwoord'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Artikelen[$i0]['objecttype']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Artikelen[$i0]['objecttype'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Artikelen=new Artikelen($Artikelen);
    if($Artikelen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Artikelen=new Artikelen();
    writeHead("<TITLE>Artikelen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Artikelen</H1>
    <DIV class="Floater Artikelen">
      <DIV class="FloaterHeader">Artikelen</DIV>
      <DIV class="FloaterContent"><?php
          $Artikelen = $Artikelen->get_Artikelen();
          echo '
          <UL>';
          foreach($Artikelen as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Artikel.php?Artikel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'artikel: ';
                echo '<SPAN CLASS="item UIartikel" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['artikel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'handeling: ';
                echo '
                <UL>';
                foreach($v0['handeling'] as $i1=>$handeling){
                  echo '
                  <LI CLASS="item UIhandeling" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($handeling);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIhandeling" ID="0.'.$i0.'.1.'.count($v0['handeling']).'">new handeling</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'orgaan: ';
                echo '
                <UL>';
                foreach($v0['orgaan'] as $i1=>$orgaan){
                  echo '
                  <LI CLASS="item UIorgaan" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Orgaan.php?Orgaan='.urlencode($orgaan).'">'.htmlspecialchars($orgaan).'</A>';
                    else echo htmlspecialchars($orgaan);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIorgaan" ID="0.'.$i0.'.2.'.count($v0['orgaan']).'">new orgaan</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'werkwoord: ';
                echo '
                <UL>';
                foreach($v0['werkwoord'] as $i1=>$werkwoord){
                  echo '
                  <LI CLASS="item UIwerkwoord" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($werkwoord);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIwerkwoord" ID="0.'.$i0.'.3.'.count($v0['werkwoord']).'">new werkwoord</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'objecttype: ';
                echo '
                <UL>';
                foreach($v0['objecttype'] as $i1=>$objecttype){
                  echo '
                  <LI CLASS="item UIobjecttype" ID="0.'.$i0.'.4.'.$i1.'">';
                    echo htmlspecialchars($objecttype);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIobjecttype" ID="0.'.$i0.'.4.'.count($v0['objecttype']).'">new objecttype</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Artikelen).'">new Artikelen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Artikelen
      function UI(id){
        return '<DIV>artikel: <SPAN CLASS="item UI_artikel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>handeling: <UL><LI CLASS="new UI_handeling" ID="'+id+'.1">new handeling</LI></UL></DIV>'
             + '<DIV>orgaan: <UL><LI CLASS="new UI_orgaan" ID="'+id+'.2">new orgaan</LI></UL></DIV>'
             + '<DIV>werkwoord: <UL><LI CLASS="new UI_werkwoord" ID="'+id+'.3">new werkwoord</LI></UL></DIV>'
             + '<DIV>objecttype: <UL><LI CLASS="new UI_objecttype" ID="'+id+'.4">new objecttype</LI></UL></DIV>'
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