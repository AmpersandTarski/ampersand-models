<?php // generated with ADL vs. 1.0-632
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
  require "Rule2.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $eigenschapvanrelatie = @$r['0'];
    $overtredingen=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $overtredingen[$i0] = @$r['1.'.$i0.''];
    }
    $uitleg = @$r['2'];
    $pattern = @$r['3'];
    $Rule2=new Rule2($ID,$eigenschapvanrelatie, $overtredingen, $uitleg, $pattern);
    if($Rule2->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Rule2='.urlencode($Rule2->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Rule2'])){
    if(!$del || !delRule2($_REQUEST['Rule2']))
      $Rule2 = readRule2($_REQUEST['Rule2']);
    else $Rule2 = false; // delete was a succes!
  } else if($new) $Rule2 = new Rule2();
  else $Rule2 = false;
  if($Rule2){
    writeHead("<TITLE>Rule2 - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Rule2->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Rule2->getId()).'" /></P>';
    else echo '<H1>'.display('MultiplicityRule','display',$Rule2->getId()).'</H1>';
    ?>
    <DIV class="Floater eigenschap van relatie">
      <DIV class="FloaterHeader">eigenschap van relatie</DIV>
      <DIV class="FloaterContent"><?php
          $eigenschapvanrelatie = $Rule2->get_eigenschapvanrelatie();
          echo '<SPAN CLASS="item UI_eigenschapvanrelatie" ID="0">';
            $displayeigenschapvanrelatie=display('Relation','display',$eigenschapvanrelatie);
          if(!$edit){
            echo '
          <A class="GotoLink" id="To0">';
            echo htmlspecialchars($displayeigenschapvanrelatie).'</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($eigenschapvanrelatie))).'">Relatiedetails</A></LI>';
            echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($eigenschapvanrelatie))).'">Populatie</A></LI>';
            echo '</UL></DIV>';
          } else echo htmlspecialchars($displayeigenschapvanrelatie);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater overtredingen">
      <DIV class="FloaterHeader">overtredingen</DIV>
      <DIV class="FloaterContent"><?php
          $overtredingen = $Rule2->get_overtredingen();
          echo '
          <UL>';
          foreach($overtredingen as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_overtredingen" ID="1.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_overtredingen" ID="1.'.count($overtredingen).'">new overtredingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater uitleg">
      <DIV class="FloaterHeader">uitleg</DIV>
      <DIV class="FloaterContent"><?php
          $uitleg = $Rule2->get_uitleg();
          echo '<SPAN CLASS="item UI_uitleg" ID="2">';
            $uitleg=$uitleg;
          echo htmlspecialchars($uitleg);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater pattern">
      <DIV class="FloaterHeader">pattern</DIV>
      <DIV class="FloaterContent"><?php
          $pattern = $Rule2->get_pattern();
          echo '<SPAN CLASS="item UI_pattern" ID="3">';
            $displaypattern=display('Pattern','display',$pattern);
          if(!$edit) echo '
          <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($pattern))).'">'.htmlspecialchars($displaypattern).'</A>';
          else echo htmlspecialchars($displaypattern);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Rule2->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Rule2'=>urlencode($Rule2->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Rule2 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Rule2 object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Rule2 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>