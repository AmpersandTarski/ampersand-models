<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 407, file "VIROENG.adl"
    SERVICE Authorizations : I[ONE]
   = [ Authorizations : V;writtenAuthOf;writtenAuthOf~
        = [ document : [Document]
          , for : authFor
          , by : authBy
          , representative : writtenAuthOf
          ]
     ]
   *********/
  
  class Authorizations {
    private $_Authorizations;
    function Authorizations($Authorizations=null){
      $this->_Authorizations=$Authorizations;
      if(!isset($Authorizations)){
        // get a Authorizations based on its identifier
        // fill the attributes
        $me=array();
        $me['Authorizations']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                            FROM  ( SELECT DISTINCT fst.`document`
                                                      FROM 
                                                         ( SELECT DISTINCT F0.`document` AS `document1`, F1.`document`
                                                             FROM `writtenauthof` AS F0, `writtenauthof` AS F1
                                                            WHERE F0.`Party`=F1.`Party`
                                                         ) AS fst
                                                     WHERE fst.`document` IS NOT NULL
                                                  ) AS f1"));
        foreach($me['Authorizations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `document`
                                    FROM `document`
                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['for']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`LegalCase` AS `for`
                                           FROM `document`
                                           JOIN `authfor` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                          WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['by']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `by`
                                          FROM `document`
                                          JOIN `authby` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                         WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative`
                                                      FROM `document`
                                                      JOIN `writtenauthof` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Authorizations($me['Authorizations']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Authorizations" => $this->_Authorizations);
      foreach($me['Authorizations'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['document'])."'", 5);
      }
      // no code for document,i in document
      // no code for for,i in legalcase
      // no code for by,i in party
      // no code for representative,i in party
      // no code for for,legalcase in plaintiff
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `writtenauthof` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `writtenauthof` (`party`,`document`) VALUES ('".addslashes($representative)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authfor` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach  ($v0['for'] as $for){
          $res=DB_doquer("INSERT IGNORE INTO `authfor` (`legalcase`,`document`) VALUES ('".addslashes($for)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authby` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach  ($v0['by'] as $by){
          $res=DB_doquer("INSERT IGNORE INTO `authby` (`party`,`document`) VALUES ('".addslashes($by)."', '".addslashes($v0['id'])."')", 5);
        }
      }
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
      if (!checkRule16()){
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
    function set_Authorizations($val){
      $this->_Authorizations=$val;
    }
    function get_Authorizations(){
      if(!isset($this->_Authorizations)) return array();
      return $this->_Authorizations;
    }
  }

?>