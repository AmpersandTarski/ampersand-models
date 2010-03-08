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
  require "Relatiedetails.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    if(@$r['0']!=''){
      $uitleg = @$r['0'];
    }else $uitleg=null;
    $cardinaliteitseigenschappen=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $cardinaliteitseigenschappen[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                               , 'eigenschap' => @$r['1.'.$i0.'.0']
                                               , 'afgeleide regel' => @$r['1.'.$i0.'.1']
                                               );
      $cardinaliteitseigenschappen[$i0]['wordt overtreden door']=array();
      for($i1=0;isset($r['1.'.$i0.'.2.'.$i1]);$i1++){
        $cardinaliteitseigenschappen[$i0]['wordt overtreden door'][$i1] = @$r['1.'.$i0.'.2.'.$i1.''];
      }
    }
    $homogeneeigenschappen=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $homogeneeigenschappen[$i0] = array( 'id' => @$r['2.'.$i0.'']
                                         , 'eigenschap' => @$r['2.'.$i0.'.0']
                                         , 'afgeleide regel' => @$r['2.'.$i0.'.1']
                                         );
      $homogeneeigenschappen[$i0]['wordt overtreden door']=array();
      for($i1=0;isset($r['2.'.$i0.'.2.'.$i1]);$i1++){
        $homogeneeigenschappen[$i0]['wordt overtreden door'][$i1] = @$r['2.'.$i0.'.2.'.$i1.''];
      }
    }
    $concepten=array();
    for($i0=0;isset($r['3.'.$i0]);$i0++){
      $concepten[$i0] = @$r['3.'.$i0.''];
    }
    $toepassinginregels=array();
    for($i0=0;isset($r['4.'.$i0]);$i0++){
      $toepassinginregels[$i0] = @$r['4.'.$i0.''];
    }
    $pattern = @$r['5'];
    $populatie=array();
    for($i0=0;isset($r['6.'.$i0]);$i0++){
      $populatie[$i0] = @$r['6.'.$i0.''];
    }
    $Relatiedetails=new Relatiedetails($ID,$uitleg, $cardinaliteitseigenschappen, $homogeneeigenschappen, $concepten, $toepassinginregels, $pattern, $populatie);
    if($Relatiedetails->save()!==false) die('ok:'.serviceref($_REQUEST['content']).'&Relatiedetails='.urlencode($Relatiedetails->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['Relatiedetails'])){
    if(!$del || !delRelatiedetails($_REQUEST['Relatiedetails']))
      $Relatiedetails = readRelatiedetails($_REQUEST['Relatiedetails']);
    else $Relatiedetails = false; // delete was a succes!
  } else if($new) $Relatiedetails = new Relatiedetails();
  else $Relatiedetails = false;
  if($Relatiedetails){
    writeHead("<TITLE>Relatiedetails - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $Relatiedetails->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($Relatiedetails->getId()).'" /></P>';
    else echo '<H1>'.display('Relation','display',$Relatiedetails->getId()).'</H1>';
    ?>
    <DIV class="Floater uitleg">
      <DIV class="FloaterHeader">uitleg</DIV>
      <DIV class="FloaterContent"><?php
          $uitleg = $Relatiedetails->get_uitleg();
          if (isset($uitleg)){
            $uitleg=$uitleg;
            echo '<DIV CLASS="item UI_uitleg" ID="0">';
            echo '</DIV>';
            if(isset($uitleg)){
              echo htmlspecialchars($uitleg);
            }
          } else echo '<DIV CLASS="new UI_uitleg" ID="0"><I>Nothing</I></DIV>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater cardinaliteitseigenschappen">
      <DIV class="FloaterHeader">cardinaliteitseigenschappen</DIV>
      <DIV class="FloaterContent"><?php
          $cardinaliteitseigenschappen = $Relatiedetails->get_cardinaliteitseigenschappen();
          echo '
          <UL>';
          foreach($cardinaliteitseigenschappen as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_cardinaliteitseigenschappen" ID="1.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule2', array('Rule2'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'eigenschap: ';
                echo '<SPAN CLASS="item UI_cardinaliteitseigenschappen_eigenschap" ID="1.'.$i0.'.0">';
                  $v0['eigenschap']=$v0['eigenschap'];
                echo htmlspecialchars($v0['eigenschap']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'afgeleide regel: ';
                echo '<SPAN CLASS="item UI_cardinaliteitseigenschappen_afgeleideregel" ID="1.'.$i0.'.1">';
                  $v0['afgeleide regel']=$v0['afgeleide regel'];
                echo htmlspecialchars($v0['afgeleide regel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'wordt overtreden door: ';
                echo '
                <UL>';
                foreach($v0['wordt overtreden door'] as $i1=>$idwordtovertredendoor){
                  $wordtovertredendoor=$idwordtovertredendoor;
                  echo '
                  <LI CLASS="item UI_cardinaliteitseigenschappen_wordtovertredendoor" ID="1.'.$i0.'.2.'.$i1.'">';
                
                    echo htmlspecialchars($wordtovertredendoor);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cardinaliteitseigenschappen_wordtovertredendoor" ID="1.'.$i0.'.2.'.count($v0['wordt overtreden door']).'">new wordt overtreden door</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cardinaliteitseigenschappen" ID="1.'.count($cardinaliteitseigenschappen).'">new cardinaliteitseigenschappen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in cardinaliteitseigenschappen
      function UI_cardinaliteitseigenschappen(id){
        return '<DIV>eigenschap: <SPAN CLASS="item UI_cardinaliteitseigenschappen_eigenschap" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>afgeleide regel: <SPAN CLASS="item UI_cardinaliteitseigenschappen_afgeleideregel" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>wordt overtreden door: <UL><LI CLASS="new UI_cardinaliteitseigenschappen_wordtovertredendoor" ID="'+id+'.2">new wordt overtreden door</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater homogene eigenschappen">
      <DIV class="FloaterHeader">homogene eigenschappen</DIV>
      <DIV class="FloaterContent"><?php
          $homogeneeigenschappen = $Relatiedetails->get_homogeneeigenschappen();
          echo '
          <UL>';
          foreach($homogeneeigenschappen as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_homogeneeigenschappen" ID="2.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule3', array('Rule3'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'eigenschap: ';
                echo '<SPAN CLASS="item UI_homogeneeigenschappen_eigenschap" ID="2.'.$i0.'.0">';
                  $v0['eigenschap']=$v0['eigenschap'];
                echo htmlspecialchars($v0['eigenschap']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'afgeleide regel: ';
                echo '<SPAN CLASS="item UI_homogeneeigenschappen_afgeleideregel" ID="2.'.$i0.'.1">';
                  $v0['afgeleide regel']=$v0['afgeleide regel'];
                echo htmlspecialchars($v0['afgeleide regel']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'wordt overtreden door: ';
                echo '
                <UL>';
                foreach($v0['wordt overtreden door'] as $i1=>$idwordtovertredendoor){
                  $wordtovertredendoor=$idwordtovertredendoor;
                  echo '
                  <LI CLASS="item UI_homogeneeigenschappen_wordtovertredendoor" ID="2.'.$i0.'.2.'.$i1.'">';
                
                    echo htmlspecialchars($wordtovertredendoor);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_homogeneeigenschappen_wordtovertredendoor" ID="2.'.$i0.'.2.'.count($v0['wordt overtreden door']).'">new wordt overtreden door</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_homogeneeigenschappen" ID="2.'.count($homogeneeigenschappen).'">new homogene eigenschappen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in homogene eigenschappen
      function UI_homogeneeigenschappen(id){
        return '<DIV>eigenschap: <SPAN CLASS="item UI_homogeneeigenschappen_eigenschap" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>afgeleide regel: <SPAN CLASS="item UI_homogeneeigenschappen_afgeleideregel" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>wordt overtreden door: <UL><LI CLASS="new UI_homogeneeigenschappen_wordtovertredendoor" ID="'+id+'.2">new wordt overtreden door</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater concepten">
      <DIV class="FloaterHeader">concepten</DIV>
      <DIV class="FloaterContent"><?php
          $concepten = $Relatiedetails->get_concepten();
          echo '
          <UL>';
          foreach($concepten as $i0=>$idv0){
            $v0=display('Concept','display',$idv0);
            echo '
            <LI CLASS="item UI_concepten" ID="3.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_concepten" ID="3.'.count($concepten).'">new concepten</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater toepassing in regels">
      <DIV class="FloaterHeader">toepassing in regels</DIV>
      <DIV class="FloaterContent"><?php
          $toepassinginregels = $Relatiedetails->get_toepassinginregels();
          echo '
          <UL>';
          foreach($toepassinginregels as $i0=>$idv0){
            $v0=display('UserRule','display',$idv0);
            echo '
            <LI CLASS="item UI_toepassinginregels" ID="4.'.$i0.'">';
          
              if(!$edit) echo '
              <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idv0))).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_toepassinginregels" ID="4.'.count($toepassinginregels).'">new toepassing in regels</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater pattern">
      <DIV class="FloaterHeader">pattern</DIV>
      <DIV class="FloaterContent"><?php
          $pattern = $Relatiedetails->get_pattern();
          echo '<SPAN CLASS="item UI_pattern" ID="5">';
            $displaypattern=display('Pattern','display',$pattern);
          if(!$edit) echo '
          <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($pattern))).'">'.htmlspecialchars($displaypattern).'</A>';
          else echo htmlspecialchars($displaypattern);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater populatie">
      <DIV class="FloaterHeader">populatie</DIV>
      <DIV class="FloaterContent"><?php
          $populatie = $Relatiedetails->get_populatie();
          echo '
          <UL>';
          foreach($populatie as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_populatie" ID="6.'.$i0.'">';
          
              echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_populatie" ID="6.'.count($populatie).'">new populatie</LI>';
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
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1','".urlencode($Relatiedetails->getId())."');","Save");
       $buttons.=ifaceButton(serviceref($_REQUEST['content'], array('Relatiedetails'=>urlencode($Relatiedetails->getId()) )),"Cancel");
     } 
  } else {
          $buttons=$buttons;
          $buttons=$buttons;
         }
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The Relatiedetails is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No Relatiedetails object selected - Atlas - ADL Prototype</TITLE>");
      ?><i>No Relatiedetails object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>