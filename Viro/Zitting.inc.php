<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3705, file "VIRO.adl"
    SERVICE Zitting : I[Zitting]
   = [ gerecht : locatie
     , kamer : kamer
     , plaats : plaats
     , rechter : rechter
     , griffier : griffier
     , geagendeerd : geagendeerd
     , feitelijkedatum : plaatsgevonden
     , zaken : zitting~;zaak
        = [ zaaknr : [Procedur]
          , eiser : eiser~
          , gedaagde : gedaagde~
          ]
     ]
   *********/
  
  class Zitting {
    protected $_id=false;
    protected $_new=true;
    private $_gerecht;
    private $_kamer;
    private $_plaats;
    private $_rechter;
    private $_griffier;
    private $_geagendeerd;
    private $_feitelijkedatum;
    private $_zaken;
    function Zitting($id=null, $gerecht=null, $kamer=null, $plaats=null, $rechter=null, $griffier=null, $geagendeerd=null, $feitelijkedatum=null, $zaken=null){
      $this->_id=$id;
      $this->_gerecht=$gerecht;
      $this->_kamer=$kamer;
      $this->_plaats=$plaats;
      $this->_rechter=$rechter;
      $this->_griffier=$griffier;
      $this->_geagendeerd=$geagendeerd;
      $this->_feitelijkedatum=$feitelijkedatum;
      $this->_zaken=$zaken;
      if(!isset($gerecht) && isset($id)){
        // get a Zitting based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttZitting` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttZitting`, `i`
                                  FROM `zitting`
                              ) AS fst
                          WHERE fst.`AttZitting` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `rechter`.`zitting` AS `id`
                                       , `zitting`.`locatie` AS `gerecht`
                                       , `zitting`.`kamer`
                                       , `zitting`.`plaats`
                                       , `zitting`.`griffier`
                                       , `zitting`.`geagendeerd`
                                       , `zitting`.`plaatsgevonden` AS `feitelijkedatum`
                                    FROM `rechter`
                                    LEFT JOIN `zitting` ON `zitting`.`i`='".addslashes($id)."'
                                   WHERE `rechter`.`zitting`='".addslashes($id)."'"));
          $me['rechter']=firstCol(DB_doquer("SELECT DISTINCT `rechter`.`persoon` AS `rechter`
                                               FROM `rechter`
                                              WHERE `rechter`.`zitting`='".addslashes($id)."'"));
          $me['zaken']=(DB_doquer("SELECT DISTINCT `behandeling`.`zaak` AS `id`
                                     FROM `behandeling`
                                    WHERE `behandeling`.`zitting`='".addslashes($id)."'"));
          foreach($me['zaken'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `zaaknr`
                                      FROM `procedur`
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
            $v0['eiser']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `eiser`
                                               FROM `procedur`
                                               JOIN `eiser` AS f1 ON `f1`.`procedur`='".addslashes($v0['id'])."'
                                              WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
            $v0['gedaagde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gedaagde`
                                                  FROM `procedur`
                                                  JOIN `gedaagde` AS f1 ON `f1`.`Procedur`='".addslashes($v0['id'])."'
                                                 WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_gerecht($me['gerecht']);
          $this->set_kamer($me['kamer']);
          $this->set_plaats($me['plaats']);
          $this->set_rechter($me['rechter']);
          $this->set_griffier($me['griffier']);
          $this->set_geagendeerd($me['geagendeerd']);
          $this->set_feitelijkedatum($me['feitelijkedatum']);
          $this->set_zaken($me['zaken']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttZitting` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttZitting`, `i`
                                  FROM `zitting`
                              ) AS fst
                          WHERE fst.`AttZitting` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "gerecht" => $this->_gerecht, "kamer" => $this->_kamer, "plaats" => $this->_plaats, "rechter" => $this->_rechter, "griffier" => $this->_griffier, "geagendeerd" => $this->_geagendeerd, "feitelijkedatum" => $this->_feitelijkedatum, "zaken" => $this->_zaken);
      DB_doquer("DELETE FROM `zitting` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `zitting` (`locatie`,`kamer`,`plaats`,`griffier`,`geagendeerd`,`plaatsgevonden`,`i`) VALUES ('".addslashes($me['gerecht'])."', '".addslashes($me['kamer'])."', '".addslashes($me['plaats'])."', '".addslashes($me['griffier'])."', '".addslashes($me['geagendeerd'])."', ".((null!=$me['feitelijkedatum'])?"'".addslashes($me['feitelijkedatum'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['zaken'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['zaaknr'])."'", 5);
      }
      // no code for zaaknr,i in procedur
      // no code for Zitting,zitting in behandeling
      // no code for gerecht,i in gerecht
      // no code for kamer,i in kamer
      $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($me['plaats'])."')", 5);
      foreach($me['rechter'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['griffier'])."'",5);
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['rechter'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['griffier'])."')", 5);
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['geagendeerd'])."'",5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['feitelijkedatum'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($me['geagendeerd'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($me['feitelijkedatum'])."')", 5);
      foreach($me['zaken'] as $i0=>$v0){
        DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zaken'] as $i0=>$v0){
        foreach  ($v0['eiser'] as $eiser){
          $res=DB_doquer("INSERT IGNORE INTO `eiser` (`procedur`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($eiser)."')", 5);
        }
      }
      // no code for zaaknr,procedur in eiser
      DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($me['id'])."'",5);
      foreach  ($me['rechter'] as $rechter){
        $res=DB_doquer("INSERT IGNORE INTO `rechter` (`persoon`,`zitting`) VALUES ('".addslashes($rechter)."', '".addslashes($me['id'])."')", 5);
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
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
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
      $me=array("id"=>$this->getId(), "gerecht" => $this->_gerecht, "kamer" => $this->_kamer, "plaats" => $this->_plaats, "rechter" => $this->_rechter, "griffier" => $this->_griffier, "geagendeerd" => $this->_geagendeerd, "feitelijkedatum" => $this->_feitelijkedatum, "zaken" => $this->_zaken);
      DB_doquer("DELETE FROM `zitting` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['rechter'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['griffier'])."'",5);
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['eiser'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zaken'] as $i0=>$v0){
        foreach($v0['gedaagde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['geagendeerd'])."'",5);
      DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($me['feitelijkedatum'])."'",5);
      foreach($me['zaken'] as $i0=>$v0){
        DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($me['id'])."'",5);
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
      if (!checkRule20()){
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
    function set_gerecht($val){
      $this->_gerecht=$val;
    }
    function get_gerecht(){
      return $this->_gerecht;
    }
    function set_kamer($val){
      $this->_kamer=$val;
    }
    function get_kamer(){
      return $this->_kamer;
    }
    function set_plaats($val){
      $this->_plaats=$val;
    }
    function get_plaats(){
      return $this->_plaats;
    }
    function set_rechter($val){
      $this->_rechter=$val;
    }
    function get_rechter(){
      if(!isset($this->_rechter)) return array();
      return $this->_rechter;
    }
    function set_griffier($val){
      $this->_griffier=$val;
    }
    function get_griffier(){
      return $this->_griffier;
    }
    function set_geagendeerd($val){
      $this->_geagendeerd=$val;
    }
    function get_geagendeerd(){
      return $this->_geagendeerd;
    }
    function set_feitelijkedatum($val){
      $this->_feitelijkedatum=$val;
    }
    function get_feitelijkedatum(){
      return $this->_feitelijkedatum;
    }
    function set_zaken($val){
      $this->_zaken=$val;
    }
    function get_zaken(){
      if(!isset($this->_zaken)) return array();
      return $this->_zaken;
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

  function getEachZitting(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `zitting`'));
  }

  function readZitting($id){
      // check existence of $id
      $obj = new Zitting($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delZitting($id){
    $tobeDeleted = new Zitting($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>