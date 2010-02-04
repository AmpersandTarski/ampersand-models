<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3795, file "VIRO.adl"
    SERVICE Artikel : I[Artikel]
   = [ tekst : wetstekst
     , handeling : handeling
     , orgaan : orgaan
     , werkwoord : werkwoord
     , objecttype : objecttype
     ]
   *********/
  
  class Artikel {
    protected $_id=false;
    protected $_new=true;
    private $_tekst;
    private $_handeling;
    private $_orgaan;
    private $_werkwoord;
    private $_objecttype;
    function Artikel($id=null, $tekst=null, $handeling=null, $orgaan=null, $werkwoord=null, $objecttype=null){
      $this->_id=$id;
      $this->_tekst=$tekst;
      $this->_handeling=$handeling;
      $this->_orgaan=$orgaan;
      $this->_werkwoord=$werkwoord;
      $this->_objecttype=$objecttype;
      if(!isset($tekst) && isset($id)){
        // get a Artikel based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttArtikel` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttArtikel`, `i`
                                  FROM `artikel`
                              ) AS fst
                          WHERE fst.`AttArtikel` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['tekst']=firstCol(DB_doquer("SELECT DISTINCT `wetstekst`.`tekst`
                                             FROM `wetstekst`
                                            WHERE `wetstekst`.`artikel`='".addslashes($id)."'"));
          $me['handeling']=firstCol(DB_doquer("SELECT DISTINCT `handelingartikel`.`handeling`
                                                 FROM `handelingartikel`
                                                WHERE `handelingartikel`.`artikel`='".addslashes($id)."'"));
          $me['orgaan']=firstCol(DB_doquer("SELECT DISTINCT `orgaanartikel`.`orgaan`
                                              FROM `orgaanartikel`
                                             WHERE `orgaanartikel`.`artikel`='".addslashes($id)."'"));
          $me['werkwoord']=firstCol(DB_doquer("SELECT DISTINCT `werkwoordartikel`.`werkwoord`
                                                 FROM `werkwoordartikel`
                                                WHERE `werkwoordartikel`.`artikel`='".addslashes($id)."'"));
          $me['objecttype']=firstCol(DB_doquer("SELECT DISTINCT `objecttypeartikel`.`objecttype`
                                                  FROM `objecttypeartikel`
                                                 WHERE `objecttypeartikel`.`artikel`='".addslashes($id)."'"));
          $this->set_tekst($me['tekst']);
          $this->set_handeling($me['handeling']);
          $this->set_orgaan($me['orgaan']);
          $this->set_werkwoord($me['werkwoord']);
          $this->set_objecttype($me['objecttype']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttArtikel` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttArtikel`, `i`
                                  FROM `artikel`
                              ) AS fst
                          WHERE fst.`AttArtikel` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "tekst" => $this->_tekst, "handeling" => $this->_handeling, "orgaan" => $this->_orgaan, "werkwoord" => $this->_werkwoord, "objecttype" => $this->_objecttype);
      foreach($me['orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['orgaan'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['tekst'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['tekst'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['objecttype'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoord` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($me['id'])."'",5);
      foreach  ($me['tekst'] as $tekst){
        $res=DB_doquer("INSERT IGNORE INTO `wetstekst` (`tekst`,`artikel`) VALUES ('".addslashes($tekst)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `handelingartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      foreach  ($me['handeling'] as $handeling){
        $res=DB_doquer("INSERT IGNORE INTO `handelingartikel` (`handeling`,`artikel`) VALUES ('".addslashes($handeling)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `orgaanartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      foreach  ($me['orgaan'] as $orgaan){
        $res=DB_doquer("INSERT IGNORE INTO `orgaanartikel` (`orgaan`,`artikel`) VALUES ('".addslashes($orgaan)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `werkwoordartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      foreach  ($me['werkwoord'] as $werkwoord){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoordartikel` (`werkwoord`,`artikel`) VALUES ('".addslashes($werkwoord)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `objecttypeartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      foreach  ($me['objecttype'] as $objecttype){
        $res=DB_doquer("INSERT IGNORE INTO `objecttypeartikel` (`objecttype`,`artikel`) VALUES ('".addslashes($objecttype)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
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
      $me=array("id"=>$this->getId(), "tekst" => $this->_tekst, "handeling" => $this->_handeling, "orgaan" => $this->_orgaan, "werkwoord" => $this->_werkwoord, "objecttype" => $this->_objecttype);
      foreach($me['orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['tekst'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `handelingartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `orgaanartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `werkwoordartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `objecttypeartikel` WHERE `artikel`='".addslashes($me['id'])."'",5);
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_tekst($val){
      $this->_tekst=$val;
    }
    function get_tekst(){
      if(!isset($this->_tekst)) return array();
      return $this->_tekst;
    }
    function set_handeling($val){
      $this->_handeling=$val;
    }
    function get_handeling(){
      if(!isset($this->_handeling)) return array();
      return $this->_handeling;
    }
    function set_orgaan($val){
      $this->_orgaan=$val;
    }
    function get_orgaan(){
      if(!isset($this->_orgaan)) return array();
      return $this->_orgaan;
    }
    function set_werkwoord($val){
      $this->_werkwoord=$val;
    }
    function get_werkwoord(){
      if(!isset($this->_werkwoord)) return array();
      return $this->_werkwoord;
    }
    function set_objecttype($val){
      $this->_objecttype=$val;
    }
    function get_objecttype(){
      if(!isset($this->_objecttype)) return array();
      return $this->_objecttype;
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

  function getEachArtikel(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `artikel`'));
  }

  function readArtikel($id){
      // check existence of $id
      $obj = new Artikel($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delArtikel($id){
    $tobeDeleted = new Artikel($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>