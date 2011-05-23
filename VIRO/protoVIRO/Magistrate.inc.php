<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 851, file "VIRO453ENG.adl"
    SERVICE Magistrate : I[Party]
   = [ court : clerk~\/members;court
     , panel : members
        = [ panel : [Panel]
          , sector : sector
          ]
     , role : actsas
     , Sessions : judge~\/clerk~
        = [ judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , city : city
          , location : location
          , panel : panel
             = [ court : court
               , sector : sector
               ]
          ]
     , received : from~
        = [ message : [Document]
          , from : from
          , sent : sent
          , received : sent
          ]
     , sent : to~
        = [ message : [Document]
          , from : from
          , sent : sent
          ]
     ]
   *********/
  
  class Magistrate {
    protected $_id=false;
    protected $_new=true;
    private $_court;
    private $_panel;
    private $_role;
    private $_Sessions;
    private $_received;
    private $_sent;
    function Magistrate($id=null, $court=null, $panel=null, $role=null, $Sessions=null, $received=null, $sent=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_panel=$panel;
      $this->_role=$role;
      $this->_Sessions=$Sessions;
      $this->_received=$received;
      $this->_sent=$sent;
      if(!isset($court) && isset($id)){
        // get a Magistrate based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttParty` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttParty`, `i`
                                  FROM `party`
                              ) AS fst
                          WHERE fst.`AttParty` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['court']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`court`
                                             FROM `party`
                                             JOIN  ( 
                                                          (SELECT DISTINCT Party, Court AS `court`
                                                                FROM `clerk`
                                                          ) UNION (SELECT DISTINCT F0.`party` AS `Party`, F1.`court`
                                                                FROM `members` AS F0, `panel` AS F1
                                                               WHERE F0.`Panel`=F1.`i`
                                                          
                                                          )
                                                        ) AS f1
                                               ON `f1`.`Party`='".addslashes($id)."'
                                            WHERE `party`.`i`='".addslashes($id)."'"));
          $me['panel']=(DB_doquer("SELECT DISTINCT `members`.`panel` AS `id`
                                     FROM `members`
                                    WHERE `members`.`party`='".addslashes($id)."'"));
          $me['role']=firstCol(DB_doquer("SELECT DISTINCT `actsas`.`role`
                                            FROM `actsas`
                                           WHERE `actsas`.`party`='".addslashes($id)."'"));
          $me['Sessions']=(DB_doquer("SELECT DISTINCT `f1`.`session` AS `id`
                                        FROM `party`
                                        JOIN  ( 
                                                     (SELECT DISTINCT party, session
                                                           FROM `judge`
                                                     ) UNION (SELECT DISTINCT clerk AS `party`, i AS `session`
                                                           FROM `session`
                                                     
                                                     )
                                                   ) AS f1
                                          ON `f1`.`party`='".addslashes($id)."'
                                       WHERE `party`.`i`='".addslashes($id)."'"));
          $me['received']=(DB_doquer("SELECT DISTINCT `document`.`i` AS `id`
                                        FROM `document`
                                       WHERE `document`.`from`='".addslashes($id)."'"));
          $me['sent']=(DB_doquer("SELECT DISTINCT `to`.`document` AS `id`
                                    FROM `to`
                                   WHERE `to`.`party`='".addslashes($id)."'"));
          foreach($me['panel'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `panel`
                                         , `f3`.`sector`
                                      FROM `panel`
                                      LEFT JOIN `panel` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['Sessions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`clerk`
                                         , `f3`.`scheduled`
                                         , `f4`.`city`
                                         , `f5`.`location`
                                         , `f6`.`panel`
                                      FROM `session`
                                      LEFT JOIN `session` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                     WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                               FROM `session`
                                               JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                              WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v1 = $v0['panel'];
            $v0['panel']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1)."' AS `id`
                                                  , `f2`.`court`
                                                  , `f3`.`sector`
                                               FROM `panel`
                                               LEFT JOIN `panel` AS f2 ON `f2`.`i`='".addslashes($v1)."'
                                               LEFT JOIN `panel` AS f3 ON `f3`.`i`='".addslashes($v1)."'
                                              WHERE `panel`.`i`='".addslashes($v1)."'"));
          }
          unset($v0);
          foreach($me['received'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `message`
                                         , `f3`.`from`
                                         , `f4`.`sent`
                                         , `f5`.`sent` AS `received`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['sent'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `message`
                                         , `f3`.`from`
                                         , `f4`.`sent`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_court($me['court']);
          $this->set_panel($me['panel']);
          $this->set_role($me['role']);
          $this->set_Sessions($me['Sessions']);
          $this->set_received($me['received']);
          $this->set_sent($me['sent']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttParty` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttParty`, `i`
                                  FROM `party`
                              ) AS fst
                          WHERE fst.`AttParty` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "role" => $this->_role, "Sessions" => $this->_Sessions, "received" => $this->_received, "sent" => $this->_sent);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `session` (`i`,`clerk`,`scheduled`,`city`,`location`,`panel`) VALUES (".((null!=$v0['id'])?"'".addslashes($v0['id'])."'":"NULL").", '".addslashes($v0['clerk'])."', '".addslashes($v0['scheduled'])."', '".addslashes($v0['city'])."', '".addslashes($v0['location'])."', '".addslashes($v0['panel']['id'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `session` SET `clerk`='".addslashes($v0['clerk'])."', `scheduled`='".addslashes($v0['scheduled'])."', `city`='".addslashes($v0['city'])."', `location`='".addslashes($v0['location'])."', `panel`='".addslashes($v0['panel']['id'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
        }
      }
      foreach($me['received'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `from`='".addslashes($v0['from'])."', `sent`='".addslashes($v0['sent'])."', `sent`='".addslashes($v0['received'])."' WHERE `i`='".addslashes($v0['message'])."'", 5);
      }
      foreach  ($me['received'] as $received){
        if(isset($me['id']))
          DB_doquer("UPDATE `document` SET `from`='".addslashes($me['id'])."' WHERE `i`='".addslashes($received['id'])."'", 5);
      }
      // no code for message,i in document
      foreach($me['sent'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `from`='".addslashes($v0['from'])."', `sent`='".addslashes($v0['sent'])."' WHERE `i`='".addslashes($v0['message'])."'", 5);
      }
      // no code for message,i in document
      // no code for court,i in court
      // no code for location,i in court
      // no code for court,i in court
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['panel']['id'])."'",5);
      }
      foreach($me['panel'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `panel` SET `i`='".addslashes($v0['id'])."', `sector`='".addslashes($v0['sector'])."' WHERE `i`='".addslashes($v0['panel'])."'", 5);
      }
      // no code for panel,i in panel
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `panel` (`i`,`court`,`sector`) VALUES ('".addslashes($v0['panel']['id'])."', '".addslashes($v0['panel']['court'])."', '".addslashes($v0['panel']['sector'])."')", 5);
        if($res!==false && !isset($v0['panel']['id']))
          $v0['panel']['id']=mysql_insert_id();
      }
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
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['sent'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['clerk'])."')", 5);
      }
      foreach($me['received'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['from'])."')", 5);
      }
      foreach($me['sent'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['from'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['panel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sector'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['panel']['sector'])."'",5);
      }
      foreach($me['panel'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['sector'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($v0['panel']['sector'])."')", 5);
      }
      foreach($me['role'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['role'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent'])."'",5);
      }
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['received'])."'",5);
      }
      foreach($me['sent'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent'])."'",5);
      }
      foreach($me['received'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($v0['sent'])."')", 5);
      }
      foreach($me['received'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($v0['received'])."')", 5);
      }
      foreach($me['sent'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($v0['sent'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `members` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach  ($me['panel'] as $panel){
        $res=DB_doquer("INSERT IGNORE INTO `members` (`panel`,`party`) VALUES ('".addslashes($panel['id'])."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach  ($me['role'] as $role){
        $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($role)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `to` WHERE `party`='".addslashes($me['id'])."'",5);
      // no code for received,document in to
      // no code for message,document in to
      // no code for sent,document in to
      foreach  ($me['sent'] as $sent){
        $res=DB_doquer("INSERT IGNORE INTO `to` (`document`,`party`) VALUES ('".addslashes($sent['id'])."', '".addslashes($me['id'])."')", 5);
      }
      // no code for message,document in to
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
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "role" => $this->_role, "Sessions" => $this->_Sessions, "received" => $this->_received, "sent" => $this->_sent);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['panel']['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['clerk'])."'",5);
      }
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['sent'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['panel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['sector'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($v0['panel']['sector'])."'",5);
      }
      foreach($me['role'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent'])."'",5);
      }
      foreach($me['received'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['received'])."'",5);
      }
      foreach($me['sent'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `members` WHERE `party`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `to` WHERE `party`='".addslashes($me['id'])."'",5);
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
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
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
    function set_court($val){
      $this->_court=$val;
    }
    function get_court(){
      if(!isset($this->_court)) return array();
      return $this->_court;
    }
    function set_panel($val){
      $this->_panel=$val;
    }
    function get_panel(){
      if(!isset($this->_panel)) return array();
      return $this->_panel;
    }
    function set_role($val){
      $this->_role=$val;
    }
    function get_role(){
      if(!isset($this->_role)) return array();
      return $this->_role;
    }
    function set_Sessions($val){
      $this->_Sessions=$val;
    }
    function get_Sessions(){
      if(!isset($this->_Sessions)) return array();
      return $this->_Sessions;
    }
    function set_received($val){
      $this->_received=$val;
    }
    function get_received(){
      if(!isset($this->_received)) return array();
      return $this->_received;
    }
    function set_sent($val){
      $this->_sent=$val;
    }
    function get_sent(){
      if(!isset($this->_sent)) return array();
      return $this->_sent;
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

  function getEachMagistrate(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `party`'));
  }

  function readMagistrate($id){
      // check existence of $id
      $obj = new Magistrate($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delMagistrate($id){
    $tobeDeleted = new Magistrate($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>