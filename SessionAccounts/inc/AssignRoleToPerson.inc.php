<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 137, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE AssignRoleToPerson : I[Person]
   = [ Person (Id) : personAssignedRole
     ]
   *********/
  
  class AssignRoleToPerson {
    protected $id=false;
    protected $_new=true;
    private $_PersonId;
    function AssignRoleToPerson($id=null, $_PersonId=null){
      $this->id=$id;
      $this->_PersonId=$_PersonId;
      if(!isset($_PersonId) && isset($id)){
        // get a AssignRoleToPerson based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpPerson` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpPerson`, `I`
                             FROM `Person` ) AS fst
                          WHERE fst.`MpPerson` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Person (Id)']=firstCol(DB_doquer("SELECT DISTINCT `personAssignedRole`.`Role` AS `Person (Id)`
                                                   FROM `personAssignedRole`
                                                  WHERE `personAssignedRole`.`Person`='".addslashes($id)."'"));
          $this->set_PersonId($me['Person (Id)']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpPerson` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpPerson`, `I`
                             FROM `Person` ) AS fst
                          WHERE fst.`MpPerson` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "Person (Id)" => $this->_PersonId);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Person` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      foreach($me['Person (Id)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['Person (Id)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Role` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for AssignRoleToPerson,Person in emailOf
      // no code for AssignRoleToPerson,Person in iscalled
      DB_doquer("DELETE FROM `personAssignedRole` WHERE `Person`='".addslashes($me['id'])."'",5);
      foreach  ($me['Person (Id)'] as $PersonId){
        $res=DB_doquer("INSERT IGNORE INTO `personAssignedRole` (`Role`,`Person`) VALUES ('".addslashes($PersonId)."', '".addslashes($me['id'])."')", 5);
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
      $me=array("id"=>$this->getId(), "Person (Id)" => $this->_PersonId);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['id'])."'",5);
      foreach($me['Person (Id)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Role` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `personAssignedRole` WHERE `Person`='".addslashes($me['id'])."'",5);
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
    function set_PersonId($val){
      $this->_PersonId=$val;
    }
    function get_PersonId(){
      if(!isset($this->_PersonId)) return array();
      return $this->_PersonId;
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

  function getEachAssignRoleToPerson(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Person`'));
  }

  function readAssignRoleToPerson($id){
      // check existence of $id
      $obj = new AssignRoleToPerson($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAssignRoleToPerson($id){
    $tobeDeleted = new AssignRoleToPerson($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>