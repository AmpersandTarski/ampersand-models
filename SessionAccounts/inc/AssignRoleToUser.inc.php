<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 127, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE AssignRoleToUser : I[UserAccount]
   = [ Username : userAssignedRole
     ]
   *********/
  
  class AssignRoleToUser {
    protected $id=false;
    protected $_new=true;
    private $_Username;
    function AssignRoleToUser($id=null, $_Username=null){
      $this->id=$id;
      $this->_Username=$_Username;
      if(!isset($_Username) && isset($id)){
        // get a AssignRoleToUser based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpUserAccount` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpUserAccount`, `I`
                             FROM `UserAccount` ) AS fst
                          WHERE fst.`MpUserAccount` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Username']=firstCol(DB_doquer("SELECT DISTINCT `userAssignedRole`.`Role` AS `Username`
                                                FROM `userAssignedRole`
                                               WHERE `userAssignedRole`.`UserAccount`='".addslashes($id)."'"));
          $this->set_Username($me['Username']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpUserAccount` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpUserAccount`, `I`
                             FROM `UserAccount` ) AS fst
                          WHERE fst.`MpUserAccount` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "Username" => $this->_Username);
      $res=DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      foreach($me['Username'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['Username'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Role` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `userAssignedRole` WHERE `UserAccount`='".addslashes($me['id'])."'",5);
      foreach  ($me['Username'] as $Username){
        $res=DB_doquer("INSERT IGNORE INTO `userAssignedRole` (`Role`,`UserAccount`) VALUES ('".addslashes($Username)."', '".addslashes($me['id'])."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "Username" => $this->_Username);
      foreach($me['Username'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `userAssignedRole` WHERE `UserAccount`='".addslashes($me['id'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Username($val){
      $this->_Username=$val;
    }
    function get_Username(){
      if(!isset($this->_Username)) return array();
      return $this->_Username;
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

  function getEachAssignRoleToUser(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `UserAccount`'));
  }

  function readAssignRoleToUser($id){
      // check existence of $id
      $obj = new AssignRoleToUser($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAssignRoleToUser($id){
    $tobeDeleted = new AssignRoleToUser($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>