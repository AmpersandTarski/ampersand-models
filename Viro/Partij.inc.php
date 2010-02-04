<?php // generated with ADL vs. 0.8.10-443
  
  /********* on line 3503, file "VIRO.adl"
    SERVICE Partij : I[Partij]
   = [ eiser : eiser
        = [ Procedure : [Procedure]
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          , gerecht : zaak~;zitting;locatie
          , zitting : zaak~;zitting
          ]
     , gedaagde : gedaagde
        = [ Procedure : [Procedure]
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          , gerecht : zaak~;zitting;locatie
          , zitting : zaak~;zitting
          ]
     , gevoegde : gevoegde
        = [ Procedure : [Procedure]
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          , gerecht : zaak~;zitting;locatie
          , zitting : zaak~;zitting
          ]
     , machtiging : door~
        = [ Machtiging : [Machtiging]
          , gemachtigde : gemachtigde~
          ]
     ]
   *********/
  
  class Partij {
    protected $_id=false;
    protected $_new=true;
    private $_eiser;
    private $_gedaagde;
    private $_gevoegde;
    private $_machtiging;
    function Partij($id=null, $eiser=null, $gedaagde=null, $gevoegde=null, $machtiging=null){
      $this->_id=$id;
      $this->_eiser=$eiser;
      $this->_gedaagde=$gedaagde;
      $this->_gevoegde=$gevoegde;
      $this->_machtiging=$machtiging;
      if(!isset($eiser) && isset($id)){
        // get a Partij based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPartij` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPartij`, `i`
                                  FROM `partij`
                              ) AS fst
                          WHERE fst.`AttPartij` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['eiser']=(DB_doquer("SELECT DISTINCT `eiser`.`procedure` AS `id`
                                     FROM `eiser`
                                    WHERE `eiser`.`partij`='".addslashes($id)."'"));
          $me['gedaagde']=(DB_doquer("SELECT DISTINCT `gedaagde`.`procedure` AS `id`
                                        FROM `gedaagde`
                                       WHERE `gedaagde`.`partij`='".addslashes($id)."'"));
          $me['gevoegde']=(DB_doquer("SELECT DISTINCT `gevoegde`.`procedure` AS `id`
                                        FROM `gevoegde`
                                       WHERE `gevoegde`.`partij`='".addslashes($id)."'"));
          $me['machtiging']=(DB_doquer("SELECT DISTINCT `machtiging`.`i` AS `id`
                                          FROM `machtiging`
                                         WHERE `machtiging`.`door`='".addslashes($id)."'"));
          foreach($me['eiser'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Procedure`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedure`
                                      LEFT JOIN `procedure` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedure` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['gerecht']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`locatie` AS `gerecht`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F2.`locatie`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1, `zitting` AS F2
                                                               WHERE F0.`i`=F1.`i`
                                                                 AND F1.`zitting`=F2.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['zitting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zitting`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F1.`zitting`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1
                                                               WHERE F0.`i`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['gedaagde'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Procedure`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedure`
                                      LEFT JOIN `procedure` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedure` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['gerecht']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`locatie` AS `gerecht`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F2.`locatie`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1, `zitting` AS F2
                                                               WHERE F0.`i`=F1.`i`
                                                                 AND F1.`zitting`=F2.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['zitting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zitting`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F1.`zitting`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1
                                                               WHERE F0.`i`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['gevoegde'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Procedure`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedure`
                                      LEFT JOIN `procedure` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedure` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['gerecht']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`locatie` AS `gerecht`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F2.`locatie`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1, `zitting` AS F2
                                                               WHERE F0.`i`=F1.`i`
                                                                 AND F1.`zitting`=F2.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
            $v0['zitting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zitting`
                                                 FROM `procedure`
                                                 JOIN  ( SELECT DISTINCT F0.`zaak`, F1.`zitting`
                                                                FROM `behandeling` AS F0, `behandeling` AS F1
                                                               WHERE F0.`i`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                                WHERE `procedure`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['machtiging'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Machtiging`
                                      FROM `machtiging`
                                     WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_eiser($me['eiser']);
          $this->set_gedaagde($me['gedaagde']);
          $this->set_gevoegde($me['gevoegde']);
          $this->set_machtiging($me['machtiging']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPartij` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPartij`, `i`
                                  FROM `partij`
                              ) AS fst
                          WHERE fst.`AttPartij` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gedaagde" => $this->_gedaagde, "gevoegde" => $this->_gevoegde, "machtiging" => $this->_machtiging);
      // no code for zitting,i in zitting
      // no code for zitting,i in zitting
      // no code for zitting,i in zitting
      foreach($me['eiser'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedure` SET `i`='".addslashes($v0['id'])."', `rechtsgebied`='".addslashes($v0['rechtsgebied'])."', `proceduresoort`='".addslashes($v0['proceduresoort'])."' WHERE `i`='".addslashes($v0['Procedure'])."'", 5);
      }
      // no code for Procedure,i in procedure
      foreach($me['gedaagde'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedure` SET `i`='".addslashes($v0['id'])."', `rechtsgebied`='".addslashes($v0['rechtsgebied'])."', `proceduresoort`='".addslashes($v0['proceduresoort'])."' WHERE `i`='".addslashes($v0['Procedure'])."'", 5);
      }
      // no code for Procedure,i in procedure
      foreach($me['gevoegde'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedure` SET `i`='".addslashes($v0['id'])."', `rechtsgebied`='".addslashes($v0['rechtsgebied'])."', `proceduresoort`='".addslashes($v0['proceduresoort'])."' WHERE `i`='".addslashes($v0['Procedure'])."'", 5);
      }
      // no code for Procedure,i in procedure
      // no code for eiser,zaak in behandeling
      // no code for gedaagde,zaak in behandeling
      // no code for gevoegde,zaak in behandeling
      // no code for gerecht,i in gerecht
      // no code for gerecht,i in gerecht
      // no code for gerecht,i in gerecht
      DB_doquer("DELETE FROM `machtiging` WHERE `door`='".addslashes($me['id'])."'",5);
      foreach($me['machtiging'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `machtiging` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['Machtiging'])."'", 5);
      }
      foreach  ($me['machtiging'] as $machtiging){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($machtiging['id'])."', '".addslashes($me['id'])."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      // no code for Machtiging,i in machtiging
      foreach($me['machtiging'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['machtiging'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      DB_doquer("DELETE FROM `eiser` WHERE `partij`='".addslashes($me['id'])."'",5);
      foreach  ($me['eiser'] as $eiser){
        $res=DB_doquer("INSERT IGNORE INTO `eiser` (`procedure`,`partij`) VALUES ('".addslashes($eiser['id'])."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `gedaagde` WHERE `partij`='".addslashes($me['id'])."'",5);
      foreach  ($me['gedaagde'] as $gedaagde){
        $res=DB_doquer("INSERT IGNORE INTO `gedaagde` (`procedure`,`partij`) VALUES ('".addslashes($gedaagde['id'])."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `gevoegde` WHERE `partij`='".addslashes($me['id'])."'",5);
      foreach  ($me['gevoegde'] as $gevoegde){
        $res=DB_doquer("INSERT IGNORE INTO `gevoegde` (`procedure`,`partij`) VALUES ('".addslashes($gevoegde['id'])."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['machtiging'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtiging'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      // no code for Machtiging,machtiging in gemachtigde
      // no code for zitting,zitting in rechter
      // no code for zitting,zitting in rechter
      // no code for zitting,zitting in rechter
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule30()){
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
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gedaagde" => $this->_gedaagde, "gevoegde" => $this->_gevoegde, "machtiging" => $this->_machtiging);
      DB_doquer("DELETE FROM `machtiging` WHERE `door`='".addslashes($me['id'])."'",5);
      foreach($me['machtiging'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      DB_doquer("DELETE FROM `eiser` WHERE `partij`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `gedaagde` WHERE `partij`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `gevoegde` WHERE `partij`='".addslashes($me['id'])."'",5);
      foreach($me['machtiging'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule30()){
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
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_eiser($val){
      $this->_eiser=$val;
    }
    function get_eiser(){
      if(!isset($this->_eiser)) return array();
      return $this->_eiser;
    }
    function set_gedaagde($val){
      $this->_gedaagde=$val;
    }
    function get_gedaagde(){
      if(!isset($this->_gedaagde)) return array();
      return $this->_gedaagde;
    }
    function set_gevoegde($val){
      $this->_gevoegde=$val;
    }
    function get_gevoegde(){
      if(!isset($this->_gevoegde)) return array();
      return $this->_gevoegde;
    }
    function set_machtiging($val){
      $this->_machtiging=$val;
    }
    function get_machtiging(){
      if(!isset($this->_machtiging)) return array();
      return $this->_machtiging;
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

  function getEachPartij(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `partij`'));
  }

  function readPartij($id){
      // check existence of $id
      $obj = new Partij($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPartij($id){
    $tobeDeleted = new Partij($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>