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
  require "CoreDataUC001.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $plaintiff=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $plaintiff[$i0] = array( 'id' => @$r['0.'.$i0.'']
                             , 'party' => @$r['0.'.$i0.'.0']
                             );
      $plaintiff[$i0]['representative']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $plaintiff[$i0]['representative'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $defendant=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $defendant[$i0] = array( 'id' => @$r['1.'.$i0.'']
                             , 'party' => @$r['1.'.$i0.'.0']
                             );
      $defendant[$i0]['representative']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $defendant[$i0]['representative'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $joinedparty=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $joinedparty[$i0] = array( 'id' => @$r['2.'.$i0.'']
                               , 'party' => @$r['2.'.$i0.'.0']
                               );
      $joinedparty[$i0]['representative']=array();
      for($i1=0;isset($r['2.'.$i0.'.1.'.$i1]);$i1++){
        $joinedparty[$i0]['representative'][$i1] = @$r['2.'.$i0.'.1.'.$i1.''];
      }
    }
    $areaoflaw = @$r['3'];
    $typeofcase = @$r['4'];
    $authorized=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $authorized[$i0] = @$r['5.'.$i0.''];
    }
    $caretakerofcasefile = @$r['6'];
    $casefile=array();
    for($i0=0;isset($r['7.'.$i0]);$i0++){
      $casefile[$i0] = array( 'id' => @$r['7.'.$i0.'.0']
                            , 'Document' => @$r['7.'.$i0.'.0']
                            , 'type' => @$r['7.'.$i0.'.1']
                            );
    }
    $cluster=array();
    for($i0=0;isset($r['8.'.$i0]);$i0++){
      $cluster[$i0] = array( 'id' => @$r['8.'.$i0.'.0']
                           , 'name' => @$r['8.'.$i0.'.0']
                           );
      $cluster[$i0]['base']=array();
      for($i1=0;isset($r['8.'.$i0.'.1.'.$i1]);$i1++){
        $cluster[$i0]['base'][$i1] = @$r['8.'.$i0.'.1.'.$i1.''];
      }
    }
    $authorizationdocuments=array();
    for($i0=0;isset($r['9.'.$i0]);$i0++){
      $authorizationdocuments[$i0] = array( 'id' => @$r['9.'.$i0.'.0']
                                          , 'document' => @$r['9.'.$i0.'.0']
                                          , 'represented' => @$r['9.'.$i0.'.1']
                                          );
      $authorizationdocuments[$i0]['representative']=array();
      for($i1=0;isset($r['9.'.$i0.'.2.'.$i1]);$i1++){
        $authorizationdocuments[$i0]['representative'][$i1] = @$r['9.'.$i0.'.2.'.$i1.''];
      }
    }
    $CoreDataUC001=new CoreDataUC001($ID,$plaintiff, $defendant, $joinedparty, $areaoflaw, $typeofcase, $authorized, $caretakerofcasefile, $casefile, $cluster, $authorizationdocuments);
    if($CoreDataUC001->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?CoreDataUC001='.urlencode($CoreDataUC001->getId())); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['CoreDataUC001'])){
    if(!$del || !delCoreDataUC001($_REQUEST['CoreDataUC001']))
      $CoreDataUC001 = readCoreDataUC001($_REQUEST['CoreDataUC001']);
    else $CoreDataUC001 = false; // delete was a succes!
  } else if($new) $CoreDataUC001 = new CoreDataUC001();
  else $CoreDataUC001 = false;
  if($CoreDataUC001){
    writeHead("<TITLE>CoreDataUC001 - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $CoreDataUC001->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($CoreDataUC001->getId()).'" /></P>';
    else echo '<H1>'.$CoreDataUC001->getId().'</H1>';
    ?>
    <DIV class="Floater plaintiff">
      <DIV class="FloaterHeader">plaintiff</DIV>
      <DIV class="FloaterContent"><?php
          $plaintiff = $CoreDataUC001->get_plaintiff();
          echo '
          <UL>';
          foreach($plaintiff as $i0=>$v0){
            echo '
            <LI CLASS="item UI_plaintiff" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Authorization.php?Authorization='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'party: ';
                echo '<SPAN CLASS="item UI_plaintiff_party" ID="0.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.0">';
                  echo htmlspecialchars($v0['party']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['party']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['party']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['party']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['party']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UI_plaintiff_representative" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($representative).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_plaintiff_representative" ID="0.'.$i0.'.1.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_plaintiff" ID="0.'.count($plaintiff).'">new plaintiff</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in plaintiff
      function UI_plaintiff(id){
        return '<DIV>party: <SPAN CLASS="item UI_plaintiff_party" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_plaintiff_representative" ID="'+id+'.1">new representative</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater defendant">
      <DIV class="FloaterHeader">defendant</DIV>
      <DIV class="FloaterContent"><?php
          $defendant = $CoreDataUC001->get_defendant();
          echo '
          <UL>';
          foreach($defendant as $i0=>$v0){
            echo '
            <LI CLASS="item UI_defendant" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Authorization.php?Authorization='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'party: ';
                echo '<SPAN CLASS="item UI_defendant_party" ID="1.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.0">';
                  echo htmlspecialchars($v0['party']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['party']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['party']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['party']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['party']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UI_defendant_representative" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To1.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($representative).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_defendant_representative" ID="1.'.$i0.'.1.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_defendant" ID="1.'.count($defendant).'">new defendant</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in defendant
      function UI_defendant(id){
        return '<DIV>party: <SPAN CLASS="item UI_defendant_party" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_defendant_representative" ID="'+id+'.1">new representative</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater joined party">
      <DIV class="FloaterHeader">joined party</DIV>
      <DIV class="FloaterContent"><?php
          $joinedparty = $CoreDataUC001->get_joinedparty();
          echo '
          <UL>';
          foreach($joinedparty as $i0=>$v0){
            echo '
            <LI CLASS="item UI_joinedparty" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Authorization.php?Authorization='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'party: ';
                echo '<SPAN CLASS="item UI_joinedparty_party" ID="2.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To2.'.$i0.'.0">';
                  echo htmlspecialchars($v0['party']).'</A>';
                  echo '<DIV class="Goto" id="GoTo2.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['party']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['party']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['party']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['party']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UI_joinedparty_representative" ID="2.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To2.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo2.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($representative).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_joinedparty_representative" ID="2.'.$i0.'.1.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_joinedparty" ID="2.'.count($joinedparty).'">new joined party</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in joined party
      function UI_joinedparty(id){
        return '<DIV>party: <SPAN CLASS="item UI_joinedparty_party" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_joinedparty_representative" ID="'+id+'.1">new representative</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater area of law">
      <DIV class="FloaterHeader">area of law</DIV>
      <DIV class="FloaterContent"><?php
          $areaoflaw = $CoreDataUC001->get_areaoflaw();
          echo '<SPAN CLASS="item UI_areaoflaw" ID="3">';
          if(!$edit) echo '
          <A HREF="AreaOfLaw.php?AreaOfLaw='.urlencode($areaoflaw).'">'.htmlspecialchars($areaoflaw).'</A>';
          else echo htmlspecialchars($areaoflaw);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater type of case">
      <DIV class="FloaterHeader">type of case</DIV>
      <DIV class="FloaterContent"><?php
          $typeofcase = $CoreDataUC001->get_typeofcase();
          echo '<SPAN CLASS="item UI_typeofcase" ID="4">';
          if(!$edit) echo '
          <A HREF="CaseType.php?CaseType='.urlencode($typeofcase).'">'.htmlspecialchars($typeofcase).'</A>';
          else echo htmlspecialchars($typeofcase);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater authorized">
      <DIV class="FloaterHeader">authorized</DIV>
      <DIV class="FloaterContent"><?php
          $authorized = $CoreDataUC001->get_authorized();
          echo '
          <UL>';
          foreach($authorized as $i0=>$v0){
            echo '
            <LI CLASS="item UI_authorized" ID="5.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Court.php?Court='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_authorized" ID="5.'.count($authorized).'">new authorized</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater caretaker of case file">
      <DIV class="FloaterHeader">caretaker of case file</DIV>
      <DIV class="FloaterContent"><?php
          $caretakerofcasefile = $CoreDataUC001->get_caretakerofcasefile();
          echo '<SPAN CLASS="item UI_caretakerofcasefile" ID="6">';
          if(!$edit) echo '
          <A HREF="Organ.php?Organ='.urlencode($caretakerofcasefile).'">'.htmlspecialchars($caretakerofcasefile).'</A>';
          else echo htmlspecialchars($caretakerofcasefile);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater case file">
      <DIV class="FloaterHeader">case file</DIV>
      <DIV class="FloaterContent"><?php
          $casefile = $CoreDataUC001->get_casefile();
          echo '
          <UL>';
          foreach($casefile as $i0=>$v0){
            echo '
            <LI CLASS="item UI_casefile" ID="7.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To7.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo7.'.$i0.'"><UL>';
                echo '<LI><A HREF="Letter.php?Letter='.urlencode($v0['id']).'">Letter</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UI_casefile_Document" ID="7.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_casefile_type" ID="7.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="DocumentType.php?DocumentType='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="7.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_casefile" ID="7.'.count($casefile).'">new case file</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in case file
      function UI_casefile(id){
        return '<DIV>Document: <SPAN CLASS="item UI_casefile_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_casefile_type" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater cluster">
      <DIV class="FloaterHeader">cluster</DIV>
      <DIV class="FloaterContent"><?php
          $cluster = $CoreDataUC001->get_cluster();
          echo '
          <UL>';
          foreach($cluster as $i0=>$v0){
            echo '
            <LI CLASS="item UI_cluster" ID="8.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Cluster.php?Cluster='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'name: ';
                echo '<SPAN CLASS="item UI_cluster_name" ID="8.'.$i0.'.0">';
                echo htmlspecialchars($v0['name']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'base: ';
                echo '
                <UL>';
                foreach($v0['base'] as $i1=>$base){
                  echo '
                  <LI CLASS="item UI_cluster_base" ID="8.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($base);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cluster_base" ID="8.'.$i0.'.1.'.count($v0['base']).'">new base</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="8.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_cluster" ID="8.'.count($cluster).'">new cluster</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in cluster
      function UI_cluster(id){
        return '<DIV>name: <SPAN CLASS="item UI_cluster_name" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>base: <UL><LI CLASS="new UI_cluster_base" ID="'+id+'.1">new base</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater authorization documents">
      <DIV class="FloaterHeader">authorization documents</DIV>
      <DIV class="FloaterContent"><?php
          $authorizationdocuments = $CoreDataUC001->get_authorizationdocuments();
          echo '
          <UL>';
          foreach($authorizationdocuments as $i0=>$v0){
            echo '
            <LI CLASS="item UI_authorizationdocuments" ID="9.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Authorization.php?Authorization='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'document: ';
                echo '<SPAN CLASS="item UI_authorizationdocuments_document" ID="9.'.$i0.'.0">';
                echo htmlspecialchars($v0['document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'represented: ';
                echo '<SPAN CLASS="item UI_authorizationdocuments_represented" ID="9.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To9.'.$i0.'.1">';
                  echo htmlspecialchars($v0['represented']).'</A>';
                  echo '<DIV class="Goto" id="GoTo9.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($v0['represented']).'">Magistrate</A></LI>';
                  echo '<LI><A HREF="Party.php?Party='.urlencode($v0['represented']).'">Party</A></LI>';
                  echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($v0['represented']).'">InterestedParty</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['represented']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'representative: ';
                echo '
                <UL>';
                foreach($v0['representative'] as $i1=>$representative){
                  echo '
                  <LI CLASS="item UI_authorizationdocuments_representative" ID="9.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To9.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($representative).'</A>';
                      echo '<DIV class="Goto" id="GoTo9.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Magistrate.php?Magistrate='.urlencode($representative).'">Magistrate</A></LI>';
                      echo '<LI><A HREF="Party.php?Party='.urlencode($representative).'">Party</A></LI>';
                      echo '<LI><A HREF="InterestedParty.php?InterestedParty='.urlencode($representative).'">InterestedParty</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($representative);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_authorizationdocuments_representative" ID="9.'.$i0.'.2.'.count($v0['representative']).'">new representative</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="9.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_authorizationdocuments" ID="9.'.count($authorizationdocuments).'">new authorization documents</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in authorization documents
      function UI_authorizationdocuments(id){
        return '<DIV>document: <SPAN CLASS="item UI_authorizationdocuments_document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>represented: <SPAN CLASS="item UI_authorizationdocuments_represented" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>representative: <UL><LI CLASS="new UI_authorizationdocuments_representative" ID="'+id+'.2">new representative</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
   if($del) echo "<P><I>Delete failed</I></P>";
   if($edit){
     if($new) 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1',document.forms[0].ID.value);","Save");
     else { 
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($CoreDataUC001->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?CoreDataUC001=".urlencode($CoreDataUC001->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&CoreDataUC001=".urlencode($CoreDataUC001->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&CoreDataUC001=".urlencode($CoreDataUC001->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The CoreDataUC001 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No CoreDataUC001 object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No CoreDataUC001 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>