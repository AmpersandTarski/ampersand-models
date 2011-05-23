<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 528, file "VIRO453ENG.adl"
    SERVICE Session : I[Session]
   = [ court : location
     , panel : panel
     , city : city
     , judge : judge
     , clerk : clerk
     , scheduled : scheduled
     , date of occurence : occured
     , cases : session~;case
        = [ nr : [Case]
          , plaintiff : plaintiff~
          , defendant : defendant~
          ]
     ]
   *********/
  
  class Session {
    protected $_id=false;
    protected $_new=true;
    private $_court;
    private $_panel;
    private $_city;
    private $_judge;
    private $_clerk;
    private $_scheduled;
    private $_dateofoccurence;
    private $_cases;
    function Session($id=null, $court=null, $panel=null, $city=null, $judge=null, $clerk=null, $scheduled=null, $dateofoccurence=null, $cases=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_panel=$panel;
      $this->_city=$city;
      $this->_judge=$judge;
      $this->_clerk=$clerk;
      $this->_scheduled=$scheduled;
      $this->_dateofoccurence=$dateofoccurence;
      $this->_cases=$cases;
      if(!isset($court) && isset($id)){
        // get a Session based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSession`, `i`
                                  FROM `session`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `judge`.`session` AS `id`
                                       , `session`.`location` AS `court`
                                       , `session`.`panel`
                                       , `session`.`city`
                                       , `session`.`clerk`
                                       , `session`.`scheduled`
                                       , `session`.`occured` AS `date of occurence`
                                    FROM `judge`
                                    LEFT JOIN `session` ON `session`.`i`='".addslashes($id)."'
                                   WHERE `judge`.`session`='".addslashes($id)."'"));
          $me['judge']=firstCol(DB_doquer("SELECT DISTINCT `judge`.`party` AS `judge`
                                             FROM `judge`
                                            WHERE `judge`.`session`='".addslashes($id)."'"));
          $me['cases']=(DB_doquer("SELECT DISTINCT `process`.`case` AS `id`
                                     FROM `process`
                                    WHERE `process`.`session`='".addslashes($id)."'"));
          foreach($me['cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                      FROM `case`
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
            $v0['plaintiff']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `plaintiff`
                                                   FROM `case`
                                                   JOIN `plaintiff` AS f1 ON `f1`.`case`='".addslashes($v0['id'])."'
                                                  WHERE `case`.`i`='".addslashes($v0['id'])."'"));
            $v0['defendant']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `defendant`
                                                   FROM `case`
                                                   JOIN `defendant` AS f1 ON `f1`.`Case`='".addslashes($v0['id'])."'
                                                  WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_court($me['court']);
          $this->set_panel($me['panel']);
          $this->set_city($me['city']);
          $this->set_judge($me['judge']);
          $this->set_clerk($me['clerk']);
          $this->set_scheduled($me['scheduled']);
          $this->set_dateofoccurence($me['date of occurence']);
          $this->set_cases($me['cases']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSession`, `i`
                                  FROM `session`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "city" => $this->_city, "judge" => $this->_judge, "clerk" => $this->_clerk, "scheduled" => $this->_scheduled, "date of occurence" => $this->_dateofoccurence, "cases" => $this->_cases);
      DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `session` (`location`,`panel`,`city`,`clerk`,`scheduled`,`occured`,`i`) VALUES ('".addslashes($me['court'])."', '".addslashes($me['panel'])."', '".addslashes($me['city'])."', '".addslashes($me['clerk'])."', '".addslashes($me['scheduled'])."', ".((null!=$me['date of occurence'])?"'".addslashes($me['date of occurence'])."'":"NULL").", ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['cases'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `case` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in case
      // no code for Session,session in process
      // no code for court,i in court
      // no code for panel,i in panel
      $res=DB_doquer("INSERT IGNORE INTO `city` (`i`) VALUES ('".addslashes($me['city'])."')", 5);
      foreach($me['judge'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['clerk'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['judge'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($me['clerk'])."')", 5);
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['date of occurence'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['scheduled'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($me['date of occurence'])."')", 5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach  ($v0['plaintiff'] as $plaintiff){
          $res=DB_doquer("INSERT IGNORE INTO `plaintiff` (`case`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($plaintiff)."')", 5);
        }
      }
      // no code for nr,case in plaintiff
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['id'])."'",5);
      foreach  ($me['judge'] as $judge){
        $res=DB_doquer("INSERT IGNORE INTO `judge` (`party`,`session`) VALUES ('".addslashes($judge)."', '".addslashes($me['id'])."')", 5);
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
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
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
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "city" => $this->_city, "judge" => $this->_judge, "clerk" => $this->_clerk, "scheduled" => $this->_scheduled, "date of occurence" => $this->_dateofoccurence, "cases" => $this->_cases);
      DB_doquer("DELETE FROM `session` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['judge'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['clerk'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['plaintiff'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['defendant'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['scheduled'])."'",5);
      DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($me['date of occurence'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `plaintiff` WHERE `case`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($me['id'])."'",5);
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
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
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
    function set_court($val){
      $this->_court=$val;
    }
    function get_court(){
      return $this->_court;
    }
    function set_panel($val){
      $this->_panel=$val;
    }
    function get_panel(){
      return $this->_panel;
    }
    function set_city($val){
      $this->_city=$val;
    }
    function get_city(){
      return $this->_city;
    }
    function set_judge($val){
      $this->_judge=$val;
    }
    function get_judge(){
      if(!isset($this->_judge)) return array();
      return $this->_judge;
    }
    function set_clerk($val){
      $this->_clerk=$val;
    }
    function get_clerk(){
      return $this->_clerk;
    }
    function set_scheduled($val){
      $this->_scheduled=$val;
    }
    function get_scheduled(){
      return $this->_scheduled;
    }
    function set_dateofoccurence($val){
      $this->_dateofoccurence=$val;
    }
    function get_dateofoccurence(){
      return $this->_dateofoccurence;
    }
    function set_cases($val){
      $this->_cases=$val;
    }
    function get_cases(){
      if(!isset($this->_cases)) return array();
      return $this->_cases;
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

  function getEachSession(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `session`'));
  }

  function readSession($id){
      // check existence of $id
      $obj = new Session($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSession($id){
    $tobeDeleted = new Session($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>