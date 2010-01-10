<?php // generated with ADL vs. 0.8.10-529
  
  /********* on line 82, file "meterkast.adl"
    SERVICE Session : I[Session]
   = [ ip : ip
     , file : session~
     ]
   *********/
  
  class Session {
    protected $id=false;
    protected $_new=true;
    private $_ip;
    private $_file;
    function Session($id=null, $_ip=null, $_file=null){
      $this->id=$id;
      $this->_ip=$_ip;
      $this->_file=$_file;
      if(!isset($_ip) && isset($id)){
        // get a Session based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttSession`, `id`
                                  FROM `sessietbl`
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `sessietbl`.`id`
                                       , `sessietbl`.`ip`
                                       , `sessietbl`.`bestand` AS `file`
                                    FROM `sessietbl`
                                   WHERE `sessietbl`.`id`='".addslashes($id)."'"));
          $this->set_ip($me['ip']);
          $this->set_file($me['file']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttSession`, `id`
                                  FROM `sessietbl`
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
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file);
      // no code for file,id in bestandtbl
      DB_doquer("DELETE FROM `sessietbl` WHERE `id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `sessietbl` (`ip`,`bestand`,`id`) VALUES ('".addslashes($me['ip'])."', ".((null!=$me['file'])?"'".addslashes($me['file'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,bestand in sessietbl
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['ip'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['ip'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file);
      DB_doquer("DELETE FROM `sessietbl` WHERE `id`='".addslashes($me['id'])."'",5);
      if(isset($me['file'])) DB_doquer("UPDATE `sessietbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['file'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['ip'])."'",5);
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
    return firstCol(DB_doquer('SELECT DISTINCT `id`
                                 FROM `sessietbl`'));
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