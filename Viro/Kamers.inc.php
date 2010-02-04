<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3794, file "VIRO.adl"
    SERVICE Kamers : I[ONE]
   = [ Kamers : [ONE*Kamer]
        = [ kamer : [Kamer]
          , gerecht : gerecht
          , sector : sector
          , bezetting : bezetting~
          ]
     ]
   *********/
  
  class Kamers {
    private $_Kamers;
    function Kamers($Kamers=null){
      $this->_Kamers=$Kamers;
      if(!isset($Kamers)){
        // get a Kamers based on its identifier
        // fill the attributes
        $me=array();
        $me['Kamers']=(DB_doquer("SELECT DISTINCT `f1`.`Kamer` AS `id`
                                    FROM  ( SELECT DISTINCT csnd.i AS `Kamer`
                                              FROM `kamer` AS csnd
                                          ) AS f1"));
        foreach($me['Kamers'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `kamer`
                                       , `f3`.`gerecht`
                                       , `f4`.`sector`
                                    FROM `kamer`
                                    LEFT JOIN `kamer` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `kamer` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `kamer`.`i`='".addslashes($v0['id'])."'"));
          $v0['bezetting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `bezetting`
                                                 FROM `kamer`
                                                 JOIN `bezetting` AS f1 ON `f1`.`Kamer`='".addslashes($v0['id'])."'
                                                WHERE `kamer`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Kamers($me['Kamers']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Kamers" => $this->_Kamers);
      // no code for gerecht,i in gerecht
      foreach($me['Kamers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Kamers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `kamer` (`i`,`gerecht`,`sector`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['gerecht'])."', '".addslashes($v0['sector'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for kamer,i in kamer
      foreach($me['Kamers'] as $i0=>$v0){
        foreach($v0['bezetting'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Kamers'] as $i0=>$v0){
        foreach($v0['bezetting'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Kamers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sector'])."'",5);
      }
      foreach($me['Kamers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['sector'])."')", 5);
      }
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
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
    function set_Kamers($val){
      $this->_Kamers=$val;
    }
    function get_Kamers(){
      if(!isset($this->_Kamers)) return array();
      return $this->_Kamers;
    }
  }

?>