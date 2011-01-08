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
  require "Inhoud toevoegen.inc.php";
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
    $Inhoudtoevoegen=new Inhoudtoevoegen(@$_REQUEST['ID'],$object, $inhoud);
    if($Inhoudtoevoegen->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Inhoudtoevoegen='.urlencode($Inhoudtoevoegen->getId()));
    else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Inhoudtoevoegen'])){
    if(!$del || !delInhoudtoevoegen($_REQUEST['Inhoudtoevoegen']))
      $Inhoudtoevoegen = readInhoudtoevoegen($_REQUEST['Inhoudtoevoegen']);
    else $Inhoudtoevoegen = false; // delete was a succes!
  } else if($new) $Inhoudtoevoegen = new Inhoudtoevoegen();
  else $Inhoudtoevoegen = false;
  if($Inhoudtoevoegen){
    writeHead("<TITLE>Inhoud toevoegen - ctxHistorie - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'').'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>'."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'.$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Inhoudtoevoegen->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Inhoudtoevoegen->getId()).'" /></P>';
    else echo '<H1>'.$Inhoudtoevoegen->getId().'</H1>';
    ?>
    <DIV class="Floater object">
      <DIV class="FloaterHeader">object</DIV>
      <DIV class="FloaterContent"><?php
          $object = $Inhoudtoevoegen->get_object();
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
          $inhoud = $Inhoudtoevoegen->get_inhoud();
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
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1', document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Inhoudtoevoegen->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Inhoudtoevoegen'=>urlencode($Inhoudtoevoegen->getId()) )),"Cancel");
     } 
  } else {
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Inhoudtoevoegen'=>urlencode($Inhoudtoevoegen->getId()),'edit'=>1)),"Edit");
          $buttons.=ifaceButton(serviceref($_REQUEST['content'],false,false, array('Inhoudtoevoegen'=>urlencode($Inhoudtoevoegen->getId()),'del'=>1)),"Delete");
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Inhoud toevoegen is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Inhoud toevoegen object selected - ctxHistorie - ADL Prototype</TITLE>");
      ?><i>No Inhoud toevoegen object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>