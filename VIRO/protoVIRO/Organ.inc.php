<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 296, file "VIRO453ENG.adl"
    SERVICE Organ : I[Organ]
   = [ case files : caretaker~
        = [ case : [Case]
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     ]
   *********/
  
  class Organ {
    protected $_id=false;
    protected $_new=true;
    private $_casefiles;
    function Organ($id=null, $casefiles=null){
      $this->_id=$id;
      $this->_casefiles=$casefiles;
      if(!isset($casefiles) && isset($id)){
        // get a Organ based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOrgan` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttOrgan`, `i`
                                  FROM `organ`
                              ) AS fst
                          WHERE fst.`AttOrgan` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['case files']=(DB_doquer("SELECT DISTINCT `case`.`i` AS `id`
                                          FROM `case`
                                         WHERE `case`.`caretaker`='".addslashes($id)."'"));
          foreach($me['case files'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `case`
                                         , `f3`.`areaoflaw` AS `area of law`
                                         , `f4`.`casetype` AS `type of case`
                                      FROM `case`
                                      LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_casefiles($me['case files']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOrgan` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttOrgan`, `i`
                                  FROM `organ`
                              ) AS fst
                          WHERE fst.`AttOrgan` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "case files" => $this->_casefiles);
      foreach($me['case files'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `case` SET `i`='".addslashes($v0['id'])."', `areaoflaw`='".addslashes($v0['area of law'])."', `casetype`='".addslashes($v0['type of case'])."' WHERE `i`='".addslashes($v0['case'])."'", 5);
      }
      foreach  ($me['case files'] as $casefiles){
        if(isset($me['id']))
          DB_doquer("UPDATE `case` SET `caretaker`='".addslashes($me['id'])."' WHERE `i`='".addslashes($casefiles['id'])."'", 5);
      }
      // no code for case,i in case
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case files'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['case files'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0['type of case'])."')", 5);
      }
      // no code for case files,case in plaintiff
      // no code for case,case in plaintiff
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
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
      if (!checkRule21()){
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
      $me=array("id"=>$this->getId(), "case files" => $this->_casefiles);
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
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
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_casefiles($val){
      $this->_casefiles=$val;
    }
    function get_casefiles(){
      if(!isset($this->_casefiles)) return array();
      return $this->_casefiles;
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

  function getEachOrgan(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `organ`'));
  }

  function readOrgan($id){
      // check existence of $id
      $obj = new Organ($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delOrgan($id){
    $tobeDeleted = new Organ($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>