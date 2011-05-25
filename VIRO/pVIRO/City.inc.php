<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 255, file "VIROENG.adl"
    SERVICE City : I[City]
   = [ court office : seatedIn~
     , jurisdiction : jurisdiction
     , court of appeal : jurisdiction;district
     , sessions : seatedIn~;location~
        = [ Session : [Session]
          , judge : judge
          , scheduled : scheduled
          , panel : panel
          ]
     ]
   *********/
  
  class City {
    protected $_id=false;
    protected $_new=true;
    private $_courtoffice;
    private $_jurisdiction;
    private $_courtofappeal;
    private $_sessions;
    function City($id=null, $courtoffice=null, $jurisdiction=null, $courtofappeal=null, $sessions=null){
      $this->_id=$id;
      $this->_courtoffice=$courtoffice;
      $this->_jurisdiction=$jurisdiction;
      $this->_courtofappeal=$courtofappeal;
      $this->_sessions=$sessions;
      if(!isset($courtoffice) && isset($id)){
        // get a City based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCity` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCity`, `i`
                                  FROM `city`
                              ) AS fst
                          WHERE fst.`AttCity` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `city`.`i` AS `id`
                                       , `city`.`jurisdiction`
                                       , `f1`.`district` AS `court of appeal`
                                    FROM `city`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`district`
                                                   FROM `city` AS F0, `court` AS F1
                                                  WHERE F0.`jurisdiction`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `city`.`i`='".addslashes($id)."'"));
          $me['court office']=firstCol(DB_doquer("SELECT DISTINCT `court`.`i` AS `court office`
                                                    FROM `court`
                                                   WHERE `court`.`seatedin`='".addslashes($id)."'"));
          $me['sessions']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                        FROM `city`
                                        JOIN  ( SELECT DISTINCT F0.`seatedin`, F1.`i`
                                                       FROM `court` AS F0, `session` AS F1
                                                      WHERE F0.`i`=F1.`location`
                                                   ) AS f1
                                          ON `f1`.`seatedin`='".addslashes($id)."'
                                       WHERE `city`.`i`='".addslashes($id)."'"));
          foreach($me['sessions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Session`
                                         , `f3`.`scheduled`
                                         , `f4`.`panel`
                                      FROM `session`
                                      LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                               FROM `session`
                                               JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                              WHERE `session`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_courtoffice($me['court office']);
          $this->set_jurisdiction($me['jurisdiction']);
          $this->set_courtofappeal($me['court of appeal']);
          $this->set_sessions($me['sessions']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCity` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCity`, `i`
                                  FROM `city`
                              ) AS fst
                          WHERE fst.`AttCity` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "court office" => $this->_courtoffice, "jurisdiction" => $this->_jurisdiction, "court of appeal" => $this->_courtofappeal, "sessions" => $this->_sessions);
      foreach($me['sessions'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `session` SET `i`='".addslashes($v0['id'])."', `scheduled`='".addslashes($v0['scheduled'])."', `panel`='".addslashes($v0['panel'])."' WHERE `i`='".addslashes($v0['Session'])."'", 5);
      }
      // no code for Session,i in session
      DB_doquer("INSERT IGNORE INTO `city` (`jurisdiction`,`i`) VALUES ('".addslashes($me['jurisdiction'])."', '".addslashes($me['id'])."')", 5);
      if(mysql_affected_rows()==0 && $me['id']!=null){
        //nothing inserted, try updating:
        DB_doquer("UPDATE `city` SET `jurisdiction`='".addslashes($me['jurisdiction'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      }
      // no code for court office,i in court
      foreach  ($me['court office'] as $courtoffice){
        if(isset($me['id']))
          DB_doquer("UPDATE `court` SET `seatedin`='".addslashes($me['id'])."' WHERE `i`='".addslashes($courtoffice)."'", 5);
      }
      // no code for jurisdiction,i in court
      // no code for judge,i in party
      // no code for panel,i in panel
      // no code for court of appeal,i in courtofappeal
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      // no code for Session,session in judge
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
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
      $me=array("id"=>$this->getId(), "court office" => $this->_courtoffice, "jurisdiction" => $this->_jurisdiction, "court of appeal" => $this->_courtofappeal, "sessions" => $this->_sessions);
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
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
    function set_courtoffice($val){
      $this->_courtoffice=$val;
    }
    function get_courtoffice(){
      if(!isset($this->_courtoffice)) return array();
      return $this->_courtoffice;
    }
    function set_jurisdiction($val){
      $this->_jurisdiction=$val;
    }
    function get_jurisdiction(){
      return $this->_jurisdiction;
    }
    function set_courtofappeal($val){
      $this->_courtofappeal=$val;
    }
    function get_courtofappeal(){
      return $this->_courtofappeal;
    }
    function set_sessions($val){
      $this->_sessions=$val;
    }
    function get_sessions(){
      if(!isset($this->_sessions)) return array();
      return $this->_sessions;
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

  function getEachCity(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `city`'));
  }

  function readCity($id){
      // check existence of $id
      $obj = new City($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCity($id){
    $tobeDeleted = new City($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>