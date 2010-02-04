<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3769, file "VIRO.adl"
    SERVICE Gerecht : I[Gerecht]
   = [ Zittingen : locatie~
        = [ Zitting : [Zitting]
          , kamer : kamer
          , rechter : rechter
          , griffier : griffier
          , geagendeerd : geagendeerd
          , rol : zitting~
             = [ nr : [Behandeling]
               , zaak : zaak
               , proceduresoort : zaak;proceduresoort
               ]
          ]
     , kamers : gerecht~
     , benoemd : griffier
     , bevoegd : bevoegd~
     , hoofdplaats : hoofdplaats
     , nevenvestigingsplaatsen : neven~
     , teAgenderen : bevoegd~/\-(locatie~;zitting~;zaak)
        = [ zaaknr : [Procedur]
          , gedaagde : gedaagde~
          , eiser : eiser~
          , gevoegde : gevoegde~
          ]
     ]
   *********/
  
  class Gerecht {
    protected $_id=false;
    protected $_new=true;
    private $_Zittingen;
    private $_kamers;
    private $_benoemd;
    private $_bevoegd;
    private $_hoofdplaats;
    private $_nevenvestigingsplaatsen;
    private $_teAgenderen;
    function Gerecht($id=null, $Zittingen=null, $kamers=null, $benoemd=null, $bevoegd=null, $hoofdplaats=null, $nevenvestigingsplaatsen=null, $teAgenderen=null){
      $this->_id=$id;
      $this->_Zittingen=$Zittingen;
      $this->_kamers=$kamers;
      $this->_benoemd=$benoemd;
      $this->_bevoegd=$bevoegd;
      $this->_hoofdplaats=$hoofdplaats;
      $this->_nevenvestigingsplaatsen=$nevenvestigingsplaatsen;
      $this->_teAgenderen=$teAgenderen;
      if(!isset($Zittingen) && isset($id)){
        // get a Gerecht based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttGerecht` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttGerecht`, `i`
                                  FROM `gerecht`
                              ) AS fst
                          WHERE fst.`AttGerecht` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `gerecht`.`i` AS `id`
                                       , `gerecht`.`hoofdplaats`
                                    FROM `gerecht`
                                   WHERE `gerecht`.`i`='".addslashes($id)."'"));
          $me['Zittingen']=(DB_doquer("SELECT DISTINCT `zitting`.`i` AS `id`
                                         FROM `zitting`
                                        WHERE `zitting`.`locatie`='".addslashes($id)."'"));
          $me['kamers']=firstCol(DB_doquer("SELECT DISTINCT `kamer`.`i` AS `kamers`
                                              FROM `kamer`
                                             WHERE `kamer`.`gerecht`='".addslashes($id)."'"));
          $me['benoemd']=firstCol(DB_doquer("SELECT DISTINCT `griffier`.`persoon` AS `benoemd`
                                               FROM `griffier`
                                              WHERE `griffier`.`gerecht`='".addslashes($id)."'"));
          $me['bevoegd']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`procedur` AS `bevoegd`
                                               FROM `gerecht`
                                               JOIN `bevoegd` AS f1 ON `f1`.`Gerecht`='".addslashes($id)."'
                                              WHERE `gerecht`.`i`='".addslashes($id)."'"));
          $me['nevenvestigingsplaatsen']=firstCol(DB_doquer("SELECT DISTINCT `plaats`.`i` AS `nevenvestigingsplaatsen`
                                                               FROM `gerecht`
                                                               JOIN `plaats` ON `plaats`.`neven`='".addslashes($id)."'
                                                              WHERE `gerecht`.`i`='".addslashes($id)."'"));
          $me['teAgenderen']=(DB_doquer("SELECT DISTINCT `f1`.`procedur` AS `id`
                                           FROM `gerecht`
                                           JOIN  ( SELECT DISTINCT isect0.`Gerecht`, isect0.`procedur`
                                                          FROM `bevoegd` AS isect0
                                                         WHERE NOT EXISTS (SELECT *
                                                                      FROM 
                                                                         ( SELECT DISTINCT F0.`locatie`, F2.`zaak`
                                                                             FROM `zitting` AS F0, `behandeling` AS F1, `behandeling` AS F2
                                                                            WHERE F0.`i`=F1.`zitting`
                                                                              AND F1.`i`=F2.`i`
                                                                         ) AS cp
                                                                     WHERE isect0.`Gerecht`=cp.`locatie` AND isect0.`procedur`=cp.`zaak`) AND isect0.`Gerecht` IS NOT NULL AND isect0.`procedur` IS NOT NULL
                                                      ) AS f1
                                             ON `f1`.`Gerecht`='".addslashes($id)."'
                                          WHERE `gerecht`.`i`='".addslashes($id)."'"));
          foreach($me['Zittingen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Zitting`
                                         , `f3`.`kamer`
                                         , `f4`.`griffier`
                                         , `f5`.`geagendeerd`
                                      FROM `zitting`
                                      LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                 FROM `zitting`
                                                 JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                                WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rol']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                     FROM `zitting`
                                     JOIN `behandeling` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                    WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            foreach($v0['rol'] as $i1=>&$v1){
              $v1=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1['id'])."' AS `id`
                                           , '".addslashes($v1['id'])."' AS `nr`
                                           , `f3`.`zaak`
                                           , `f4`.`proceduresoort`
                                        FROM `behandeling`
                                        LEFT JOIN `behandeling` AS f3 ON `f3`.`i`='".addslashes($v1['id'])."'
                                        LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`proceduresoort`
                                                       FROM `behandeling` AS F0, `procedur` AS F1
                                                      WHERE F0.`zaak`=F1.`i`
                                                   ) AS f4
                                          ON `f4`.`i`='".addslashes($v1['id'])."'
                                       WHERE `behandeling`.`i`='".addslashes($v1['id'])."'"));
            }
            unset($v1);
          }
          unset($v0);
          foreach($me['teAgenderen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `zaaknr`
                                      FROM `procedur`
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
            $v0['gedaagde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gedaagde`
                                                  FROM `procedur`
                                                  JOIN `gedaagde` AS f1 ON `f1`.`Procedur`='".addslashes($v0['id'])."'
                                                 WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
            $v0['eiser']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `eiser`
                                               FROM `procedur`
                                               JOIN `eiser` AS f1 ON `f1`.`procedur`='".addslashes($v0['id'])."'
                                              WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
            $v0['gevoegde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gevoegde`
                                                  FROM `procedur`
                                                  JOIN `gevoegde` AS f1 ON `f1`.`Procedur`='".addslashes($v0['id'])."'
                                                 WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Zittingen($me['Zittingen']);
          $this->set_kamers($me['kamers']);
          $this->set_benoemd($me['benoemd']);
          $this->set_bevoegd($me['bevoegd']);
          $this->set_hoofdplaats($me['hoofdplaats']);
          $this->set_nevenvestigingsplaatsen($me['nevenvestigingsplaatsen']);
          $this->set_teAgenderen($me['teAgenderen']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttGerecht` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttGerecht`, `i`
                                  FROM `gerecht`
                              ) AS fst
                          WHERE fst.`AttGerecht` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "Zittingen" => $this->_Zittingen, "kamers" => $this->_kamers, "benoemd" => $this->_benoemd, "bevoegd" => $this->_bevoegd, "hoofdplaats" => $this->_hoofdplaats, "nevenvestigingsplaatsen" => $this->_nevenvestigingsplaatsen, "teAgenderen" => $this->_teAgenderen);
      foreach($me['Zittingen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `zitting` SET `i`='".addslashes($v0['id'])."', `kamer`='".addslashes($v0['kamer'])."', `griffier`='".addslashes($v0['griffier'])."', `geagendeerd`='".addslashes($v0['geagendeerd'])."' WHERE `i`='".addslashes($v0['Zitting'])."'", 5);
      }
      foreach  ($me['Zittingen'] as $Zittingen){
        if(isset($me['id']))
          DB_doquer("UPDATE `zitting` SET `locatie`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Zittingen['id'])."'", 5);
      }
      // no code for Zitting,i in zitting
      // no code for zaak,i in procedur
      // no code for bevoegd,i in procedur
      foreach($me['teAgenderen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['zaaknr'])."'", 5);
      }
      // no code for zaaknr,i in procedur
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          if(isset($v1['id']))
            DB_doquer("UPDATE `behandeling` SET `i`='".addslashes($v1['id'])."', `zaak`='".addslashes($v1['zaak'])."' WHERE `i`='".addslashes($v1['nr'])."'", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          if(isset($v0['id']))
            DB_doquer("UPDATE `behandeling` SET `zitting`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($rol['id'])."'", 5);
        }
      }
      // no code for nr,i in behandeling
      if(isset($me['id']))
        DB_doquer("UPDATE `gerecht` SET `hoofdplaats`='".addslashes($me['hoofdplaats'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for kamer,i in kamer
      // no code for kamers,i in kamer
      foreach  ($me['kamers'] as $kamers){
        if(isset($me['id']))
          DB_doquer("UPDATE `kamer` SET `gerecht`='".addslashes($me['id'])."' WHERE `i`='".addslashes($kamers)."'", 5);
      }
      DB_doquer("DELETE FROM `plaats` WHERE `neven`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($me['hoofdplaats'])."')", 5);
      foreach($me['nevenvestigingsplaatsen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach  ($me['nevenvestigingsplaatsen'] as $nevenvestigingsplaatsen){
        $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`,`neven`) VALUES ('".addslashes($nevenvestigingsplaatsen)."', ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['benoemd'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gevoegde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['griffier'])."')", 5);
      }
      foreach($me['benoemd'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gevoegde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v1['proceduresoort'])."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v1['proceduresoort'])."')", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($v0['id'])."'",5);
      }
      // no code for zaak,procedur in eiser
      // no code for bevoegd,procedur in eiser
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach  ($v0['eiser'] as $eiser){
          $res=DB_doquer("INSERT IGNORE INTO `eiser` (`procedur`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($eiser)."')", 5);
        }
      }
      // no code for zaaknr,procedur in eiser
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for Zitting,zitting in rechter
      DB_doquer("DELETE FROM `griffier` WHERE `gerecht`='".addslashes($me['id'])."'",5);
      foreach  ($me['benoemd'] as $benoemd){
        $res=DB_doquer("INSERT IGNORE INTO `griffier` (`persoon`,`gerecht`) VALUES ('".addslashes($benoemd)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
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
      $me=array("id"=>$this->getId(), "Zittingen" => $this->_Zittingen, "kamers" => $this->_kamers, "benoemd" => $this->_benoemd, "bevoegd" => $this->_bevoegd, "hoofdplaats" => $this->_hoofdplaats, "nevenvestigingsplaatsen" => $this->_nevenvestigingsplaatsen, "teAgenderen" => $this->_teAgenderen);
      DB_doquer("DELETE FROM `plaats` WHERE `neven`='".addslashes($me['id'])."'",5);
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['benoemd'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        foreach($v0['gevoegde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v1['proceduresoort'])."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['teAgenderen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `griffier` WHERE `gerecht`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Zittingen($val){
      $this->_Zittingen=$val;
    }
    function get_Zittingen(){
      if(!isset($this->_Zittingen)) return array();
      return $this->_Zittingen;
    }
    function set_kamers($val){
      $this->_kamers=$val;
    }
    function get_kamers(){
      if(!isset($this->_kamers)) return array();
      return $this->_kamers;
    }
    function set_benoemd($val){
      $this->_benoemd=$val;
    }
    function get_benoemd(){
      if(!isset($this->_benoemd)) return array();
      return $this->_benoemd;
    }
    function set_bevoegd($val){
      $this->_bevoegd=$val;
    }
    function get_bevoegd(){
      if(!isset($this->_bevoegd)) return array();
      return $this->_bevoegd;
    }
    function set_hoofdplaats($val){
      $this->_hoofdplaats=$val;
    }
    function get_hoofdplaats(){
      return $this->_hoofdplaats;
    }
    function set_nevenvestigingsplaatsen($val){
      $this->_nevenvestigingsplaatsen=$val;
    }
    function get_nevenvestigingsplaatsen(){
      if(!isset($this->_nevenvestigingsplaatsen)) return array();
      return $this->_nevenvestigingsplaatsen;
    }
    function set_teAgenderen($val){
      $this->_teAgenderen=$val;
    }
    function get_teAgenderen(){
      if(!isset($this->_teAgenderen)) return array();
      return $this->_teAgenderen;
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

  function getEachGerecht(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `gerecht`'));
  }

  function readGerecht($id){
      // check existence of $id
      $obj = new Gerecht($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delGerecht($id){
    $tobeDeleted = new Gerecht($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>