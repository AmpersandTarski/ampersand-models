<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 341, file "VIRO453ENG.adl"
    SERVICE Organ : I[Organ]
   = [ current acts : organ~;act
        = [ act : [Act]
          , prio : use_case~;prio
          , usecase : use_case~
          , rol : may
          ]
     , actions : as~
        = [ actie : [Action]
          , subject : subject
          , type : actionType
          ]
     , case files : caretaker~
        = [ case : [Case]
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     ]
   *********/
  
  class Organ {
    protected $_id=false;
    protected $_new=true;
    private $_currentacts;
    private $_actions;
    private $_casefiles;
    function Organ($id=null, $currentacts=null, $actions=null, $casefiles=null){
      $this->_id=$id;
      $this->_currentacts=$currentacts;
      $this->_actions=$actions;
      $this->_casefiles=$casefiles;
      if(!isset($currentacts) && isset($id)){
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
          $me['current acts']=(DB_doquer("SELECT DISTINCT `f1`.`Act` AS `id`
                                            FROM `organ`
                                            JOIN  ( SELECT DISTINCT F0.`Organ`, F1.`Act`
                                                           FROM `organarticle` AS F0, `actarticle` AS F1
                                                          WHERE F0.`article`=F1.`article`
                                                       ) AS f1
                                              ON `f1`.`Organ`='".addslashes($id)."'
                                           WHERE `organ`.`i`='".addslashes($id)."'"));
          $me['actions']=(DB_doquer("SELECT DISTINCT `f1`.`action` AS `id`
                                       FROM `organ`
                                       JOIN `as` AS f1 ON `f1`.`Organ`='".addslashes($id)."'
                                      WHERE `organ`.`i`='".addslashes($id)."'"));
          $me['case files']=(DB_doquer("SELECT DISTINCT `case`.`i` AS `id`
                                          FROM `case`
                                         WHERE `case`.`caretaker`='".addslashes($id)."'"));
          foreach($me['current acts'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `act`
                                      FROM `act`
                                     WHERE `act`.`i`='".addslashes($v0['id'])."'"));
            $v0['prio']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`prio`
                                              FROM `act`
                                              JOIN  ( SELECT DISTINCT F0.`Act`, F1.`prio`
                                                             FROM `use_case` AS F0, `usecase` AS F1
                                                            WHERE F0.`usecase`=F1.`i`
                                                         ) AS f1
                                                ON `f1`.`Act`='".addslashes($v0['id'])."'
                                             WHERE `act`.`i`='".addslashes($v0['id'])."'"));
            $v0['usecase']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`usecase`
                                                 FROM `act`
                                                 JOIN `use_case` AS f1 ON `f1`.`Act`='".addslashes($v0['id'])."'
                                                WHERE `act`.`i`='".addslashes($v0['id'])."'"));
            $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                             FROM `act`
                                             JOIN `may` AS f1 ON `f1`.`act`='".addslashes($v0['id'])."'
                                            WHERE `act`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['actions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `actie`
                                         , `f3`.`subject`
                                         , `f4`.`actiontype` AS `type`
                                      FROM `action`
                                      LEFT JOIN `action` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `action` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `action`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
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
          $this->set_currentacts($me['current acts']);
          $this->set_actions($me['actions']);
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
      $me=array("id"=>$this->getId(), "current acts" => $this->_currentacts, "actions" => $this->_actions, "case files" => $this->_casefiles);
      foreach($me['case files'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `case` SET `i`='".addslashes($v0['id'])."', `areaoflaw`='".addslashes($v0['area of law'])."', `casetype`='".addslashes($v0['type of case'])."' WHERE `i`='".addslashes($v0['case'])."'", 5);
      }
      foreach  ($me['case files'] as $casefiles){
        if(isset($me['id']))
          DB_doquer("UPDATE `case` SET `caretaker`='".addslashes($me['id'])."' WHERE `i`='".addslashes($casefiles['id'])."'", 5);
      }
      // no code for case,i in case
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `action` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['actions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `action` (`i`,`subject`,`actiontype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['subject'])."', '".addslashes($v0['type'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for actie,i in action
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['actions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['subject'])."')", 5);
      }
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
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['act'])."'",5);
      }
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `act` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['current acts'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `act` (`i`) VALUES ('".addslashes($v0['act'])."')", 5);
      }
      foreach($me['actions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `act` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for case files,case in plaintiff
      // no code for case,case in plaintiff
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `may` WHERE `act`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `may` (`role`,`act`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat as vertegenwoordiger from het organ dat de act uitvoert\"';
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
      if (!checkRule14()){
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
      $me=array("id"=>$this->getId(), "current acts" => $this->_currentacts, "actions" => $this->_actions, "case files" => $this->_casefiles);
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `action` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case files'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['act'])."'",5);
      }
      foreach($me['actions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['current acts'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['current acts'] as $i0=>$v0){
        DB_doquer("DELETE FROM `may` WHERE `act`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat as vertegenwoordiger from het organ dat de act uitvoert\"';
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
      if (!checkRule14()){
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_currentacts($val){
      $this->_currentacts=$val;
    }
    function get_currentacts(){
      if(!isset($this->_currentacts)) return array();
      return $this->_currentacts;
    }
    function set_actions($val){
      $this->_actions=$val;
    }
    function get_actions(){
      if(!isset($this->_actions)) return array();
      return $this->_actions;
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