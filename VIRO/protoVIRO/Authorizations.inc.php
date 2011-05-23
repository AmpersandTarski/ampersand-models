<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 759, file "VIRO453ENG.adl"
    SERVICE Authorizations : I[ONE]
   = [ Authorizations : [ONE*Authorization]
        = [ document : [Authorization]
          , for : for
          , by : by
          , representative : authorizedRepresentative~
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
        $me['Authorizations']=(DB_doquer("SELECT DISTINCT `f1`.`Authorization` AS `id`
                                            FROM  ( SELECT DISTINCT csnd.i AS `Authorization`
                                                      FROM `authorization` AS csnd
                                                  ) AS f1"));
        foreach($me['Authorizations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `document`
                                       , `f3`.`by`
                                    FROM `authorization`
                                    LEFT JOIN `authorization` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          $v0['for']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Case` AS `for`
                                           FROM `authorization`
                                           JOIN `for` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                          WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                      FROM `authorization`
                                                      JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                     WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
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
      // no code for for,i in case
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['by'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for document,i in authorization
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['by'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['by'])."')", 5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for for,case in plaintiff
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      // no code for document,authorization in authorizedrepresentative
      foreach($me['Authorizations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `for` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Authorizations'] as $i0=>$v0){
        foreach  ($v0['for'] as $for){
          $res=DB_doquer("INSERT IGNORE INTO `for` (`case`,`authorization`) VALUES ('".addslashes($for)."', '".addslashes($v0['id'])."')", 5);
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
    function set_Authorizations($val){
      $this->_Authorizations=$val;
    }
    function get_Authorizations(){
      if(!isset($this->_Authorizations)) return array();
      return $this->_Authorizations;
    }
  }

?>