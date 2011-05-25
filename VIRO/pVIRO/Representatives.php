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
  require "Representatives.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Representatives=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Representatives[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                                   , 'name' => @$r['0.'.$i0.'.0']
                                   , 'rol' => @$r['0.'.$i0.'.1']
                                   );
      $Representatives[$i0]['represents']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Representatives[$i0]['represents'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Representatives[$i0]['cases']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Representatives[$i0]['cases'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
    }
    $Representatives=new Representatives($Representatives);
    if($Representatives->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Representatives=new Representatives();
    writeHead("<TITLE>Representatives - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Representatives</H1>
    <DIV class="Floater Representatives">
      <DIV class="FloaterHeader">Representatives</DIV>
      <DIV class="FloaterContent"><?php
          $Representatives = $Representatives->get_Representatives();
          echo '
          <UL>';
          foreach($Representatives as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To0.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo0.'.$i0.'"><UL>';
                echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['id']).'">Magistrate</A></LI>';
                echo '<LI><A HREF="Party.php?Party='.urlencode($v0['id']).'">Party</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UIname" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'rol: ';
                echo '<SPAN CLASS="item UIrol" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['rol']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'represents: ';
                echo '
                <UL>';
                foreach($v0['represents'] as $i1=>$represents){
                  echo '
                  <LI CLASS="item UIrepresents" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($represents).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($represents).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($represents).'">Party</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($represents);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIrepresents" ID="0.'.$i0.'.2.'.count($v0['represents']).'">new represents</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'cases: ';
                echo '
                <UL>';
                foreach($v0['cases'] as $i1=>$cases){
                  echo '
                  <LI CLASS="item UIcases" ID="0.'.$i0.'.3.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="LegalCase.php?LegalCase='.urlencode($cases).'">'.htmlspecialchars($cases).'</A>';
                    else echo htmlspecialchars($cases);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIcases" ID="0.'.$i0.'.3.'.count($v0['cases']).'">new cases</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Representatives).'">new Representatives</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Representatives
      function UI(id){
        return '<DIV>name: <SPAN CLASS="item UI_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>rol: <SPAN CLASS="item UI_rol" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>represents: <UL><LI CLASS="new UI_represents" ID="'+id+'.2">new represents</LI></UL></DIV>'
             + '<DIV>cases: <UL><LI CLASS="new UI_cases" ID="'+id+'.3">new cases</LI></UL></DIV>'
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