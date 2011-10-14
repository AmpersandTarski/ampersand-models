<?php // generated with ADL vs. 1.1-646
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
  require "Overzicht.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Patternlijst=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Patternlijst[$i0] = array( 'id' => @$r['0.'.$i0.'']
                                );
      $Patternlijst[$i0]['regels die overtreden worden']=array();
      for($i1=0;isset($r['0.'.$i0.'.0.'.$i1]);$i1++){
        $Patternlijst[$i0]['regels die overtreden worden'][$i1] = @$r['0.'.$i0.'.0.'.$i1.''];
      }
      $Patternlijst[$i0]['relaties waarvan een eigenschap overtreden wordt']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Patternlijst[$i0]['relaties waarvan een eigenschap overtreden wordt'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $Overzicht=new Overzicht($Patternlijst);
    if($Overzicht->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Overzicht=new Overzicht();
    writeHead("<TITLE>Overzicht - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Overzicht</H1>
    <DIV class="Floater Patternlijst">
      <DIV class="FloaterHeader">Patternlijst</DIV>
      <DIV class="FloaterContent"><?php
          $Patternlijst = $Overzicht->get_Patternlijst();
          echo '
          <UL>';
          foreach($Patternlijst as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
            echo display('Pattern','display',$idv0['id']);
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Pattern', array('Pattern'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'regels die overtreden worden: ';
                echo '
                <UL>';
                foreach($v0['regels die overtreden worden'] as $i1=>$idregelsdieovertredenworden){
                  $regelsdieovertredenworden=display('UserRule','display',$idregelsdieovertredenworden);
                  echo '
                  <LI CLASS="item UIregelsdieovertredenworden" ID="0.'.$i0.'.0.'.$i1.'">';
                
                    if(!$edit) echo '
                    <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idregelsdieovertredenworden))).'">'.htmlspecialchars($regelsdieovertredenworden).'</A>';
                    else echo htmlspecialchars($regelsdieovertredenworden);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIregelsdieovertredenworden" ID="0.'.$i0.'.0.'.count($v0['regels die overtreden worden']).'">new regels die overtreden worden</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'relaties waarvan een eigenschap overtreden wordt: ';
                echo '
                <UL>';
                foreach($v0['relaties waarvan een eigenschap overtreden wordt'] as $i1=>$idrelatieswaarvaneeneigenschapovertredenwordt){
                  $relatieswaarvaneeneigenschapovertredenwordt=display('Relation','display',$idrelatieswaarvaneeneigenschapovertredenwordt);
                  echo '
                  <LI CLASS="item UIrelatieswaarvaneeneigenschapovertredenwordt" ID="0.'.$i0.'.1.'.$i1.'">';
                
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($relatieswaarvaneeneigenschapovertredenwordt).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($idrelatieswaarvaneeneigenschapovertredenwordt))).'">Relatiedetails</A></LI>';
                      echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($idrelatieswaarvaneeneigenschapovertredenwordt))).'">Populatie</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($relatieswaarvaneeneigenschapovertredenwordt);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrelatieswaarvaneeneigenschapovertredenwordt" ID="0.'.$i0.'.1.'.count($v0['relaties waarvan een eigenschap overtreden wordt']).'">new relaties waarvan een eigenschap overtreden wordt</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Patternlijst).'">new Patternlijst</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Patternlijst
      function UI(id){
        return '<DIV>regels die overtreden worden: <UL><LI CLASS="new UI_regelsdieovertredenworden" ID="'+id+'.0">new regels die overtreden worden</LI></UL></DIV>'
             + '<DIV>relaties waarvan een eigenschap overtreden wordt: <UL><LI CLASS="new UI_relatieswaarvaneeneigenschapovertredenwordt" ID="'+id+'.1">new relaties waarvan een eigenschap overtreden wordt</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';

    include_once "Concepten.inc.php";
    include_once "Relaties.inc.php";
    include_once "Regels.inc.php";
    $cs = new Concepten();
    $res = new Relaties();
    $rus = new Regels();
    $cpts = count($cs->get_Conceptenlijst());
    $rels = count($res->get_Relatielijst());
    $ruls = count($rus->get_Regellijst());
    echo "<DIV class='Floater ctxinfo'>";
    echo "  <DIV class='FloaterHeader'>";
    echo "  <DIV class='FloaterContent'>aantal relaties : ". $rels."</DIV>";
    echo "  <DIV class='FloaterContent'>aantal concepten: ". $cpts."</DIV>";
    echo "  <DIV class='FloaterContent'>aantal regels   : ". $ruls."</DIV>";
    echo "  </DIV>";
    echo "</DIV>";
	  
  if(!$edit) $buttons=$buttons;
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>
