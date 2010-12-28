<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 72, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE User : I[UserAccount]
   = [ Accountverantwoordelijke (persoon) : userPerson
     , Wachtwoord : userPassword
     ]
   *********/
  
  class User {
    protected $id=false;
    protected $_new=true;
    private $_Accountverantwoordelijkepersoon;
    private $_Wachtwoord;
    function User($id=null, $_Accountverantwoordelijkepersoon=null, $_Wachtwoord=null){
      $this->id=$id;
      $this->_Accountverantwoordelijkepersoon=$_Accountverantwoordelijkepersoon;
      $this->_Wachtwoord=$_Wachtwoord;
      if(!isset($_Accountverantwoordelijkepersoon) && isset($id)){
        // get a User based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpUserAccount` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpUserAccount`, `I`
                             FROM `UserAccount` ) AS fst
                          WHERE fst.`MpUserAccount` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `UserAccount`.`I` AS `id`
                                       , `UserAccount`.`userPerson` AS `Accountverantwoordelijke (persoon)`
                                       , `UserAccount`.`userPassword` AS `Wachtwoord`
                                    FROM `UserAccount`
                                   WHERE `UserAccount`.`I`='".addslashes($id)."'"));
          $this->set_Accountverantwoordelijkepersoon($me['Accountverantwoordelijke (persoon)']);
          $this->set_Wachtwoord($me['Wachtwoord']);
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
      $me=array("id"=>$this->getId(), "Accountverantwoordelijke (persoon)" => $this->_Accountverantwoordelijkepersoon, "Wachtwoord" => $this->_Wachtwoord);
      DB_doquer("DELETE FROM `UserAccount` WHERE `I`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`,`userPerson`,`userPassword`) VALUES ('".addslashes($me['id'])."', '".addslashes($me['Accountverantwoordelijke (persoon)'])."', '".addslashes($me['Wachtwoord'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `Password` WHERE `I`='".addslashes($me['Wachtwoord'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Password` (`I`) VALUES ('".addslashes($me['Wachtwoord'])."')", 5);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['Accountverantwoordelijke (persoon)'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Person` (`I`) VALUES ('".addslashes($me['Accountverantwoordelijke (persoon)'])."')", 5);
      // no code for Accountverantwoordelijke (persoon),Person in emailOf
      // no code for Accountverantwoordelijke (persoon),Person in iscalled
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld\\ndat bij de username hoort.\\n\"';
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
      $me=array("id"=>$this->getId(), "Accountverantwoordelijke (persoon)" => $this->_Accountverantwoordelijkepersoon, "Wachtwoord" => $this->_Wachtwoord);
      DB_doquer("DELETE FROM `UserAccount` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `Password` WHERE `I`='".addslashes($me['Wachtwoord'])."'",5);
      DB_doquer("DELETE FROM `Person` WHERE `I`='".addslashes($me['Accountverantwoordelijke (persoon)'])."'",5);
      if (!checkRule0()){
        $DB_err='\"Any person without a name has the property of being \'anonymous\'.\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Within Personen zijn uniek gekarakteriseerd door hun email adres\\n\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld\\ndat bij de username hoort.\\n\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Accountverantwoordelijkepersoon($val){
      $this->_Accountverantwoordelijkepersoon=$val;
    }
    function get_Accountverantwoordelijkepersoon(){
      return $this->_Accountverantwoordelijkepersoon;
    }
    function set_Wachtwoord($val){
      $this->_Wachtwoord=$val;
    }
    function get_Wachtwoord(){
      return $this->_Wachtwoord;
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

  function getEachUser(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `UserAccount`'));
  }

  function readUser($id){
      // check existence of $id
      $obj = new User($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delUser($id){
    $tobeDeleted = new User($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>