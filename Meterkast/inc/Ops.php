<?php // generated with ADL vs. 0.8.10-408
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
  require "Ops.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Operations=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Operations[$i0] = array( 'id' => @$r['0.'.$i0.'']
                              , 'name' => @$r['0.'.$i0.'.0']
                              , 'call' => @$r['0.'.$i0.'.1']
                              );
    }
    $Ops=new Ops($Operations);
    if($Ops->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Ops=new Ops();
    writeHead("<TITLE>Ops - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Ops</H1>
    <DIV class="Floater">
      <DIV class="FloaterHeader">Operations</DIV>
      <DIV class="FloaterContent"><?php
          $Operations = $Ops->get_Operations();
          echo '
          <UL>';
          foreach($Operations as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Operatie.php?Operatie='.$v0['id'].'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UIname" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'call: ';
                echo '<SPAN CLASS="item UIcall" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['call']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Operations).'">new Operations</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Operations
      function UI(id){
        return '<DIV>name: <SPAN CLASS="item UI_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>call: <SPAN CLASS="item UI_call" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>