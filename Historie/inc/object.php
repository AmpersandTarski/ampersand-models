<?php // generated with ADL vs. 1.1.0.801
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
  require "object.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $object = @$r['0'];
    $inhoud=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $inhoud[$i0] = array( 'id' => @$r['1.'.$i0.'.0']
                          , 'inhoud' => @$r['1.'.$i0.'.0']
                          , 'versie' => @$r['1.'.$i0.'.1']
                          );
    }
    $verloop=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $verloop[$i0] = @$r['2.'.$i0.''];
    }
    $object=new object(@$_REQUEST['ID'],$object, $inhoud, $verloop);
    if($object->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&object='.urlencode($object->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['object'])){
    if(!$del || !delobject($_REQUEST['object']))
      $object = readobject($_REQUEST['object']);
    else $object = false; // delete was a succes!
  } else if($new) $object = new object();
  else $object = false;
  if($object){
    writeHead("<TITLE>object - ctxHistorie - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $object->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($object->getId()).'" /></P>';
    else echo '<H1>'.$object->getId().'</H1>';
    ?>
    <DIV class="Floater object">
      <DIV class="FloaterHeader">object</DIV>
      <DIV class="FloaterContent"><?php
          $object = $object->get_object();
          //PICK an existing item0. Creating instances should at most be possible for simple Concepts.
          if(isset($object)){
            echo '<DIV CLASS="item UI_object" ID="0">';
          }else{
            echo '<DIV CLASS="new UI_object" ID="0">';
          }
              if(isset($object) && $object!=''){
                echo htmlspecialchars($object);
              } else {echo '<I>Nothing</I>';}
          echo '</DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater inhoud">
      <DIV class="FloaterHeader">inhoud</DIV>
      <DIV class="FloaterContent"><?php
          $inhoud = $object->get_inhoud();
          echo '
          <UL>';
          foreach($inhoud as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_inhoud" ID="1.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('inhoud',false,$edit, array('inhoud'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'inhoud: ';
                //PICK an existing item1.'.$i0.'.0. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['inhoud'])){
                  echo '<DIV CLASS="item UI_inhoud_inhoud" ID="1.'.$i0.'.0">';
                }else{
                  echo '<DIV CLASS="new UI_inhoud_inhoud" ID="1.'.$i0.'.0">';
                }
                    if(isset($v0['inhoud']) && $v0['inhoud']!=''){
                      echo htmlspecialchars($v0['inhoud']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '</DIV>
              <DIV>';
                echo 'versie: ';
                //PICK an existing item1.'.$i0.'.1. Creating instances should at most be possible for simple Concepts.
                if(isset($v0['versie'])){
                  echo '<DIV CLASS="item UI_inhoud_versie" ID="1.'.$i0.'.1">';
                }else{
                  echo '<DIV CLASS="new UI_inhoud_versie" ID="1.'.$i0.'.1">';
                }
                    if(isset($v0['versie']) && $v0['versie']!=''){
                      echo htmlspecialchars($v0['versie']);
                    } else {echo '<I>Nothing</I>';}
                echo '</DIV>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_inhoud" ID="1.'.count($inhoud).'">enter instance of inhoud</LI>
            <LI CLASS="newlink UI_inhoud" ID="1.'.(count($inhoud)+1).'">
              <A HREF="'.serviceref('inhoud',$edit).'">new instance of inhoud</A>
            </LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in inhoud
      function UI_inhoud(id){
        return '<DIV>inhoud: <SPAN CLASS="item UI_inhoud_inhoud" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>versie: <SPAN CLASS="item UI_inhoud_versie" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater verloop">
      <DIV class="FloaterHeader">verloop</DIV>
      <DIV class="FloaterContent"><?php
          $verloop = $object->get_verloop();
          echo '
          <UL>';
          foreach($verloop as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_verloop" ID="2.'.$i0.'">';
          
              if($v0==''){echo '<I>Nothing</I>';}
              else{
              if(!$edit) echo '
              <A HREF="'.serviceref('inhoud',false,$edit, array('inhoud'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
              }
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_verloop" ID="2.'.count($verloop).'">enter instance of verloop</LI>
            <LI CLASS="newlink UI_verloop" ID="2.'.(count($verloop)+1).'">
              <A HREF="'.serviceref('inhoud',$edit).'">new instance of verloop</A>
            </LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($object->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('object'=>urlencode($object->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('object'=>urlencode($object->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('object'=>urlencode($object->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The object is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No object object selected - ctxHistorie - ADL Prototype</TITLE>");
      ?><i>No object object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>