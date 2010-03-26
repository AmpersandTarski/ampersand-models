<?php // generated with ADL vs. 1.1-647
  
  /********* on line 108, file "apps/Meterkast/meterkast.adl"
    SERVICE Actie : I[Actie]
   = [ file : object
     , operatie : type
     , compiled : done
     , error : error
     ]
   *********/
  
  class Actie {
    protected $id=false;
    protected $_new=true;
    private $_file;
    private $_operatie;
    private $_compiled;
    private $_error;
    function Actie($id=null, $_file=null, $_operatie=null, $_compiled=null, $_error=null){
      $this->id=$id;
      $this->_file=$_file;
      $this->_operatie=$_operatie;
      $this->_compiled=$_compiled;
      $this->_error=$_error;
      if(!isset($_file) && isset($id)){
        // get a Actie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttActie`, `Id`
                                  FROM `ActieTbl`
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `ActieTbl`.`Id` AS `id`
                                       , `ActieTbl`.`object` AS `file`
                                       , `ActieTbl`.`type` AS `operatie`
                                       , `ActieTbl`.`done` AS `compiled`
                                       , `ActieTbl`.`error`
                                    FROM `ActieTbl`
                                   WHERE `ActieTbl`.`Id`='".addslashes($id)."'"));
          $this->set_file($me['file']);
          $this->set_operatie($me['operatie']);
          $this->set_compiled($me['compiled']);
          $this->set_error($me['error']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttActie`, `Id`
                                  FROM `ActieTbl`
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie, "compiled" => $this->_compiled, "error" => $this->_error);
      // no code for operatie,Id in OperationTbl
      DB_doquer("DELETE FROM `ActieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `ActieTbl` (`object`,`type`,`done`,`error`,`Id`) VALUES ('".addslashes($me['file'])."', '".addslashes($me['operatie'])."', '".addslashes($me['compiled'])."', ".((null!=$me['error'])?"'".addslashes($me['error'])."'":"NULL").", ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,Id in BestandTbl
      // no code for file,bestand in SessieTbl
      DB_doquer("DELETE FROM `Flag` WHERE `I`='".addslashes($me['compiled'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Flag` (`I`) VALUES ('".addslashes($me['compiled'])."')", 5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['error'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($me['error'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie, "compiled" => $this->_compiled, "error" => $this->_error);
      DB_doquer("DELETE FROM `ActieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      if(isset($me['file'])) DB_doquer("UPDATE `SessieTbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['file'])."'",5);
      DB_doquer("DELETE FROM `Flag` WHERE `I`='".addslashes($me['compiled'])."'",5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['error'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_file($val){
      $this->_file=$val;
    }
    function get_file(){
      return $this->_file;
    }
    function set_operatie($val){
      $this->_operatie=$val;
    }
    function get_operatie(){
      return $this->_operatie;
    }
    function set_compiled($val){
      $this->_compiled=$val;
    }
    function get_compiled(){
      return $this->_compiled;
    }
    function set_error($val){
      $this->_error=$val;
    }
    function get_error(){
      return $this->_error;
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

  function getEachActie(){
    return firstCol(DB_doquer('SELECT DISTINCT `Id`
                                 FROM `ActieTbl`'));
  }

  function readActie($id){
      // check existence of $id
      $obj = new Actie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delActie($id){
    $tobeDeleted = new Actie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>