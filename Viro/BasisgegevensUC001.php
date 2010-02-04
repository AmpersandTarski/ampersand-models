<?php // generated with ADL vs. 0.8.10-452
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
  require "BasisgegevensUC001.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    $ID=@$_REQUEST['ID'];
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $eiser=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $eiser[$i0] = array( 'id' => @$r['0.'.$i0.'']
                         , 'partij' => @$r['0.'.$i0.'.0']
                         );
      $eiser[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $eiser[$i0]['gemachtigde'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
    }
    $gedaagde=array();
    for($i0=0;isset($r['1.'.$i0]);$i0++){
      $gedaagde[$i0] = array( 'id' => @$r['1.'.$i0.'']
                            , 'partij' => @$r['1.'.$i0.'.0']
                            );
      $gedaagde[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['1.'.$i0.'.1.'.$i1]);$i1++){
        $gedaagde[$i0]['gemachtigde'][$i1] = @$r['1.'.$i0.'.1.'.$i1.''];
      }
    }
    $gevoegde=array();
    for($i0=0;isset($r['2.'.$i0]);$i0++){
      $gevoegde[$i0] = array( 'id' => @$r['2.'.$i0.'']
                            , 'partij' => @$r['2.'.$i0.'.0']
                            );
      $gevoegde[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['2.'.$i0.'.1.'.$i1]);$i1++){
        $gevoegde[$i0]['gemachtigde'][$i1] = @$r['2.'.$i0.'.1.'.$i1.''];
      }
    }
    $rechtsgebied = @$r['3'];
    $proceduresoort = @$r['4'];
    $bevoegd=array();
    for($i0=0;isset($r['5.'.$i0]);$i0++){
      $bevoegd[$i0] = @$r['5.'.$i0.''];
    }
    $zorgdragervoordossier = @$r['6'];
    $dossierstukken=array();
    for($i0=0;isset($r['7.'.$i0]);$i0++){
      $dossierstukken[$i0] = array( 'id' => @$r['7.'.$i0.'.0']
                                  , 'Document' => @$r['7.'.$i0.'.0']
                                  , 'type' => @$r['7.'.$i0.'.1']
                                  );
    }
    $cluster=array();
    for($i0=0;isset($r['8.'.$i0]);$i0++){
      $cluster[$i0] = array( 'id' => @$r['8.'.$i0.'.0']
                           , 'naam' => @$r['8.'.$i0.'.0']
                           );
      $cluster[$i0]['grond']=array();
      for($i1=0;isset($r['8.'.$i0.'.1.'.$i1]);$i1++){
        $cluster[$i0]['grond'][$i1] = @$r['8.'.$i0.'.1.'.$i1.''];
      }
    }
    $machtigingen=array();
    for($i0=0;isset($r['9.'.$i0]);$i0++){
      $machtigingen[$i0] = array( 'id' => @$r['9.'.$i0.'.0']
                                , 'machtiging' => @$r['9.'.$i0.'.0']
                                , 'partij' => @$r['9.'.$i0.'.1']
                                );
      $machtigingen[$i0]['gemachtigde']=array();
      for($i1=0;isset($r['9.'.$i0.'.2.'.$i1]);$i1++){
        $machtigingen[$i0]['gemachtigde'][$i1] = @$r['9.'.$i0.'.2.'.$i1.''];
      }
    }
    $BasisgegevensUC001=new BasisgegevensUC001($ID,$eiser, $gedaagde, $gevoegde, $rechtsgebied, $proceduresoort, $bevoegd, $zorgdragervoordossier, $dossierstukken, $cluster, $machtigingen);
    if($BasisgegevensUC001->save()!==false) die('ok:'.$_SERVER['PHP_SELF'].'?BasisgegevensUC001='.urlencode($BasisgegevensUC001->getId())); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['new'])) $new=true; else $new=false;
  if(isset($_REQUEST['edit'])||$new) $edit=true; else $edit=false;
  $del=isset($_REQUEST['del']);
  if(isset($_REQUEST['BasisgegevensUC001'])){
    if(!$del || !delBasisgegevensUC001($_REQUEST['BasisgegevensUC001']))
      $BasisgegevensUC001 = readBasisgegevensUC001($_REQUEST['BasisgegevensUC001']);
    else $BasisgegevensUC001 = false; // delete was a succes!
  } else if($new) $BasisgegevensUC001 = new BasisgegevensUC001();
  else $BasisgegevensUC001 = false;
  if($BasisgegevensUC001){
    writeHead("<TITLE>BasisgegevensUC001 - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    if($edit && $BasisgegevensUC001->isNew())
         echo '<P><INPUT TYPE="TEXT" NAME="ID" VALUE="'.addslashes($BasisgegevensUC001->getId()).'" /></P>';
    else echo '<H1>'.$BasisgegevensUC001->getId().'</H1>';
    ?>
    <DIV class="Floater eiser">
      <DIV class="FloaterHeader">eiser</DIV>
      <DIV class="FloaterContent"><?php
          $eiser = $BasisgegevensUC001->get_eiser();
          echo '
          <UL>';
          foreach($eiser as $i0=>$v0){
            echo '
            <LI CLASS="item UI_eiser" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'partij: ';
                echo '<SPAN CLASS="item UI_eiser_partij" ID="0.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To0.'.$i0.'.0">';
                  echo htmlspecialchars($v0['partij']).'</A>';
                  echo '<DIV class="Goto" id="GoTo0.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['partij']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['partij']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['partij']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['partij']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_eiser_gemachtigde" ID="0.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To0.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gemachtigde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_eiser_gemachtigde" ID="0.'.$i0.'.1.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_eiser" ID="0.'.count($eiser).'">new eiser</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in eiser
      function UI_eiser(id){
        return '<DIV>partij: <SPAN CLASS="item UI_eiser_partij" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_eiser_gemachtigde" ID="'+id+'.1">new gemachtigde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater gedaagde">
      <DIV class="FloaterHeader">gedaagde</DIV>
      <DIV class="FloaterContent"><?php
          $gedaagde = $BasisgegevensUC001->get_gedaagde();
          echo '
          <UL>';
          foreach($gedaagde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gedaagde" ID="1.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'partij: ';
                echo '<SPAN CLASS="item UI_gedaagde_partij" ID="1.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To1.'.$i0.'.0">';
                  echo htmlspecialchars($v0['partij']).'</A>';
                  echo '<DIV class="Goto" id="GoTo1.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['partij']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['partij']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['partij']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['partij']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_gedaagde_gemachtigde" ID="1.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To1.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo1.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gemachtigde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gedaagde_gemachtigde" ID="1.'.$i0.'.1.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="1.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gedaagde" ID="1.'.count($gedaagde).'">new gedaagde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in gedaagde
      function UI_gedaagde(id){
        return '<DIV>partij: <SPAN CLASS="item UI_gedaagde_partij" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_gedaagde_gemachtigde" ID="'+id+'.1">new gemachtigde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater gevoegde">
      <DIV class="FloaterHeader">gevoegde</DIV>
      <DIV class="FloaterContent"><?php
          $gevoegde = $BasisgegevensUC001->get_gevoegde();
          echo '
          <UL>';
          foreach($gevoegde as $i0=>$v0){
            echo '
            <LI CLASS="item UI_gevoegde" ID="2.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'partij: ';
                echo '<SPAN CLASS="item UI_gevoegde_partij" ID="2.'.$i0.'.0">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To2.'.$i0.'.0">';
                  echo htmlspecialchars($v0['partij']).'</A>';
                  echo '<DIV class="Goto" id="GoTo2.'.$i0.'.0"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['partij']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['partij']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['partij']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['partij']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_gevoegde_gemachtigde" ID="2.'.$i0.'.1.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To2.'.$i0.'.1.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo2.'.$i0.'.1.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gemachtigde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_gevoegde_gemachtigde" ID="2.'.$i0.'.1.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="2.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_gevoegde" ID="2.'.count($gevoegde).'">new gevoegde</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in gevoegde
      function UI_gevoegde(id){
        return '<DIV>partij: <SPAN CLASS="item UI_gevoegde_partij" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_gevoegde_gemachtigde" ID="'+id+'.1">new gemachtigde</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater rechtsgebied">
      <DIV class="FloaterHeader">rechtsgebied</DIV>
      <DIV class="FloaterContent"><?php
          $rechtsgebied = $BasisgegevensUC001->get_rechtsgebied();
          echo '<SPAN CLASS="item UI_rechtsgebied" ID="3">';
          if(!$edit) echo '
          <A HREF="Rechtsgebied.php?Rechtsgebied='.urlencode($rechtsgebied).'">'.htmlspecialchars($rechtsgebied).'</A>';
          else echo htmlspecialchars($rechtsgebied);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater proceduresoort">
      <DIV class="FloaterHeader">proceduresoort</DIV>
      <DIV class="FloaterContent"><?php
          $proceduresoort = $BasisgegevensUC001->get_proceduresoort();
          echo '<SPAN CLASS="item UI_proceduresoort" ID="4">';
          if(!$edit) echo '
          <A HREF="Proceduresoort.php?Proceduresoort='.urlencode($proceduresoort).'">'.htmlspecialchars($proceduresoort).'</A>';
          else echo htmlspecialchars($proceduresoort);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater bevoegd">
      <DIV class="FloaterHeader">bevoegd</DIV>
      <DIV class="FloaterContent"><?php
          $bevoegd = $BasisgegevensUC001->get_bevoegd();
          echo '
          <UL>';
          foreach($bevoegd as $i0=>$v0){
            echo '
            <LI CLASS="item UI_bevoegd" ID="5.'.$i0.'">';
              if(!$edit) echo '
              <A HREF="Gerecht.php?Gerecht='.urlencode($v0).'">'.htmlspecialchars($v0).'</A>';
              else echo htmlspecialchars($v0);
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_bevoegd" ID="5.'.count($bevoegd).'">new bevoegd</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater zorgdrager voor dossier">
      <DIV class="FloaterHeader">zorgdrager voor dossier</DIV>
      <DIV class="FloaterContent"><?php
          $zorgdragervoordossier = $BasisgegevensUC001->get_zorgdragervoordossier();
          echo '<SPAN CLASS="item UI_zorgdragervoordossier" ID="6">';
          if(!$edit) echo '
          <A HREF="Orgaan.php?Orgaan='.urlencode($zorgdragervoordossier).'">'.htmlspecialchars($zorgdragervoordossier).'</A>';
          else echo htmlspecialchars($zorgdragervoordossier);
          echo '</SPAN>';
        ?> 
      </DIV>
    </DIV>
    <DIV class="Floater dossierstukken">
      <DIV class="FloaterHeader">dossierstukken</DIV>
      <DIV class="FloaterContent"><?php
          $dossierstukken = $BasisgegevensUC001->get_dossierstukken();
          echo '
          <UL>';
          foreach($dossierstukken as $i0=>$v0){
            echo '
            <LI CLASS="item UI_dossierstukken" ID="7.'.$i0.'">';
              if(!$edit){
                echo '
              <DIV class="GotoArrow" id="To7.'.$i0.'">&rArr;</DIV>';
                echo '<DIV class="Goto" id="GoTo7.'.$i0.'"><UL>';
                echo '<LI><A HREF="Brief.php?Brief='.urlencode($v0['id']).'">Brief</A></LI>';
                echo '<LI><A HREF="Betaling.php?Betaling='.urlencode($v0['id']).'">Betaling</A></LI>';
                echo '<LI><A HREF="Document.php?Document='.urlencode($v0['id']).'">Document</A></LI>';
                echo '</UL></DIV>';
              }
              echo '
              <DIV>';
                echo 'Document: ';
                echo '<SPAN CLASS="item UI_dossierstukken_Document" ID="7.'.$i0.'.0">';
                echo htmlspecialchars($v0['Document']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'type: ';
                echo '<SPAN CLASS="item UI_dossierstukken_type" ID="7.'.$i0.'.1">';
                if(!$edit) echo '
                <A HREF="Documenttype.php?Documenttype='.urlencode($v0['type']).'">'.htmlspecialchars($v0['type']).'</A>';
                else echo htmlspecialchars($v0['type']);
                echo '</SPAN>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="7.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_dossierstukken" ID="7.'.count($dossierstukken).'">new dossierstukken</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in dossierstukken
      function UI_dossierstukken(id){
        return '<DIV>Document: <SPAN CLASS="item UI_dossierstukken_Document" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>type: <SPAN CLASS="item UI_dossierstukken_type" ID="'+id+'.1"></SPAN></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater cluster">
      <DIV class="FloaterHeader">cluster</DIV>
      <DIV class="FloaterContent"><?php
          $cluster = $BasisgegevensUC001->get_cluster();
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
                echo 'naam: ';
                echo '<SPAN CLASS="item UI_cluster_naam" ID="8.'.$i0.'.0">';
                echo htmlspecialchars($v0['naam']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'grond: ';
                echo '
                <UL>';
                foreach($v0['grond'] as $i1=>$grond){
                  echo '
                  <LI CLASS="item UI_cluster_grond" ID="8.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($grond);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_cluster_grond" ID="8.'.$i0.'.1.'.count($v0['grond']).'">new grond</LI>';
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
        return '<DIV>naam: <SPAN CLASS="item UI_cluster_naam" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>grond: <UL><LI CLASS="new UI_cluster_grond" ID="'+id+'.1">new grond</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <DIV class="Floater machtigingen">
      <DIV class="FloaterHeader">machtigingen</DIV>
      <DIV class="FloaterContent"><?php
          $machtigingen = $BasisgegevensUC001->get_machtigingen();
          echo '
          <UL>';
          foreach($machtigingen as $i0=>$v0){
            echo '
            <LI CLASS="item UI_machtigingen" ID="9.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Machtiging.php?Machtiging='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'machtiging: ';
                echo '<SPAN CLASS="item UI_machtigingen_machtiging" ID="9.'.$i0.'.0">';
                echo htmlspecialchars($v0['machtiging']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'partij: ';
                echo '<SPAN CLASS="item UI_machtigingen_partij" ID="9.'.$i0.'.1">';
                if(!$edit){
                  echo '
                <A class="GotoLink" id="To9.'.$i0.'.1">';
                  echo htmlspecialchars($v0['partij']).'</A>';
                  echo '<DIV class="Goto" id="GoTo9.'.$i0.'.1"><UL>';
                  echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['partij']).'">Gerechtelijkeambtenaar</A></LI>';
                  echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['partij']).'">Persoon</A></LI>';
                  echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['partij']).'">Belanghebbende</A></LI>';
                  echo '</UL></DIV>';
                } else echo htmlspecialchars($v0['partij']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'gemachtigde: ';
                echo '
                <UL>';
                foreach($v0['gemachtigde'] as $i1=>$gemachtigde){
                  echo '
                  <LI CLASS="item UI_machtigingen_gemachtigde" ID="9.'.$i0.'.2.'.$i1.'">';
                    if(!$edit){
                      echo '
                    <A class="GotoLink" id="To9.'.$i0.'.2.'.$i1.'">';
                      echo htmlspecialchars($gemachtigde).'</A>';
                      echo '<DIV class="Goto" id="GoTo9.'.$i0.'.2.'.$i1.'"><UL>';
                      echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gemachtigde).'">Gerechtelijkeambtenaar</A></LI>';
                      echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gemachtigde).'">Persoon</A></LI>';
                      echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gemachtigde).'">Belanghebbende</A></LI>';
                      echo '</UL></DIV>';
                    } else echo htmlspecialchars($gemachtigde);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UI_machtigingen_gemachtigde" ID="9.'.$i0.'.2.'.count($v0['gemachtigde']).'">new gemachtigde</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="9.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI_machtigingen" ID="9.'.count($machtigingen).'">new machtigingen</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in machtigingen
      function UI_machtigingen(id){
        return '<DIV>machtiging: <SPAN CLASS="item UI_machtigingen_machtiging" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>partij: <SPAN CLASS="item UI_machtigingen_partij" ID="'+id+'.1"></SPAN></DIV>'
             + '<DIV>gemachtigde: <UL><LI CLASS="new UI_machtigingen_gemachtigde" ID="'+id+'.2">new gemachtigde</LI></UL></DIV>'
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
       $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1','".urlencode($BasisgegevensUC001->getId())."');","Save");
       $buttons.=ifaceButton($_SERVER['PHP_SELF']."?BasisgegevensUC001=".urlencode($BasisgegevensUC001->getId()),"Cancel");
     } 
  } else $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1&BasisgegevensUC001=".urlencode($BasisgegevensUC001->getId()),"Edit")
                 .ifaceButton($_SERVER['PHP_SELF']."?del=1&BasisgegevensUC001=".urlencode($BasisgegevensUC001->getId()),"Delete");
  }else{
    if($del){
      writeHead("<TITLE>Delete geslaagd</TITLE>");
      echo 'The BasisgegevensUC001 is deleted';
    }else{  // deze pagina zou onbereikbaar moeten zijn
      writeHead("<TITLE>No BasisgegevensUC001 object selected - VIRO - ADL Prototype</TITLE>");
      ?><i>No BasisgegevensUC001 object selected</i><?php 
    }
    $buttons.=ifaceButton($_SERVER['PHP_SELF']."?new=1","New");
  }
  writeTail($buttons);
?>