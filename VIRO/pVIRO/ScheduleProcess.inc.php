<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 296, file "VIROENG.adl"
    SERVICE ScheduleProcess : I[Process]
   = [ session : session
     , case : legalCase
     ]
   *********/
  
  class ScheduleProcess {
    protected $_id=false;
    protected $_new=true;
    private $_session;
    private $_case;
    function ScheduleProcess($id=null, $session=null, $case=null){
      $this->_id=$id;
      $this->_session=$session;
      $this->_case=$case;
      if(!isset($session) && isset($id)){
        // get a ScheduleProcess based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcess` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcess`, `i`
                                  FROM `process`
                              ) AS fst
                          WHERE fst.`AttProcess` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `process`.`i` AS `id`
                                       , `process`.`session`
                                       , `process`.`legalcase` AS `case`
                                    FROM `process`
                                   WHERE `process`.`i`='".addslashes($id)."'"));
          $this->set_session($me['session']);
          $this->set_case($me['case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcess` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcess`, `i`
                                  FROM `process`
                              ) AS fst
                          WHERE fst.`AttProcess` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "session" => $this->_session, "case" => $this->_case);
      // no code for session,i in session
      // no code for case,i in legalcase
      DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `process` (`session`,`legalcase`,`i`) VALUES ('".addslashes($me['session'])."', '".addslashes($me['case'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for case,legalcase in plaintiff
      // no code for session,session in judge
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
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
      $me=array("id"=>$this->getId(), "session" => $this->_session, "case" => $this->_case);
      DB_doquer("DELETE FROM `process` WHERE `i`='".addslashes($me['id'])."'",5);
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"a session can be identified by its panel, its city and its date.\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_session($val){
      $this->_session=$val;
    }
    function get_session(){
      return $this->_session;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
      return $this->_case;
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

  function getEachScheduleProcess(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `process`'));
  }

  function readScheduleProcess($id){
      // check existence of $id
      $obj = new ScheduleProcess($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delScheduleProcess($id){
    $tobeDeleted = new ScheduleProcess($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>