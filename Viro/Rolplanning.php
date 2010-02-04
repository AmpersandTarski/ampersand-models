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
  require "Rolplanning.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Rol=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Rol[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                       , 'rolnr' => @$r['0.'.$i0.'.0']
                       , 'zaak' => array( 'id' => @$r['0.'.$i0.'.1.0'], 'zaaknr' => @$r['0.'.$i0.'.1.0'])
                       , 'zitting' => array( 'id' => @$r['0.'.$i0.'.2'], 'kamer' => @$r['0.'.$i0.'.2.0'], 'griffier' => @$r['0.'.$i0.'.2.2'], 'geagendeerd' => @$r['0.'.$i0.'.2.3'])
                       );
    }
    $Rolplanning=new Rolplanning($Rol);
    if($Rolplanning->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('Please fix errors!');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Rolplanning=new Rolplanning();
    writeHead("<TITLE>Rolplanning - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Rolplanning</H1>
    <DIV class="Floater Rol">
      <DIV class="FloaterHeader">Rol</DIV>
      <DIV class="FloaterContent"><?php
          $Rol = $Rolplanning->get_Rol();
          echo '
          <UL>';
          foreach($Rol as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Behandeling.php?Behandeling='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'rolnr: ';
                echo '<SPAN CLASS="item UIrolnr" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['rolnr']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">zaak</DIV>
                  <DIV class="HolderContent" name="zaak"><?php
                      echo '<DIV CLASS="UIzaak" ID="0.'.$i0.'.1">';
                        if(!$edit){
                          echo '
                        <DIV class="GotoArrow" id="To0.'.$i0.'.1">&rArr;</DIV>';
                          echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1"><UL>';
                          echo '<LI><A HREF="BasisgegevensUC001.php?BasisgegevensUC001='.urlencode($v0['zaak']['id']).'">BasisgegevensUC001</A></LI>';
                          echo '<LI><A HREF="Procedure.php?Procedure='.urlencode($v0['zaak']['id']).'">Procedure</A></LI>';
                          echo '<LI><A HREF="nieuweProcedure.php?nieuweProcedure='.urlencode($v0['zaak']['id']).'">nieuweProcedure</A></LI>';
                          echo '</UL></DIV>';
                        }
                        echo '
                        <DIV>';
                          echo 'zaaknr: ';
                          echo '<SPAN CLASS="item UIzaak_zaaknr" ID="0.'.$i0.'.1.0">';
                          echo htmlspecialchars($v0['zaak']['zaaknr']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'gedaagde: ';
                          echo '
                          <UL>';
                          foreach($v0['zaak']['gedaagde'] as $i1=>$gedaagde){
                            echo '
                            <LI CLASS="item UIzaak_gedaagde" ID="0.'.$i0.'.1.1.'.$i1.'">';
                              if(!$edit){
                                echo '
                              <A class="GotoLink" id="To0.'.$i0.'.1.1.'.$i1.'">';
                                echo htmlspecialchars($gedaagde).'</A>';
                                echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.1.'.$i1.'"><UL>';
                                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gedaagde).'">Gerechtelijkeambtenaar</A></LI>';
                                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gedaagde).'">Persoon</A></LI>';
                                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gedaagde).'">Belanghebbende</A></LI>';
                                echo '</UL></DIV>';
                              } else echo htmlspecialchars($gedaagde);
                            echo '</LI>';
                          }
                          if($edit) echo '
                            <LI CLASS="new UIzaak_gedaagde" ID="0.'.$i0.'.1.1.'.count($v0['zaak']['gedaagde']).'">new gedaagde</LI>';
                          echo '
                          </UL>';
                        echo '</DIV>
                        <DIV>';
                          echo 'eiser: ';
                          echo '
                          <UL>';
                          foreach($v0['zaak']['eiser'] as $i1=>$eiser){
                            echo '
                            <LI CLASS="item UIzaak_eiser" ID="0.'.$i0.'.1.2.'.$i1.'">';
                              if(!$edit){
                                echo '
                              <A class="GotoLink" id="To0.'.$i0.'.1.2.'.$i1.'">';
                                echo htmlspecialchars($eiser).'</A>';
                                echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.2.'.$i1.'"><UL>';
                                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($eiser).'">Gerechtelijkeambtenaar</A></LI>';
                                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($eiser).'">Persoon</A></LI>';
                                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($eiser).'">Belanghebbende</A></LI>';
                                echo '</UL></DIV>';
                              } else echo htmlspecialchars($eiser);
                            echo '</LI>';
                          }
                          if($edit) echo '
                            <LI CLASS="new UIzaak_eiser" ID="0.'.$i0.'.1.2.'.count($v0['zaak']['eiser']).'">new eiser</LI>';
                          echo '
                          </UL>';
                        echo '</DIV>
                        <DIV>';
                          echo 'gevoegde: ';
                          echo '
                          <UL>';
                          foreach($v0['zaak']['gevoegde'] as $i1=>$gevoegde){
                            echo '
                            <LI CLASS="item UIzaak_gevoegde" ID="0.'.$i0.'.1.3.'.$i1.'">';
                              if(!$edit){
                                echo '
                              <A class="GotoLink" id="To0.'.$i0.'.1.3.'.$i1.'">';
                                echo htmlspecialchars($gevoegde).'</A>';
                                echo '<DIV class="Goto" id="GoTo0.'.$i0.'.1.3.'.$i1.'"><UL>';
                                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($gevoegde).'">Gerechtelijkeambtenaar</A></LI>';
                                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($gevoegde).'">Persoon</A></LI>';
                                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($gevoegde).'">Belanghebbende</A></LI>';
                                echo '</UL></DIV>';
                              } else echo htmlspecialchars($gevoegde);
                            echo '</LI>';
                          }
                          if($edit) echo '
                            <LI CLASS="new UIzaak_gevoegde" ID="0.'.$i0.'.1.3.'.count($v0['zaak']['gevoegde']).'">new gevoegde</LI>';
                          echo '
                          </UL>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="0.'.$i0.'.1.ID" VALUE="'.$v0['zaak']['id'].'" />';
                      echo '</DIV>';
                    ?> 
                  </DIV>
                </DIV>
                <?php
              echo '</DIV>
              <DIV>';
                ?> 
                <DIV class ="Holder"><DIV class="HolderHeader">zitting</DIV>
                  <DIV class="HolderContent" name="zitting"><?php
                      echo '<DIV CLASS="UIzitting" ID="0.'.$i0.'.2">';
                        if(!$edit){
                          echo '
                        <A HREF="Zitting.php?Zitting='.urlencode($v0['zitting']['id']).'">';
                          echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
                        }
                        echo '
                        <DIV>';
                          echo 'kamer: ';
                          echo '<SPAN CLASS="item UIzitting_kamer" ID="0.'.$i0.'.2.0">';
                          if(!$edit) echo '
                          <A HREF="Kamer.php?Kamer='.urlencode($v0['zitting']['kamer']).'">'.htmlspecialchars($v0['zitting']['kamer']).'</A>';
                          else echo htmlspecialchars($v0['zitting']['kamer']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'rechter: ';
                          echo '
                          <UL>';
                          foreach($v0['zitting']['rechter'] as $i1=>$rechter){
                            echo '
                            <LI CLASS="item UIzitting_rechter" ID="0.'.$i0.'.2.1.'.$i1.'">';
                              if(!$edit){
                                echo '
                              <A class="GotoLink" id="To0.'.$i0.'.2.1.'.$i1.'">';
                                echo htmlspecialchars($rechter).'</A>';
                                echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.1.'.$i1.'"><UL>';
                                echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($rechter).'">Gerechtelijkeambtenaar</A></LI>';
                                echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($rechter).'">Persoon</A></LI>';
                                echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($rechter).'">Belanghebbende</A></LI>';
                                echo '</UL></DIV>';
                              } else echo htmlspecialchars($rechter);
                            echo '</LI>';
                          }
                          if($edit) echo '
                            <LI CLASS="new UIzitting_rechter" ID="0.'.$i0.'.2.1.'.count($v0['zitting']['rechter']).'">new rechter</LI>';
                          echo '
                          </UL>';
                        echo '</DIV>
                        <DIV>';
                          echo 'griffier: ';
                          echo '<SPAN CLASS="item UIzitting_griffier" ID="0.'.$i0.'.2.2">';
                          if(!$edit){
                            echo '
                          <A class="GotoLink" id="To0.'.$i0.'.2.2">';
                            echo htmlspecialchars($v0['zitting']['griffier']).'</A>';
                            echo '<DIV class="Goto" id="GoTo0.'.$i0.'.2.2"><UL>';
                            echo '<LI><A HREF="Gerechtelijkeambtenaar.php?Gerechtelijkeambtenaar='.urlencode($v0['zitting']['griffier']).'">Gerechtelijkeambtenaar</A></LI>';
                            echo '<LI><A HREF="Persoon.php?Persoon='.urlencode($v0['zitting']['griffier']).'">Persoon</A></LI>';
                            echo '<LI><A HREF="Belanghebbende.php?Belanghebbende='.urlencode($v0['zitting']['griffier']).'">Belanghebbende</A></LI>';
                            echo '</UL></DIV>';
                          } else echo htmlspecialchars($v0['zitting']['griffier']);
                          echo '</SPAN>';
                        echo '</DIV>
                        <DIV>';
                          echo 'geagendeerd: ';
                          echo '<SPAN CLASS="item UIzitting_geagendeerd" ID="0.'.$i0.'.2.3">';
                          echo htmlspecialchars($v0['zitting']['geagendeerd']);
                          echo '</SPAN>';
                        echo '
                        </DIV>';
                        if($edit) echo '
                        <INPUT TYPE="hidden" name="0.'.$i0.'.2.ID" VALUE="'.$v0['zitting']['id'].'" />';
                      echo '</DIV>';
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
            <LI CLASS="new UI" ID="0.'.count($Rol).'">new Rol</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Rol
      function UI(id){
        return '<DIV>rolnr: <SPAN CLASS="item UI_rolnr" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>zaak: <SPAN CLASS="item UI_zaak" ID="'+id+'.1"><DIV>zaaknr: <SPAN CLASS="item UI_zaak_zaaknr" ID="'+id+'.10"></SPAN></DIV><DIV>gedaagde: <UL><LI CLASS="new UI_zaak_gedaagde" ID="'+id+'.11">new gedaagde</LI></UL></DIV><DIV>eiser: <UL><LI CLASS="new UI_zaak_eiser" ID="'+id+'.12">new eiser</LI></UL></DIV><DIV>gevoegde: <UL><LI CLASS="new UI_zaak_gevoegde" ID="'+id+'.13">new gevoegde</LI></UL></DIV></SPAN></DIV>'
             + '<DIV>zitting: <SPAN CLASS="item UI_zitting" ID="'+id+'.2"><DIV>kamer: <SPAN CLASS="item UI_zitting_kamer" ID="'+id+'.20"></SPAN></DIV><DIV>rechter: <UL><LI CLASS="new UI_zitting_rechter" ID="'+id+'.21">new rechter</LI></UL></DIV><DIV>griffier: <SPAN CLASS="item UI_zitting_griffier" ID="'+id+'.22"></SPAN></DIV><DIV>geagendeerd: <SPAN CLASS="item UI_zitting_geagendeerd" ID="'+id+'.23"></SPAN></DIV></SPAN></DIV>'
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