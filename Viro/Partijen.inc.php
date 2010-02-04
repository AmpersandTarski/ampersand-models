<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3701, file "VIRO.adl"
    SERVICE Partijen : I[ONE]
   = [ Eisers : V;eiser;eiser~
     , Gedaagden : V;gedaagde;gedaagde~
     , Gevoegden : V;gevoegde;gevoegde~
     ]
   *********/
  
  class Partijen {
    private $_Eisers;
    private $_Gedaagden;
    private $_Gevoegden;
    function Partijen($Eisers=null, $Gedaagden=null, $Gevoegden=null){
      $this->_Eisers=$Eisers;
      $this->_Gedaagden=$Gedaagden;
      $this->_Gevoegden=$Gevoegden;
      if(!isset($Eisers)){
        // get a Partijen based on its identifier
        // fill the attributes
        $me=array();
        $me['Eisers']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `Eisers`
                                            FROM  ( SELECT DISTINCT fst.`persoon`
                                                      FROM 
                                                         ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                             FROM `eiser` AS F0, `eiser` AS F1
                                                            WHERE F0.`procedur`=F1.`procedur`
                                                         ) AS fst
                                                     WHERE fst.`persoon` IS NOT NULL
                                                  ) AS f1"));
        $me['Gedaagden']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `Gedaagden`
                                               FROM  ( SELECT DISTINCT fst.`persoon`
                                                         FROM 
                                                            ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                FROM `gedaagde` AS F0, `gedaagde` AS F1
                                                               WHERE F0.`Procedur`=F1.`Procedur`
                                                            ) AS fst
                                                        WHERE fst.`persoon` IS NOT NULL
                                                     ) AS f1"));
        $me['Gevoegden']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `Gevoegden`
                                               FROM  ( SELECT DISTINCT fst.`persoon`
                                                         FROM 
                                                            ( SELECT DISTINCT F0.`persoon` AS `persoon1`, F1.`persoon`
                                                                FROM `gevoegde` AS F0, `gevoegde` AS F1
                                                               WHERE F0.`Procedur`=F1.`Procedur`
                                                            ) AS fst
                                                        WHERE fst.`persoon` IS NOT NULL
                                                     ) AS f1"));
        $this->set_Eisers($me['Eisers']);
        $this->set_Gedaagden($me['Gedaagden']);
        $this->set_Gevoegden($me['Gevoegden']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Eisers" => $this->_Eisers, "Gedaagden" => $this->_Gedaagden, "Gevoegden" => $this->_Gevoegden);
      foreach($me['Eisers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Gedaagden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Gevoegden'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Eisers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Gedaagden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Gevoegden'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
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
    function set_Eisers($val){
      $this->_Eisers=$val;
    }
    function get_Eisers(){
      if(!isset($this->_Eisers)) return array();
      return $this->_Eisers;
    }
    function set_Gedaagden($val){
      $this->_Gedaagden=$val;
    }
    function get_Gedaagden(){
      if(!isset($this->_Gedaagden)) return array();
      return $this->_Gedaagden;
    }
    function set_Gevoegden($val){
      $this->_Gevoegden=$val;
    }
    function get_Gevoegden(){
      if(!isset($this->_Gevoegden)) return array();
      return $this->_Gevoegden;
    }
  }

?>