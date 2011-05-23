<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 646, file "VIRO453ENG.adl"
    SERVICE newCase : I[Case]
   = [ caretaker voor dossier : caretaker
     , area of law : areaOfLaw
     , type of case : caseType
     ]
   *********/
  
  class newCase {
    protected $_id=false;
    protected $_new=true;
    private $_caretakervoordossier;
    private $_areaoflaw;
    private $_typeofcase;
    function newCase($id=null, $caretakervoordossier=null, $areaoflaw=null, $typeofcase=null){
      $this->_id=$id;
      $this->_caretakervoordossier=$caretakervoordossier;
      $this->_areaoflaw=$areaoflaw;
      $this->_typeofcase=$typeofcase;
      if(!isset($caretakervoordossier) && isset($id)){
        // get a newCase based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCase`, `i`
                                  FROM `case`
                              ) AS fst
                          WHERE fst.`AttCase` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `plaintiff`.`case` AS `id`
                                       , `case`.`caretaker` AS `caretaker voor dossier`
                                       , `case`.`areaoflaw` AS `area of law`
                                       , `case`.`casetype` AS `type of case`
                                    FROM `plaintiff`
                                    LEFT JOIN `case` ON `case`.`i`='".addslashes($id)."'
                                   WHERE `plaintiff`.`case`='".addslashes($id)."'"));
          $this->set_caretakervoordossier($me['caretaker voor dossier']);
          $this->set_areaoflaw($me['area of law']);
          $this->set_typeofcase($me['type of case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCase`, `i`
                                  FROM `case`
                              ) AS fst
                          WHERE fst.`AttCase` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "caretaker voor dossier" => $this->_caretakervoordossier, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase);
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `case` (`caretaker`,`areaoflaw`,`casetype`,`i`) VALUES ('".addslashes($me['caretaker voor dossier'])."', '".addslashes($me['area of law'])."', '".addslashes($me['type of case'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker voor dossier'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($me['caretaker voor dossier'])."')", 5);
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($me['area of law'])."')", 5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['type of case'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($me['type of case'])."')", 5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
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
      $me=array("id"=>$this->getId(), "caretaker voor dossier" => $this->_caretakervoordossier, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase);
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker voor dossier'])."'",5);
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['type of case'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_caretakervoordossier($val){
      $this->_caretakervoordossier=$val;
    }
    function get_caretakervoordossier(){
      return $this->_caretakervoordossier;
    }
    function set_areaoflaw($val){
      $this->_areaoflaw=$val;
    }
    function get_areaoflaw(){
      return $this->_areaoflaw;
    }
    function set_typeofcase($val){
      $this->_typeofcase=$val;
    }
    function get_typeofcase(){
      return $this->_typeofcase;
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

  function getEachnewCase(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `case`'));
  }

  function readnewCase($id){
      // check existence of $id
      $obj = new newCase($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delnewCase($id){
    $tobeDeleted = new newCase($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>