<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3972, file "VIRO.adl"
    SERVICE Machtigingen : I[ONE]
   = [ Machtigingen : [ONE*Machtiging]
        = [ stuk : [Machtiging]
          , inzake : inzake
          , door : door
          , gemachtigde : gemachtigde~
          ]
     ]
   *********/
  
  class Machtigingen {
    private $_Machtigingen;
    function Machtigingen($Machtigingen=null){
      $this->_Machtigingen=$Machtigingen;
      if(!isset($Machtigingen)){
        // get a Machtigingen based on its identifier
        // fill the attributes
        $me=array();
        $me['Machtigingen']=(DB_doquer("SELECT DISTINCT `f1`.`Machtiging` AS `id`
                                          FROM  ( SELECT DISTINCT csnd.i AS `Machtiging`
                                                    FROM `machtiging` AS csnd
                                                ) AS f1"));
        foreach($me['Machtigingen'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `stuk`
                                       , `f3`.`door`
                                    FROM `machtiging`
                                    LEFT JOIN `machtiging` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          $v0['inzake']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Procedur` AS `inzake`
                                              FROM `machtiging`
                                              JOIN `inzake` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                             WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                   FROM `machtiging`
                                                   JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                  WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Machtigingen($me['Machtigingen']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Machtigingen" => $this->_Machtigingen);
      // no code for inzake,i in procedur
      foreach($me['Machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['door'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for stuk,i in machtiging
      foreach($me['Machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['door'])."'",5);
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['door'])."')", 5);
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for inzake,procedur in eiser
      foreach($me['Machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      // no code for stuk,machtiging in gemachtigde
      foreach($me['Machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `inzake` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Machtigingen'] as $i0=>$v0){
        foreach  ($v0['inzake'] as $inzake){
          $res=DB_doquer("INSERT IGNORE INTO `inzake` (`procedur`,`machtiging`) VALUES ('".addslashes($inzake)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Machtigingen($val){
      $this->_Machtigingen=$val;
    }
    function get_Machtigingen(){
      if(!isset($this->_Machtigingen)) return array();
      return $this->_Machtigingen;
    }
  }

?>