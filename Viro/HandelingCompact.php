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
  require "HandelingCompact.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $objectObjecttype=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $objectObjecttype[$i0] = @$r['0.'.$i0.''];
    }
    $werkwoord=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $werkwoord[$i0] = @$r['1.'.$i0.''];
    }
    $usecase=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $usecase[$i0] = array( 'id' => @$r['2.'.$i0.'']
                           , 'omschrijving' => @$r['2.'.$i0.'.0']
                           );
    }
    $rol=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $rol[$i0] = @$r['3.'.$i0.''];
    }
    $grondslag=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $grondslag[$i0] = array( 'id' => @$r['4.'.$i0.'.0']
                             , 'artikel' => @$r['4.'.$i0.'.0']
                             );
      $grondslag[$i0]['tekst']=array();
      for($i1=0;isset($r['4.'.$i0.'.1.'.$i1]);$i1++){
        $grondslag[$i0]['tekst'][$i1] = @$r['4.'.$i0.'.1.'.$i1.''];
      }
    }
    $HandelingCompact=new HandelingCompact($ID,$objectObjecttype, $werkwoord, $usecase, $rol, $grondslag);
    if($HandelingCompact->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?HandelingCompact='.urlencode($HandelingCompact->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['HandelingCompact'])){
    if(!$del || !delHandelingCompact($_REQUEST['HandelingCompact']))
      $HandelingCompact = readHandelingCompact($_REQUEST['HandelingCompact']);
    else $HandelingCompact = false; // delete was a succes!
  } else if($new) $HandelingCompact = new HandelingCompact();
  else $HandelingCompact = false;
  if($HandelingCompact){
    writeHead("<TITLE>HandelingCompact - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $HandelingCompact->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($HandelingCompact->getId()).'" /></P>';
    else echo '<H1>'.$HandelingCompact->getId().'</H1>';
    ?>
    <DIV class="Floater object Objecttype">
      <DIV class="FloaterHeader">object Objecttype</DIV>
      <DIV class="FloaterContent"><?php
          $objectObjecttype = $HandelingCompact->get_objectObjecttype();
          echo '
          <UL>';
          foreach($objectObjecttype as $i0=>$v0){
            echo '
            <LI CLASS="item UI_objectObjecttype" ID="0.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Objecttype.php?Objecttype='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_objectObjecttype" ID="0.'.count($objectObjecttype).'">new object Objecttype</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater werkwoord">
      <DIV class="FloaterHeader">werkwoord</DIV>
      <DIV class="FloaterContent"><?php
          $werkwoord = $HandelingCompact->get_werkwoord();
          echo '
          <UL>';
          foreach($werkwoord as $i0=>$v0){
            echo '
            <LI CLASS="item UI_werkwoord" ID="1.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Werkwoord.php?Werkwoord='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_werkwoord" ID="1.'.count($werkwoord).'">new werkwoord</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater usecase">
      <DIV class="FloaterHeader">usecase</DIV>
      <DIV class="FloaterContent"><?php
          $usecase = $HandelingCompact->get_usecase();
          echo '
          <UL>';
          foreach($usecase as $i0=>$v0){
            echo '
            <LI CLASS="item UI_usecase" ID="2.'.$i0.'">';
              echo '
              <DIV>';
                echo 'omschrijving: ';
                if (isset($v0['omschrijving'])){
                  echo '<DIV CLASS="item UI_usecase" ID="2.'.$i0.'.0">';
                  echo '</DIV>';
                  if(isset($v0['omschrijving'])){
                    echo htmlspecialchars($v0['omschrijving']);
                  }
                } else echo '<DIV CLASS="new UI_usecase" ID="2.'.$i0.'.0"><I>Nothing</I></DIV>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_usecase" ID="2.'.count($usecase).'">new usecase</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in usecase
      function UI_usecase(id){
        return '<DIV>omschrijving: <DIV CLASS="new UI_usecase_omschrijving" ID="'+id+'.0"><I>Nothing</I></DIV></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rol">
      <DIV class="FloaterHeader">rol</DIV>
      <DIV class="FloaterContent"><?php
          $rol = $HandelingCompact->get_rol();
          echo '
          <UL>';
          foreach($rol as $i0=>$v0){
            echo '
            <LI CLASS="item UI_rol" ID="3.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Rol.php?Rol='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_rol" ID="3.'.count($rol).'">new rol</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater grondslag">
      <DIV class="FloaterHeader">grondslag</DIV>
      <DIV class="FloaterContent"><?php
          $grondslag = $HandelingCompact->get_grondslag();
          echo '
          <UL>';
          foreach($grondslag as $i0=>$v0){
            echo '
            <LI CLASS="item UI_grondslag" ID="4.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Artikel.php?Artikel='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'artikel: ';
                echo '<SPAN CLASS="item UI_grondslag_artikel" ID="4.'.$i0.'.0">';
                echo htmlspecialchars($v0['artikel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'tekst: ';
                echo '
                <UL>';
                foreach($v0['tekst'] as $i1=>$tekst){
                  echo '
                  <LI CLASS="item UI_grondslag_tekst" ID="4.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($tekst);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_grondslag_tekst" ID="4.'.$i0.'.1.'.count($v0['tekst']).'">new tekst</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="4.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_grondslag" ID="4.'.count($grondslag).'">new grondslag</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in grondslag
      function UI_grondslag(id){
        return '<DIV>artikel: <SPAN CLASS="item UI_grondslag_artikel" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>tekst: <UL><LI CLASS="new UI_grondslag_tekst" ID="'+id+'.1">new tekst</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($HandelingCompact->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?HandelingCompact=".urlencode($HandelingCompact->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&HandelingCompact=".urlencode($HandelingCompact->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&HandelingCompact=".urlencode($HandelingCompact->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The HandelingCompact is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No HandelingCompact object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No HandelingCompact object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>