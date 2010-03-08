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
  require "Relaties.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Relatielijst=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Relatielijst[$i0] = array( 'id' => @$r['0.'.$i0.'']
                                , 'voorbeeld' => @$r['0.'.$i0.'.0']
                                );
    }
    $Relaties=new Relaties($Relatielijst);
    if($Relaties->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Relaties=new Relaties();
    writeHead("<TITLE>Relaties - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Relaties</H1>
    <DIV class="Floater Relatielijst">
      <DIV class="FloaterHeader">Relatielijst</DIV>
      <DIV class="FloaterContent"><?php
          $Relatielijst = $Relaties->get_Relatielijst();
          echo '
          <UL>';
          foreach($Relatielijst as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
            echo display('Relation','display',$idv0['id']);
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="'.serviceref('Relatiedetails', array('Relatiedetails'=>urlencode($idv0['id']))).'">Relatiedetails</A></LI>';
                echo '<LI><A HREF="'.serviceref('Populatie', array('Populatie'=>urlencode($idv0['id']))).'">Populatie</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'voorbeeld: ';
                echo '<SPAN CLASS="item UI" ID="0.'.$i0.'.0">';
                  $v0['voorbeeld']=$v0['voorbeeld'];
                echo htmlspecialchars($v0['voorbeeld']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Relatielijst).'">new Relatielijst</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Relatielijst
      function UI(id){
        return '<DIV>voorbeeld: <SPAN CLASS="item UI_voorbeeld" ID="'+id+'.0"></SPAN></DIV>'
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