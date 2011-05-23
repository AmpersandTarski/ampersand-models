<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 806, file "VIRO453ENG.adl"
    SERVICE Court : I[Court]
   = [ Sessions : location~
        = [ nr : [Session]
          , panel : panel
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , schedule : session~
             = [ nr : [Process]
               , case : case
               , type of case : case;caseType
               ]
          ]
     , panels : court~
     , members : clerk\/court~;members~
     , cases : authorized~
     , main city : mainCity
     , local cities : localCities~
     , o schedule : authorized~/\-(location~;session~;case)
        = [ casenr : [Case]
          , defendant : defendant~
          , plaintiff : plaintiff~
          , joined party : joinedInterestedParty~
          ]
     ]
   *********/
  
  class Court {
    protected $_id=false;
    protected $_new=true;
    private $_Sessions;
    private $_panels;
    private $_members;
    private $_cases;
    private $_maincity;
    private $_localcities;
    private $_oschedule;
    function Court($id=null, $Sessions=null, $panels=null, $members=null, $cases=null, $maincity=null, $localcities=null, $oschedule=null){
      $this->_id=$id;
      $this->_Sessions=$Sessions;
      $this->_panels=$panels;
      $this->_members=$members;
      $this->_cases=$cases;
      $this->_maincity=$maincity;
      $this->_localcities=$localcities;
      $this->_oschedule=$oschedule;
      if(!isset($Sessions) && isset($id)){
        // get a Court based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCourt` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCourt`, `i`
                                  FROM `court`
                              ) AS fst
                          WHERE fst.`AttCourt` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `court`.`i` AS `id`
                                       , `court`.`maincity` AS `main city`
                                    FROM `court`
                                   WHERE `court`.`i`='".addslashes($id)."'"));
          $me['Sessions']=(DB_doquer("SELECT DISTINCT `session`.`i` AS `id`
                                        FROM `session`
                                       WHERE `session`.`location`='".addslashes($id)."'"));
          $me['panels']=firstCol(DB_doquer("SELECT DISTINCT `panel`.`i` AS `panels`
                                              FROM `panel`
                                             WHERE `panel`.`court`='".addslashes($id)."'"));
          $me['members']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `members`
                                               FROM `court`
                                               JOIN  ( 
                                                            (SELECT DISTINCT court, party AS `Party`
                                                                  FROM `clerk`
                                                            ) UNION (SELECT DISTINCT F0.`court`, F1.`party` AS `Party`
                                                                  FROM `panel` AS F0, `members` AS F1
                                                                 WHERE F0.`i`=F1.`Panel`
                                                            
                                                            )
                                                          ) AS f1
                                                 ON `f1`.`court`='".addslashes($id)."'
                                              WHERE `court`.`i`='".addslashes($id)."'"));
          $me['cases']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`case` AS `cases`
                                             FROM `court`
                                             JOIN `authorized` AS f1 ON `f1`.`Court`='".addslashes($id)."'
                                            WHERE `court`.`i`='".addslashes($id)."'"));
          $me['local cities']=firstCol(DB_doquer("SELECT DISTINCT `city`.`i` AS `local cities`
                                                    FROM `court`
                                                    JOIN `city` ON `city`.`localcities`='".addslashes($id)."'
                                                   WHERE `court`.`i`='".addslashes($id)."'"));
          $me['o schedule']=(DB_doquer("SELECT DISTINCT `f1`.`case` AS `id`
                                          FROM `court`
                                          JOIN  ( SELECT DISTINCT isect0.`Court`, isect0.`case`
                                                         FROM `authorized` AS isect0
                                                        WHERE NOT EXISTS (SELECT *
                                                                     FROM 
                                                                        ( SELECT DISTINCT F0.`location`, F2.`case`
                                                                            FROM `session` AS F0, `process` AS F1, `process` AS F2
                                                                           WHERE F0.`i`=F1.`session`
                                                                             AND F1.`i`=F2.`i`
                                                                        ) AS cp
                                                                    WHERE isect0.`Court`=cp.`location` AND isect0.`case`=cp.`case`) AND isect0.`Court` IS NOT NULL AND isect0.`case` IS NOT NULL
                                                     ) AS f1
                                            ON `f1`.`Court`='".addslashes($id)."'
                                         WHERE `court`.`i`='".addslashes($id)."'"));
          foreach($me['Sessions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`panel`
                                         , `f4`.`clerk`
                                         , `f5`.`scheduled`
                                      FROM `session`
                                      LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                               FROM `session`
                                               JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                              WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v0['schedule']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                          FROM `session`
                                          JOIN `process` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                         WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            foreach($v0['schedule'] as $i1=>&$v1){
              $v1=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1['id'])."' AS `id`
                                           , '".addslashes($v1['id'])."' AS `nr`
                                           , `f3`.`case`
                                           , `f4`.`casetype` AS `type of case`
                                        FROM `process`
                                        LEFT JOIN `process` AS f3 ON `f3`.`i`='".addslashes($v1['id'])."'
                                        LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`casetype`
                                                       FROM `process` AS F0, `case` AS F1
                                                      WHERE F0.`case`=F1.`i`
                                                   ) AS f4
                                          ON `f4`.`i`='".addslashes($v1['id'])."'
                                       WHERE `process`.`i`='".addslashes($v1['id'])."'"));
            }
            unset($v1);
          }
          unset($v0);
          foreach($me['o schedule'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `casenr`
                                      FROM `case`
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
            $v0['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                   FROM `case`
                                                   JOIN `defendant` AS f1 ON `f1`.`Case`='".addslashes($v0['id'])."'
                                                  WHERE `case`.`i`='".addslashes($v0['id'])."'"));
            $v0['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `plaintiff`
                                                   FROM `case`
                                                   JOIN `plaintiff` AS f1 ON `f1`.`case`='".addslashes($v0['id'])."'
                                                  WHERE `case`.`i`='".addslashes($v0['id'])."'"));
            $v0['joined party']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `joined party`
                                                      FROM `case`
                                                      JOIN `joinedinterestedparty` AS f1 ON `f1`.`Case`='".addslashes($v0['id'])."'
                                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Sessions($me['Sessions']);
          $this->set_panels($me['panels']);
          $this->set_members($me['members']);
          $this->set_cases($me['cases']);
          $this->set_maincity($me['main city']);
          $this->set_localcities($me['local cities']);
          $this->set_oschedule($me['o schedule']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCourt` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCourt`, `i`
                                  FROM `court`
                              ) AS fst
                          WHERE fst.`AttCourt` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "Sessions" => $this->_Sessions, "panels" => $this->_panels, "members" => $this->_members, "cases" => $this->_cases, "main city" => $this->_maincity, "local cities" => $this->_localcities, "o schedule" => $this->_oschedule);
      foreach($me['Sessions'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `session` SET `i`='".addslashes($v0['id'])."', `panel`='".addslashes($v0['panel'])."', `clerk`='".addslashes($v0['clerk'])."', `scheduled`='".addslashes($v0['scheduled'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['Sessions'] as $Sessions){
        if(isset($me['id']))
          DB_doquer("UPDATE `session` SET `location`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Sessions['id'])."'", 5);
      }
      // no code for nr,i in session
      // no code for case,i in case
      // no code for cases,i in case
      foreach($me['o schedule'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `case` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['casenr'])."'", 5);
      }
      // no code for casenr,i in case
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          if(isset($v1['id']))
            DB_doquer("UPDATE `process` SET `i`='".addslashes($v1['id'])."', `case`='".addslashes($v1['case'])."' WHERE `i`='".addslashes($v1['nr'])."'", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['schedule'] as $schedule){
          if(isset($v0['id']))
            DB_doquer("UPDATE `process` SET `session`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($schedule['id'])."'", 5);
        }
      }
      // no code for nr,i in process
      if(isset($me['id']))
        DB_doquer("UPDATE `court` SET `maincity`='".addslashes($me['main city'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for panel,i in panel
      // no code for panels,i in panel
      foreach  ($me['panels'] as $panels){
        if(isset($me['id']))
          DB_doquer("UPDATE `panel` SET `court`='".addslashes($me['id'])."' WHERE `i`='".addslashes($panels)."'", 5);
      }
      DB_doquer("DELETE FROM `city` WHERE `localcities`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `city` (`i`) VALUES ('".addslashes($me['main city'])."')", 5);
      foreach($me['local cities'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `city` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach  ($me['local cities'] as $localcities){
        $res=DB_doquer("INSERT IGNORE INTO `city` (`i`,`localcities`) VALUES ('".addslashes($localcities)."', ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['members'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['joined party'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['clerk'])."')", 5);
      }
      foreach($me['members'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['joined party'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1['type of case'])."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1['type of case'])."')", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['o schedule'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($v0['id'])."'",5);
      }
      // no code for case,case in plaintiff
      // no code for cases,case in plaintiff
      foreach($me['o schedule'] as $i0=>$v0){
        foreach  ($v0['plaintiff'] as $plaintiff){
          $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`case`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($plaintiff)."')", 5);
        }
      }
      // no code for casenr,case in plaintiff
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      // no code for nr,session in judge
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
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
      if (!checkRule35()){
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
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "Sessions" => $this->_Sessions, "panels" => $this->_panels, "members" => $this->_members, "cases" => $this->_cases, "main city" => $this->_maincity, "local cities" => $this->_localcities, "o schedule" => $this->_oschedule);
      DB_doquer("DELETE FROM `city` WHERE `localcities`='".addslashes($me['id'])."'",5);
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['members'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['o schedule'] as $i0=>$v0){
        foreach($v0['joined party'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1['type of case'])."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['o schedule'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
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
      if (!checkRule35()){
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
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
    function set_panels($val){
      $this->_panels=$val;
    }
    function get_panels(){
      if(!isset($this->_panels)) return array();
      return $this->_panels;
    }
    function set_members($val){
      $this->_members=$val;
    }
    function get_members(){
      if(!isset($this->_members)) return array();
      return $this->_members;
    }
    function set_cases($val){
      $this->_cases=$val;
    }
    function get_cases(){
      if(!isset($this->_cases)) return array();
      return $this->_cases;
    }
    function set_maincity($val){
      $this->_maincity=$val;
    }
    function get_maincity(){
      return $this->_maincity;
    }
    function set_localcities($val){
      $this->_localcities=$val;
    }
    function get_localcities(){
      if(!isset($this->_localcities)) return array();
      return $this->_localcities;
    }
    function set_oschedule($val){
      $this->_oschedule=$val;
    }
    function get_oschedule(){
      if(!isset($this->_oschedule)) return array();
      return $this->_oschedule;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id===null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachCourt(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `court`'));
  }

  function readCourt($id){
      // check existence of $id
      $obj = new Court($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCourt($id){
    $tobeDeleted = new Court($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>