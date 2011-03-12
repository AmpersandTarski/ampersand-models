<?php // generated with Prototype vs. 1.1.0.899(core vs. 2.0.0.25)
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
  require "Person.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $myattsassetManager=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $myattsassetManager[$i0] = @$r['0.'.$i0.''];
    }
    $Person=new Person(@$_REQUEST['ID'],$myattsassetManager);
    if($Person->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Person='.urlencode($Person->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Person'])){
    if(!$del || !delPerson($_REQUEST['Person']))
      $Person = readPerson($_REQUEST['Person']);
    else $Person = false; // delete was a succes!
  } else if($new) $Person = new Person();
  else $Person = false;
  if($Person){
    writeHead("<TITLE>Person - ctxELMtest - Ampersand Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Person->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Person->getId()).'" /></P>';
    else echo '<H1>'.$Person->getId().'</H1>';
    ?>
    <DIV class="Floater myattsassetManager">
      <DIV class="FloaterHeader">myattsassetManager</DIV>
      <DIV class="FloaterContent"><?php
          $myattsassetManager = $Person->get_myattsassetManager();
          echo '
          <UL>';
          foreach($myattsassetManager as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit){
                echo '
              <A class="GotoLink" id="To0.'.$i0.'">';
                echo htmlspecialchars($v0).'</A>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('Asset1',false,$edit, array('Asset1'=>urlencode($idv0))).'">Asset1</A></LI>';
                echo '<LI><A HREF="'.serviceref('Assets2',false,$edit, array('Assets2'=>urlencode($idv0))).'">Assets2</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAssetRisks',false,$edit, array('decideAssetRisks'=>urlencode($idv0))).'">decideAssetRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('decideAllRisks',false,$edit, array('decideAllRisks'=>urlencode($idv0))).'">decideAllRisks</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk1',false,$edit, array('estimateRisk1'=>urlencode($idv0))).'">estimateRisk1</A></LI>';
                echo '<LI><A HREF="'.serviceref('estimateRisk3',false,$edit, array('estimateRisk3'=>urlencode($idv0))).'">estimateRisk3</A></LI>';
                echo '</UL></DIV>';
              } else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) { //["Select","Edit","Delete","New"]
            echo '<LI CLASS="new UI" ID="0.'.count($myattsassetManager).'">enter instance of myattsassetManager</LI>';
            echo '<LI CLASS="newlink UI" ID="0.'.(count($myattsassetManager)+1).'">';
            echo '<A class="GotoLink" id="To0">new instance of myattsassetManager</A>';
            echo '<DIV class="Goto" id="GoTo0"><UL>';
            echo '<LI><A HREF="'.serviceref('Asset1',$edit).'">new Asset1</A></LI>';
            echo '<LI><A HREF="'.serviceref('Assets2',$edit).'">new Assets2</A></LI>';
            echo '<LI><A HREF="'.serviceref('decideAssetRisks',$edit).'">new decideAssetRisks</A></LI>';
            echo '<LI><A HREF="'.serviceref('decideAllRisks',$edit).'">new decideAllRisks</A></LI>';
            echo '<LI><A HREF="'.serviceref('estimateRisk1',$edit).'">new estimateRisk1</A></LI>';
            echo '<LI><A HREF="'.serviceref('estimateRisk3',$edit).'">new estimateRisk3</A></LI>';
            echo '</UL></DIV>';
            echo '</LI>';
          }
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1', document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Person->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Person'=>urlencode($Person->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Person'=>urlencode($Person->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Person'=>urlencode($Person->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Person is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Person object selected - ctxELMtest - Ampersand Prototype</TITLE>");
      ?><i>No Person object selected</i><?php 
    }
  }
  writeTail($buttons);
?>