<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3904, file "VIRO.adl"
    SERVICE Belanghebbenden : I[ONE]
   = [ Belanghebbenden : V;(eiser;eiser~\/gedaagde;gedaagde~\/gevoegde;gevoegde~)
        = [ naam : [Persoon]
          , rol : vervult
          , gemachtigde : door~;gemachtigde~
          ]
     ]
   *********/
  
  class Belanghebbenden {
    private $_Belanghebbenden;
    function Belanghebbenden($Belanghebbenden=null){
      $this->_Belanghebbenden=$Belanghebbenden;
      if(!isset($Belanghebbenden)){
        // get a Belanghebbenden based on its identifier
        // fill the attributes
        $me=array();
        $me['Belanghebbenden']=(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `id`
                                             FROM  ( SELECT DISTINCT fst.`persoon`
                                                       FROM 
                                                          ( 
                                                            (SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                  FROM `eiser` AS F0, `eiser` AS F1
                                                                 WHERE F0.`procedur`=F1.`procedur`
                                                            ) UNION (SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                  FROM `gedaagde` AS F0, `gedaagde` AS F1
                                                                 WHERE F0.`Procedur`=F1.`Procedur`
                                                            ) UNION (SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                  FROM `gevoegde` AS F0, `gevoegde` AS F1
                                                                 WHERE F0.`Procedur`=F1.`Procedur`
                                                            
                                                            
                                                            )
                                                          ) AS fst
                                                      WHERE fst.`persoon` IS NOT NULL
                                                   ) AS f1"));
        foreach($me['Belanghebbenden'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `naam`
                                    FROM `persoon`
                                   WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                           FROM `persoon`
                                           JOIN `vervult` AS f1 ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                          WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                   FROM `persoon`
                                                   JOIN  ( SELECT DISTINCT F0.`door`, F1.`persoon`
                                                                  FROM `machtiging` AS F0, `gemachtigde` AS F1
                                                                 WHERE F0.`i`=F1.`machtiging`
                                                              ) AS f1
                                                     ON `f1`.`door`='".addslashes($v0['id'])."'
                                                  WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Belanghebbenden($me['Belanghebbenden']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Belanghebbenden" => $this->_Belanghebbenden);
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Belanghebbenden'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `vervult` (`rol`,`persoon`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient in te loggen met een van de rollen die hij of zij vervult.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Elke persoon die een rol vervult moet daarvoor geautoriseerd zijn.\"';
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
      if (!checkRule69()){
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
    function set_Belanghebbenden($val){
      $this->_Belanghebbenden=$val;
    }
    function get_Belanghebbenden(){
      if(!isset($this->_Belanghebbenden)) return array();
      return $this->_Belanghebbenden;
    }
  }

?>