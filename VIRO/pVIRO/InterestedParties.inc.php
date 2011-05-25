<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 370, file "VIROENG.adl"
    SERVICE InterestedParties : I[ONE]
   = [ Interested parties : V;(plaintiff;plaintiff~\/defendant;defendant~)
        = [ name : [Party]
          , role : actsas
          , representative : authBy~;writtenAuthOf
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
                                                                    WHERE F0.`legalcase`=F1.`legalcase`
                                                               ) UNION (SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                     FROM `defendant` AS F0, `defendant` AS F1
                                                                    WHERE F0.`LegalCase`=F1.`LegalCase`
                                                               
                                                               )
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        foreach($me['Interested parties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `name`
                                       , `f3`.`actsas` AS `role`
                                    FROM `party`
                                    LEFT JOIN `party` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `party`.`i`='".addslashes($v0['id'])."'"));
          $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative`
                                                      FROM `party`
                                                      JOIN  ( SELECT DISTINCT F0.`Party`
                                                                     FROM `authby` AS F0, `writtenauthof` AS F1
                                                                    WHERE F0.`document`=F1.`document`
                                                                 ) AS f1
                                                        ON `f1`.`Party`='".addslashes($v0['id'])."'
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
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`,`actsas`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['role'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for name,i in party
      // no code for representative,i in party
      foreach($me['Interested parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0['role'])."'",5);
      }
      foreach($me['Interested parties'] as $i0=>$v0){
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
    function set_Interestedparties($val){
      $this->_Interestedparties=$val;
    }
    function get_Interestedparties(){
      if(!isset($this->_Interestedparties)) return array();
      return $this->_Interestedparties;
    }
  }

?>