<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 217, file "VIROENG.adl"
    SERVICE Cases : I[ONE]
   = [ Cases : [ONE*LegalCase]
        = [ nr : [LegalCase]
          , session : legalCase~;session
          , area of law : areaOfLaw
          , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
          , court : legalCase~;session;location
          ]
     ]
   *********/
  
  class Cases {
    private $_Cases;
    function Cases($Cases=null){
      $this->_Cases=$Cases;
      if(!isset($Cases)){
        // get a Cases based on its identifier
        // fill the attributes
        $me=array();
        $me['Cases']=(DB_doquer("SELECT DISTINCT `f1`.`LegalCase` AS `id`
                                   FROM  ( SELECT DISTINCT csnd.i AS `LegalCase`
                                             FROM `legalcase` AS csnd
                                         ) AS f1"));
        foreach($me['Cases'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`areaoflaw` AS `area of law`
                                    FROM `legalcase`
                                    LEFT JOIN `legalcase` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          $v0['session']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`session`
                                               FROM `legalcase`
                                               JOIN  ( SELECT DISTINCT F0.`legalcase`, F1.`session`
                                                              FROM `process` AS F0, `process` AS F1
                                                             WHERE F0.`i`=F1.`i`
                                                          ) AS f1
                                                 ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                              WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          $v0['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
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
                                                      ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                                   WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          $v0['court']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`location` AS `court`
                                             FROM `legalcase`
                                             JOIN  ( SELECT DISTINCT F0.`legalcase`, F2.`location`
                                                            FROM `process` AS F0, `process` AS F1, `session` AS F2
                                                           WHERE F0.`i`=F1.`i`
                                                             AND F1.`session`=F2.`i`
                                                        ) AS f1
                                               ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                            WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Cases($me['Cases']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Cases" => $this->_Cases);
      // no code for session,i in session
      foreach($me['Cases'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."', `areaoflaw`='".addslashes($v0['area of law'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in legalcase
      // no code for Cases,legalcase in process
      // no code for court,i in court
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for Cases,legalcase in plaintiff
      // no code for nr,legalcase in plaintiff
      // no code for session,session in judge
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
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
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
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
    function set_Cases($val){
      $this->_Cases=$val;
    }
    function get_Cases(){
      if(!isset($this->_Cases)) return array();
      return $this->_Cases;
    }
  }

?>