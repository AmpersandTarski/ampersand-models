<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 355, file "VIROENG.adl"
    SERVICE Magistrate : I[Party]
   = [ court : clerk~\/members;court
     , panel : members
     , role : actsas
     , Sessions : judge~\/clerk~
        = [ judge : judge
          , clerk : clerk
          , scheduled : scheduled
          , city : location;seatedIn
          , location : location
          , panel : panel
             = [ court : court
               ]
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
    function Magistrate($id=null, $court=null, $panel=null, $role=null, $Sessions=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_panel=$panel;
      $this->_role=$role;
      $this->_Sessions=$Sessions;
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
          $me=firstRow(DB_doquer("SELECT DISTINCT `party`.`i` AS `id`
                                       , `party`.`actsas` AS `role`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($id)."'"));
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
          $me['panel']=firstCol(DB_doquer("SELECT DISTINCT `members`.`panel`
                                             FROM `members`
                                            WHERE `members`.`party`='".addslashes($id)."'"));
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
          foreach($me['Sessions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`clerk`
                                         , `f3`.`scheduled`
                                         , `f4`.`seatedin` AS `city`
                                         , `f5`.`location`
                                         , `f6`.`panel`
                                      FROM `session`
                                      LEFT JOIN `session` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`seatedin`
                                                     FROM `session` AS F0, `court` AS F1
                                                    WHERE F0.`location`=F1.`i`
                                                 ) AS f4
                                        ON `f4`.`i`='".addslashes($v0['id'])."'
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
                                               FROM `panel`
                                               LEFT JOIN `panel` AS f2 ON `f2`.`i`='".addslashes($v1)."'
                                              WHERE `panel`.`i`='".addslashes($v1)."'"));
          }
          unset($v0);
          $this->set_court($me['court']);
          $this->set_panel($me['panel']);
          $this->set_role($me['role']);
          $this->set_Sessions($me['Sessions']);
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "role" => $this->_role, "Sessions" => $this->_Sessions);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `session` (`i`,`clerk`,`scheduled`,`location`,`panel`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['clerk'])."', '".addslashes($v0['scheduled'])."', '".addslashes($v0['location'])."', '".addslashes($v0['panel']['id'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `session` SET `clerk`='".addslashes($v0['clerk'])."', `scheduled`='".addslashes($v0['scheduled'])."', `location`='".addslashes($v0['location'])."', `panel`='".addslashes($v0['panel']['id'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
        }
      }
      // no code for city,i in city
      // no code for court,i in court
      // no code for location,i in court
      // no code for court,i in court
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `party` (`actsas`,`i`) VALUES ('".addslashes($me['role'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for judge,i in party
      // no code for clerk,i in party
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['panel']['id'])."'",5);
      }
      // no code for panel,i in panel
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `panel` (`i`,`court`) VALUES ('".addslashes($v0['panel']['id'])."', '".addslashes($v0['panel']['court'])."')", 5);
        if($res!==false && !isset($v0['panel']['id']))
          $v0['panel']['id']=mysql_insert_id();
      }
      DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($me['role'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($me['role'])."')", 5);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      DB_doquer("DELETE FROM `members` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach  ($me['panel'] as $panel){
        $res=DB_doquer("INSERT IGNORE INTO `members` (`panel`,`party`) VALUES ('".addslashes($panel)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
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
      if (!checkRule49()){
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
      if (!checkRule62()){
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "panel" => $this->_panel, "role" => $this->_role, "Sessions" => $this->_Sessions);
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['panel']['id'])."'",5);
      }
      DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($me['role'])."'",5);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      DB_doquer("DELETE FROM `members` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach($me['Sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
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
      if (!checkRule49()){
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
      if (!checkRule62()){
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
      return $this->_role;
    }
    function set_Sessions($val){
      $this->_Sessions=$val;
    }
    function get_Sessions(){
      if(!isset($this->_Sessions)) return array();
      return $this->_Sessions;
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