<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3774, file "VIRO.adl"
    SERVICE Behandeling : I[Behandeling]
   = [ zitting : zitting
        = [ gerecht : locatie
          , rechter : rechter
          , griffier : griffier
          , geagendeerd : geagendeerd
          , feitelijkedatum : plaatsgevonden
          ]
     , zaak : zaak
        = [ rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          , zitting : zaak~;zitting
          ]
     ]
   *********/
  
  class Behandeling {
    protected $_id=false;
    protected $_new=true;
    private $_zitting;
    private $_zaak;
    function Behandeling($id=null, $zitting=null, $zaak=null){
      $this->_id=$id;
      $this->_zitting=$zitting;
      $this->_zaak=$zaak;
      if(!isset($zitting) && isset($id)){
        // get a Behandeling based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBehandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttBehandeling`, `i`
                                  FROM `behandeling`
                              ) AS fst
                          WHERE fst.`AttBehandeling` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `behandeling`.`i` AS `id`
                                       , `behandeling`.`zitting`
                                       , `behandeling`.`zaak`
                                    FROM `behandeling`
                                   WHERE `behandeling`.`i`='".addslashes($id)."'"));
          $v0 = $me['zitting'];
          $me['zitting']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0)."' AS `id`
                                                  , `f2`.`locatie` AS `gerecht`
                                                  , `f3`.`griffier`
                                                  , `f4`.`geagendeerd`
                                                  , `f5`.`plaatsgevonden` AS `feitelijkedatum`
                                               FROM `zitting`
                                               LEFT JOIN `zitting` AS f2 ON `f2`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `zitting` AS f5 ON `f5`.`i`='".addslashes($v0)."'
                                              WHERE `zitting`.`i`='".addslashes($v0)."'"));
          $me['zitting']['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                          FROM `zitting`
                                                          JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0)."'
                                                         WHERE `zitting`.`i`='".addslashes($v0)."'"));
          $v0 = $me['zaak'];
          $me['zaak']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0)."' AS `id`
                                               , `f2`.`rechtsgebied`
                                               , `f3`.`proceduresoort`
                                            FROM `procedur`
                                            LEFT JOIN `procedur` AS f2 ON `f2`.`i`='".addslashes($v0)."'
                                            LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0)."'
                                           WHERE `procedur`.`i`='".addslashes($v0)."'"));
          $me['zaak']['zitting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zitting`
                                                       FROM `procedur`
                                                       JOIN  ( SELECT DISTINCT F0.`zaak`, F1.`zitting`
                                                                      FROM `behandeling` AS F0, `behandeling` AS F1
                                                                     WHERE F0.`i`=F1.`i`
                                                                  ) AS f1
                                                         ON `f1`.`zaak`='".addslashes($v0)."'
                                                      WHERE `procedur`.`i`='".addslashes($v0)."'"));
          $this->set_zitting($me['zitting']);
          $this->set_zaak($me['zaak']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBehandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttBehandeling`, `i`
                                  FROM `behandeling`
                              ) AS fst
                          WHERE fst.`AttBehandeling` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "zitting" => $this->_zitting, "zaak" => $this->_zaak);
      if(isset($me['zitting']['id']))
        DB_doquer("UPDATE `zitting` SET `locatie`='".addslashes($me['zitting']['gerecht'])."', `griffier`='".addslashes($me['zitting']['griffier'])."', `geagendeerd`='".addslashes($me['zitting']['geagendeerd'])."', `plaatsgevonden`=".((null!=$me['zitting']['feitelijkedatum'])?"'".addslashes($me['zitting']['feitelijkedatum'])."'":"NULL")." WHERE `i`='".addslashes($me['zitting']['id'])."'", 5);
      // no code for zitting,i in zitting
      if(isset($me['zaak']['id']))
        DB_doquer("UPDATE `procedur` SET `rechtsgebied`='".addslashes($me['zaak']['rechtsgebied'])."', `proceduresoort`='".addslashes($me['zaak']['proceduresoort'])."' WHERE `i`='".addslashes($me['zaak']['id'])."'", 5);
      DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`zitting`,`zaak`,`i`) VALUES ('".addslashes($me['zitting']['id'])."', '".addslashes($me['zaak']['id'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for zaak,zaak in behandeling
      // no code for gerecht,i in gerecht
      foreach($me['zitting']['rechter'] as $i1=>$v1){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['zitting']['griffier'])."'",5);
      foreach($me['zitting']['rechter'] as $i1=>$v1){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['zitting']['griffier'])."')", 5);
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['zaak']['rechtsgebied'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($me['zaak']['rechtsgebied'])."')", 5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['zaak']['proceduresoort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($me['zaak']['proceduresoort'])."')", 5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['zitting']['geagendeerd'])."'",5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['zitting']['feitelijkedatum'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($me['zitting']['geagendeerd'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($me['zitting']['feitelijkedatum'])."')", 5);
      // no code for zaak,procedur in eiser
      DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($me['zitting']['id'])."'",5);
      foreach  ($me['zitting']['rechter'] as $rechter){
        $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($me['zitting']['id'])."', '".addslashes($rechter)."')", 5);
      }
      // no code for zitting,zitting in rechter
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
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule22()){
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
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
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
      if (!checkRule74()){
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
      $me=array("id"=>$this->getId(), "zitting" => $this->_zitting, "zaak" => $this->_zaak);
      DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['zitting']['rechter'] as $i1=>$v1){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['zitting']['griffier'])."'",5);
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['zaak']['rechtsgebied'])."'",5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['zaak']['proceduresoort'])."'",5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['zitting']['geagendeerd'])."'",5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['zitting']['feitelijkedatum'])."'",5);
      DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($me['zitting']['id'])."'",5);
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
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule22()){
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
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
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
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_zitting($val){
      $this->_zitting=$val;
    }
    function get_zitting(){
      return $this->_zitting;
    }
    function set_zaak($val){
      $this->_zaak=$val;
    }
    function get_zaak(){
      return $this->_zaak;
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

  function getEachBehandeling(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `behandeling`'));
  }

  function readBehandeling($id){
      // check existence of $id
      $obj = new Behandeling($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delBehandeling($id){
    $tobeDeleted = new Behandeling($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>