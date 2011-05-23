<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 763, file "VIRO453ENG.adl"
    SERVICE Process : I[Process]
   = [ session : session
        = [ court : location
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , date of occurence : occured
          ]
     , case : case
        = [ area of law : areaOfLaw
          , type of case : caseType
          , session : case~;session
          ]
     ]
   *********/
  
  class Process {
    protected $_id=false;
    protected $_new=true;
    private $_session;
    private $_case;
    function Process($id=null, $session=null, $case=null){
      $this->_id=$id;
      $this->_session=$session;
      $this->_case=$case;
      if(!isset($session) && isset($id)){
        // get a Process based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcess` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcess`, `i`
                                  FROM `process`
                              ) AS fst
                          WHERE fst.`AttProcess` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `process`.`i` AS `id`
                                       , `process`.`session`
                                       , `process`.`case`
                                    FROM `process`
                                   WHERE `process`.`i`='".addslashes($id)."'"));
          $v0 = $me['session'];
          $me['session']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0)."' AS `id`
                                                  , `f2`.`location` AS `court`
                                                  , `f3`.`clerk`
                                                  , `f4`.`scheduled`
                                                  , `f5`.`occured` AS `date of occurence`
                                               FROM `session`
                                               LEFT JOIN `session` AS f2 ON `f2`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0)."'
                                               LEFT JOIN `session` AS f5 ON `f5`.`i`='".addslashes($v0)."'
                                              WHERE `session`.`i`='".addslashes($v0)."'"));
          $me['session']['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                                        FROM `session`
                                                        JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0)."'
                                                       WHERE `session`.`i`='".addslashes($v0)."'"));
          $v0 = $me['case'];
          $me['case']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0)."' AS `id`
                                               , `f2`.`areaoflaw` AS `area of law`
                                               , `f3`.`casetype` AS `type of case`
                                            FROM `case`
                                            LEFT JOIN `case` AS f2 ON `f2`.`i`='".addslashes($v0)."'
                                            LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0)."'
                                           WHERE `case`.`i`='".addslashes($v0)."'"));
          $me['case']['session']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`session`
                                                       FROM `case`
                                                       JOIN  ( SELECT DISTINCT F0.`case`, F1.`session`
                                                                      FROM `process` AS F0, `process` AS F1
                                                                     WHERE F0.`i`=F1.`i`
                                                                  ) AS f1
                                                         ON `f1`.`case`='".addslashes($v0)."'
                                                      WHERE `case`.`i`='".addslashes($v0)."'"));
          $this->set_session($me['session']);
          $this->set_case($me['case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcess` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcess`, `i`
                                  FROM `process`
                              ) AS fst
                          WHERE fst.`AttProcess` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "session" => $this->_session, "case" => $this->_case);
      if(isset($me['session']['id']))
        DB_doquer("UPDATE `session` SET `location`='".addslashes($me['session']['court'])."', `clerk`='".addslashes($me['session']['clerk'])."', `scheduled`='".addslashes($me['session']['scheduled'])."', `occured`=".((null!=$me['session']['date of occurence'])?"'".addslashes($me['session']['date of occurence'])."'":"NULL")." WHERE `i`='".addslashes($me['session']['id'])."'", 5);
      // no code for session,i in session
      if(isset($me['case']['id']))
        DB_doquer("UPDATE `case` SET `areaoflaw`='".addslashes($me['case']['area of law'])."', `casetype`='".addslashes($me['case']['type of case'])."' WHERE `i`='".addslashes($me['case']['id'])."'", 5);
      DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `process` (`session`,`case`,`i`) VALUES ('".addslashes($me['session']['id'])."', '".addslashes($me['case']['id'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for case,case in process
      // no code for court,i in court
      foreach($me['session']['judge'] as $i1=>$v1){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['session']['clerk'])."'",5);
      foreach($me['session']['judge'] as $i1=>$v1){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($me['session']['clerk'])."')", 5);
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['case']['area of law'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($me['case']['area of law'])."')", 5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['case']['type of case'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($me['case']['type of case'])."')", 5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['date of occurence'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['session']['scheduled'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['session']['date of occurence'])."')", 5);
      // no code for case,case in plaintiff
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['session']['id'])."'",5);
      foreach  ($me['session']['judge'] as $judge){
        $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($me['session']['id'])."', '".addslashes($judge)."')", 5);
      }
      // no code for session,session in judge
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
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
      $me=array("id"=>$this->getId(), "session" => $this->_session, "case" => $this->_case);
      DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['session']['judge'] as $i1=>$v1){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['session']['clerk'])."'",5);
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['case']['area of law'])."'",5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['case']['type of case'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['date of occurence'])."'",5);
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['session']['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
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
    function set_session($val){
      $this->_session=$val;
    }
    function get_session(){
      return $this->_session;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
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

  function getEachProcess(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `process`'));
  }

  function readProcess($id){
      // check existence of $id
      $obj = new Process($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delProcess($id){
    $tobeDeleted = new Process($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>