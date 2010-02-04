<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3913, file "VIRO.adl"
    SERVICE Gemachtigden : I[ONE]
   = [ Gemachtigden : V;gemachtigde;gemachtigde~
        = [ naam : [Persoon]
          , rol : vervult
          , vertegenwoordigt : gemachtigde;door
          , zaken : gemachtigde;inzake
          ]
     ]
   *********/
  
  class Gemachtigden {
    private $_Gemachtigden;
    function Gemachtigden($Gemachtigden=null){
      $this->_Gemachtigden=$Gemachtigden;
      if(!isset($Gemachtigden)){
        // get a Gemachtigden based on its identifier
        // fill the attributes
        $me=array();
        $me['Gemachtigden']=(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `id`
                                          FROM  ( SELECT DISTINCT fst.`persoon`
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                           FROM `gemachtigde` AS F0, `gemachtigde` AS F1
                                                          WHERE F0.`machtiging`=F1.`machtiging`
                                                       ) AS fst
                                                   WHERE fst.`persoon` IS NOT NULL
                                                ) AS f1"));
        foreach($me['Gemachtigden'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `naam`
                                    FROM `persoon`
                                   WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                           FROM `persoon`
                                           JOIN `vervult` AS f1 ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                          WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['vertegenwoordigt']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`door` AS `vertegenwoordigt`
                                                        FROM `persoon`
                                                        JOIN  ( SELECT DISTINCT F0.`persoon`, F1.`door`
                                                                       FROM `gemachtigde` AS F0, `machtiging` AS F1
                                                                      WHERE F0.`machtiging`=F1.`i`
                                                                   ) AS f1
                                                          ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                                       WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['zaken']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Procedur` AS `zaken`
                                             FROM `persoon`
                                             JOIN  ( SELECT DISTINCT F0.`persoon`, F1.`Procedur`
                                                            FROM `gemachtigde` AS F0, `inzake` AS F1
                                                           WHERE F0.`machtiging`=F1.`machtiging`
                                                        ) AS f1
                                               ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                            WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Gemachtigden($me['Gemachtigden']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Gemachtigden" => $this->_Gemachtigden);
      // no code for zaken,i in procedur
      foreach($me['Gemachtigden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        foreach($v0['vertegenwoordigt'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        foreach($v0['vertegenwoordigt'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for zaken,procedur in eiser
      foreach($me['Gemachtigden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
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
    function set_Gemachtigden($val){
      $this->_Gemachtigden=$val;
    }
    function get_Gemachtigden(){
      if(!isset($this->_Gemachtigden)) return array();
      return $this->_Gemachtigden;
    }
  }

?>