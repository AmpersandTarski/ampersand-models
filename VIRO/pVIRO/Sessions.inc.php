<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 242, file "VIROENG.adl"
    SERVICE Sessions : I[ONE]
   = [ Sessions : [ONE*Session]
        = [ nr : [Session]
          , panel : panel
          , court : location
          , city : location;seatedIn
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , date of occurence : occured
          ]
     ]
   *********/
  
  class Sessions {
    private $_Sessions;
    function Sessions($Sessions=null){
      $this->_Sessions=$Sessions;
      if(!isset($Sessions)){
        // get a Sessions based on its identifier
        // fill the attributes
        $me=array();
        $me['Sessions']=(DB_doquer("SELECT DISTINCT `f1`.`Session` AS `id`
                                      FROM  ( SELECT DISTINCT csnd.i AS `Session`
                                                FROM `session` AS csnd
                                            ) AS f1"));
        foreach($me['Sessions'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`panel`
                                       , `f4`.`location` AS `court`
                                       , `f5`.`seatedin` AS `city`
                                       , `f6`.`clerk`
                                       , `f7`.`scheduled`
                                       , `f8`.`occured` AS `date of occurence`
                                    FROM `session`
                                    LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`seatedin`
                                                   FROM `session` AS F0, `court` AS F1
                                                  WHERE F0.`location`=F1.`i`
                                               ) AS f5
                                      ON `f5`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f8 ON `f8`.`i`='".addslashes($v0['id'])."'
                                   WHERE `session`.`i`='".addslashes($v0['id'])."'"));
          $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                             FROM `session`
                                             JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                            WHERE `session`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Sessions($me['Sessions']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Sessions" => $this->_Sessions);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `session` (`i`,`panel`,`location`,`clerk`,`scheduled`,`occured`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['panel'])."', '".addslashes($v0['court'])."', '".addslashes($v0['clerk'])."', '".addslashes($v0['scheduled'])."', ".((null!=$v0['date of occurence'])?"'".addslashes($v0['date of occurence'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in session
      // no code for city,i in city
      // no code for court,i in court
      // no code for judge,i in party
      // no code for clerk,i in party
      // no code for panel,i in panel
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['date of occurence'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['date of occurence'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      // no code for nr,session in judge
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
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
    function set_Sessions($val){
      $this->_Sessions=$val;
    }
    function get_Sessions(){
      if(!isset($this->_Sessions)) return array();
      return $this->_Sessions;
    }
  }

?>