<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 612, file "VIRO453ENG.adl"
    SERVICE LegalCase : I[Case]
   = [ plaintiff : plaintiff~
     , representative of plaintiff : (plaintiff~;by~/\for~);authorizedRepresentative~
     , defendant : defendant~
     , representative of defendant : (defendant~;by~/\for~);authorizedRepresentative~
     , joined party : joinedInterestedParty~
     , representative of joined party : (joinedInterestedParty~;by~/\for~);authorizedRepresentative~
     , area of law : areaOfLaw
     , type of case : caseType
     , process : case~
        = [ nr : [Process]
          , session : session
          , panel : session;panel
          , scheduled : session;scheduled
          , judge : session;judge
          , clerk : session;clerk
          ]
     , authorized : authorized
     , caretaker of case file : caretaker
     , case file : caseFile~
        = [ Document : [Document]
          , type : documentType
          ]
     , authorization documents : for~
        = [ authorization : [Authorization]
          , party : by
          , representative : authorizedRepresentative~
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
    private $_joinedparty;
    private $_representativeofjoinedparty;
    private $_areaoflaw;
    private $_typeofcase;
    private $_process;
    private $_authorized;
    private $_caretakerofcasefile;
    private $_casefile;
    private $_authorizationdocuments;
    function LegalCase($id=null, $plaintiff=null, $representativeofplaintiff=null, $defendant=null, $representativeofdefendant=null, $joinedparty=null, $representativeofjoinedparty=null, $areaoflaw=null, $typeofcase=null, $process=null, $authorized=null, $caretakerofcasefile=null, $casefile=null, $authorizationdocuments=null){
      $this->_id=$id;
      $this->_plaintiff=$plaintiff;
      $this->_representativeofplaintiff=$representativeofplaintiff;
      $this->_defendant=$defendant;
      $this->_representativeofdefendant=$representativeofdefendant;
      $this->_joinedparty=$joinedparty;
      $this->_representativeofjoinedparty=$representativeofjoinedparty;
      $this->_areaoflaw=$areaoflaw;
      $this->_typeofcase=$typeofcase;
      $this->_process=$process;
      $this->_authorized=$authorized;
      $this->_caretakerofcasefile=$caretakerofcasefile;
      $this->_casefile=$casefile;
      $this->_authorizationdocuments=$authorizationdocuments;
      if(!isset($plaintiff) && isset($id)){
        // get a LegalCase based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCase`, `i`
                                  FROM `case`
                              ) AS fst
                          WHERE fst.`AttCase` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `plaintiff`.`case` AS `id`
                                       , `case`.`areaoflaw` AS `area of law`
                                       , `case`.`casetype` AS `type of case`
                                       , `case`.`caretaker` AS `caretaker of case file`
                                    FROM `plaintiff`
                                    LEFT JOIN `case` ON `case`.`i`='".addslashes($id)."'
                                   WHERE `plaintiff`.`case`='".addslashes($id)."'"));
          $me['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `plaintiff`.`party` AS `plaintiff`
                                                 FROM `plaintiff`
                                                WHERE `plaintiff`.`case`='".addslashes($id)."'"));
          $me['representative of plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative of plaintiff`
                                                                   FROM `case`
                                                                   JOIN  ( SELECT DISTINCT F0.`case`, F1.`party`
                                                                                  FROM 
                                                                                     ( SELECT DISTINCT isect0.`case`, isect0.`i`
                                                                                         FROM 
                                                                                            ( SELECT DISTINCT F0.`case`, F1.`i`
                                                                                                FROM `plaintiff` AS F0, `authorization` AS F1
                                                                                               WHERE F0.`party`=F1.`by`
                                                                                            ) AS isect0, `for` AS isect1
                                                                                        WHERE (isect0.`case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                     ) AS F0, `authorizedrepresentative` AS F1
                                                                                 WHERE F0.`i`=F1.`authorization`
                                                                              ) AS f1
                                                                     ON `f1`.`case`='".addslashes($id)."'
                                                                  WHERE `case`.`i`='".addslashes($id)."'"));
          $me['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                 FROM `case`
                                                 JOIN `defendant` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                                WHERE `case`.`i`='".addslashes($id)."'"));
          $me['representative of defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative of defendant`
                                                                   FROM `case`
                                                                   JOIN  ( SELECT DISTINCT F0.`Case`, F1.`party`
                                                                                  FROM 
                                                                                     ( SELECT DISTINCT isect0.`Case`, isect0.`i`
                                                                                         FROM 
                                                                                            ( SELECT DISTINCT F0.`Case`, F1.`i`
                                                                                                FROM `defendant` AS F0, `authorization` AS F1
                                                                                               WHERE F0.`party`=F1.`by`
                                                                                            ) AS isect0, `for` AS isect1
                                                                                        WHERE (isect0.`Case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`Case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                     ) AS F0, `authorizedrepresentative` AS F1
                                                                                 WHERE F0.`i`=F1.`authorization`
                                                                              ) AS f1
                                                                     ON `f1`.`Case`='".addslashes($id)."'
                                                                  WHERE `case`.`i`='".addslashes($id)."'"));
          $me['joined party']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `joined party`
                                                    FROM `case`
                                                    JOIN `joinedinterestedparty` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                                   WHERE `case`.`i`='".addslashes($id)."'"));
          $me['representative of joined party']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative of joined party`
                                                                      FROM `case`
                                                                      JOIN  ( SELECT DISTINCT F0.`Case`, F1.`party`
                                                                                     FROM 
                                                                                        ( SELECT DISTINCT isect0.`Case`, isect0.`i`
                                                                                            FROM 
                                                                                               ( SELECT DISTINCT F0.`Case`, F1.`i`
                                                                                                   FROM `joinedinterestedparty` AS F0, `authorization` AS F1
                                                                                                  WHERE F0.`party`=F1.`by`
                                                                                               ) AS isect0, `for` AS isect1
                                                                                           WHERE (isect0.`Case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`Case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                        ) AS F0, `authorizedrepresentative` AS F1
                                                                                    WHERE F0.`i`=F1.`authorization`
                                                                                 ) AS f1
                                                                        ON `f1`.`Case`='".addslashes($id)."'
                                                                     WHERE `case`.`i`='".addslashes($id)."'"));
          $me['process']=(DB_doquer("SELECT DISTINCT `process`.`i` AS `id`
                                       FROM `process`
                                      WHERE `process`.`case`='".addslashes($id)."'"));
          $me['authorized']=firstCol(DB_doquer("SELECT DISTINCT `authorized`.`court` AS `authorized`
                                                  FROM `authorized`
                                                 WHERE `authorized`.`case`='".addslashes($id)."'"));
          $me['case file']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                         FROM `case`
                                         JOIN `casefile` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                        WHERE `case`.`i`='".addslashes($id)."'"));
          $me['authorization documents']=(DB_doquer("SELECT DISTINCT `f1`.`authorization` AS `id`
                                                       FROM `case`
                                                       JOIN `for` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                                      WHERE `case`.`i`='".addslashes($id)."'"));
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
                                         , `f3`.`by` AS `party`
                                      FROM `authorization`
                                      LEFT JOIN `authorization` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                        FROM `authorization`
                                                        JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                       WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_plaintiff($me['plaintiff']);
          $this->set_representativeofplaintiff($me['representative of plaintiff']);
          $this->set_defendant($me['defendant']);
          $this->set_representativeofdefendant($me['representative of defendant']);
          $this->set_joinedparty($me['joined party']);
          $this->set_representativeofjoinedparty($me['representative of joined party']);
          $this->set_areaoflaw($me['area of law']);
          $this->set_typeofcase($me['type of case']);
          $this->set_process($me['process']);
          $this->set_authorized($me['authorized']);
          $this->set_caretakerofcasefile($me['caretaker of case file']);
          $this->set_casefile($me['case file']);
          $this->set_authorizationdocuments($me['authorization documents']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCase`, `i`
                                  FROM `case`
                              ) AS fst
                          WHERE fst.`AttCase` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "representative of plaintiff" => $this->_representativeofplaintiff, "defendant" => $this->_defendant, "representative of defendant" => $this->_representativeofdefendant, "joined party" => $this->_joinedparty, "representative of joined party" => $this->_representativeofjoinedparty, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "process" => $this->_process, "authorized" => $this->_authorized, "caretaker of case file" => $this->_caretakerofcasefile, "case file" => $this->_casefile, "authorization documents" => $this->_authorizationdocuments);
      // no code for session,i in session
      foreach($me['case file'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `case` (`areaoflaw`,`casetype`,`caretaker`,`i`) VALUES ('".addslashes($me['area of law'])."', '".addslashes($me['type of case'])."', '".addslashes($me['caretaker of case file'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['process'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `process` SET `i`='".addslashes($v0['id'])."', `session`='".addslashes($v0['session'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['process'] as $process){
        if(isset($me['id']))
          DB_doquer("UPDATE `process` SET `case`='".addslashes($me['id'])."' WHERE `i`='".addslashes($process['id'])."'", 5);
      }
      // no code for nr,i in process
      // no code for authorized,i in court
      // no code for panel,i in panel
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['party'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for authorization,i in authorization
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['case file'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker of case file'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($me['caretaker of case file'])."')", 5);
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['process'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['representative of plaintiff'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['representative of defendant'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['representative of joined party'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['process'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['clerk'])."')", 5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['party'])."')", 5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($me['area of law'])."')", 5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['type of case'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($me['type of case'])."')", 5);
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['process'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach  ($me['plaintiff'] as $plaintiff){
        $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`party`,`case`) VALUES ('".addslashes($plaintiff)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      // no code for authorization,authorization in authorizedrepresentative
      // no code for session,session in judge
      DB_doquer("DELETE FROM `authorized` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach  ($me['authorized'] as $authorized){
        $res=DB_doquer("INSERT IGNORE INTO `authorized` (`court`,`case`) VALUES ('".addslashes($authorized)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for case file,document in to
      // no code for Document,document in to
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
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
      if (!checkRule12()){
        $DB_err='\"\"';
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
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "representative of plaintiff" => $this->_representativeofplaintiff, "defendant" => $this->_defendant, "representative of defendant" => $this->_representativeofdefendant, "joined party" => $this->_joinedparty, "representative of joined party" => $this->_representativeofjoinedparty, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "process" => $this->_process, "authorized" => $this->_authorized, "caretaker of case file" => $this->_caretakerofcasefile, "case file" => $this->_casefile, "authorization documents" => $this->_authorizationdocuments);
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker of case file'])."'",5);
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['representative of joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['process'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['type of case'])."'",5);
      foreach($me['process'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `authorized` WHERE `case`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De clerk in een case moet benoemd zijn bij de rechtbank waar deze case dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
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
      if (!checkRule12()){
        $DB_err='\"\"';
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
    function set_joinedparty($val){
      $this->_joinedparty=$val;
    }
    function get_joinedparty(){
      if(!isset($this->_joinedparty)) return array();
      return $this->_joinedparty;
    }
    function set_representativeofjoinedparty($val){
      $this->_representativeofjoinedparty=$val;
    }
    function get_representativeofjoinedparty(){
      if(!isset($this->_representativeofjoinedparty)) return array();
      return $this->_representativeofjoinedparty;
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
      return $this->_typeofcase;
    }
    function set_process($val){
      $this->_process=$val;
    }
    function get_process(){
      if(!isset($this->_process)) return array();
      return $this->_process;
    }
    function set_authorized($val){
      $this->_authorized=$val;
    }
    function get_authorized(){
      if(!isset($this->_authorized)) return array();
      return $this->_authorized;
    }
    function set_caretakerofcasefile($val){
      $this->_caretakerofcasefile=$val;
    }
    function get_caretakerofcasefile(){
      return $this->_caretakerofcasefile;
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
                                 FROM `case`'));
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