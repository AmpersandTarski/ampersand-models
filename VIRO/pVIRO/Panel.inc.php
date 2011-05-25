<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 309, file "VIROENG.adl"
    SERVICE Panel : I[Panel]
   = [ court : court
     , members : members~
     , sessions : panel~
     ]
   *********/
  
  class Panel {
    protected $_id=false;
    protected $_new=true;
    private $_court;
    private $_members;
    private $_sessions;
    function Panel($id=null, $court=null, $members=null, $sessions=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_members=$members;
      $this->_sessions=$sessions;
      if(!isset($court) && isset($id)){
        // get a Panel based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPanel` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPanel`, `i`
                                  FROM `panel`
                              ) AS fst
                          WHERE fst.`AttPanel` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `panel`.`i` AS `id`
                                       , `panel`.`court`
                                    FROM `panel`
                                   WHERE `panel`.`i`='".addslashes($id)."'"));
          $me['members']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `members`
                                               FROM `panel`
                                               JOIN `members` AS f1 ON `f1`.`Panel`='".addslashes($id)."'
                                              WHERE `panel`.`i`='".addslashes($id)."'"));
          $me['sessions']=firstCol(DB_doquer("SELECT DISTINCT `session`.`i` AS `sessions`
                                                FROM `session`
                                               WHERE `session`.`panel`='".addslashes($id)."'"));
          $this->set_court($me['court']);
          $this->set_members($me['members']);
          $this->set_sessions($me['sessions']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPanel` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPanel`, `i`
                                  FROM `panel`
                              ) AS fst
                          WHERE fst.`AttPanel` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "members" => $this->_members, "sessions" => $this->_sessions);
      // no code for sessions,i in session
      foreach  ($me['sessions'] as $sessions){
        if(isset($me['id']))
          DB_doquer("UPDATE `session` SET `panel`='".addslashes($me['id'])."' WHERE `i`='".addslashes($sessions)."'", 5);
      }
      // no code for court,i in court
      // no code for members,i in party
      DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `panel` (`court`,`i`) VALUES ('".addslashes($me['court'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for sessions,session in judge
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
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
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
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "court" => $this->_court, "members" => $this->_members, "sessions" => $this->_sessions);
      DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($me['id'])."'",5);
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
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
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
    function set_members($val){
      $this->_members=$val;
    }
    function get_members(){
      if(!isset($this->_members)) return array();
      return $this->_members;
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

  function getEachPanel(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `panel`'));
  }

  function readPanel($id){
      // check existence of $id
      $obj = new Panel($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPanel($id){
    $tobeDeleted = new Panel($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>