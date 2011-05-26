<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 286, file "VIROENG.adl"
    SERVICE Schedule : I[ONE]
   = [ Process : [ONE*Process]
        = [ nr : [Process]
          , session : session
          , case : legalCase
          , scheduled : session;scheduled
          ]
     ]
   *********/
  
  class Schedule {
    private $_Process;
    function Schedule($Process=null){
      $this->_Process=$Process;
      if(!isset($Process)){
        // get a Schedule based on its identifier
        // fill the attributes
        $me=array();
        $me['Process']=(DB_doquer("SELECT DISTINCT `f1`.`Process` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.i AS `Process`
                                               FROM `process` AS csnd
                                           ) AS f1"));
        foreach($me['Process'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`session`
                                       , `f4`.`legalcase` AS `case`
                                       , `f5`.`scheduled`
                                    FROM `process`
                                    LEFT JOIN `process` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `process` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`scheduled`
                                                   FROM `process` AS F0, `session` AS F1
                                                  WHERE F0.`session`=F1.`i`
                                               ) AS f5
                                      ON `f5`.`i`='".addslashes($v0['id'])."'
                                   WHERE `process`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Process($me['Process']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Process" => $this->_Process);
      // no code for session,i in session
      // no code for case,i in legalcase
      foreach($me['Process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `process` (`i`,`session`,`legalcase`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['session'])."', '".addslashes($v0['case'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in process
      foreach($me['Process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      // no code for case,legalcase in plaintiff
      // no code for session,session in judge
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule7()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
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
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Process($val){
      $this->_Process=$val;
    }
    function get_Process(){
      if(!isset($this->_Process)) return array();
      return $this->_Process;
    }
  }

?>