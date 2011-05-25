<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 281, file "VIROENG.adl"
    SERVICE Process : I[Process]
   = [ session : session
        = [ court : location
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , date of occurence : occured
          ]
     , case : legalCase
        = [ area of law : areaOfLaw
          , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
          , session : legalCase~;session
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
                                       , `process`.`legalcase` AS `case`
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
                                            FROM `legalcase`
                                            LEFT JOIN `legalcase` AS f2 ON `f2`.`i`='".addslashes($v0)."'
                                           WHERE `legalcase`.`i`='".addslashes($v0)."'"));
          $me['case']['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                            FROM `legalcase`
                                                            JOIN  ( 
                                                                         (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                               FROM `appeal` AS F0, `legalcase` AS F1
                                                                              WHERE F0.`legalcase1`=F1.`i`
                                                                         ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                               FROM `appealtoadmincourt` AS F0, `legalcase` AS F1
                                                                              WHERE F0.`legalcase1`=F1.`i`
                                                                         ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                               FROM `objection` AS F0, `legalcase` AS F1
                                                                              WHERE F0.`legalcase1`=F1.`i`
                                                                         
                                                                         
                                                                         )
                                                                       ) AS f1
                                                              ON `f1`.`legalcase`='".addslashes($v0)."'
                                                           WHERE `legalcase`.`i`='".addslashes($v0)."'"));
          $me['case']['session']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`session`
                                                       FROM `legalcase`
                                                       JOIN  ( SELECT DISTINCT F0.`legalcase`, F1.`session`
                                                                      FROM `process` AS F0, `process` AS F1
                                                                     WHERE F0.`i`=F1.`i`
                                                                  ) AS f1
                                                         ON `f1`.`legalcase`='".addslashes($v0)."'
                                                      WHERE `legalcase`.`i`='".addslashes($v0)."'"));
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
        DB_doquer("UPDATE `legalcase` SET `areaoflaw`='".addslashes($me['case']['area of law'])."' WHERE `i`='".addslashes($me['case']['id'])."'", 5);
      DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `process` (`session`,`legalcase`,`i`) VALUES ('".addslashes($me['session']['id'])."', '".addslashes($me['case']['id'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for case,legalcase in process
      // no code for court,i in court
      // no code for judge,i in party
      // no code for clerk,i in party
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['case']['area of law'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($me['case']['area of law'])."')", 5);
      foreach($me['case']['type of case'] as $i1=>$v1){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
      }
      foreach($me['case']['type of case'] as $i1=>$v1){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
      }
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['date of occurence'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['session']['scheduled'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['session']['date of occurence'])."')", 5);
      // no code for case,legalcase in plaintiff
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['session']['id'])."'",5);
      foreach  ($me['session']['judge'] as $judge){
        $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($me['session']['id'])."', '".addslashes($judge)."')", 5);
      }
      // no code for session,session in judge
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
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
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
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
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['case']['area of law'])."'",5);
      foreach($me['case']['type of case'] as $i1=>$v1){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
      }
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['session']['date of occurence'])."'",5);
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['session']['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
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
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
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
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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