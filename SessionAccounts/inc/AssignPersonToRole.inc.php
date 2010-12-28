<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 142, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE AssignPersonToRole : I[Role]
   = [ Role/Function : personAssignedRole~
     ]
   *********/
  
  class AssignPersonToRole {
    protected $id=false;
    protected $_new=true;
    private $_RoleFunction;
    function AssignPersonToRole($id=null, $_RoleFunction=null){
      $this->id=$id;
      $this->_RoleFunction=$_RoleFunction;
      if(!isset($_RoleFunction) && isset($id)){
        // get a AssignPersonToRole based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpRole` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpRole`, `I`
                             FROM `Role` ) AS fst
                          WHERE fst.`MpRole` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Role/Function']=firstCol(DB_doquer("SELECT DISTINCT `personAssignedRole`.`Person` AS `Role/Function`
                                                     FROM `personAssignedRole`
                                                    WHERE `personAssignedRole`.`Role`='".addslashes($id)."'"));
          $this->set_RoleFunction($me['Role/Function']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpRole` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpRole`, `I`
                             FROM `Role` ) AS fst
                          WHERE fst.`MpRole` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "Role/Function" => $this->_RoleFunction);
      foreach($me['Role/Function'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['Role/Function'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Person` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Role` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      // no code for Role/Function,Person in emailOf
      // no code for Role/Function,Person in iscalled
      DB_doquer("DELETE FROM `personAssignedRole` WHERE `Role`='".addslashes($me['id'])."'",5);
      foreach  ($me['Role/Function'] as $RoleFunction){
        $res=DB_doquer("INSERT IGNORE INTO `personAssignedRole` (`Person`,`Role`) VALUES ('".addslashes($RoleFunction)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
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
      $me=array("id"=>$this->getId(), "Role/Function" => $this->_RoleFunction);
      foreach($me['Role/Function'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `personAssignedRole` WHERE `Role`='".addslashes($me['id'])."'",5);
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_RoleFunction($val){
      $this->_RoleFunction=$val;
    }
    function get_RoleFunction(){
      if(!isset($this->_RoleFunction)) return array();
      return $this->_RoleFunction;
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

  function getEachAssignPersonToRole(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Role`'));
  }

  function readAssignPersonToRole($id){
      // check existence of $id
      $obj = new AssignPersonToRole($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAssignPersonToRole($id){
    $tobeDeleted = new AssignPersonToRole($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>