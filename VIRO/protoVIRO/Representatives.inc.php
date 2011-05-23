<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 701, file "VIRO453ENG.adl"
    SERVICE Representatives : I[ONE]
   = [ Representatives : V;authorizedRepresentative;authorizedRepresentative~
        = [ name : [Party]
          , rol : actsas
          , represents : authorizedRepresentative;by
          , cases : authorizedRepresentative;for
          ]
     ]
   *********/
  
  class Representatives {
    private $_Representatives;
    function Representatives($Representatives=null){
      $this->_Representatives=$Representatives;
      if(!isset($Representatives)){
        // get a Representatives based on its identifier
        // fill the attributes
        $me=array();
        $me['Representatives']=(DB_doquer("SELECT DISTINCT `f1`.`party` AS `id`
                                             FROM  ( SELECT DISTINCT fst.`party`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                              FROM `authorizedrepresentative` AS F0, `authorizedrepresentative` AS F1
                                                             WHERE F0.`authorization`=F1.`authorization`
                                                          ) AS fst
                                                      WHERE fst.`party` IS NOT NULL
                                                   ) AS f1"));
        foreach($me['Representatives'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `rol`
                                           FROM `party`
                                           JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                          WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['represents']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`by` AS `represents`
                                                  FROM `party`
                                                  JOIN  ( SELECT DISTINCT F0.`party`, F1.`by`
                                                                 FROM `authorizedrepresentative` AS F0, `authorization` AS F1
                                                                WHERE F0.`authorization`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`party`='".addslashes($v0['id'])."'
                                                 WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['cases']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Case` AS `cases`
                                             FROM `party`
                                             JOIN  ( SELECT DISTINCT F0.`party`, F1.`Case`
                                                            FROM `authorizedrepresentative` AS F0, `for` AS F1
                                                           WHERE F0.`authorization`=F1.`authorization`
                                                        ) AS f1
                                               ON `f1`.`party`='".addslashes($v0['id'])."'
                                            WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Representatives($me['Representatives']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Representatives" => $this->_Representatives);
      // no code for cases,i in case
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['represents'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['represents'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for cases,case in plaintiff
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
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
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Representatives($val){
      $this->_Representatives=$val;
    }
    function get_Representatives(){
      if(!isset($this->_Representatives)) return array();
      return $this->_Representatives;
    }
  }

?>