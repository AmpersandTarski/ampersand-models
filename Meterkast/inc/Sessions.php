<?php // generated with ADL vs. 1.1-647
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
  require "Sessions.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Session=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Session[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                           , 'id' => @$r['0.'.$i0.'.0']
                           , 'ip' => @$r['0.'.$i0.'.1']
                           , 'file' => @$r['0.'.$i0.'.2']
                           );
    }
    $Sessions=new Sessions($Session);
    if($Sessions->save()!==false) die('ok:'.serviceref($_REQUEST['content'])); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Sessions=new Sessions();
    writeHead("<TITLE>Sessions - Meterkast - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="js/edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="js/navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Sessions</H1>
    <DIV class="Floater Session">
      <DIV class="FloaterHeader">Session</DIV>
      <DIV class="FloaterContent"><?php
          $Session = $Sessions->get_Session();
          echo '
          <UL>';
          foreach($Session as $i0=>$idv0){
            $v0=$idv0;
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
          
              if(!$edit){
                echo '
              <A HREF="'.serviceref('Session', array('Session'=>urlencode($idv0['id']))).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'id: ';
                echo '<SPAN CLASS="item UIid" ID="0.'.$i0.'.0">';
                  $v0['id']=$v0['id'];
                echo htmlspecialchars($v0['id']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'ip: ';
                echo '<SPAN CLASS="item UIip" ID="0.'.$i0.'.1">';
                  $v0['ip']=$v0['ip'];
                echo htmlspecialchars($v0['ip']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'file: ';
                if (isset($v0['file'])){
                  $v0['file']=$v0['file'];
                  echo '<DIV CLASS="item UIfile" ID="0.'.$i0.'.2">';
                  echo '</DIV>';
                  if(isset($v0['file'])){
                    if(!$edit) echo '
                    <A HREF="'.serviceref('Bestand', array('Bestand'=>urlencode($v0['file']))).'">'.htmlspecialchars($v0['file']).'</A>';
                    else echo htmlspecialchars($v0['file']);
                  }
                } else echo '<DIV CLASS="new UIfile" ID="0.'.$i0.'.2"><I>Nothing</I></DIV>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Session).'">new Session</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Session
      function UI(id){
        return '<DIV>id: <SPAN CLASS="item UI_id" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>ip: <SPAN CLASS="item UI_ip" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>file: <DIV CLASS="new UI_file" ID="'+id+'.2"><I>Nothing</I></DIV></DIV>'
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