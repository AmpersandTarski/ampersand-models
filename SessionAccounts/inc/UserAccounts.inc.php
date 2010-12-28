<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 77, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE UserAccounts : I[UserAccount]
   = [ Accounts : I[UserAccount]
     ]
   *********/
  
  class UserAccounts {
    protected $id=false;
    protected $_new=true;
    private $_Accounts;
    function UserAccounts($id=null, $_Accounts=null){
      $this->id=$id;
      $this->_Accounts=$_Accounts;
      if(!isset($_Accounts) && isset($id)){
        // get a UserAccounts based on its identifier
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
                                       , `UserAccount`.`I` AS `Accounts`
                                    FROM `UserAccount`
                                   WHERE `UserAccount`.`I`='".addslashes($id)."'"));
          $this->set_Accounts($me['Accounts']);
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
      $me=array("id"=>$this->getId(), "Accounts" => $this->_Accounts);
      DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      if(mysql_affected_rows()==0 && $me['id']!=null){
        //nothing inserted, try updating:
        DB_doquer("UPDATE `UserAccount` SET `I`='".addslashes($me['id'])."' WHERE `I`='".addslashes($me['Accounts'])."'", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`) VALUES ('".addslashes($me['Accounts'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "Accounts" => $this->_Accounts);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Accounts($val){
      $this->_Accounts=$val;
    }
    function get_Accounts(){
      return $this->_Accounts;
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

  function getEachUserAccounts(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `UserAccount`'));
  }

  function readUserAccounts($id){
      // check existence of $id
      $obj = new UserAccounts($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delUserAccounts($id){
    $tobeDeleted = new UserAccounts($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>