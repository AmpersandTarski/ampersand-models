<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 355, file "VIROENG.adl"
    SERVICE Parties : I[ONE]
   = [ Parties : V;(plaintiff;plaintiff~\/defendant;defendant~)
        = [ name : [Party]
          , role : actsas
          ]
     , Representatives : V;writtenAuthOf~;writtenAuthOf
        = [ name : [Party]
          , role : actsas
          ]
     , Judges : V;judge~;judge
        = [ name : [Party]
          , role : actsas
          ]
     , Clerks : V;clerk~;I;clerk
        = [ name : [Party]
          , role : actsas
          ]
     ]
   *********/
  
  class Parties {
    private $_Parties;
    private $_Representatives;
    private $_Judges;
    private $_Clerks;
    function Parties($Parties=null, $Representatives=null, $Judges=null, $Clerks=null){
      $this->_Parties=$Parties;
      $this->_Representatives=$Representatives;
      $this->_Judges=$Judges;
      $this->_Clerks=$Clerks;
      if(!isset($Parties)){
        // get a Parties based on its identifier
        // fill the attributes
        $me=array();
        $me['Parties']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                     FROM  ( SELECT DISTINCT fst.`party`
                                               FROM 
                                                  ( 
                                                    (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                          FROM `plaintiff` AS F0, `plaintiff` AS F1
                                                         WHERE F0.`legalcase`=F1.`legalcase`
                                                    ) UNION (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                          FROM `defendant` AS F0, `defendant` AS F1
                                                         WHERE F0.`LegalCase`=F1.`LegalCase`
                                                    
                                                    )
                                                  ) AS fst
                                              WHERE fst.`party` IS NOT NULL
                                           ) AS f1"));
        $me['Representatives']=(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `id`
                                             FROM  ( SELECT DISTINCT fst.`Party`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`Party` AS `Party1`, F1.`Party`
                                                              FROM `writtenauthof` AS F0, `writtenauthof` AS F1
                                                             WHERE F0.`document`=F1.`document`
                                                          ) AS fst
                                                      WHERE fst.`Party` IS NOT NULL
                                                   ) AS f1"));
        $me['Judges']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                    FROM  ( SELECT DISTINCT fst.`party`
                                              FROM 
                                                 ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                     FROM `judge` AS F0, `judge` AS F1
                                                    WHERE F0.`session`=F1.`session`
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
        foreach($me['Parties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Representatives'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Judges'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
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
        }
        unset($v0);
        $this->set_Parties($me['Parties']);
        $this->set_Representatives($me['Representatives']);
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
      $me=array("id"=>1, "Parties" => $this->_Parties, "Representatives" => $this->_Representatives, "Judges" => $this->_Judges, "Clerks" => $this->_Clerks);
      foreach($me['Parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['role'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['role'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
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
      foreach($me['Parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0['role'])."')", 5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0['role'])."')", 5);
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
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
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
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
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
    function set_Parties($val){
      $this->_Parties=$val;
    }
    function get_Parties(){
      if(!isset($this->_Parties)) return array();
      return $this->_Parties;
    }
    function set_Representatives($val){
      $this->_Representatives=$val;
    }
    function get_Representatives(){
      if(!isset($this->_Representatives)) return array();
      return $this->_Representatives;
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