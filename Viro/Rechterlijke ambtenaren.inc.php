<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 3897, file "VIRO.adl"
    SERVICE Rechterlijke ambtenaren : I[ONE]
   = [ Rechters : V;rechter~;rechter
        = [ naam : [Persoon]
          , rol : vervult
          ]
     , Griffiers : V;griffier~;I;griffier
        = [ naam : [Persoon]
          , rol : vervult
          ]
     ]
   *********/
  
  class Rechterlijke ambtenaren {
    private $_Rechters;
    private $_Griffiers;
    function Rechterlijke ambtenaren($Rechters=null, $Griffiers=null){
      $this->_Rechters=$Rechters;
      $this->_Griffiers=$Griffiers;
      if(!isset($Rechters)){
        // get a Rechterlijke ambtenaren based on its identifier
        // fill the attributes
        $me=array();
        $me['Rechters']=(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `id`
                                      FROM  ( SELECT DISTINCT fst.`persoon`
                                                FROM 
                                                   ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                       FROM `rechter` AS F0, `rechter` AS F1
                                                      WHERE F0.`zitting`=F1.`zitting`
                                                   ) AS fst
                                               WHERE fst.`persoon` IS NOT NULL
                                            ) AS f1"));
        $me['Griffiers']=(DB_doquer("SELECT DISTINCT `f1`.`Persoon` AS `id`
                                       FROM  ( SELECT DISTINCT fst.`Persoon`
                                                 FROM 
                                                    ( SELECT DISTINCT F0.`Persoon` AS `Persoon1`, F2.`Persoon`
                                                        FROM `griffier` AS F0, `gerecht` AS F1, `griffier` AS F2
                                                       WHERE F0.`gerecht`=F1.`i`
                                                         AND F1.`i`=F2.`gerecht`
                                                    ) AS fst
                                                WHERE fst.`Persoon` IS NOT NULL
                                             ) AS f1"));
        foreach($me['Rechters'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `naam`
                                    FROM `persoon`
                                   WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                           FROM `persoon`
                                           JOIN `vervult` AS f1 ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                          WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Griffiers'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `naam`
                                    FROM `persoon`
                                   WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
          $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                           FROM `persoon`
                                           JOIN `vervult` AS f1 ON `f1`.`persoon`='".addslashes($v0['id'])."'
                                          WHERE `persoon`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Rechters($me['Rechters']);
        $this->set_Griffiers($me['Griffiers']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Rechters" => $this->_Rechters, "Griffiers" => $this->_Griffiers);
      foreach($me['Rechters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Rechters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Rechters'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Rechters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `vervult` (`rol`,`persoon`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `vervult` (`rol`,`persoon`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient in te loggen met een van de rollen die hij of zij vervult.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Elke persoon die een rol vervult moet daarvoor geautoriseerd zijn.\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
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
    function set_Rechters($val){
      $this->_Rechters=$val;
    }
    function get_Rechters(){
      if(!isset($this->_Rechters)) return array();
      return $this->_Rechters;
    }
    function set_Griffiers($val){
      $this->_Griffiers=$val;
    }
    function get_Griffiers(){
      if(!isset($this->_Griffiers)) return array();
      return $this->_Griffiers;
    }
  }

?>