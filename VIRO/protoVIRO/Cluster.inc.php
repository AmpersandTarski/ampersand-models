<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 656, file "VIRO453ENG.adl"
    SERVICE Cluster : I[Cluster]
   = [ name : name
     , base : base
     , case : cluster~
        = [ caretaker of case file : caretaker
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     ]
   *********/
  
  class Cluster {
    protected $_id=false;
    protected $_new=true;
    private $_name;
    private $_base;
    private $_case;
    function Cluster($id=null, $name=null, $base=null, $case=null){
      $this->_id=$id;
      $this->_name=$name;
      $this->_base=$base;
      $this->_case=$case;
      if(!isset($name) && isset($id)){
        // get a Cluster based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCluster` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCluster`, `i`
                                  FROM `cluster`
                              ) AS fst
                          WHERE fst.`AttCluster` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `base`.`cluster` AS `id`
                                       , `cluster`.`name`
                                    FROM `base`
                                    LEFT JOIN `cluster` ON `cluster`.`i`='".addslashes($id)."'
                                   WHERE `base`.`cluster`='".addslashes($id)."'"));
          $me['base']=firstCol(DB_doquer("SELECT DISTINCT `base`.`text` AS `base`
                                            FROM `base`
                                           WHERE `base`.`cluster`='".addslashes($id)."'"));
          $me['case']=(DB_doquer("SELECT DISTINCT `f1`.`case` AS `id`
                                    FROM `cluster`
                                    JOIN `clustercase` AS f1 ON `f1`.`Cluster`='".addslashes($id)."'
                                   WHERE `cluster`.`i`='".addslashes($id)."'"));
          foreach($me['case'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`caretaker` AS `caretaker of case file`
                                         , `f3`.`areaoflaw` AS `area of law`
                                         , `f4`.`casetype` AS `type of case`
                                      FROM `case`
                                      LEFT JOIN `case` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_name($me['name']);
          $this->set_base($me['base']);
          $this->set_case($me['case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCluster` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCluster`, `i`
                                  FROM `cluster`
                              ) AS fst
                          WHERE fst.`AttCluster` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "name" => $this->_name, "base" => $this->_base, "case" => $this->_case);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `case` (`i`,`caretaker`,`areaoflaw`,`casetype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['caretaker of case file'])."', '".addslashes($v0['area of law'])."', '".addslashes($v0['type of case'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `cluster` (`name`,`i`) VALUES ('".addslashes($me['name'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0['caretaker of case file'])."')", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0['type of case'])."')", 5);
      }
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['name'])."'",5);
      foreach($me['base'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['name'])."')", 5);
      foreach($me['base'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for case,case in plaintiff
      DB_doquer("DELETE FROM `base` WHERE `cluster`='".addslashes($me['id'])."'",5);
      foreach  ($me['base'] as $base){
        $res=DB_doquer("INSERT IGNORE INTO `base` (`text`,`cluster`) VALUES ('".addslashes($base)."', '".addslashes($me['id'])."')", 5);
      }
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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
      $me=array("id"=>$this->getId(), "name" => $this->_name, "base" => $this->_base, "case" => $this->_case);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['name'])."'",5);
      foreach($me['base'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `base` WHERE `cluster`='".addslashes($me['id'])."'",5);
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_name($val){
      $this->_name=$val;
    }
    function get_name(){
      return $this->_name;
    }
    function set_base($val){
      $this->_base=$val;
    }
    function get_base(){
      if(!isset($this->_base)) return array();
      return $this->_base;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
      if(!isset($this->_case)) return array();
      return $this->_case;
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

  function getEachCluster(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `cluster`'));
  }

  function readCluster($id){
      // check existence of $id
      $obj = new Cluster($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCluster($id){
    $tobeDeleted = new Cluster($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>