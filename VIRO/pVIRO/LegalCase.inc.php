<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 204, file "VIROENG.adl"
    SERVICE LegalCase : I[LegalCase]
   = [ plaintiff : plaintiff~
     , representative of plaintiff : (plaintiff~;authBy~/\authFor~);writtenAuthOf
     , defendant : defendant~
     , representative of defendant : (defendant~;authBy~/\authFor~);writtenAuthOf
     , area of law : areaOfLaw
     , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
     , process : legalCase~
        = [ nr : [Process]
          , session : session
          , panel : session;panel
          , scheduled : session;scheduled
          , judge : session;judge
          , clerk : session;clerk
          ]
     , court : broughtBefore
     , case file : caseFile~
        = [ Document : [Document]
          , type : documentType
          ]
     , authorization documents : authFor~
        = [ authorization : [Document]
          , party : authBy
          , representative : writtenAuthOf
          ]
     ]
   *********/
  
  class LegalCase {
    protected $_id=false;
    protected $_new=true;
    private $_plaintiff;
    private $_representativeofplaintiff;
    private $_defendant;
    private $_representativeofdefendant;
    private $_areaoflaw;
    private $_typeofcase;
    private $_process;
    private $_court;
    private $_casefile;
    private $_authorizationdocuments;
    function LegalCase($id=null, $plaintiff=null, $representativeofplaintiff=null, $defendant=null, $representativeofdefendant=null, $areaoflaw=null, $typeofcase=null, $process=null, $court=null, $casefile=null, $authorizationdocuments=null){
      $this->_id=$id;
      $this->_plaintiff=$plaintiff;
      $this->_representativeofplaintiff=$representativeofplaintiff;
      $this->_defendant=$defendant;
      $this->_representativeofdefendant=$representativeofdefendant;
      $this->_areaoflaw=$areaoflaw;
      $this->_typeofcase=$typeofcase;
      $this->_process=$process;
      $this->_court=$court;
      $this->_casefile=$casefile;
      $this->_authorizationdocuments=$authorizationdocuments;
      if(!isset($plaintiff) && isset($id)){
        // get a LegalCase based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttLegalCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttLegalCase`, `i`
                                  FROM `legalcase`
                              ) AS fst
                          WHERE fst.`AttLegalCase` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `plaintiff`.`legalcase` AS `id`
                                       , `legalcase`.`areaoflaw` AS `area of law`
                                    FROM `plaintiff`
                                    LEFT JOIN `legalcase` ON `legalcase`.`i`='".addslashes($id)."'
                                   WHERE `plaintiff`.`legalcase`='".addslashes($id)."'"));
          $me['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `plaintiff`.`party` AS `plaintiff`
                                                 FROM `plaintiff`
                                                WHERE `plaintiff`.`legalcase`='".addslashes($id)."'"));
          $me['representative of plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative of plaintiff`
                                                                   FROM `legalcase`
                                                                   JOIN  ( SELECT DISTINCT F0.`legalcase`, F1.`Party`
                                                                                  FROM 
                                                                                     ( SELECT DISTINCT isect0.`legalcase`, isect0.`document`
                                                                                         FROM 
                                                                                            ( SELECT DISTINCT F0.`legalcase`, F1.`document`
                                                                                                FROM `plaintiff` AS F0, `authby` AS F1
                                                                                               WHERE F0.`party`=F1.`Party`
                                                                                            ) AS isect0, `authfor` AS isect1
                                                                                        WHERE (isect0.`legalcase` = isect1.`LegalCase` AND isect0.`document` = isect1.`document`) AND isect0.`legalcase` IS NOT NULL AND isect0.`document` IS NOT NULL
                                                                                     ) AS F0, `writtenauthof` AS F1
                                                                                 WHERE F0.`document`=F1.`document`
                                                                              ) AS f1
                                                                     ON `f1`.`legalcase`='".addslashes($id)."'
                                                                  WHERE `legalcase`.`i`='".addslashes($id)."'"));
          $me['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                 FROM `legalcase`
                                                 JOIN `defendant` AS f1 ON `f1`.`LegalCase`='".addslashes($id)."'
                                                WHERE `legalcase`.`i`='".addslashes($id)."'"));
          $me['representative of defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative of defendant`
                                                                   FROM `legalcase`
                                                                   JOIN  ( SELECT DISTINCT F0.`LegalCase`, F1.`Party`
                                                                                  FROM 
                                                                                     ( SELECT DISTINCT isect0.`LegalCase`, isect0.`document`
                                                                                         FROM 
                                                                                            ( SELECT DISTINCT F0.`LegalCase`, F1.`document`
                                                                                                FROM `defendant` AS F0, `authby` AS F1
                                                                                               WHERE F0.`party`=F1.`Party`
                                                                                            ) AS isect0, `authfor` AS isect1
                                                                                        WHERE (isect0.`LegalCase` = isect1.`LegalCase` AND isect0.`document` = isect1.`document`) AND isect0.`LegalCase` IS NOT NULL AND isect0.`document` IS NOT NULL
                                                                                     ) AS F0, `writtenauthof` AS F1
                                                                                 WHERE F0.`document`=F1.`document`
                                                                              ) AS f1
                                                                     ON `f1`.`LegalCase`='".addslashes($id)."'
                                                                  WHERE `legalcase`.`i`='".addslashes($id)."'"));
          $me['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                    FROM `legalcase`
                                                    JOIN  ( 
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
                                                               ) AS f1
                                                      ON `f1`.`legalcase`='".addslashes($id)."'
                                                   WHERE `legalcase`.`i`='".addslashes($id)."'"));
          $me['process']=(DB_doquer("SELECT DISTINCT `process`.`i` AS `id`
                                       FROM `process`
                                      WHERE `process`.`legalcase`='".addslashes($id)."'"));
          $me['court']=firstCol(DB_doquer("SELECT DISTINCT `broughtbefore`.`court`
                                             FROM `broughtbefore`
                                            WHERE `broughtbefore`.`legalcase`='".addslashes($id)."'"));
          $me['case file']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                         FROM `legalcase`
                                         JOIN `casefile` AS f1 ON `f1`.`LegalCase`='".addslashes($id)."'
                                        WHERE `legalcase`.`i`='".addslashes($id)."'"));
          $me['authorization documents']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                                       FROM `legalcase`
                                                       JOIN `authfor` AS f1 ON `f1`.`LegalCase`='".addslashes($id)."'
                                                      WHERE `legalcase`.`i`='".addslashes($id)."'"));
          foreach($me['process'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`session`
                                         , `f4`.`panel`
                                         , `f5`.`scheduled`
                                         , `f6`.`clerk`
                                      FROM `process`
                                      LEFT JOIN `process` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`panel`
                                                     FROM `process` AS F0, `session` AS F1
                                                    WHERE F0.`session`=F1.`i`
                                                 ) AS f4
                                        ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`scheduled`
                                                     FROM `process` AS F0, `session` AS F1
                                                    WHERE F0.`session`=F1.`i`
                                                 ) AS f5
                                        ON `f5`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`clerk`
                                                     FROM `process` AS F0, `session` AS F1
                                                    WHERE F0.`session`=F1.`i`
                                                 ) AS f6
                                        ON `f6`.`i`='".addslashes($v0['id'])."'
                                     WHERE `process`.`i`='".addslashes($v0['id'])."'"));
            $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                               FROM `process`
                                               JOIN  ( SELECT DISTINCT F0.`i`, F1.`party`
                                                              FROM `process` AS F0, `judge` AS F1
                                                             WHERE F0.`session`=F1.`session`
                                                          ) AS f1
                                                 ON `f1`.`i`='".addslashes($v0['id'])."'
                                              WHERE `process`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['case file'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Document`
                                         , `f3`.`documenttype` AS `type`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['authorization documents'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `authorization`
                                      FROM `document`
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['party']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `party`
                                               FROM `document`
                                               JOIN `authby` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                              WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative`
                                                        FROM `document`
                                                        JOIN `writtenauthof` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                                       WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_plaintiff($me['plaintiff']);
          $this->set_representativeofplaintiff($me['representative of plaintiff']);
          $this->set_defendant($me['defendant']);
          $this->set_representativeofdefendant($me['representative of defendant']);
          $this->set_areaoflaw($me['area of law']);
          $this->set_typeofcase($me['type of case']);
          $this->set_process($me['process']);
          $this->set_court($me['court']);
          $this->set_casefile($me['case file']);
          $this->set_authorizationdocuments($me['authorization documents']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttLegalCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttLegalCase`, `i`
                                  FROM `legalcase`
                              ) AS fst
                          WHERE fst.`AttLegalCase` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "representative of plaintiff" => $this->_representativeofplaintiff, "defendant" => $this->_defendant, "representative of defendant" => $this->_representativeofdefendant, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "process" => $this->_process, "court" => $this->_court, "case file" => $this->_casefile, "authorization documents" => $this->_authorizationdocuments);
      // no code for session,i in session
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `document` (`i`,`documenttype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['type'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
        }
      }
      // no code for Document,i in document
      foreach($me['authorization documents'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['authorization'])."'", 5);
      }
      // no code for authorization,i in document
      if(isset($me['id']))
        DB_doquer("UPDATE `legalcase` SET `areaoflaw`='".addslashes($me['area of law'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      foreach($me['process'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `process` SET `i`='".addslashes($v0['id'])."', `session`='".addslashes($v0['session'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['process'] as $process){
        if(isset($me['id']))
          DB_doquer("UPDATE `process` SET `legalcase`='".addslashes($me['id'])."' WHERE `i`='".addslashes($process['id'])."'", 5);
      }
      // no code for nr,i in process
      // no code for court,i in court
      // no code for plaintiff,i in party
      // no code for representative of plaintiff,i in party
      // no code for defendant,i in party
      // no code for representative of defendant,i in party
      // no code for judge,i in party
      // no code for clerk,i in party
      // no code for party,i in party
      // no code for representative,i in party
      // no code for panel,i in panel
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($me['area of law'])."')", 5);
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['case file'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['type of case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['type of case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($me['id'])."'",5);
      foreach  ($me['plaintiff'] as $plaintiff){
        $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`party`,`legalcase`) VALUES ('".addslashes($plaintiff)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `writtenauthof` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `writtenauthof` (`party`,`document`) VALUES ('".addslashes($representative)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authby` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach  ($v0['party'] as $party){
          $res=DB_doquer("INSERT IGNORE INTO `authby` (`party`,`document`) VALUES ('".addslashes($party)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      // no code for session,session in judge
      DB_doquer("DELETE FROM `broughtbefore` WHERE `legalcase`='".addslashes($me['id'])."'",5);
      foreach  ($me['court'] as $court){
        $res=DB_doquer("INSERT IGNORE INTO `broughtbefore` (`court`,`legalcase`) VALUES ('".addslashes($court)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule12()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule44()){
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
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
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
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "representative of plaintiff" => $this->_representativeofplaintiff, "defendant" => $this->_defendant, "representative of defendant" => $this->_representativeofdefendant, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "process" => $this->_process, "court" => $this->_court, "case file" => $this->_casefile, "authorization documents" => $this->_authorizationdocuments);
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['type of case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      DB_doquer("DELETE FROM `plaintiff` WHERE `legalcase`='".addslashes($me['id'])."'",5);
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `writtenauthof` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authby` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `broughtbefore` WHERE `legalcase`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule9()){
        $DB_err='\"The clerk of a session must be the clerk of the court where the session is held.\"';
      } else
      if (!checkRule10()){
        $DB_err='\"All sessions are scheduled\"';
      } else
      if (!checkRule12()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule44()){
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
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
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
    function set_plaintiff($val){
      $this->_plaintiff=$val;
    }
    function get_plaintiff(){
      if(!isset($this->_plaintiff)) return array();
      return $this->_plaintiff;
    }
    function set_representativeofplaintiff($val){
      $this->_representativeofplaintiff=$val;
    }
    function get_representativeofplaintiff(){
      if(!isset($this->_representativeofplaintiff)) return array();
      return $this->_representativeofplaintiff;
    }
    function set_defendant($val){
      $this->_defendant=$val;
    }
    function get_defendant(){
      if(!isset($this->_defendant)) return array();
      return $this->_defendant;
    }
    function set_representativeofdefendant($val){
      $this->_representativeofdefendant=$val;
    }
    function get_representativeofdefendant(){
      if(!isset($this->_representativeofdefendant)) return array();
      return $this->_representativeofdefendant;
    }
    function set_areaoflaw($val){
      $this->_areaoflaw=$val;
    }
    function get_areaoflaw(){
      return $this->_areaoflaw;
    }
    function set_typeofcase($val){
      $this->_typeofcase=$val;
    }
    function get_typeofcase(){
      if(!isset($this->_typeofcase)) return array();
      return $this->_typeofcase;
    }
    function set_process($val){
      $this->_process=$val;
    }
    function get_process(){
      if(!isset($this->_process)) return array();
      return $this->_process;
    }
    function set_court($val){
      $this->_court=$val;
    }
    function get_court(){
      if(!isset($this->_court)) return array();
      return $this->_court;
    }
    function set_casefile($val){
      $this->_casefile=$val;
    }
    function get_casefile(){
      if(!isset($this->_casefile)) return array();
      return $this->_casefile;
    }
    function set_authorizationdocuments($val){
      $this->_authorizationdocuments=$val;
    }
    function get_authorizationdocuments(){
      if(!isset($this->_authorizationdocuments)) return array();
      return $this->_authorizationdocuments;
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

  function getEachLegalCase(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `legalcase`'));
  }

  function readLegalCase($id){
      // check existence of $id
      $obj = new LegalCase($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delLegalCase($id){
    $tobeDeleted = new LegalCase($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>