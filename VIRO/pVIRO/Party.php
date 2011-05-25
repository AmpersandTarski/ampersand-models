<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  require "interfaceDef.inc.php";
  require "Party.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $cases=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $cases[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                         , 'nr' => @$r['0.'.$i0.'.0']
                         , 'area of law' => @$r['0.'.$i0.'.1']
                         );
      $cases[$i0]['type of case']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $cases[$i0]['type of case'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
    }
    $role = @$r['1'];
    $authorized=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $authorized[$i0] = array( 'id' => @$r['2.'.$i0.'']
                              );
      $authorized[$i0]['representative']=array();
      for($i1=0;isset($r['2.'.$i0.'.0.'.$i1]);$i1++){
        $authorized[$i0]['representative'][$i1] = @$r['2.'.$i0.'.0.'.$i1.''];
      }
    }
    $Party=new Party($ID,$cases, $role, $authorized);
    if($Party->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?Party='.urlencode($Party->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Party'])){
    if(!$del || !delParty($_REQUEST['Party']))
      $Party = readParty($_REQUEST['Party']);
    else $Party = false; // delete was a succes!
  } else if($new) $Party = new Party();
  else $Party = false;
  if($Party){
    writeHead("<TITLE>Party - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Party->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Party->getId()).'" /></P>';
    else echo '<H1>'.$Party->getId().'</H1>';
    ?>
    <DIV class="Floater cases">
      <DIV class="FloaterHeader">cases</DIV>
      <DIV class="FloaterContent"><?php
          $cases = $Party->get_cases();
          echo '
          <UL>';
          foreach($cases as $i0=>$v0){
            echo '
            <LI CLASS="item UI_cases" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="LegalCase.php?LegalCase='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UI_cases_nr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'area of law: ';
                echo '<SPAN CLASS="item UI_cases_areaoflaw" ID="0.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($v0['area of law']).'">'.htmlspecialchars($v0['area of law']).'</A>';
                else echo htmlspecialchars($v0['area of law']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type of case: ';
                echo '
                <UL>';
                foreach($v0['type of case'] as $i1=>$typeofcase){
                  echo '
                  <LI CLASS="item UI_cases_typeofcase" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
                    else echo htmlspecialchars($typeofcase);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cases_typeofcase" ID="0.'.$i0.'.2.'.count($v0['type of case']).'">new type of case</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cases" ID="0.'.count($cases).'">new cases</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in cases
      function UI_cases(id){
        return '<DIV>nr: <SPAN CLASS="item UI_cases_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UI_cases_areaoflaw" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type of case: <UL><LI CLASS="new UI_cases_typeofcase" ID="'+id+'.2">new type of case</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater role">
      <DIV class="FloaterHeader">role</DIV>
      <DIV class="FloaterContent"><?php
          $role = $Party->get_role();
          echo '<SPAN CLASS="item UI_role" ID="1">';
          echo htmlspecialchars($role);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater authorized">
      <DIV class="FloaterHeader">authorized</DIV>
      <DIV class="FloaterContent"><?php
          $authorized = $Party->get_authorized();
          echo '
          <UL>';
          foreach($authorized as $i0=>$v0){
            echo '
            <LI CLASS="item UI_authorized" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To2.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo2.'.$i0.'"><UL>';
                echo '<LI><A HREF="Correspondence.php?Correspondence='.urlencode($v0['id']).'">Correspondence</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UI_authorized" ID="2.'.$i0.'.0.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To2.'.$i0.'.0.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo2.'.$i0.'.0.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_authorized" ID="2.'.$i0.'.0.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_authorized" ID="2.'.count($authorized).'">new authorized</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in authorized
      function UI_authorized(id){
        return '<DIV>representative: <UL><LI CLASS="new UI_authorized_representative" ID="'+id+'.0">new representative</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($Party->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?Party=".urlencode($Party->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&Party=".urlencode($Party->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&Party=".urlencode($Party->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Party is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Party object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No Party object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>