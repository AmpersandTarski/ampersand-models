<?php // generated with ADL vs. 0.8.10-529
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
  require "ISArelations.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $ISarelations=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $ISarelations[$i0] = array( 'id' => @$r['0.'.$i0.'']
                                , 'IS-a relation' => @$r['0.'.$i0.'.0']
                                , 'specific' => @$r['0.'.$i0.'.1']
                                , 'isa' => @$r['0.'.$i0.'.2']
                                , 'pattern' => @$r['0.'.$i0.'.3']
                                );
    }
    $ISArelations=new ISArelations($ISarelations);
    if($ISArelations->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $ISArelations=new ISArelations();
    writeHead("<TITLE>ISArelations - Atlas - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>ISArelations</H1>
    <DIV class="Floater IS-a relations">
      <DIV class="FloaterHeader">IS-a relations</DIV>
      <DIV class="FloaterContent"><?php
          $ISarelations = $ISArelations->get_ISarelations();
          echo '
          <UL>';
          foreach($ISarelations as $i0=>$idv0){
            $v0=$idv0;
          
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              echo '
              <DIV>';
                echo 'IS-a relation: ';
                echo '<SPAN CLASS="item UIISarelation" ID="0.'.$i0.'.0">';
                  $v0['IS-a relation']=$v0['IS-a relation'];
                echo htmlspecialchars($v0['IS-a relation']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'specific: ';
                echo '<SPAN CLASS="item UIspecific" ID="0.'.$i0.'.1">';
                  $displayv0['specific']=display('Concept','display',$v0['specific']);
                if(!$edit) echo '
                <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($v0['specific']))).'">'.htmlspecialchars($displayv0['specific']).'</A>';
                else echo htmlspecialchars($displayv0['specific']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'isa: ';
                echo '<SPAN CLASS="item UIisa" ID="0.'.$i0.'.2">';
                  $displayv0['isa']=display('Concept','display',$v0['isa']);
                if(!$edit) echo '
                <A HREF="'.serviceref('Concept', array('Concept'=>urlencode($v0['isa']))).'">'.htmlspecialchars($displayv0['isa']).'</A>';
                else echo htmlspecialchars($displayv0['isa']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'pattern: ';
                echo '<SPAN CLASS="item UIpattern" ID="0.'.$i0.'.3">';
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
            <LI CLASS="new UI" ID="0.'.count($ISarelations).'">new IS-a relations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in IS-a relations
      function UI(id){
        return '<DIV>IS-a relation: <SPAN CLASS="item UI_ISarelation" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>specific: <SPAN CLASS="item UI_specific" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>isa: <SPAN CLASS="item UI_isa" ID="'+id+'.2"></SPAN></DIV>'
             + '<DIV>pattern: <SPAN CLASS="item UI_pattern" ID="'+id+'.3"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton(serviceref($_REQUEST['content'])."&edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".serviceref($_REQUEST['content'])."&save=1');","Save")
             .ifaceButton(serviceref($_REQUEST['content']),"Cancel");
  writeTail($buttons);
?>