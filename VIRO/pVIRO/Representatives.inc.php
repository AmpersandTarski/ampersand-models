<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 378, file "VIROENG.adl"
    SERVICE Representatives : I[ONE]
   = [ Representatives : V;writtenAuthOf~;writtenAuthOf
        = [ name : [Party]
          , rol : actsas
          , represents : writtenAuthOf~;authBy
          , cases : writtenAuthOf~;authFor
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
        $me['Representatives']=(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `id`
                                             FROM  ( SELECT DISTINCT fst.`Party`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`Party` AS `Party1`, F1.`Party`
                                                              FROM `writtenauthof` AS F0, `writtenauthof` AS F1
                                                             WHERE F0.`document`=F1.`document`
                                                          ) AS fst
                                                      WHERE fst.`Party` IS NOT NULL
                                                   ) AS f1"));
        foreach($me['Representatives'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `rol`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['represents']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `represents`
                                                  FROM `party`
                                                  JOIN  ( SELECT DISTINCT F0.`Party`
                                                                 FROM `writtenauthof` AS F0, `authby` AS F1
                                                                WHERE F0.`document`=F1.`document`
                                                             ) AS f1
                                                    ON `f1`.`Party`='".addslashes($v0['id'])."'
                                                 WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['cases']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`LegalCase` AS `cases`
                                             FROM `party`
                                             JOIN  ( SELECT DISTINCT F0.`Party`, F1.`LegalCase`
                                                            FROM `writtenauthof` AS F0, `authfor` AS F1
                                                           WHERE F0.`document`=F1.`document`
                                                        ) AS f1
                                               ON `f1`.`Party`='".addslashes($v0['id'])."'
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
      // no code for cases,i in legalcase
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['rol'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
      // no code for represents,i in party
      foreach($me['Representatives'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['rol'])."'",5);
      }
      foreach($me['Representatives'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0['rol'])."')", 5);
      }
      // no code for cases,legalcase in plaintiff
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
      if (!checkRule35()){
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