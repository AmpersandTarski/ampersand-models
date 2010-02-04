<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 486, file "VIRO.adl"
    SERVICE Handelingen : I[ONE]
   = [ Handelingen : [ONE*Handeling]
        = [ nr : [Handeling]
          , Orgaan : handeling~;orgaan
          , wet : handeling~
          , usecase : use_case~
          , rol : mag
          ]
     ]
   *********/
  
  class Handelingen {
    private $_Handelingen;
    function Handelingen($Handelingen=null){
      $this->_Handelingen=$Handelingen;
      if(!isset($Handelingen)){
        // get a Handelingen based on its identifier
        // fill the attributes
        $me=array();
        $me['Handelingen']=(DB_doquer("SELECT DISTINCT `f1`.`Handeling` AS `id`
                                         FROM  ( SELECT DISTINCT csnd.i AS `Handeling`
                                                   FROM `handeling` AS csnd
                                               ) AS f1"));
        foreach($me['Handelingen'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                    FROM `handeling`
                                   WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
          $v0['Orgaan']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Orgaan`
                                              FROM `handeling`
                                              JOIN  ( SELECT DISTINCT F0.`Handeling`, F1.`Orgaan`
                                                             FROM `handelingartikel` AS F0, `orgaanartikel` AS F1
                                                            WHERE F0.`artikel`=F1.`artikel`
                                                         ) AS f1
                                                ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                             WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
          $v0['wet']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`artikel` AS `wet`
                                           FROM `handeling`
                                           JOIN `handelingartikel` AS f1 ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                          WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
          $v0['usecase']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`usecase`
                                               FROM `handeling`
                                               JOIN `use_case` AS f1 ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                              WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                           FROM `handeling`
                                           JOIN `mag` AS f1 ON `f1`.`handeling`='".addslashes($v0['id'])."'
                                          WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Handelingen($me['Handelingen']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Handelingen" => $this->_Handelingen);
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['Orgaan'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['Orgaan'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['wet'] as $i1=>$v1){
          DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['wet'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['nr'])."'",5);
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['nr'])."')", 5);
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Handelingen'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `mag` (`rol`,`handeling`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Handelingen($val){
      $this->_Handelingen=$val;
    }
    function get_Handelingen(){
      if(!isset($this->_Handelingen)) return array();
      return $this->_Handelingen;
    }
  }

?>