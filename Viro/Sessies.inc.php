<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 336, file "VIRO.adl"
    SERVICE Sessies : I[ONE]
   = [ Sessies : [ONE*Sessie]
        = [ nr : [Sessie]
          , start : start
          , einde : einde
          , DigID : digid
          , rol : rol
          , persoon : login~
          ]
     ]
   *********/
  
  class Sessies {
    private $_Sessies;
    function Sessies($Sessies=null){
      $this->_Sessies=$Sessies;
      if(!isset($Sessies)){
        // get a Sessies based on its identifier
        // fill the attributes
        $me=array();
        $me['Sessies']=(DB_doquer("SELECT DISTINCT `f1`.`Sessie` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.i AS `Sessie`
                                               FROM `sessie` AS csnd
                                           ) AS f1"));
        foreach($me['Sessies'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`start`
                                       , `f4`.`einde`
                                       , `f5`.`digid` AS `DigID`
                                       , `f6`.`rol`
                                       , `f7`.`login` AS `persoon`
                                    FROM `sessie`
                                    LEFT JOIN `sessie` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `sessie` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `sessie` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `sessie` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `sessie` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                   WHERE `sessie`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Sessies($me['Sessies']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Sessies" => $this->_Sessies);
      foreach($me['Sessies'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sessie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sessie` (`i`,`start`,`einde`,`digid`,`rol`,`login`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['start'])."', ".((null!=$v0['einde'])?"'".addslashes($v0['einde'])."'":"NULL").", '".addslashes($v0['DigID'])."', '".addslashes($v0['rol'])."', '".addslashes($v0['persoon'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in sessie
      // no code for DigID,i in digid
      foreach($me['Sessies'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['persoon'])."'",5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['persoon'])."')", 5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0['rol'])."'",5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0['rol'])."')", 5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['start'])."'",5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['einde'])."'",5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['start'])."')", 5);
      }
      foreach($me['Sessies'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['einde'])."')", 5);
      }
      if (!checkRule8()){
        $DB_err='\"Elke sessie behoort geautoriseerd te zijn op basis van de juiste DigID\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient een rol te krijgen die hij of zij conform autorisatie van de Rechtbank mag vervullen.\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule62()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule65()){
        $DB_err='\"\"';
      } else
      if (!checkRule66()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule68()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule70()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule72()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Sessies($val){
      $this->_Sessies=$val;
    }
    function get_Sessies(){
      if(!isset($this->_Sessies)) return array();
      return $this->_Sessies;
    }
  }

?>