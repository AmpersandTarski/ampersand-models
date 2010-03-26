<?php // generated with ADL vs. 1.1-647
  
  /********* on line 115, file "apps/Meterkast/meterkast.adl"
    SERVICE Operatie : I[Operation]
   = [ naam : name
     , call : call
     , outputURL : output
     ]
   *********/
  
  class Operatie {
    protected $id=false;
    protected $_new=true;
    private $_naam;
    private $_call;
    private $_outputURL;
    function Operatie($id=null, $_naam=null, $_call=null, $_outputURL=null){
      $this->id=$id;
      $this->_naam=$_naam;
      $this->_call=$_call;
      $this->_outputURL=$_outputURL;
      if(!isset($_naam) && isset($id)){
        // get a Operatie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttOperation`, `Id`
                                  FROM `OperationTbl`
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `OperationTbl`.`Id` AS `id`
                                       , `OperationTbl`.`name` AS `naam`
                                       , `OperationTbl`.`call`
                                       , `OperationTbl`.`output` AS `outputURL`
                                    FROM `OperationTbl`
                                   WHERE `OperationTbl`.`Id`='".addslashes($id)."'"));
          $this->set_naam($me['naam']);
          $this->set_call($me['call']);
          $this->set_outputURL($me['outputURL']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttOperation`, `Id`
                                  FROM `OperationTbl`
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call, "outputURL" => $this->_outputURL);
      DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `OperationTbl` (`name`,`call`,`output`,`Id`) VALUES ('".addslashes($me['naam'])."', '".addslashes($me['call'])."', '".addslashes($me['outputURL'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['call'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($me['naam'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($me['call'])."')", 5);
      DB_doquer("DELETE FROM `Compilation` WHERE `I`='".addslashes($me['outputURL'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Compilation` (`I`) VALUES ('".addslashes($me['outputURL'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call, "outputURL" => $this->_outputURL);
      DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['call'])."'",5);
      DB_doquer("DELETE FROM `Compilation` WHERE `I`='".addslashes($me['outputURL'])."'",5);
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
    function set_outputURL($val){
      $this->_outputURL=$val;
    }
    function get_outputURL(){
      return $this->_outputURL;
    }
    function setId($id){
      $this->id=$id;
      return $this->id;
    }
    function getId(){
      if($this->id===null) return false;
      return $this->id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachOperatie(){
    return firstCol(DB_doquer('SELECT DISTINCT `Id`
                                 FROM `OperationTbl`'));
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