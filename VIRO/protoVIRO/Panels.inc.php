<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 603, file "VIRO453ENG.adl"
    SERVICE Panels : I[ONE]
   = [ Panels : [ONE*Panel]
        = [ panel : [Panel]
          , court : court
          , sector : sector
          , members : members~
          ]
     ]
   *********/
  
  class Panels {
    private $_Panels;
    function Panels($Panels=null){
      $this->_Panels=$Panels;
      if(!isset($Panels)){
        // get a Panels based on its identifier
        // fill the attributes
        $me=array();
        $me['Panels']=(DB_doquer("SELECT DISTINCT `f1`.`Panel` AS `id`
                                    FROM  ( SELECT DISTINCT csnd.i AS `Panel`
                                              FROM `panel` AS csnd
                                          ) AS f1"));
        foreach($me['Panels'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `panel`
                                       , `f3`.`court`
                                       , `f4`.`sector`
                                    FROM `panel`
                                    LEFT JOIN `panel` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `panel` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
          $v0['members']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `members`
                                               FROM `panel`
                                               JOIN `members` AS f1 ON `f1`.`Panel`='".addslashes($v0['id'])."'
                                              WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Panels($me['Panels']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Panels" => $this->_Panels);
      // no code for court,i in court
      foreach($me['Panels'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Panels'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `panel` (`i`,`court`,`sector`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['court'])."', '".addslashes($v0['sector'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for panel,i in panel
      foreach($me['Panels'] as $i0=>$v0){
        foreach($v0['members'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Panels'] as $i0=>$v0){
        foreach($v0['members'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Panels'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sector'])."'",5);
      }
      foreach($me['Panels'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['sector'])."')", 5);
      }
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
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
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Panels($val){
      $this->_Panels=$val;
    }
    function get_Panels(){
      if(!isset($this->_Panels)) return array();
      return $this->_Panels;
    }
  }

?>