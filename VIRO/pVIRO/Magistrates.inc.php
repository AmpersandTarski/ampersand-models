<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 400, file "VIROENG.adl"
    SERVICE Magistrates : I[ONE]
   = [ Judges : V;members;members~
        = [ name : [Party]
          , court : members;court
          , role : actsas
          ]
     , Clerks : V;clerk~;I;clerk
        = [ name : [Party]
          , court : clerk~
          , role : actsas
          ]
     ]
   *********/
  
  class Magistrates {
    private $_Judges;
    private $_Clerks;
    function Magistrates($Judges=null, $Clerks=null){
      $this->_Judges=$Judges;
      $this->_Clerks=$Clerks;
      if(!isset($Judges)){
        // get a Magistrates based on its identifier
        // fill the attributes
        $me=array();
        $me['Judges']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                    FROM  ( SELECT DISTINCT fst.`party`
                                              FROM 
                                                 ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                     FROM `members` AS F0, `members` AS F1
                                                    WHERE F0.`Panel`=F1.`Panel`
                                                 ) AS fst
                                             WHERE fst.`party` IS NOT NULL
                                          ) AS f1"));
        $me['Clerks']=(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `id`
                                    FROM  ( SELECT DISTINCT fst.`Party`
                                              FROM 
                                                 ( SELECT DISTINCT F0.`Party` AS `Party1`, F2.`Party`
                                                     FROM `clerk` AS F0, `court` AS F1, `clerk` AS F2
                                                    WHERE F0.`court`=F1.`i`
                                                      AND F1.`i`=F2.`court`
                                                 ) AS fst
                                             WHERE fst.`Party` IS NOT NULL
                                          ) AS f1"));
        foreach($me['Judges'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['court']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`court`
                                             FROM `party`
                                             JOIN  ( SELECT DISTINCT F0.`party`, F1.`court`
                                                            FROM `members` AS F0, `panel` AS F1
                                                           WHERE F0.`Panel`=F1.`i`
                                                        ) AS f1
                                               ON `f1`.`party`='".addslashes($v0['id'])."'
                                            WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Clerks'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['court']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`court`
                                             FROM `party`
                                             JOIN `clerk` AS f1 ON `f1`.`Party`='".addslashes($v0['id'])."'
                                            WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Judges($me['Judges']);
        $this->set_Clerks($me['Clerks']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Judges" => $this->_Judges, "Clerks" => $this->_Clerks);
      // no code for court,i in court
      // no code for court,i in court
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['role'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
      foreach($me['Clerks'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['role'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0['role'])."')", 5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0['role'])."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
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
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
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
    function set_Judges($val){
      $this->_Judges=$val;
    }
    function get_Judges(){
      if(!isset($this->_Judges)) return array();
      return $this->_Judges;
    }
    function set_Clerks($val){
      $this->_Clerks=$val;
    }
    function get_Clerks(){
      if(!isset($this->_Clerks)) return array();
      return $this->_Clerks;
    }
  }

?>