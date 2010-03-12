<?php // generated with ADL vs. 1.1-632
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
  require "Overtredingen.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $deregel=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $deregel[$i0] = array( 'id' => @$r['0.'.$i0.'']
                           );
      $deregel[$i0]['wordt overtreden door']=array();
      for($i1=0;isset($r['0.'.$i0.'.0.'.$i1]);$i1++){
        $deregel[$i0]['wordt overtreden door'][$i1] = @$r['0.'.$i0.'.0.'.$i1.''];
      }
    }
    $decardinaliteitseigenschap=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $decardinaliteitseigenschap[$i0] = array( 'id' => @$r['1.'.$i0.'']
                                              , 'eigenschap' => @$r['1.'.$i0.'.0']
                                              , 'van relatie' => @$r['1.'.$i0.'.1']
                                              );
      $decardinaliteitseigenschap[$i0]['wordt overtreden door']=array();
      for($i1=0;isset($r['1.'.$i0.'.2.'.$i1]);$i1++){
        $decardinaliteitseigenschap[$i0]['wordt overtreden door'][$i1] = @$r['1.'.$i0.'.2.'.$i1.''];
      }
    }
    $dehomogeneeigenschap=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $dehomogeneeigenschap[$i0] = array( 'id' => @$r['2.'.$i0.'']
                                        , 'eigenschap' => @$r['2.'.$i0.'.0']
                                        , 'van relatie' => @$r['2.'.$i0.'.1']
                                        );
      $dehomogeneeigenschap[$i0]['wordt overtreden door']=array();
      for($i1=0;isset($r['2.'.$i0.'.2.'.$i1]);$i1++){
        $dehomogeneeigenschap[$i0]['wordt overtreden door'][$i1] = @$r['2.'.$i0.'.2.'.$i1.''];
      }
    }
    $Overtredingen=new Overtredingen($deregel, $decardinaliteitseigenschap, $dehomogeneeigenschap);
    if($Overtredingen->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Overtredingen=new Overtredingen();
    writeHead("<TITLE>Overtredingen - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Overtredingen</H1>
    <DIV class="Floater de regel">
      <DIV class="FloaterHeader">de regel</DIV>
      <DIV class="FloaterContent"><?php
          $deregel = $Overtredingen->get_deregel();
          echo '
          <UL>';
          foreach($deregel as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_deregel" ID="0.'.$i0.'">';
            echo display('UserRule','display',$idv0['id']);
              if(!$edit){
                echo '
              <A HREF="'.serviceref('UserRule', array('UserRule'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'wordt overtreden door: ';
                echo '
                <UL>';
                foreach($v0['wordt overtreden door'] as $i1=>$idwordtovertredendoor){
                  $wordtovertredendoor=$idwordtovertredendoor;
                  echo '
                  <LI CLASS="item UI_deregel" ID="0.'.$i0.'.0.'.$i1.'">';
                
                    echo htmlspecialchars($wordtovertredendoor);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_deregel" ID="0.'.$i0.'.0.'.count($v0['wordt overtreden door']).'">new wordt overtreden door</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_deregel" ID="0.'.count($deregel).'">new de regel</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in de regel
      function UI_deregel(id){
        return '<DIV>wordt overtreden door: <UL><LI CLASS="new UI_deregel_wordtovertredendoor" ID="'+id+'.0">new wordt overtreden door</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater de cardinaliteitseigenschap">
      <DIV class="FloaterHeader">de cardinaliteitseigenschap</DIV>
      <DIV class="FloaterContent"><?php
          $decardinaliteitseigenschap = $Overtredingen->get_decardinaliteitseigenschap();
          echo '
          <UL>';
          foreach($decardinaliteitseigenschap as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_decardinaliteitseigenschap" ID="1.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule2', array('Rule2'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'eigenschap: ';
                echo '<SPAN CLASS="item UI_decardinaliteitseigenschap_eigenschap" ID="1.'.$i0.'.0">';
                  $v0['eigenschap']=$v0['eigenschap'];
                echo htmlspecialchars($v0['eigenschap']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van relatie: ';
                echo '<SPAN CLASS="item UI_decardinaliteitseigenschap_vanrelatie" ID="1.'.$i0.'.1">';
                  $displayv0['van relatie']=display('Relation','display',$v0['van relatie']);
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.1">';
                  echo htmlspecialchars($displayv0['van relatie']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($v0['van relatie']))).'">Relatiedetails</A></LI>';
                  echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($v0['van relatie']))).'">Populatie</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($displayv0['van relatie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'wordt overtreden door: ';
                echo '
                <UL>';
                foreach($v0['wordt overtreden door'] as $i1=>$idwordtovertredendoor){
                  $wordtovertredendoor=$idwordtovertredendoor;
                  echo '
                  <LI CLASS="item UI_decardinaliteitseigenschap_wordtovertredendoor" ID="1.'.$i0.'.2.'.$i1.'">';
                
                    echo htmlspecialchars($wordtovertredendoor);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_decardinaliteitseigenschap_wordtovertredendoor" ID="1.'.$i0.'.2.'.count($v0['wordt overtreden door']).'">new wordt overtreden door</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_decardinaliteitseigenschap" ID="1.'.count($decardinaliteitseigenschap).'">new de cardinaliteitseigenschap</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in de cardinaliteitseigenschap
      function UI_decardinaliteitseigenschap(id){
        return '<DIV>eigenschap: <SPAN CLASS="item UI_decardinaliteitseigenschap_eigenschap" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>van relatie: <SPAN CLASS="item UI_decardinaliteitseigenschap_vanrelatie" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>wordt overtreden door: <UL><LI CLASS="new UI_decardinaliteitseigenschap_wordtovertredendoor" ID="'+id+'.2">new wordt overtreden door</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater de homogene eigenschap">
      <DIV class="FloaterHeader">de homogene eigenschap</DIV>
      <DIV class="FloaterContent"><?php
          $dehomogeneeigenschap = $Overtredingen->get_dehomogeneeigenschap();
          echo '
          <UL>';
          foreach($dehomogeneeigenschap as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI_dehomogeneeigenschap" ID="2.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Rule3', array('Rule3'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'eigenschap: ';
                echo '<SPAN CLASS="item UI_dehomogeneeigenschap_eigenschap" ID="2.'.$i0.'.0">';
                  $v0['eigenschap']=$v0['eigenschap'];
                echo htmlspecialchars($v0['eigenschap']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'van relatie: ';
                echo '<SPAN CLASS="item UI_dehomogeneeigenschap_vanrelatie" ID="2.'.$i0.'.1">';
                  $displayv0['van relatie']=display('Relation','display',$v0['van relatie']);
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To2.'.$i0.'.1">';
                  echo htmlspecialchars($displayv0['van relatie']).'</A>';
                  echo '<DIV class="Goto" id="GoTo2.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($v0['van relatie']))).'">Relatiedetails</A></LI>';
                  echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($v0['van relatie']))).'">Populatie</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($displayv0['van relatie']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'wordt overtreden door: ';
                echo '
                <UL>';
                foreach($v0['wordt overtreden door'] as $i1=>$idwordtovertredendoor){
                  $wordtovertredendoor=$idwordtovertredendoor;
                  echo '
                  <LI CLASS="item UI_dehomogeneeigenschap_wordtovertredendoor" ID="2.'.$i0.'.2.'.$i1.'">';
                
                    echo htmlspecialchars($wordtovertredendoor);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_dehomogeneeigenschap_wordtovertredendoor" ID="2.'.$i0.'.2.'.count($v0['wordt overtreden door']).'">new wordt overtreden door</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_dehomogeneeigenschap" ID="2.'.count($dehomogeneeigenschap).'">new de homogene eigenschap</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in de homogene eigenschap
      function UI_dehomogeneeigenschap(id){
        return '<DIV>eigenschap: <SPAN CLASS="item UI_dehomogeneeigenschap_eigenschap" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>van relatie: <SPAN CLASS="item UI_dehomogeneeigenschap_vanrelatie" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>wordt overtreden door: <UL><LI CLASS="new UI_dehomogeneeigenschap_wordtovertredendoor" ID="'+id+'.2">new wordt overtreden door</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons=$buttons;
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>