<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 227, file "VIROENG.adl"
    SERVICE Session : I[Session]
   = [ court : location
     , panel : panel
     , city : location;seatedIn
     , judge : judge
     , clerk : clerk
     , scheduled : scheduled
     , date of occurence : occured
     , cases : session~;legalCase
        = [ nr : [LegalCase]
          , plaintiff : plaintiff~
          , defendant : defendant~
          ]
     ]
   *********/
  
  class Session {
    protected $_id=false;
    protected $_new=true;
    private $_court;
    private $_panel;
    private $_city;
    private $_judge;
    private $_clerk;
    private $_scheduled;
    private $_dateofoccurence;
    private $_cases;
    function Session($id=null, $court=null, $panel=null, $city=null, $judge=null, $clerk=null, $scheduled=null, $dateofoccurence=null, $cases=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_panel=$panel;
      $this->_city=$city;
      $this->_judge=$judge;
      $this->_clerk=$clerk;
      $this->_scheduled=$scheduled;
      $this->_dateofoccurence=$dateofoccurence;
      $this->_cases=$cases;
      if(!isset($court) && isset($id)){
        // get a Session based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSession`, `i`
                                  FROM `session`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `judge`.`session` AS `id`
                                       , `session`.`location` AS `court`
                                       , `session`.`panel`
                                       , `session`.`clerk`
                                       , `session`.`scheduled`
                                       , `session`.`occured` AS `date of occurence`
                                       , `f1`.`seatedin` AS `city`
                                    FROM `judge`
                                    LEFT JOIN `session` ON `session`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`seatedin`
                                                   FROM `session` AS F0, `court` AS F1
                                                  WHERE F0.`location`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `judge`.`session`='".addslashes($id)."'"));
          $me['judge']=firstCol(DB_doquer("SELECT DISTINCT `judge`.`party` AS `judge`
                                             FROM `judge`
                                            WHERE `judge`.`session`='".addslashes($id)."'"));
          $me['cases']=(DB_doquer("SELECT DISTINCT `process`.`legalcase` AS `id`
                                     FROM `process`
                                    WHERE `process`.`session`='".addslashes($id)."'"));
          foreach($me['cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                      FROM `legalcase`
                                     WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
            $v0['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `plaintiff`
                                                   FROM `legalcase`
                                                   JOIN `plaintiff` AS f1 ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                                  WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
            $v0['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                   FROM `legalcase`
                                                   JOIN `defendant` AS f1 ON `f1`.`LegalCase`='".addslashes($v0['id'])."'
                                                  WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_court($me['court']);
          $this->set_panel($me['panel']);
          $this->set_city($me['city']);
          $this->set_judge($me['judge']);
          $this->set_clerk($me['clerk']);
          $this->set_scheduled($me['scheduled']);
          $this->set_dateofoccurence($me['date of occurence']);
          $this->set_cases($me['cases']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSession`, `i`
                                  FROM `session`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "city" => $this->_city, "judge" => $this->_judge, "clerk" => $this->_clerk, "scheduled" => $this->_scheduled, "date of occurence" => $this->_dateofoccurence, "cases" => $this->_cases);
      DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `session` (`location`,`panel`,`clerk`,`scheduled`,`occured`,`i`) VALUES ('".addslashes($me['court'])."', '".addslashes($me['panel'])."', '".addslashes($me['clerk'])."', '".addslashes($me['scheduled'])."', ".((null!=$me['date of occurence'])?"'".addslashes($me['date of occurence'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['cases'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in legalcase
      // no code for city,i in city
      // no code for Session,session in process
      // no code for court,i in court
      // no code for judge,i in party
      // no code for clerk,i in party
      // no code for plaintiff,i in party
      // no code for defendant,i in party
      // no code for panel,i in panel
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['date of occurence'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['scheduled'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['date of occurence'])."')", 5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach  ($v0['plaintiff'] as $plaintiff){
          $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`legalcase`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($plaintiff)."')", 5);
        }
      }
      // no code for nr,legalcase in plaintiff
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['id'])."'",5);
      foreach  ($me['judge'] as $judge){
        $res=DB_doquer("INSERT IGNORE INTO `judge` (`party`,`session`) VALUES ('".addslashes($judge)."', '".addslashes($me['id'])."')", 5);
      }
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
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
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
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
      if (!checkRule61()){
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "city" => $this->_city, "judge" => $this->_judge, "clerk" => $this->_clerk, "scheduled" => $this->_scheduled, "date of occurence" => $this->_dateofoccurence, "cases" => $this->_cases);
      DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['date of occurence'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['id'])."'",5);
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
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
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
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_court($val){
      $this->_court=$val;
    }
    function get_court(){
      return $this->_court;
    }
    function set_panel($val){
      $this->_panel=$val;
    }
    function get_panel(){
      return $this->_panel;
    }
    function set_city($val){
      $this->_city=$val;
    }
    function get_city(){
      return $this->_city;
    }
    function set_judge($val){
      $this->_judge=$val;
    }
    function get_judge(){
      if(!isset($this->_judge)) return array();
      return $this->_judge;
    }
    function set_clerk($val){
      $this->_clerk=$val;
    }
    function get_clerk(){
      return $this->_clerk;
    }
    function set_scheduled($val){
      $this->_scheduled=$val;
    }
    function get_scheduled(){
      return $this->_scheduled;
    }
    function set_dateofoccurence($val){
      $this->_dateofoccurence=$val;
    }
    function get_dateofoccurence(){
      return $this->_dateofoccurence;
    }
    function set_cases($val){
      $this->_cases=$val;
    }
    function get_cases(){
      if(!isset($this->_cases)) return array();
      return $this->_cases;
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

  function getEachSession(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `session`'));
  }

  function readSession($id){
      // check existence of $id
      $obj = new Session($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSession($id){
    $tobeDeleted = new Session($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>