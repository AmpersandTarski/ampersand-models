<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 877, file "VIRO453ENG.adl"
    SERVICE Parties : I[ONE]
   = [ Interested parties : V;(plaintiff;plaintiff~\/defendant;defendant~\/joinedInterestedParty;joinedInterestedParty~)
        = [ name : [Party]
          , rol : actsas
          ]
     , Representatives : V;authorizedRepresentative;authorizedRepresentative~
        = [ name : [Party]
          , rol : actsas
          ]
     , Judges : V;judge~;judge
        = [ name : [Party]
          , rol : actsas
          ]
     , Clerks : V;clerk~;I;clerk
        = [ name : [Party]
          , rol : actsas
          ]
     ]
   *********/
  
  class Parties {
    private $_Interestedparties;
    private $_Representatives;
    private $_Judges;
    private $_Clerks;
    function Parties($Interestedparties=null, $Representatives=null, $Judges=null, $Clerks=null){
      $this->_Interestedparties=$Interestedparties;
      $this->_Representatives=$Representatives;
      $this->_Judges=$Judges;
      $this->_Clerks=$Clerks;
      if(!isset($Interestedparties)){
        // get a Parties based on its identifier
        // fill the attributes
        $me=array();
        $me['Interested parties']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                                FROM  ( SELECT DISTINCT fst.`party`
                                                          FROM 
                                                             ( 
                                                               (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                     FROM `plaintiff` AS F0, `plaintiff` AS F1
                                                                    WHERE F0.`case`=F1.`case`
                                                               ) UNION (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                     FROM `defendant` AS F0, `defendant` AS F1
                                                                    WHERE F0.`Case`=F1.`Case`
                                                               ) UNION (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                     FROM `joinedinterestedparty` AS F0, `joinedinterestedparty` AS F1
                                                                    WHERE F0.`Case`=F1.`Case`
                                                               
                                                               
                                                               )
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        $me['Representatives']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                             FROM  ( SELECT DISTINCT fst.`party`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                              FROM `authorizedrepresentative` AS F0, `authorizedrepresentative` AS F1
                                                             WHERE F0.`authorization`=F1.`authorization`
                                                          ) AS fst
                                                      WHERE fst.`party` IS NOT NULL
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
        foreach($me['Interested parties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                           FROM `party`
                                           JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                          WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Representatives'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                           FROM `party`
                                           JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                          WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Judges'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                           FROM `party`
                                           JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                          WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Clerks'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                           FROM `party`
                                           JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                          WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Interestedparties($me['Interested parties']);
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
      $me=array("id"=>1, "Interested parties" => $this->_Interestedparties, "Representatives" => $this->_Representatives, "Judges" => $this->_Judges, "Clerks" => $this->_Clerks);
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Judges'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Clerks'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Judges'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Clerks'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Judges'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Clerks'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Judges'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clerks'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Judges'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Clerks'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
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
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
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
    function set_Interestedparties($val){
      $this->_Interestedparties=$val;
    }
    function get_Interestedparties(){
      if(!isset($this->_Interestedparties)) return array();
      return $this->_Interestedparties;
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