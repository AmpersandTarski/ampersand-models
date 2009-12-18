<?php // generated with ADL vs. 0.8.10-495
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
  require "Bestand.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $path = @$r['0'];
    $session = @$r['1'];
    $compilations=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $compilations[$i0] = array( 'id' => @$r['2.'.$i0.'.0']
                                , 'id' => @$r['2.'.$i0.'.0']
                                , 'operatie' => @$r['2.'.$i0.'.1']
                                );
    }
    $Bestand=new Bestand($ID,$path, $session, $compilations);
    if($Bestand->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Bestand='.urlencode($Bestand->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Bestand'])){
    if(!$del || !delBestand($_REQUEST['Bestand']))
      $Bestand = readBestand($_REQUEST['Bestand']);
    else $Bestand = false; // delete was a succes!
  } else if($new) $Bestand = new Bestand();
  else $Bestand = false;
  if($Bestand){
    writeHead("<TITLE>Bestand - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Bestand->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Bestand->getId()).'" /></P>';
    else echo '<H1>'.$Bestand->getId().'</H1>';
    ?>
    <DIV class="Floater path">
      <DIV class="FloaterHeader">path</DIV>
      <DIV class="FloaterContent"><?php
          $path = $Bestand->get_path();
          echo '<SPAN CLASS="item UI_path" ID="0">';
            $path=$path;
          echo htmlspecialchars($path);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater session">
      <DIV class="FloaterHeader">session</DIV>
      <DIV class="FloaterContent"><?php
          $session = $Bestand->get_session();
          echo '<SPAN CLASS="item UI_session" ID="1">';
            $session=$session;
          if(!$edit) echo '
          <A HREF="'.serviceref('Session', array('Session'=>urlencode($session))).'">'.htmlspecialchars($session).'</A>';
          else echo htmlspecialchars($session);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater compilations">
      <DIV class="FloaterHeader">compilations</DIV>
      <DIV class="FloaterContent"><?php
          $compilations = $Bestand->get_compilations();
          echo '
          <UL>';
          foreach($compilations as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_compilations" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Actie', array('Actie'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'id: ';
                echo '<SPAN CLASS="item UI_compilations_id" ID="2.'.$i0.'.0">';
                  $v0['id']=$v0['id'];
                echo htmlspecialchars($v0['id']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'operatie: ';
                echo '<SPAN CLASS="item UI_compilations_operatie" ID="2.'.$i0.'.1">';
                  $v0['operatie']=$v0['operatie'];
                if(!$edit) echo '
                <A HREF="'.serviceref('Operatie', array('Operatie'=>urlencode($v0['operatie']))).'">'.htmlspecialchars($v0['operatie']).'</A>';
                else echo htmlspecialchars($v0['operatie']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_compilations" ID="2.'.count($compilations).'">new compilations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in compilations
      function UI_compilations(id){
        return '<DIV>id: <SPAN CLASS="item UI_compilations_id" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>operatie: <SPAN CLASS="item UI_compilations_operatie" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Bestand->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Bestand'=>urlencode($Bestand->getId()) )),"Cancel");
     } 
  } else $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Bestand'=>urlencode($Bestand->getId()),'edit'=>1)),"Edit")
                 .ifaceButton(serviceref($_REQUEST['content'], array('Bestand'=>urlencode($Bestand->getId()),'del'=>1)),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Bestand is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Bestand object selected - Meterkast - ADL Prototype</TITLE>");
      ?><i>No Bestand object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>