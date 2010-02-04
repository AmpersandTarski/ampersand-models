<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 475, file "VIRO.adl"
    SERVICE Documenten : I[ONE]
   = [ Documenten : [ONE*Document]
        = [ nr : [Document]
          , type : type
          , zorgdrager : zaaksdossier;zorgdrager
          , rechtsgebied : zaaksdossier;rechtsgebied
          , proceduresoort : zaaksdossier;proceduresoort
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
                                       , `f3`.`type`
                                    FROM `document`
                                    LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['zorgdrager']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zorgdrager`
                                                  FROM `document`
                                                  JOIN  ( SELECT DISTINCT F0.`document`, F1.`zorgdrager`
                                                                 FROM `zaaksdossier` AS F0, `procedur` AS F1
                                                                WHERE F0.`Procedur`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`document`='".addslashes($v0['id'])."'
                                                 WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['rechtsgebied']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`rechtsgebied`
                                                    FROM `document`
                                                    JOIN  ( SELECT DISTINCT F0.`document`, F1.`rechtsgebied`
                                                                   FROM `zaaksdossier` AS F0, `procedur` AS F1
                                                                  WHERE F0.`Procedur`=F1.`i`
                                                               ) AS f1
                                                      ON `f1`.`document`='".addslashes($v0['id'])."'
                                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['proceduresoort']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`proceduresoort`
                                                      FROM `document`
                                                      JOIN  ( SELECT DISTINCT F0.`document`, F1.`proceduresoort`
                                                                     FROM `zaaksdossier` AS F0, `procedur` AS F1
                                                                    WHERE F0.`Procedur`=F1.`i`
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
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `type`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in document
      foreach($me['Documenten'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['Documenten'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['zorgdrager'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['zorgdrager'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['rechtsgebied'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['rechtsgebied'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['proceduresoort'] as $i1=>$v1){
          DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documenten'] as $i0=>$v0){
        foreach($v0['proceduresoort'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for Documenten,document in aan
      // no code for nr,document in aan
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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