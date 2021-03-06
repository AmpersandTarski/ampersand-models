<?php // generated with ADL vs. 1.1-647
  
  /********* on line 89, file "apps/Meterkast/meterkast.adl"
    SERVICE Session : I[Session]
   = [ ip : ip
     , file : session~
     , gebruiker : user
     ]
   *********/
  
  class Session {
    protected $id=false;
    protected $_new=true;
    private $_ip;
    private $_file;
    private $_gebruiker;
    function Session($id=null, $_ip=null, $_file=null, $_gebruiker=null){
      $this->id=$id;
      $this->_ip=$_ip;
      $this->_file=$_file;
      $this->_gebruiker=$_gebruiker;
      if(!isset($_ip) && isset($id)){
        // get a Session based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttSession`, `Id`
                                  FROM `SessieTbl`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `SessieTbl`.`Id` AS `id`
                                       , `SessieTbl`.`ip`
                                       , `SessieTbl`.`bestand` AS `file`
                                       , `SessieTbl`.`gebruiker`
                                    FROM `SessieTbl`
                                   WHERE `SessieTbl`.`Id`='".addslashes($id)."'"));
          $this->set_ip($me['ip']);
          $this->set_file($me['file']);
          $this->set_gebruiker($me['gebruiker']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `Id`
                           FROM 
                              ( SELECT DISTINCT `Id` AS `AttSession`, `Id`
                                  FROM `SessieTbl`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file, "gebruiker" => $this->_gebruiker);
      // no code for file,Id in BestandTbl
      DB_doquer("DELETE FROM `SessieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `SessieTbl` (`ip`,`bestand`,`gebruiker`,`Id`) VALUES ('".addslashes($me['ip'])."', ".((null!=$me['file'])?"'".addslashes($me['file'])."'":"NULL").", '".addslashes($me['gebruiker'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,bestand in SessieTbl
      DB_doquer("DELETE FROM `Gebruiker` WHERE `I`='".addslashes($me['gebruiker'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Gebruiker` (`I`) VALUES ('".addslashes($me['gebruiker'])."')", 5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['ip'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($me['ip'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file, "gebruiker" => $this->_gebruiker);
      DB_doquer("DELETE FROM `SessieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      if(isset($me['file'])) DB_doquer("UPDATE `SessieTbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['file'])."'",5);
      DB_doquer("DELETE FROM `Gebruiker` WHERE `I`='".addslashes($me['gebruiker'])."'",5);
      DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($me['ip'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_ip($val){
      $this->_ip=$val;
    }
    function get_ip(){
      return $this->_ip;
    }
    function set_file($val){
      $this->_file=$val;
    }
    function get_file(){
      return $this->_file;
    }
    function set_gebruiker($val){
      $this->_gebruiker=$val;
    }
    function get_gebruiker(){
      return $this->_gebruiker;
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

  function getEachSession(){
    return firstCol(DB_doquer('SELECT DISTINCT `Id`
                                 FROM `SessieTbl`'));
  }

  function readSession($id){
      // check existence of $id
      $obj = new Session($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSession($id){
    $tobeDeleted = new Session($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>