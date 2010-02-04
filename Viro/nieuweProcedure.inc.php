<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3700, file "VIRO.adl"
    SERVICE nieuweProcedure : I[Procedur]
   = [ zorgdrager voor dossier : zorgdrager
     , rechtsgebied : rechtsgebied
     , proceduresoort : proceduresoort
     ]
   *********/
  
  class nieuweProcedure {
    protected $_id=false;
    protected $_new=true;
    private $_zorgdragervoordossier;
    private $_rechtsgebied;
    private $_proceduresoort;
    function nieuweProcedure($id=null, $zorgdragervoordossier=null, $rechtsgebied=null, $proceduresoort=null){
      $this->_id=$id;
      $this->_zorgdragervoordossier=$zorgdragervoordossier;
      $this->_rechtsgebied=$rechtsgebied;
      $this->_proceduresoort=$proceduresoort;
      if(!isset($zorgdragervoordossier) && isset($id)){
        // get a nieuweProcedure based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcedur` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcedur`, `i`
                                  FROM `procedur`
                              ) AS fst
                          WHERE fst.`AttProcedur` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `eiser`.`procedur` AS `id`
                                       , `procedur`.`zorgdrager` AS `zorgdrager voor dossier`
                                       , `procedur`.`rechtsgebied`
                                       , `procedur`.`proceduresoort`
                                    FROM `eiser`
                                    LEFT JOIN `procedur` ON `procedur`.`i`='".addslashes($id)."'
                                   WHERE `eiser`.`procedur`='".addslashes($id)."'"));
          $this->set_zorgdragervoordossier($me['zorgdrager voor dossier']);
          $this->set_rechtsgebied($me['rechtsgebied']);
          $this->set_proceduresoort($me['proceduresoort']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcedur` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcedur`, `i`
                                  FROM `procedur`
                              ) AS fst
                          WHERE fst.`AttProcedur` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort);
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `procedur` (`zorgdrager`,`rechtsgebied`,`proceduresoort`,`i`) VALUES ('".addslashes($me['zorgdrager voor dossier'])."', '".addslashes($me['rechtsgebied'])."', '".addslashes($me['proceduresoort'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($me['zorgdrager voor dossier'])."')", 5);
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($me['rechtsgebied'])."')", 5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($me['proceduresoort'])."')", 5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule28()){
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
      $me=array("id"=>$this->getId(), "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort);
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_zorgdragervoordossier($val){
      $this->_zorgdragervoordossier=$val;
    }
    function get_zorgdragervoordossier(){
      return $this->_zorgdragervoordossier;
    }
    function set_rechtsgebied($val){
      $this->_rechtsgebied=$val;
    }
    function get_rechtsgebied(){
      return $this->_rechtsgebied;
    }
    function set_proceduresoort($val){
      $this->_proceduresoort=$val;
    }
    function get_proceduresoort(){
      return $this->_proceduresoort;
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

  function getEachnieuweProcedure(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `procedur`'));
  }

  function readnieuweProcedure($id){
      // check existence of $id
      $obj = new nieuweProcedure($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delnieuweProcedure($id){
    $tobeDeleted = new nieuweProcedure($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>