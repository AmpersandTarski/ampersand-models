<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 39, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE Persoon : I[Person]
   = [ Id : I[Person]
     , name : iscalled
     , email addr : emailOf~
     , telefoonnr : phoneOf~
     ]
   *********/
  
  class Persoon {
    protected $id=false;
    protected $_new=true;
    private $_Id;
    private $_name;
    private $_emailaddr;
    private $_telefoonnr;
    function Persoon($id=null, $_Id=null, $_name=null, $_emailaddr=null, $_telefoonnr=null){
      $this->id=$id;
      $this->_Id=$_Id;
      $this->_name=$_name;
      $this->_emailaddr=$_emailaddr;
      $this->_telefoonnr=$_telefoonnr;
      if(!isset($_Id) && isset($id)){
        // get a Persoon based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpPerson` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpPerson`, `I`
                             FROM `Person` ) AS fst
                          WHERE fst.`MpPerson` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Person`.`I` AS `id`
                                       , `Person`.`I` AS `Id`
                                       , `emailOf`.`Person` AS `Id`
                                    FROM `Person`
                                    LEFT JOIN `emailOf` ON `emailOf`.`Person`='".addslashes($id)."'
                                   WHERE `Person`.`I`='".addslashes($id)."'"));
          $me['name']=firstCol(DB_doquer("SELECT DISTINCT `iscalled`.`Text` AS `name`
                                            FROM `iscalled`
                                           WHERE `iscalled`.`Person`='".addslashes($id)."'"));
          $me['email addr']=firstCol(DB_doquer("SELECT DISTINCT `emailOf`.`Emailaddr` AS `email addr`
                                                  FROM `emailOf`
                                                 WHERE `emailOf`.`Person`='".addslashes($id)."'"));
          $me['telefoonnr']=firstCol(DB_doquer("SELECT DISTINCT `phoneOf`.`Phonenumber` AS `telefoonnr`
                                                  FROM `phoneOf`
                                                 WHERE `phoneOf`.`Person`='".addslashes($id)."'"));
          $this->set_Id($me['Id']);
          $this->set_name($me['name']);
          $this->set_emailaddr($me['email addr']);
          $this->set_telefoonnr($me['telefoonnr']);
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
      $me=array("id"=>$this->getId(), "Id" => $this->_Id, "name" => $this->_name, "email addr" => $this->_emailaddr, "telefoonnr" => $this->_telefoonnr);
      foreach($me['telefoonnr'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Phonenumber` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['telefoonnr'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Phonenumber` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['email addr'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Emailaddr` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['email addr'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Emailaddr` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['name'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text1` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['name'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Text1` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['Id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Person` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      $res=DB_doquer("INSERT IGNORE INTO `Person` (`I`) VALUES ('".addslashes($me['Id'])."')", 5);
      DB_doquer("DELETE FROM `emailOf` WHERE `Person`='".addslashes($me['id'])."'",5);
      foreach  ($me['email addr'] as $emailaddr){
        $res=DB_doquer("INSERT IGNORE INTO `emailOf` (`Person`,`Emailaddr`) VALUES ('".addslashes($me['id'])."', '".addslashes($emailaddr)."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      // no code for Id,Person in emailOf
      DB_doquer("DELETE FROM `phoneOf` WHERE `Person`='".addslashes($me['id'])."'",5);
      foreach  ($me['telefoonnr'] as $telefoonnr){
        $res=DB_doquer("INSERT IGNORE INTO `phoneOf` (`Phonenumber`,`Person`) VALUES ('".addslashes($telefoonnr)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `iscalled` WHERE `Person`='".addslashes($me['id'])."'",5);
      foreach  ($me['name'] as $name){
        $res=DB_doquer("INSERT IGNORE INTO `iscalled` (`Person`,`Text`) VALUES ('".addslashes($me['id'])."', '".addslashes($name)."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      // no code for Id,Person in iscalled
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
      } else
      if (!checkRule5()){
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
      $me=array("id"=>$this->getId(), "Id" => $this->_Id, "name" => $this->_name, "email addr" => $this->_emailaddr, "telefoonnr" => $this->_telefoonnr);
      foreach($me['telefoonnr'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Phonenumber` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['email addr'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Emailaddr` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['name'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text1` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['Id'])."'",5);
      DB_doquer("DELETE FROM `emailOf` WHERE `Person`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `phoneOf` WHERE `Person`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `iscalled` WHERE `Person`='".addslashes($me['id'])."'",5);
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
      } else
      if (!checkRule5()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Id($val){
      $this->_Id=$val;
    }
    function get_Id(){
      return $this->_Id;
    }
    function set_name($val){
      $this->_name=$val;
    }
    function get_name(){
      if(!isset($this->_name)) return array();
      return $this->_name;
    }
    function set_emailaddr($val){
      $this->_emailaddr=$val;
    }
    function get_emailaddr(){
      if(!isset($this->_emailaddr)) return array();
      return $this->_emailaddr;
    }
    function set_telefoonnr($val){
      $this->_telefoonnr=$val;
    }
    function get_telefoonnr(){
      if(!isset($this->_telefoonnr)) return array();
      return $this->_telefoonnr;
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

  function getEachPersoon(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Person`'));
  }

  function readPersoon($id){
      // check existence of $id
      $obj = new Persoon($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPersoon($id){
    $tobeDeleted = new Persoon($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>