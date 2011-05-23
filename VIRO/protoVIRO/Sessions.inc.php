<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 543, file "VIRO453ENG.adl"
    SERVICE Sessions : I[ONE]
   = [ Sessions : [ONE*Session]
        = [ nr : [Session]
          , panel : panel
          , court : location
          , city : city
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , date of occurence : occured
          ]
     ]
   *********/
  
  class Sessions {
    private $_Sessions;
    function Sessions($Sessions=null){
      $this->_Sessions=$Sessions;
      if(!isset($Sessions)){
        // get a Sessions based on its identifier
        // fill the attributes
        $me=array();
        $me['Sessions']=(DB_doquer("SELECT DISTINCT `f1`.`Session` AS `id`
                                      FROM  ( SELECT DISTINCT csnd.i AS `Session`
                                                FROM `session` AS csnd
                                            ) AS f1"));
        foreach($me['Sessions'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`panel`
                                       , `f4`.`location` AS `court`
                                       , `f5`.`city`
                                       , `f6`.`clerk`
                                       , `f7`.`scheduled`
                                       , `f8`.`occured` AS `date of occurence`
                                    FROM `session`
                                    LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `session` AS f8 ON `f8`.`i`='".addslashes($v0['id'])."'
                                   WHERE `session`.`i`='".addslashes($v0['id'])."'"));
          $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                             FROM `session`
                                             JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                            WHERE `session`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Sessions($me['Sessions']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Sessions" => $this->_Sessions);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `session` (`i`,`panel`,`location`,`city`,`clerk`,`scheduled`,`occured`) VALUES (".((null!=$v0['id'])?"'".addslashes($v0['id'])."'":"NULL").", '".addslashes($v0['panel'])."', '".addslashes($v0['court'])."', '".addslashes($v0['city'])."', '".addslashes($v0['clerk'])."', '".addslashes($v0['scheduled'])."', ".((null!=$v0['date of occurence'])?"'".addslashes($v0['date of occurence'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in session
      // no code for court,i in court
      // no code for panel,i in panel
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `city` (`i`) VALUES ('".addslashes($v0['city'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['clerk'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['date of occurence'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['date of occurence'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      // no code for nr,session in judge
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
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
    function set_Sessions($val){
      $this->_Sessions=$val;
    }
    function get_Sessions(){
      if(!isset($this->_Sessions)) return array();
      return $this->_Sessions;
    }
  }

?>