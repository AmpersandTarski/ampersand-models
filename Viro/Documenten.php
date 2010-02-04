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
      $Documenten[$i0]['zorgdrager']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Documenten[$i0]['zorgdrager'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Documenten[$i0]['rechtsgebied']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Documenten[$i0]['rechtsgebied'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Documenten[$i0]['proceduresoort']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Documenten[$i0]['proceduresoort'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Documenten=new Documenten($Documenten);
    if($Documenten->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Documenten=new Documenten();
    writeHead("<TITLE>Documenten - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Documenten</H1>
    <DIV class="Floater Documenten">
      <DIV class="FloaterHeader">Documenten</DIV>
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
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
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
                <A HREF="Documenttype.php?Documenttype='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'zorgdrager: ';
                echo '
                <UL>';
                foreach($v0['zorgdrager'] as $i1=>$zorgdrager){
                  echo '
                  <LI CLASS="item UIzorgdrager" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Orgaan.php?Orgaan='.urlencode($zorgdrager).'">'.htmlspecialchars($zorgdrager).'</A>';
                    else echo htmlspecialchars($zorgdrager);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIzorgdrager" ID="0.'.$i0.'.2.'.count($v0['zorgdrager']).'">new zorgdrager</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rechtsgebied: ';
                echo '
                <UL>';
                foreach($v0['rechtsgebied'] as $i1=>$rechtsgebied){
                  echo '
                  <LI CLASS="item UIrechtsgebied" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($rechtsgebied).'">'.htmlspecialchars($rechtsgebied).'</A>';
                    else echo htmlspecialchars($rechtsgebied);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrechtsgebied" ID="0.'.$i0.'.3.'.count($v0['rechtsgebied']).'">new rechtsgebied</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'proceduresoort: ';
                echo '
                <UL>';
                foreach($v0['proceduresoort'] as $i1=>$proceduresoort){
                  echo '
                  <LI CLASS="item UIproceduresoort" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($proceduresoort).'">'.htmlspecialchars($proceduresoort).'</A>';
                    else echo htmlspecialchars($proceduresoort);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIproceduresoort" ID="0.'.$i0.'.4.'.count($v0['proceduresoort']).'">new proceduresoort</LI>';
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
             + '<DIV>zorgdrager: <UL><LI CLASS="new UI_zorgdrager" ID="'+id+'.2">new zorgdrager</LI></UL></DIV>'
             + '<DIV>rechtsgebied: <UL><LI CLASS="new UI_rechtsgebied" ID="'+id+'.3">new rechtsgebied</LI></UL></DIV>'
             + '<DIV>proceduresoort: <UL><LI CLASS="new UI_proceduresoort" ID="'+id+'.4">new proceduresoort</LI></UL></DIV>'
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