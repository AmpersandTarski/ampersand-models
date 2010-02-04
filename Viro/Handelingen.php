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
  require "Handelingen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Handelingen=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Handelingen[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                               , 'nr' => @$r['0.'.$i0.'.0']
                               );
      $Handelingen[$i0]['Orgaan']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Handelingen[$i0]['Orgaan'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Handelingen[$i0]['wet']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Handelingen[$i0]['wet'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Handelingen[$i0]['usecase']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Handelingen[$i0]['usecase'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Handelingen[$i0]['rol']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Handelingen[$i0]['rol'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Handelingen=new Handelingen($Handelingen);
    if($Handelingen->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Handelingen=new Handelingen();
    writeHead("<TITLE>Handelingen - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Handelingen</H1>
    <DIV class="Floater Handelingen">
      <DIV class="FloaterHeader">Handelingen</DIV>
      <DIV class="FloaterContent"><?php
          $Handelingen = $Handelingen->get_Handelingen();
          echo '
          <UL>';
          foreach($Handelingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="HandelingCompact.php?HandelingCompact='.urlencode($v0['id']).'">HandelingCompact</A></LI>';
                echo '<LI><A HREF="Handeling.php?Handeling='.urlencode($v0['id']).'">Handeling</A></LI>';
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
                echo 'Orgaan: ';
                echo '
                <UL>';
                foreach($v0['Orgaan'] as $i1=>$Orgaan){
                  echo '
                  <LI CLASS="item UIOrgaan" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Orgaan.php?Orgaan='.urlencode($Orgaan).'">'.htmlspecialchars($Orgaan).'</A>';
                    else echo htmlspecialchars($Orgaan);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIOrgaan" ID="0.'.$i0.'.1.'.count($v0['Orgaan']).'">new Orgaan</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'wet: ';
                echo '
                <UL>';
                foreach($v0['wet'] as $i1=>$wet){
                  echo '
                  <LI CLASS="item UIwet" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Artikel.php?Artikel='.urlencode($wet).'">'.htmlspecialchars($wet).'</A>';
                    else echo htmlspecialchars($wet);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIwet" ID="0.'.$i0.'.2.'.count($v0['wet']).'">new wet</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'usecase: ';
                echo '
                <UL>';
                foreach($v0['usecase'] as $i1=>$usecase){
                  echo '
                  <LI CLASS="item UIusecase" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($usecase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIusecase" ID="0.'.$i0.'.3.'.count($v0['usecase']).'">new usecase</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '
                <UL>';
                foreach($v0['rol'] as $i1=>$rol){
                  echo '
                  <LI CLASS="item UIrol" ID="0.'.$i0.'.4.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Rol.php?Rol='.urlencode($rol).'">'.htmlspecialchars($rol).'</A>';
                    else echo htmlspecialchars($rol);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrol" ID="0.'.$i0.'.4.'.count($v0['rol']).'">new rol</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Handelingen).'">new Handelingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Handelingen
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>Orgaan: <UL><LI CLASS="new UI_Orgaan" ID="'+id+'.1">new Orgaan</LI></UL></DIV>'
             + '<DIV>wet: <UL><LI CLASS="new UI_wet" ID="'+id+'.2">new wet</LI></UL></DIV>'
             + '<DIV>usecase: <UL><LI CLASS="new UI_usecase" ID="'+id+'.3">new usecase</LI></UL></DIV>'
             + '<DIV>rol: <UL><LI CLASS="new UI_rol" ID="'+id+'.4">new rol</LI></UL></DIV>'
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