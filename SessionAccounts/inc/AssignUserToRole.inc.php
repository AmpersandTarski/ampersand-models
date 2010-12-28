<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 132, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE AssignUserToRole : I[Role]
   = [ Role/Permissionset : userAssignedRole~
     ]
   *********/
  
  class AssignUserToRole {
    protected $id=false;
    protected $_new=true;
    private $_RolePermissionset;
    function AssignUserToRole($id=null, $_RolePermissionset=null){
      $this->id=$id;
      $this->_RolePermissionset=$_RolePermissionset;
      if(!isset($_RolePermissionset) && isset($id)){
        // get a AssignUserToRole based on its identifier
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
          $me['Role/Permissionset']=firstCol(DB_doquer("SELECT DISTINCT `userAssignedRole`.`UserAccount` AS `Role/Permissionset`
                                                          FROM `userAssignedRole`
                                                         WHERE `userAssignedRole`.`Role`='".addslashes($id)."'"));
          $this->set_RolePermissionset($me['Role/Permissionset']);
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
      $me=array("id"=>$this->getId(), "Role/Permissionset" => $this->_RolePermissionset);
      foreach($me['Role/Permissionset'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Role` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      DB_doquer("DELETE FROM `userAssignedRole` WHERE `Role`='".addslashes($me['id'])."'",5);
      foreach  ($me['Role/Permissionset'] as $RolePermissionset){
        $res=DB_doquer("INSERT IGNORE INTO `userAssignedRole` (`UserAccount`,`Role`) VALUES ('".addslashes($RolePermissionset)."', '".addslashes($me['id'])."')", 5);
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
      $me=array("id"=>$this->getId(), "Role/Permissionset" => $this->_RolePermissionset);
      DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `userAssignedRole` WHERE `Role`='".addslashes($me['id'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_RolePermissionset($val){
      $this->_RolePermissionset=$val;
    }
    function get_RolePermissionset(){
      if(!isset($this->_RolePermissionset)) return array();
      return $this->_RolePermissionset;
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

  function getEachAssignUserToRole(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Role`'));
  }

  function readAssignUserToRole($id){
      // check existence of $id
      $obj = new AssignUserToRole($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAssignUserToRole($id){
    $tobeDeleted = new AssignUserToRole($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>