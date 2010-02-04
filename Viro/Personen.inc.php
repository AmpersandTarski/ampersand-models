<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3707, file "VIRO.adl"
    SERVICE Personen : I[ONE]
   = [ Gemachtigden : V;gemachtigde;gemachtigde~
     , Rechters : V;rechter~;rechter
     , Griffiers : V;griffier~;I;griffier
     ]
   *********/
  
  class Personen {
    private $_Gemachtigden;
    private $_Rechters;
    private $_Griffiers;
    function Personen($Gemachtigden=null, $Rechters=null, $Griffiers=null){
      $this->_Gemachtigden=$Gemachtigden;
      $this->_Rechters=$Rechters;
      $this->_Griffiers=$Griffiers;
      if(!isset($Gemachtigden)){
        // get a Personen based on its identifier
        // fill the attributes
        $me=array();
        $me['Gemachtigden']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `Gemachtigden`
                                                  FROM  ( SELECT DISTINCT fst.`persoon`
                                                            FROM 
                                                               ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                   FROM `gemachtigde` AS F0, `gemachtigde` AS F1
                                                                  WHERE F0.`machtiging`=F1.`machtiging`
                                                               ) AS fst
                                                           WHERE fst.`persoon` IS NOT NULL
                                                        ) AS f1"));
        $me['Rechters']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `Rechters`
                                              FROM  ( SELECT DISTINCT fst.`persoon`
                                                        FROM 
                                                           ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                               FROM `rechter` AS F0, `rechter` AS F1
                                                              WHERE F0.`zitting`=F1.`zitting`
                                                           ) AS fst
                                                       WHERE fst.`persoon` IS NOT NULL
                                                    ) AS f1"));
        $me['Griffiers']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Persoon` AS `Griffiers`
                                               FROM  ( SELECT DISTINCT fst.`Persoon`
                                                         FROM 
                                                            ( SELECT DISTINCT F0.`Persoon` AS `Persoon1`, F2.`Persoon`
                                                                FROM `griffier` AS F0, `gerecht` AS F1, `griffier` AS F2
                                                               WHERE F0.`gerecht`=F1.`i`
                                                                 AND F1.`i`=F2.`gerecht`
                                                            ) AS fst
                                                        WHERE fst.`Persoon` IS NOT NULL
                                                     ) AS f1"));
        $this->set_Gemachtigden($me['Gemachtigden']);
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
      $me=array("id"=>1, "Gemachtigden" => $this->_Gemachtigden, "Rechters" => $this->_Rechters, "Griffiers" => $this->_Griffiers);
      foreach($me['Gemachtigden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Gemachtigden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Rechters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Griffiers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
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