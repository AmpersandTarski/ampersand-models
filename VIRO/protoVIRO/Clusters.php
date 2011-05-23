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
  require "Clusters.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Clusters=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Clusters[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                            , 'nr' => @$r['0.'.$i0.'.0']
                            , 'name' => @$r['0.'.$i0.'.1']
                            );
      $Clusters[$i0]['cases']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Clusters[$i0]['cases'][$i1] = array( 'id' => @$r['0.'.$i0.'.2.'.$i1.'']
                                            , 'caretaker of case file' => @$r['0.'.$i0.'.2.'.$i1.'.0']
                                            , 'area of law' => @$r['0.'.$i0.'.2.'.$i1.'.1']
                                            , 'type of case' => @$r['0.'.$i0.'.2.'.$i1.'.2']
                                            );
      }
    }
    $Clusters=new Clusters($Clusters);
    if($Clusters->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Clusters=new Clusters();
    writeHead("<TITLE>Clusters - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Clusters</H1>
    <DIV class="Floater Clusters">
      <DIV class="FloaterHeader">Clusters</DIV>
      <DIV class="FloaterContent"><?php
          $Clusters = $Clusters->get_Clusters();
          echo '
          <UL>';
          foreach($Clusters as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Cluster.php?Cluster='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'nr: ';
                echo '<SPAN CLASS="item UInr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['nr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UIname" ID="0.'.$i0.'.1">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">cases</DIV>
                  <DIV class="HolderContent" name="cases"><?php
                      echo '
                      <UL>';
                      foreach($v0['cases'] as $i1=>$cases){
                        echo '
                        <LI CLASS="item UIcases" ID="0.'.$i0.'.2.'.$i1.'">';
                          if(!$edit){
                            echo '
                          <DIV class="GotoArrow" id="To0.'.$i0.'.2.'.$i1.'">&rArr;</DIV>';
                            echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.'.$i1.'"><UL>';
                            echo '<LI><A HREF="CoreDataUC001.php?CoreDataUC001='.urlencode($cases['id']).'">CoreDataUC001</A></LI>';
                            echo '<LI><A HREF="LegalCase.php?LegalCase='.urlencode($cases['id']).'">LegalCase</A></LI>';
                            echo '<LI><A HREF="newCase.php?newCase='.urlencode($cases['id']).'">newCase</A></LI>';
                            echo '</UL></DIV>';
                          }
                          echo '
                          <DIV>';
                            echo 'caretaker of case file: ';
                            echo '<SPAN CLASS="item UIcases_caretakerofcasefile" ID="0.'.$i0.'.2.'.$i1.'.0">';
                            if(!$edit) echo '
                            <A HREF="Organ.php?Organ='.urlencode($cases['caretaker of case file']).'">'.htmlspecialchars($cases['caretaker of case file']).'</A>';
                            else echo htmlspecialchars($cases['caretaker of case file']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'area of law: ';
                            echo '<SPAN CLASS="item UIcases_areaoflaw" ID="0.'.$i0.'.2.'.$i1.'.1">';
                            if(!$edit) echo '
                            <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($cases['area of law']).'">'.htmlspecialchars($cases['area of law']).'</A>';
                            else echo htmlspecialchars($cases['area of law']);
                            echo '</SPAN>';
                          echo '</DIV>
                          <DIV>';
                            echo 'type of case: ';
                            echo '<SPAN CLASS="item UIcases_typeofcase" ID="0.'.$i0.'.2.'.$i1.'.2">';
                            if(!$edit) echo '
                            <A HREF="CaseType.php?CaseType='.urlencode($cases['type of case']).'">'.htmlspecialchars($cases['type of case']).'</A>';
                            else echo htmlspecialchars($cases['type of case']);
                            echo '</SPAN>';
                          echo '
                          </DIV>';
                          if($edit) echo '
                          <INPUT TYPE="hidden" name="0.'.$i0.'.2.'.$i1.'.ID" VALUE="'.$cases['id'].'" />';
                        echo '</LI>';
                      }
                      if($edit) echo '
                        <LI CLASS="new UIcases" ID="0.'.$i0.'.2.'.count($v0['cases']).'">new cases</LI>';
                      echo '
                      </UL>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Clusters).'">new Clusters</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Clusters
      function UI(id){
        return '<DIV>nr: <SPAN CLASS="item UI_nr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>name: <SPAN CLASS="item UI_name" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>cases: <UL><LI CLASS="new UI_cases" ID="'+id+'.2">new cases</LI></UL></DIV>'
              ;
      }
      function UIcases(id){
        return '<DIV>caretaker of case file: <SPAN CLASS="item UIcases_caretakerofcasefile" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>area of law: <SPAN CLASS="item UIcases_areaoflaw" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>type of case: <SPAN CLASS="item UIcases_typeofcase" ID="'+id+'.2"></SPAN></DIV>'
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