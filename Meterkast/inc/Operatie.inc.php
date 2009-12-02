<?php // generated with ADL vs. 0.8.10-408
  
  /********* on line 78, file "Meterkast.adl"
    SERVICE Operatie : I[Operation]
   = [ naam : name
     , call : call
     ]
   *********/
  
  class Operatie {
    protected $_id=false;
    protected $_new=true;
    private $_naam;
    private $_call;
    function Operatie($id=null, $naam=null, $call=null){
      $this->_id=$id;
      $this->_naam=$naam;
      $this->_call=$call;
      if(!isset($naam) && isset($id)){
        // get a Operatie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttOperation`, Id
                                  FROM OperationTbl
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `OperationTbl`.`name` AS `naam`
                                       , `OperationTbl`.`call`
                                       , '".addslashes($id)."' AS `id`
                                    FROM `OperationTbl`
                                   WHERE `OperationTbl`.`Id`='".addslashes($id)."'"));
          $this->set_naam($me['naam']);
          $this->set_call($me['call']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttOperation`, Id
                                  FROM OperationTbl
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call);
      DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `OperationTbl` (`name`,`call`,`Id`) VALUES ('".addslashes($me['naam'])."', '".addslashes($me['call'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['call'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($me['naam'])."')", 5);
      if($res!==false && !isset($me['naam']['id']))
        $me['naam']['id']=mysql_insert_id();
      $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($me['call'])."')", 5);
      if($res!==false && !isset($me['call']['id']))
        $me['call']['id']=mysql_insert_id();
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule10()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule12()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule14()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule16()){
        $DB_err=$preErr.'\"\"';
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
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call);
      DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['call'])."'",5);
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule10()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule12()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule14()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule16()){
        $DB_err=$preErr.'\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_naam($val){
      $this->_naam=$val;
    }
    function get_naam(){
      return $this->_naam;
    }
    function set_call($val){
      $this->_call=$val;
    }
    function get_call(){
      return $this->_call;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id==null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachOperatie(){
    return firstCol(DB_doquer('SELECT DISTINCT Id
                                 FROM OperationTbl'));
  }

  function readOperatie($id){
      // check existence of $id
      $obj = new Operatie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delOperatie($id){
    $tobeDeleted = new Operatie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>