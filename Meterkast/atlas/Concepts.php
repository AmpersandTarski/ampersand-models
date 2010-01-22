<?php // generated with ADL vs. 0.8.10-559
/**********************\
*                      *
*   Interface V1.3.1   *
*                      *
*                      *
*   Using interfaceDef *
*                      *
\**********************/
  error_reporting(E_ALL); 
  ini_set("display_errors", 1);
  require "interfaceDef.inc.php";
  require "Concepts.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Concepts=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Concepts[$i0] = @$r['0.'.$i0.''];
    }
    $Concepts=new Concepts($Concepts);
    if($Concepts->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Concepts=new Concepts();
    writeHead("<TITLE>Concepts - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Concepts</H1>
    <DIV class="Floater Concept_s">
      <DIV class="FloaterHeader">Concept_s</DIV>
      <DIV class="FloaterContent"><?php
          $Concepts = $Concepts->get_Concepts();
          echo '
          <UL>';
          foreach($Concepts as $i0=>$idv0){
            $v0=display('Concept','display',$idv0);
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Concepts).'">new Concept_s</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons=$buttons;
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>