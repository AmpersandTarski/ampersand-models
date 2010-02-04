<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 446, file "VIRO.adl"
    SERVICE Brief : I[Document]
   = [ zaaksdossier : zaaksdossier
     , type : type
     , van : van
     , aan : aan
     , kenmerk : kenmerkVan
     , verzonden : verzonden
     , ontvangen : ontvangen
     ]
   *********/
  
  class Brief {
    protected $_id=false;
    protected $_new=true;
    private $_zaaksdossier;
    private $_type;
    private $_van;
    private $_aan;
    private $_kenmerk;
    private $_verzonden;
    private $_ontvangen;
    function Brief($id=null, $zaaksdossier=null, $type=null, $van=null, $aan=null, $kenmerk=null, $verzonden=null, $ontvangen=null){
      $this->_id=$id;
      $this->_zaaksdossier=$zaaksdossier;
      $this->_type=$type;
      $this->_van=$van;
      $this->_aan=$aan;
      $this->_kenmerk=$kenmerk;
      $this->_verzonden=$verzonden;
      $this->_ontvangen=$ontvangen;
      if(!isset($zaaksdossier) && isset($id)){
        // get a Brief based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `aan`.`document` AS `id`
                                       , `document`.`type`
                                       , `document`.`van`
                                       , `document`.`kenmerkvan` AS `kenmerk`
                                       , `document`.`verzonden`
                                       , `document`.`ontvangen`
                                    FROM `aan`
                                    LEFT JOIN `document` ON `document`.`i`='".addslashes($id)."'
                                   WHERE `aan`.`document`='".addslashes($id)."'"));
          $me['zaaksdossier']=firstCol(DB_doquer("SELECT DISTINCT `zaaksdossier`.`procedur` AS `zaaksdossier`
                                                    FROM `zaaksdossier`
                                                   WHERE `zaaksdossier`.`document`='".addslashes($id)."'"));
          $me['aan']=firstCol(DB_doquer("SELECT DISTINCT `aan`.`persoon` AS `aan`
                                           FROM `aan`
                                          WHERE `aan`.`document`='".addslashes($id)."'"));
          $this->set_zaaksdossier($me['zaaksdossier']);
          $this->set_type($me['type']);
          $this->set_van($me['van']);
          $this->set_aan($me['aan']);
          $this->set_kenmerk($me['kenmerk']);
          $this->set_verzonden($me['verzonden']);
          $this->set_ontvangen($me['ontvangen']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "zaaksdossier" => $this->_zaaksdossier, "type" => $this->_type, "van" => $this->_van, "aan" => $this->_aan, "kenmerk" => $this->_kenmerk, "verzonden" => $this->_verzonden, "ontvangen" => $this->_ontvangen);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `document` (`type`,`van`,`kenmerkvan`,`verzonden`,`ontvangen`,`i`) VALUES ('".addslashes($me['type'])."', '".addslashes($me['van'])."', '".addslashes($me['kenmerk'])."', '".addslashes($me['verzonden'])."', ".((null!=$me['ontvangen'])?"'".addslashes($me['ontvangen'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for zaaksdossier,i in procedur
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['van'])."'",5);
      foreach($me['aan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['van'])."')", 5);
      foreach($me['aan'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($me['kenmerk'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($me['kenmerk'])."')", 5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['verzonden'])."'",5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['ontvangen'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($me['verzonden'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($me['ontvangen'])."')", 5);
      DB_doquer("DELETE FROM `zaaksdossier` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['zaaksdossier'] as $zaaksdossier){
        $res=DB_doquer("INSERT IGNORE INTO `zaaksdossier` (`procedur`,`document`) VALUES ('".addslashes($zaaksdossier)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for zaaksdossier,procedur in eiser
      DB_doquer("DELETE FROM `aan` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['aan'] as $aan){
        $res=DB_doquer("INSERT IGNORE INTO `aan` (`persoon`,`document`) VALUES ('".addslashes($aan)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
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
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
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
      if (!checkRule80()){
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
      $me=array("id"=>$this->getId(), "zaaksdossier" => $this->_zaaksdossier, "type" => $this->_type, "van" => $this->_van, "aan" => $this->_aan, "kenmerk" => $this->_kenmerk, "verzonden" => $this->_verzonden, "ontvangen" => $this->_ontvangen);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['van'])."'",5);
      foreach($me['aan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($me['kenmerk'])."'",5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['verzonden'])."'",5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['ontvangen'])."'",5);
      DB_doquer("DELETE FROM `zaaksdossier` WHERE `document`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `aan` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
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
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
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
      if (!checkRule80()){
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
    function set_zaaksdossier($val){
      $this->_zaaksdossier=$val;
    }
    function get_zaaksdossier(){
      if(!isset($this->_zaaksdossier)) return array();
      return $this->_zaaksdossier;
    }
    function set_type($val){
      $this->_type=$val;
    }
    function get_type(){
      return $this->_type;
    }
    function set_van($val){
      $this->_van=$val;
    }
    function get_van(){
      return $this->_van;
    }
    function set_aan($val){
      $this->_aan=$val;
    }
    function get_aan(){
      if(!isset($this->_aan)) return array();
      return $this->_aan;
    }
    function set_kenmerk($val){
      $this->_kenmerk=$val;
    }
    function get_kenmerk(){
      return $this->_kenmerk;
    }
    function set_verzonden($val){
      $this->_verzonden=$val;
    }
    function get_verzonden(){
      return $this->_verzonden;
    }
    function set_ontvangen($val){
      $this->_ontvangen=$val;
    }
    function get_ontvangen(){
      return $this->_ontvangen;
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

  function getEachBrief(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `document`'));
  }

  function readBrief($id){
      // check existence of $id
      $obj = new Brief($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delBrief($id){
    $tobeDeleted = new Brief($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>