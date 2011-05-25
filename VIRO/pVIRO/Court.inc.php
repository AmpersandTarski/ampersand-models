<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 315, file "VIROENG.adl"
    SERVICE Court : I[Court]
   = [ Sessions : location~
        = [ nr : [Session]
          , panel : panel
          , judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , schedule : session~
             = [ nr : [Process]
               , case : legalCase
               , type of case : legalCase;(appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType)
               ]
          ]
     , panels : court~
     , members : clerk\/court~;members~
     , cases : broughtBefore~
     , main office : seatedIn
     , local offices : localOffices~
     , court of appeal : district
     , schedule : broughtBefore~/\-(location~;session~;legalCase)
        = [ casenr : [LegalCase]
          , defendant : defendant~
          , plaintiff : plaintiff~
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
    private $_mainoffice;
    private $_localoffices;
    private $_courtofappeal;
    private $_schedule;
    function Court($id=null, $Sessions=null, $panels=null, $members=null, $cases=null, $mainoffice=null, $localoffices=null, $courtofappeal=null, $schedule=null){
      $this->_id=$id;
      $this->_Sessions=$Sessions;
      $this->_panels=$panels;
      $this->_members=$members;
      $this->_cases=$cases;
      $this->_mainoffice=$mainoffice;
      $this->_localoffices=$localoffices;
      $this->_courtofappeal=$courtofappeal;
      $this->_schedule=$schedule;
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
                                       , `court`.`seatedin` AS `main office`
                                       , `court`.`district` AS `court of appeal`
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
          $me['cases']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`legalcase` AS `cases`
                                             FROM `court`
                                             JOIN `broughtbefore` AS f1 ON `f1`.`Court`='".addslashes($id)."'
                                            WHERE `court`.`i`='".addslashes($id)."'"));
          $me['local offices']=firstCol(DB_doquer("SELECT DISTINCT `city`.`i` AS `local offices`
                                                     FROM `court`
                                                     JOIN `city` ON `city`.`localoffices`='".addslashes($id)."'
                                                    WHERE `court`.`i`='".addslashes($id)."'"));
          $me['schedule']=(DB_doquer("SELECT DISTINCT `f1`.`legalcase` AS `id`
                                        FROM `court`
                                        JOIN  ( SELECT DISTINCT isect0.`Court`, isect0.`legalcase`
                                                       FROM `broughtbefore` AS isect0
                                                      WHERE NOT EXISTS (SELECT *
                                                                   FROM 
                                                                      ( SELECT DISTINCT F0.`location`, F2.`legalcase`
                                                                          FROM `session` AS F0, `process` AS F1, `process` AS F2
                                                                         WHERE F0.`i`=F1.`session`
                                                                           AND F1.`i`=F2.`i`
                                                                      ) AS cp
                                                                  WHERE isect0.`Court`=cp.`location` AND isect0.`legalcase`=cp.`legalcase`) AND isect0.`Court` IS NOT NULL AND isect0.`legalcase` IS NOT NULL
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
                                           , `f3`.`legalcase` AS `case`
                                        FROM `process`
                                        LEFT JOIN `process` AS f3 ON `f3`.`i`='".addslashes($v1['id'])."'
                                       WHERE `process`.`i`='".addslashes($v1['id'])."'"));
              $v1['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                        FROM `process`
                                                        JOIN  ( SELECT DISTINCT F0.`i`, F1.`casetype`
                                                                       FROM `process` AS F0, 
                                                                          ( 
                                                                            (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                                  FROM `appeal` AS F0, `legalcase` AS F1
                                                                                 WHERE F0.`legalcase1`=F1.`i`
                                                                            ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                                  FROM `appealtoadmincourt` AS F0, `legalcase` AS F1
                                                                                 WHERE F0.`legalcase1`=F1.`i`
                                                                            ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                                  FROM `objection` AS F0, `legalcase` AS F1
                                                                                 WHERE F0.`legalcase1`=F1.`i`
                                                                            
                                                                            
                                                                            )
                                                                          ) AS F1
                                                                      WHERE F0.`legalcase`=F1.`legalcase`
                                                                   ) AS f1
                                                          ON `f1`.`i`='".addslashes($v1['id'])."'
                                                       WHERE `process`.`i`='".addslashes($v1['id'])."'"));
            }
            unset($v1);
          }
          unset($v0);
          foreach($me['schedule'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `casenr`
                                      FROM `legalcase`
                                     WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
            $v0['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                   FROM `legalcase`
                                                   JOIN `defendant` AS f1 ON `f1`.`LegalCase`='".addslashes($v0['id'])."'
                                                  WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
            $v0['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `plaintiff`
                                                   FROM `legalcase`
                                                   JOIN `plaintiff` AS f1 ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                                  WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Sessions($me['Sessions']);
          $this->set_panels($me['panels']);
          $this->set_members($me['members']);
          $this->set_cases($me['cases']);
          $this->set_mainoffice($me['main office']);
          $this->set_localoffices($me['local offices']);
          $this->set_courtofappeal($me['court of appeal']);
          $this->set_schedule($me['schedule']);
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
      $me=array("id"=>$this->getId(), "Sessions" => $this->_Sessions, "panels" => $this->_panels, "members" => $this->_members, "cases" => $this->_cases, "main office" => $this->_mainoffice, "local offices" => $this->_localoffices, "court of appeal" => $this->_courtofappeal, "schedule" => $this->_schedule);
      foreach($me['Sessions'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `session` SET `i`='".addslashes($v0['id'])."', `panel`='".addslashes($v0['panel'])."', `clerk`='".addslashes($v0['clerk'])."', `scheduled`='".addslashes($v0['scheduled'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['Sessions'] as $Sessions){
        if(isset($me['id']))
          DB_doquer("UPDATE `session` SET `location`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Sessions['id'])."'", 5);
      }
      // no code for nr,i in session
      // no code for case,i in legalcase
      // no code for cases,i in legalcase
      foreach($me['schedule'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['casenr'])."'", 5);
      }
      // no code for casenr,i in legalcase
      // no code for main office,i in city
      // no code for local offices,i in city
      if(isset($me['id'])) DB_doquer("UPDATE `city` SET `localoffices`=NULL WHERE `localoffices`='".addslashes($me['id'])."'",5);
      foreach  ($me['local offices'] as $localoffices){
        if(isset($me['id']))
          DB_doquer("UPDATE `city` SET `localoffices`='".addslashes($me['id'])."' WHERE `i`='".addslashes($localoffices)."'", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          if(isset($v1['id']))
            DB_doquer("UPDATE `process` SET `i`='".addslashes($v1['id'])."', `legalcase`='".addslashes($v1['case'])."' WHERE `i`='".addslashes($v1['nr'])."'", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['schedule'] as $schedule){
          if(isset($v0['id']))
            DB_doquer("UPDATE `process` SET `session`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($schedule['id'])."'", 5);
        }
      }
      // no code for nr,i in process
      DB_doquer("DELETE FROM `court` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `court` (`seatedin`,`district`,`i`) VALUES ('".addslashes($me['main office'])."', '".addslashes($me['court of appeal'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for judge,i in party
      // no code for clerk,i in party
      // no code for members,i in party
      // no code for defendant,i in party
      // no code for plaintiff,i in party
      DB_doquer("DELETE FROM `panel` WHERE `court`='".addslashes($me['id'])."'",5);
      // no code for panel,i in panel
      // no code for panels,i in panel
      foreach  ($me['panels'] as $panels){
        $res=DB_doquer("INSERT IGNORE INTO `panel` (`i`,`court`) VALUES ('".addslashes($panels)."', '".addslashes($me['id'])."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      // no code for court of appeal,i in courtofappeal
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          foreach($v1['type of case'] as $i2=>$v2){
            DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v2)."'",5);
          }
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          foreach($v1['type of case'] as $i2=>$v2){
            $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v2)."')", 5);
          }
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['schedule'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($v0['id'])."'",5);
      }
      // no code for case,legalcase in plaintiff
      // no code for cases,legalcase in plaintiff
      foreach($me['schedule'] as $i0=>$v0){
        foreach  ($v0['plaintiff'] as $plaintiff){
          $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`legalcase`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($plaintiff)."')", 5);
        }
      }
      // no code for casenr,legalcase in plaintiff
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
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
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
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
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
      if (!checkRule39()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
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
      $me=array("id"=>$this->getId(), "Sessions" => $this->_Sessions, "panels" => $this->_panels, "members" => $this->_members, "cases" => $this->_cases, "main office" => $this->_mainoffice, "local offices" => $this->_localoffices, "court of appeal" => $this->_courtofappeal, "schedule" => $this->_schedule);
      if(isset($me['id'])) DB_doquer("UPDATE `city` SET `localoffices`=NULL WHERE `localoffices`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `court` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `panel` WHERE `court`='".addslashes($me['id'])."'",5);
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['schedule'] as $i1=>$v1){
          foreach($v1['type of case'] as $i2=>$v2){
            DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v2)."'",5);
          }
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['schedule'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
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
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
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
      if (!checkRule39()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
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
    function set_mainoffice($val){
      $this->_mainoffice=$val;
    }
    function get_mainoffice(){
      return $this->_mainoffice;
    }
    function set_localoffices($val){
      $this->_localoffices=$val;
    }
    function get_localoffices(){
      if(!isset($this->_localoffices)) return array();
      return $this->_localoffices;
    }
    function set_courtofappeal($val){
      $this->_courtofappeal=$val;
    }
    function get_courtofappeal(){
      return $this->_courtofappeal;
    }
    function set_schedule($val){
      $this->_schedule=$val;
    }
    function get_schedule(){
      if(!isset($this->_schedule)) return array();
      return $this->_schedule;
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