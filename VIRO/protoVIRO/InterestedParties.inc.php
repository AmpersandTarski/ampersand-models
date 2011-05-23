<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 892, file "VIRO453ENG.adl"
    SERVICE InterestedParties : I[ONE]
   = [ Interested parties : V;(plaintiff;plaintiff~\/defendant;defendant~\/joinedInterestedParty;joinedInterestedParty~)
        = [ name : [Party]
          , role : actsas
          , representative : by~;authorizedRepresentative~
          ]
     ]
   *********/
  
  class InterestedParties {
    private $_Interestedparties;
    function InterestedParties($Interestedparties=null){
      $this->_Interestedparties=$Interestedparties;
      if(!isset($Interestedparties)){
        // get a InterestedParties based on its identifier
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
        foreach($me['Interested parties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['role']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Role` AS `role`
                                            FROM `party`
                                            JOIN `actsas` AS f1 ON `f1`.`party`='".addslashes($v0['id'])."'
                                           WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                      FROM `party`
                                                      JOIN  ( SELECT DISTINCT F0.`by`, F1.`party`
                                                                     FROM `authorization` AS F0, `authorizedrepresentative` AS F1
                                                                    WHERE F0.`i`=F1.`authorization`
                                                                 ) AS f1
                                                        ON `f1`.`by`='".addslashes($v0['id'])."'
                                                     WHERE `party`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Interestedparties($me['Interested parties']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Interested parties" => $this->_Interestedparties);
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['role'] as $i1=>$v1){
          DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach($v0['role'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
        foreach  ($v0['role'] as $role){
          $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($role)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
  }

?>