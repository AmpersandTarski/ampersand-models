<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 3839, file "VIRO.adl"
    SERVICE Rechterlijke ambtenaar : I[Persoon]
   = [ lid : bezetting
        = [ kamer : [Kamer]
          , gerecht : gerecht
          , sectorSector : sector
          ]
     , rol : vervult
     , geautoriseerd voor : aut
     , Zittingen : rechter~\/griffier~
        = [ rechter : rechter
          , griffier : griffier
          , geagendeerd : geagendeerd
          , plaats : plaats
          , locatie : locatie
          , kamer : kamer
             = [ gerecht : gerecht
               , sectorSector : sector
               ]
          ]
     , ontvangen : van~
        = [ bericht : [Document]
          , van : van
          , verzonden : verzonden
          , ontvangen : verzonden
          ]
     , verzonden : aan~
        = [ bericht : [Document]
          , van : van
          , verzonden : verzonden
          ]
     ]
   *********/
  
  class Rechterlijke ambtenaar {
    protected $_id=false;
    protected $_new=true;
    private $_lid;
    private $_rol;
    private $_geautoriseerdvoor;
    private $_Zittingen;
    private $_ontvangen;
    private $_verzonden;
    function Rechterlijke ambtenaar($id=null, $lid=null, $rol=null, $geautoriseerdvoor=null, $Zittingen=null, $ontvangen=null, $verzonden=null){
      $this->_id=$id;
      $this->_lid=$lid;
      $this->_rol=$rol;
      $this->_geautoriseerdvoor=$geautoriseerdvoor;
      $this->_Zittingen=$Zittingen;
      $this->_ontvangen=$ontvangen;
      $this->_verzonden=$verzonden;
      if(!isset($lid) && isset($id)){
        // get a Rechterlijke ambtenaar based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPersoon` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPersoon`, `i`
                                  FROM `persoon`
                              ) AS fst
                          WHERE fst.`AttPersoon` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['lid']=(DB_doquer("SELECT DISTINCT `bezetting`.`kamer` AS `id`
                                   FROM `bezetting`
                                  WHERE `bezetting`.`persoon`='".addslashes($id)."'"));
          $me['rol']=firstCol(DB_doquer("SELECT DISTINCT `vervult`.`rol`
                                           FROM `vervult`
                                          WHERE `vervult`.`persoon`='".addslashes($id)."'"));
          $me['geautoriseerd voor']=firstCol(DB_doquer("SELECT DISTINCT `aut`.`rol` AS `geautoriseerd voor`
                                                          FROM `aut`
                                                         WHERE `aut`.`persoon`='".addslashes($id)."'"));
          $me['Zittingen']=(DB_doquer("SELECT DISTINCT `f1`.`zitting` AS `id`
                                         FROM `persoon`
                                         JOIN  ( 
                                                      (SELECT DISTINCT persoon, zitting
                                                            FROM `rechter`
                                                      ) UNION (SELECT DISTINCT griffier AS `persoon`, i AS `zitting`
                                                            FROM `zitting`
                                                      
                                                      )
                                                    ) AS f1
                                           ON `f1`.`persoon`='".addslashes($id)."'
                                        WHERE `persoon`.`i`='".addslashes($id)."'"));
          $me['ontvangen']=(DB_doquer("SELECT DISTINCT `document`.`i` AS `id`
                                         FROM `document`
                                        WHERE `document`.`van`='".addslashes($id)."'"));
          $me['verzonden']=(DB_doquer("SELECT DISTINCT `aan`.`document` AS `id`
                                         FROM `aan`
                                        WHERE `aan`.`persoon`='".addslashes($id)."'"));
          foreach($me['lid'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `kamer`
                                         , `f3`.`gerecht`
                                         , `f4`.`sector` AS `sectorSector`
                                      FROM `kamer`
                                      LEFT JOIN `kamer` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `kamer` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `kamer`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['Zittingen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`griffier`
                                         , `f3`.`geagendeerd`
                                         , `f4`.`plaats`
                                         , `f5`.`locatie`
                                         , `f6`.`kamer`
                                      FROM `zitting`
                                      LEFT JOIN `zitting` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                     WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                 FROM `zitting`
                                                 JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                                WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v1 = $v0['kamer'];
            $v0['kamer']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1)."' AS `id`
                                                  , `f2`.`gerecht`
                                                  , `f3`.`sector` AS `sectorSector`
                                               FROM `kamer`
                                               LEFT JOIN `kamer` AS f2 ON `f2`.`i`='".addslashes($v1)."'
                                               LEFT JOIN `kamer` AS f3 ON `f3`.`i`='".addslashes($v1)."'
                                              WHERE `kamer`.`i`='".addslashes($v1)."'"));
          }
          unset($v0);
          foreach($me['ontvangen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `bericht`
                                         , `f3`.`van`
                                         , `f4`.`verzonden`
                                         , `f5`.`verzonden` AS `ontvangen`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['verzonden'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `bericht`
                                         , `f3`.`van`
                                         , `f4`.`verzonden`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_lid($me['lid']);
          $this->set_rol($me['rol']);
          $this->set_geautoriseerdvoor($me['geautoriseerd voor']);
          $this->set_Zittingen($me['Zittingen']);
          $this->set_ontvangen($me['ontvangen']);
          $this->set_verzonden($me['verzonden']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPersoon` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPersoon`, `i`
                                  FROM `persoon`
                              ) AS fst
                          WHERE fst.`AttPersoon` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "lid" => $this->_lid, "rol" => $this->_rol, "geautoriseerd voor" => $this->_geautoriseerdvoor, "Zittingen" => $this->_Zittingen, "ontvangen" => $this->_ontvangen, "verzonden" => $this->_verzonden);
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `zitting` (`i`,`griffier`,`geagendeerd`,`plaats`,`locatie`,`kamer`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['griffier'])."', '".addslashes($v0['geagendeerd'])."', '".addslashes($v0['plaats'])."', '".addslashes($v0['locatie'])."', '".addslashes($v0['kamer']['id'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `zitting` SET `griffier`='".addslashes($v0['griffier'])."', `geagendeerd`='".addslashes($v0['geagendeerd'])."', `plaats`='".addslashes($v0['plaats'])."', `locatie`='".addslashes($v0['locatie'])."', `kamer`='".addslashes($v0['kamer']['id'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
        }
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `van`='".addslashes($v0['van'])."', `verzonden`='".addslashes($v0['verzonden'])."', `verzonden`='".addslashes($v0['ontvangen'])."' WHERE `i`='".addslashes($v0['bericht'])."'", 5);
      }
      foreach  ($me['ontvangen'] as $ontvangen){
        if(isset($me['id']))
          DB_doquer("UPDATE `document` SET `van`='".addslashes($me['id'])."' WHERE `i`='".addslashes($ontvangen['id'])."'", 5);
      }
      // no code for bericht,i in document
      foreach($me['verzonden'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `van`='".addslashes($v0['van'])."', `verzonden`='".addslashes($v0['verzonden'])."' WHERE `i`='".addslashes($v0['bericht'])."'", 5);
      }
      // no code for bericht,i in document
      // no code for gerecht,i in gerecht
      // no code for locatie,i in gerecht
      // no code for gerecht,i in gerecht
      foreach($me['lid'] as $i0=>$v0){
        DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($v0['kamer']['id'])."'",5);
      }
      foreach($me['lid'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `kamer` (`i`,`gerecht`,`sector`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['gerecht'])."', '".addslashes($v0['sectorSector'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for kamer,i in kamer
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `kamer` (`i`,`gerecht`,`sector`) VALUES ('".addslashes($v0['kamer']['id'])."', '".addslashes($v0['kamer']['gerecht'])."', '".addslashes($v0['kamer']['sectorSector'])."')", 5);
        if($res!==false && !isset($v0['kamer']['id']))
          $v0['kamer']['id']=mysql_insert_id();
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($v0['plaats'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['griffier'])."')", 5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['van'])."')", 5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['van'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      foreach($me['lid'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sectorSector'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['kamer']['sectorSector'])."'",5);
      }
      foreach($me['lid'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['sectorSector'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['kamer']['sectorSector'])."')", 5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['geautoriseerd voor'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['geautoriseerd voor'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzonden'])."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['ontvangen'])."'",5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzonden'])."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['verzonden'])."')", 5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['ontvangen'])."')", 5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['verzonden'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `bezetting` WHERE `persoon`='".addslashes($me['id'])."'",5);
      foreach  ($me['lid'] as $lid){
        $res=DB_doquer("INSERT IGNORE INTO `bezetting` (`kamer`,`persoon`) VALUES ('".addslashes($lid['id'])."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($me['id'])."'",5);
      foreach  ($me['rol'] as $rol){
        $res=DB_doquer("INSERT IGNORE INTO `vervult` (`rol`,`persoon`) VALUES ('".addslashes($rol)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `aut` WHERE `persoon`='".addslashes($me['id'])."'",5);
      foreach  ($me['geautoriseerd voor'] as $geautoriseerdvoor){
        $res=DB_doquer("INSERT IGNORE INTO `aut` (`rol`,`persoon`) VALUES ('".addslashes($geautoriseerdvoor)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `aan` WHERE `persoon`='".addslashes($me['id'])."'",5);
      // no code for ontvangen,document in aan
      // no code for bericht,document in aan
      // no code for verzonden,document in aan
      foreach  ($me['verzonden'] as $verzonden){
        $res=DB_doquer("INSERT IGNORE INTO `aan` (`document`,`persoon`) VALUES ('".addslashes($verzonden['id'])."', '".addslashes($me['id'])."')", 5);
      }
      // no code for bericht,document in aan
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient in te loggen met een van de rollen die hij of zij vervult.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Elke persoon die een rol vervult moet daarvoor geautoriseerd zijn.\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "lid" => $this->_lid, "rol" => $this->_rol, "geautoriseerd voor" => $this->_geautoriseerdvoor, "Zittingen" => $this->_Zittingen, "ontvangen" => $this->_ontvangen, "verzonden" => $this->_verzonden);
      foreach($me['lid'] as $i0=>$v0){
        DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($v0['kamer']['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['lid'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sectorSector'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['kamer']['sectorSector'])."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['geautoriseerd voor'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzonden'])."'",5);
      }
      foreach($me['ontvangen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['ontvangen'])."'",5);
      }
      foreach($me['verzonden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzonden'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `bezetting` WHERE `persoon`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `aut` WHERE `persoon`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `aan` WHERE `persoon`='".addslashes($me['id'])."'",5);
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient in te loggen met een van de rollen die hij of zij vervult.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Elke persoon die een rol vervult moet daarvoor geautoriseerd zijn.\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_lid($val){
      $this->_lid=$val;
    }
    function get_lid(){
      if(!isset($this->_lid)) return array();
      return $this->_lid;
    }
    function set_rol($val){
      $this->_rol=$val;
    }
    function get_rol(){
      if(!isset($this->_rol)) return array();
      return $this->_rol;
    }
    function set_geautoriseerdvoor($val){
      $this->_geautoriseerdvoor=$val;
    }
    function get_geautoriseerdvoor(){
      if(!isset($this->_geautoriseerdvoor)) return array();
      return $this->_geautoriseerdvoor;
    }
    function set_Zittingen($val){
      $this->_Zittingen=$val;
    }
    function get_Zittingen(){
      if(!isset($this->_Zittingen)) return array();
      return $this->_Zittingen;
    }
    function set_ontvangen($val){
      $this->_ontvangen=$val;
    }
    function get_ontvangen(){
      if(!isset($this->_ontvangen)) return array();
      return $this->_ontvangen;
    }
    function set_verzonden($val){
      $this->_verzonden=$val;
    }
    function get_verzonden(){
      if(!isset($this->_verzonden)) return array();
      return $this->_verzonden;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id===null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachRechterlijkeambtenaar(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `persoon`'));
  }

  function readRechterlijkeambtenaar($id){
      // check existence of $id
      $obj = new Rechterlijkeambtenaar($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRechterlijkeambtenaar($id){
    $tobeDeleted = new Rechterlijkeambtenaar($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>