<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 324, file "VIRO453ENG.adl"
    SERVICE Documenten : I[ONE]
   = [ Documenten : [ONE*Document]
        = [ nr : [Document]
          , type : documentType
          , caretaker of case file : caseFile;caretaker
          , area of law : caseFile;areaOfLaw
          , type of case : caseFile;caseType
          ]
     ]
   *********/
  
  class Documenten {
    private $_Documenten;
    function Documenten($Documenten=null){
      $this->_Documenten=$Documenten;
      if(!isset($Documenten)){
        // get a Documenten based on its identifier
        // fill the attributes
        $me=array();
        $me['Documenten']=(DB_doquer("SELECT DISTINCT `f1`.`Document` AS `id`
                                        FROM  ( SELECT DISTINCT csnd.i AS `Document`
                                                  FROM `document` AS csnd
                                              ) AS f1"));
        foreach($me['Documenten'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`documenttype` AS `type`
                                    FROM `document`
                                    LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['caretaker of case file']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`caretaker` AS `caretaker of case file`
                                                              FROM `document`
                                                              JOIN  ( SELECT DISTINCT F0.`document`, F1.`caretaker`
                                                                             FROM `casefile` AS F0, `case` AS F1
                                                                            WHERE F0.`Case`=F1.`i`
                                                                         ) AS f1
                                                                ON `f1`.`document`='".addslashes($v0['id'])."'
                                                             WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['area of law']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`areaoflaw` AS `area of law`
                                                   FROM `document`
                                                   JOIN  ( SELECT DISTINCT F0.`document`, F1.`areaoflaw`
                                                                  FROM `casefile` AS F0, `case` AS F1
                                                                 WHERE F0.`Case`=F1.`i`
                                                              ) AS f1
                                                     ON `f1`.`document`='".addslashes($v0['id'])."'
                                                  WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                    FROM `document`
                                                    JOIN  ( SELECT DISTINCT F0.`document`, F1.`casetype`
                                                                   FROM `casefile` AS F0, `case` AS F1
                                                                  WHERE F0.`Case`=F1.`i`
                                                               ) AS f1
                                                      ON `f1`.`document`='".addslashes($v0['id'])."'
                                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Documenten($me['Documenten']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Documenten" => $this->_Documenten);
      foreach($me['Documenten'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in document
      foreach($me['Documenten'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['Documenten'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['caretaker of case file'] as $i1=>$v1){
          DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['caretaker of case file'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['area of law'] as $i1=>$v1){
          DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['area of law'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for Documenten,document in to
      // no code for nr,document in to
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Documenten($val){
      $this->_Documenten=$val;
    }
    function get_Documenten(){
      if(!isset($this->_Documenten)) return array();
      return $this->_Documenten;
    }
  }

?>