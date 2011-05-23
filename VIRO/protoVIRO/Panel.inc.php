<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 612, file "VIRO453ENG.adl"
    SERVICE Panel : I[Panel]
   = [ court : court
     , sector : sector
     , members : members~
     , sessions : panel~
     ]
   *********/
  
  class Panel {
    protected $_id=false;
    protected $_new=true;
    private $_court;
    private $_sector;
    private $_members;
    private $_sessions;
    function Panel($id=null, $court=null, $sector=null, $members=null, $sessions=null){
      $this->_id=$id;
      $this->_court=$court;
      $this->_sector=$sector;
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
                                       , `panel`.`sector`
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
          $this->set_sector($me['sector']);
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "sector" => $this->_sector, "members" => $this->_members, "sessions" => $this->_sessions);
      // no code for sessions,i in session
      foreach  ($me['sessions'] as $sessions){
        if(isset($me['id']))
          DB_doquer("UPDATE `session` SET `panel`='".addslashes($me['id'])."' WHERE `i`='".addslashes($sessions)."'", 5);
      }
      // no code for court,i in court
      DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `panel` (`court`,`sector`,`i`) VALUES ('".addslashes($me['court'])."', '".addslashes($me['sector'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['members'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['members'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($me['sector'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($me['sector'])."')", 5);
      // no code for sessions,session in judge
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
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
      if (!checkRule27()){
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
      $me=array("id"=>$this->getId(), "court" => $this->_court, "sector" => $this->_sector, "members" => $this->_members, "sessions" => $this->_sessions);
      DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['members'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($me['sector'])."'",5);
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
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
      if (!checkRule27()){
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
    function set_sector($val){
      $this->_sector=$val;
    }
    function get_sector(){
      return $this->_sector;
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