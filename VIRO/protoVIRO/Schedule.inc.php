<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 740, file "VIRO453ENG.adl"
    SERVICE Schedule : I[ONE]
   = [ Process : [ONE*Process]
        = [ nr : [Process]
          , session : session
          , case : case
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
                                       , `f4`.`case`
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
      // no code for case,i in case
      foreach($me['Process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `process` (`i`,`session`,`case`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['session'])."', '".addslashes($v0['case'])."')", 5);
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
      // no code for case,case in plaintiff
      // no code for session,session in judge
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
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