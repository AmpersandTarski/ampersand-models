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
  require "ISArelaties.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $ISarelaties=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $ISarelaties[$i0] = array( 'id' => @$r['0.'.$i0.'']
                               , 'het specifieke concept' => @$r['0.'.$i0.'.0']
                               , 'is een' => @$r['0.'.$i0.'.1']
                               , 'pattern' => @$r['0.'.$i0.'.2']
                               );
    }
    $ISArelaties=new ISArelaties($ISarelaties);
    if($ISArelaties->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $ISArelaties=new ISArelaties();
    writeHead("<TITLE>ISArelaties - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>ISArelaties</H1>
    <DIV class="Floater IS-a relaties">
      <DIV class="FloaterHeader">IS-a relaties</DIV>
      <DIV class="FloaterContent"><?php
          $ISarelaties = $ISArelaties->get_ISarelaties();
          echo '
          <UL>';
          foreach($ISarelaties as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
            echo display('IsaRelation','display',$idv0['id']);
              echo '
              <DIV>';
                echo 'het specifieke concept: ';
                echo '<SPAN CLASS="item UIhetspecifiekeconcept" ID="0.'.$i0.'.0">';
                  $displayv0['het specifieke concept']=display('Concept','display',$v0['het specifieke concept']);
                if(!$edit) echo '
                <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($v0['het specifieke concept']))).'">'.htmlspecialchars($displayv0['het specifieke concept']).'</A>';
                else echo htmlspecialchars($displayv0['het specifieke concept']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'is een: ';
                echo '<SPAN CLASS="item UIiseen" ID="0.'.$i0.'.1">';
                  $displayv0['is een']=display('Concept','display',$v0['is een']);
                if(!$edit) echo '
                <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($v0['is een']))).'">'.htmlspecialchars($displayv0['is een']).'</A>';
                else echo htmlspecialchars($displayv0['is een']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'pattern: ';
                echo '<SPAN CLASS="item UIpattern" ID="0.'.$i0.'.2">';
                  $v0['pattern']=$v0['pattern'];
                echo htmlspecialchars($v0['pattern']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($ISarelaties).'">new IS-a relaties</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in IS-a relaties
      function UI(id){
        return '<DIV>het specifieke concept: <SPAN CLASS="item UI_hetspecifiekeconcept" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>is een: <SPAN CLASS="item UI_iseen" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>pattern: <SPAN CLASS="item UI_pattern" ID="'+id+'.2"></SPAN></DIV>'
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