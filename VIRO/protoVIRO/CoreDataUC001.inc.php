<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 579, file "VIRO453ENG.adl"
    SERVICE CoreDataUC001 : I[Case]
   = [ plaintiff : plaintiff~;by~/\for~
        = [ party : by
          , representative : authorizedRepresentative~
          ]
     , defendant : defendant~;by~/\for~
        = [ party : by
          , representative : authorizedRepresentative~
          ]
     , joined party : joinedInterestedParty~;by~/\for~
        = [ party : by
          , representative : authorizedRepresentative~
          ]
     , area of law : areaOfLaw
     , type of case : caseType
     , authorized : authorized
     , caretaker of case file : caretaker
     , case file : caseFile~
        = [ Document : [Document]
          , type : documentType
          ]
     , cluster : cluster
        = [ name : [Cluster]
          , base : base
          ]
     , authorization documents : for~
        = [ document : [Authorization]
          , represented : by
          , representative : authorizedRepresentative~
          ]
     ]
   *********/
  
  class CoreDataUC001 {
    protected $_id=false;
    protected $_new=true;
    private $_plaintiff;
    private $_defendant;
    private $_joinedparty;
    private $_areaoflaw;
    private $_typeofcase;
    private $_authorized;
    private $_caretakerofcasefile;
    private $_casefile;
    private $_cluster;
    private $_authorizationdocuments;
    function CoreDataUC001($id=null, $plaintiff=null, $defendant=null, $joinedparty=null, $areaoflaw=null, $typeofcase=null, $authorized=null, $caretakerofcasefile=null, $casefile=null, $cluster=null, $authorizationdocuments=null){
      $this->_id=$id;
      $this->_plaintiff=$plaintiff;
      $this->_defendant=$defendant;
      $this->_joinedparty=$joinedparty;
      $this->_areaoflaw=$areaoflaw;
      $this->_typeofcase=$typeofcase;
      $this->_authorized=$authorized;
      $this->_caretakerofcasefile=$caretakerofcasefile;
      $this->_casefile=$casefile;
      $this->_cluster=$cluster;
      $this->_authorizationdocuments=$authorizationdocuments;
      if(!isset($plaintiff) && isset($id)){
        // get a CoreDataUC001 based on its identifier
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
          $me['plaintiff']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                         FROM `case`
                                         JOIN  ( SELECT DISTINCT isect0.`case`, isect0.`i`
                                                        FROM 
                                                           ( SELECT DISTINCT F0.`case`, F1.`i`
                                                               FROM `plaintiff` AS F0, `authorization` AS F1
                                                              WHERE F0.`party`=F1.`by`
                                                           ) AS isect0, `for` AS isect1
                                                       WHERE (isect0.`case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                    ) AS f1
                                           ON `f1`.`case`='".addslashes($id)."'
                                        WHERE `case`.`i`='".addslashes($id)."'"));
          $me['defendant']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                         FROM `case`
                                         JOIN  ( SELECT DISTINCT isect0.`Case`, isect0.`i`
                                                        FROM 
                                                           ( SELECT DISTINCT F0.`Case`, F1.`i`
                                                               FROM `defendant` AS F0, `authorization` AS F1
                                                              WHERE F0.`party`=F1.`by`
                                                           ) AS isect0, `for` AS isect1
                                                       WHERE (isect0.`Case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`Case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                    ) AS f1
                                           ON `f1`.`Case`='".addslashes($id)."'
                                        WHERE `case`.`i`='".addslashes($id)."'"));
          $me['joined party']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                            FROM `case`
                                            JOIN  ( SELECT DISTINCT isect0.`Case`, isect0.`i`
                                                           FROM 
                                                              ( SELECT DISTINCT F0.`Case`, F1.`i`
                                                                  FROM `joinedinterestedparty` AS F0, `authorization` AS F1
                                                                 WHERE F0.`party`=F1.`by`
                                                              ) AS isect0, `for` AS isect1
                                                          WHERE (isect0.`Case` = isect1.`Case` AND isect0.`i` = isect1.`authorization`) AND isect0.`Case` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                       ) AS f1
                                              ON `f1`.`Case`='".addslashes($id)."'
                                           WHERE `case`.`i`='".addslashes($id)."'"));
          $me['authorized']=firstCol(DB_doquer("SELECT DISTINCT `authorized`.`court` AS `authorized`
                                                  FROM `authorized`
                                                 WHERE `authorized`.`case`='".addslashes($id)."'"));
          $me['case file']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                         FROM `case`
                                         JOIN `casefile` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                        WHERE `case`.`i`='".addslashes($id)."'"));
          $me['cluster']=(DB_doquer("SELECT DISTINCT `clustercase`.`cluster` AS `id`
                                       FROM `clustercase`
                                      WHERE `clustercase`.`case`='".addslashes($id)."'"));
          $me['authorization documents']=(DB_doquer("SELECT DISTINCT `f1`.`authorization` AS `id`
                                                       FROM `case`
                                                       JOIN `for` AS f1 ON `f1`.`Case`='".addslashes($id)."'
                                                      WHERE `case`.`i`='".addslashes($id)."'"));
          foreach($me['plaintiff'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`by` AS `party`
                                      FROM `authorization`
                                      LEFT JOIN `authorization` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                        FROM `authorization`
                                                        JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                       WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['defendant'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`by` AS `party`
                                      FROM `authorization`
                                      LEFT JOIN `authorization` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                        FROM `authorization`
                                                        JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                       WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['joined party'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`by` AS `party`
                                      FROM `authorization`
                                      LEFT JOIN `authorization` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                        FROM `authorization`
                                                        JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                       WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
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
          foreach($me['cluster'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `name`
                                      FROM `cluster`
                                     WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
            $v0['base']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`text` AS `base`
                                              FROM `cluster`
                                              JOIN `base` AS f1 ON `f1`.`cluster`='".addslashes($v0['id'])."'
                                             WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['authorization documents'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `document`
                                         , `f3`.`by` AS `represented`
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
          $this->set_defendant($me['defendant']);
          $this->set_joinedparty($me['joined party']);
          $this->set_areaoflaw($me['area of law']);
          $this->set_typeofcase($me['type of case']);
          $this->set_authorized($me['authorized']);
          $this->set_caretakerofcasefile($me['caretaker of case file']);
          $this->set_casefile($me['case file']);
          $this->set_cluster($me['cluster']);
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
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "defendant" => $this->_defendant, "joined party" => $this->_joinedparty, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "authorized" => $this->_authorized, "caretaker of case file" => $this->_caretakerofcasefile, "case file" => $this->_casefile, "cluster" => $this->_cluster, "authorization documents" => $this->_authorizationdocuments);
      foreach($me['case file'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `case` (`areaoflaw`,`casetype`,`caretaker`,`i`) VALUES ('".addslashes($me['area of law'])."', '".addslashes($me['type of case'])."', '".addslashes($me['caretaker of case file'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for authorized,i in court
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['party'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['defendant'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['party'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['joined party'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['party'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['represented'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for document,i in authorization
      foreach($me['cluster'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `cluster` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['name'])."'", 5);
      }
      // no code for name,i in cluster
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['case file'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker of case file'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($me['caretaker of case file'])."')", 5);
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['represented'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['party'])."')", 5);
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['defendant'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['party'])."')", 5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['joined party'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['party'])."')", 5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['represented'])."')", 5);
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
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['base'] as $i1=>$v1){
          DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['base'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      foreach($me['defendant'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      foreach($me['joined party'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      // no code for document,authorization in authorizedrepresentative
      DB_doquer("DELETE FROM `clustercase` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach  ($me['cluster'] as $cluster){
        $res=DB_doquer("INSERT IGNORE INTO `clustercase` (`cluster`,`case`) VALUES ('".addslashes($cluster['id'])."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `base` WHERE `cluster`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach  ($v0['base'] as $base){
          $res=DB_doquer("INSERT IGNORE INTO `base` (`cluster`,`text`) VALUES ('".addslashes($v0['id'])."', '".addslashes($base)."')", 5);
        }
      }
      // no code for name,cluster in base
      DB_doquer("DELETE FROM `authorized` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach  ($me['authorized'] as $authorized){
        $res=DB_doquer("INSERT IGNORE INTO `authorized` (`court`,`case`) VALUES ('".addslashes($authorized)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for case file,document in to
      // no code for Document,document in to
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
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
      if (!checkRule59()){
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
      $me=array("id"=>$this->getId(), "plaintiff" => $this->_plaintiff, "defendant" => $this->_defendant, "joined party" => $this->_joinedparty, "area of law" => $this->_areaoflaw, "type of case" => $this->_typeofcase, "authorized" => $this->_authorized, "caretaker of case file" => $this->_caretakerofcasefile, "case file" => $this->_casefile, "cluster" => $this->_cluster, "authorization documents" => $this->_authorizationdocuments);
      DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['case file'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($me['caretaker of case file'])."'",5);
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['party'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['represented'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($me['area of law'])."'",5);
      DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($me['type of case'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['base'] as $i1=>$v1){
          DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['plaintiff'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['defendant'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['joined party'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorization documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `clustercase` WHERE `case`='".addslashes($me['id'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `base` WHERE `cluster`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `authorized` WHERE `case`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
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
      if (!checkRule59()){
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
    function set_defendant($val){
      $this->_defendant=$val;
    }
    function get_defendant(){
      if(!isset($this->_defendant)) return array();
      return $this->_defendant;
    }
    function set_joinedparty($val){
      $this->_joinedparty=$val;
    }
    function get_joinedparty(){
      if(!isset($this->_joinedparty)) return array();
      return $this->_joinedparty;
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
    function set_cluster($val){
      $this->_cluster=$val;
    }
    function get_cluster(){
      if(!isset($this->_cluster)) return array();
      return $this->_cluster;
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

  function getEachCoreDataUC001(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `case`'));
  }

  function readCoreDataUC001($id){
      // check existence of $id
      $obj = new CoreDataUC001($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCoreDataUC001($id){
    $tobeDeleted = new CoreDataUC001($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>