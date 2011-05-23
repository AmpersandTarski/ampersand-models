<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 676, file "VIRO453ENG.adl"
    SERVICE Cases : I[ONE]
   = [ Cases : [ONE*Case]
        = [ nr : [Case]
          , session : case~;session
          , area of law : areaOfLaw
          , type of case : caseType
          , caretaker voor dossier : caretaker
          , court : case~;session;location
          , clusters : cluster
             = [ cases : cluster~
               ]
          ]
     ]
   *********/
  
  class Cases {
    private $_Cases;
    function Cases($Cases=null){
      $this->_Cases=$Cases;
      if(!isset($Cases)){
        // get a Cases based on its identifier
        // fill the attributes
        $me=array();
        $me['Cases']=(DB_doquer("SELECT DISTINCT `f1`.`Case` AS `id`
                                   FROM  ( SELECT DISTINCT csnd.i AS `Case`
                                             FROM `case` AS csnd
                                         ) AS f1"));
        foreach($me['Cases'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`areaoflaw` AS `area of law`
                                       , `f4`.`casetype` AS `type of case`
                                       , `f5`.`caretaker` AS `caretaker voor dossier`
                                    FROM `case`
                                    LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `case` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                   WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          $v0['session']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`session`
                                               FROM `case`
                                               JOIN  ( SELECT DISTINCT F0.`case`, F1.`session`
                                                              FROM `process` AS F0, `process` AS F1
                                                             WHERE F0.`i`=F1.`i`
                                                          ) AS f1
                                                 ON `f1`.`case`='".addslashes($v0['id'])."'
                                              WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          $v0['court']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`location` AS `court`
                                             FROM `case`
                                             JOIN  ( SELECT DISTINCT F0.`case`, F2.`location`
                                                            FROM `process` AS F0, `process` AS F1, `session` AS F2
                                                           WHERE F0.`i`=F1.`i`
                                                             AND F1.`session`=F2.`i`
                                                        ) AS f1
                                               ON `f1`.`case`='".addslashes($v0['id'])."'
                                            WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          $v0['clusters']=(DB_doquer("SELECT DISTINCT `f1`.`Cluster` AS `id`
                                        FROM `case`
                                        JOIN `clustercase` AS f1 ON `f1`.`case`='".addslashes($v0['id'])."'
                                       WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          foreach($v0['clusters'] as $i1=>&$v1){
            $v1['cases']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`case` AS `cases`
                                               FROM `cluster`
                                               JOIN `clustercase` AS f1 ON `f1`.`Cluster`='".addslashes($v1['id'])."'
                                              WHERE `cluster`.`i`='".addslashes($v1['id'])."'"));
          }
          unset($v1);
        }
        unset($v0);
        $this->set_Cases($me['Cases']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Cases" => $this->_Cases);
      // no code for session,i in session
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `case` (`i`,`areaoflaw`,`casetype`,`caretaker`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['area of law'])."', '".addslashes($v0['type of case'])."', '".addslashes($v0['caretaker voor dossier'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in case
      // no code for cases,i in case
      // no code for Cases,case in process
      // no code for court,i in court
      // no code for clusters,i in cluster
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker voor dossier'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0['caretaker voor dossier'])."')", 5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0['type of case'])."')", 5);
      }
      // no code for Cases,case in plaintiff
      // no code for nr,case in plaintiff
      // no code for cases,case in plaintiff
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `clustercase` WHERE `case`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        foreach  ($v0['clusters'] as $clusters){
          $res=DB_doquer("INSERT IGNORE INTO `clustercase` (`cluster`,`case`) VALUES ('".addslashes($clusters['id'])."', '".addslashes($v0['id'])."')", 5);
        }
      }
      // no code for clusters,cluster in base
      // no code for session,session in judge
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
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
      if (!checkRule31()){
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Cases($val){
      $this->_Cases=$val;
    }
    function get_Cases(){
      if(!isset($this->_Cases)) return array();
      return $this->_Cases;
    }
  }

?>