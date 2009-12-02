<?php // generated with ADL vs. 0.8.10-408
  
  /********* on line 61, file "Meterkast.adl"
    SERVICE Session : I[Session]
   = [ ip : ip
     , file : session~
     ]
   *********/
  
  class Session {
    protected $_id=false;
    protected $_new=true;
    private $_ip;
    private $_file;
    function Session($id=null, $ip=null, $file=null){
      $this->_id=$id;
      $this->_ip=$ip;
      $this->_file=$file;
      if(!isset($ip) && isset($id)){
        // get a Session based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttSession`, Id
                                  FROM SessieTbl
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `SessieTbl`.`ip`
                                       , `SessieTbl`.`bestand` AS `file`
                                       , '".addslashes($id)."' AS `id`
                                    FROM `SessieTbl`
                                   WHERE `SessieTbl`.`Id`='".addslashes($id)."'"));
          $this->set_ip($me['ip']);
          $this->set_file($me['file']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSession` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttSession`, Id
                                  FROM SessieTbl
                              ) AS fst
                          WHERE fst.`AttSession` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file);
      // no code for file,Id in BestandTbl
      DB_doquer("DELETE FROM `SessieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `SessieTbl` (`ip`,`bestand`,`Id`) VALUES ('".addslashes($me['ip'])."', ".((null!=$me['file'])?"'".addslashes($me['file'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,bestand in SessieTbl
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['ip'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($me['ip'])."')", 5);
      if($res!==false && !isset($me['ip']['id']))
        $me['ip']['id']=mysql_insert_id();
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule2()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule3()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule4()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule5()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule7()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule8()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
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
      $me=array("id"=>$this->getId(), "ip" => $this->_ip, "file" => $this->_file);
      DB_doquer("DELETE FROM `SessieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($me['ip'])."'",5);
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule2()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule3()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule4()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule5()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule7()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule8()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
      } else
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
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id==null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachSession(){
    return firstCol(DB_doquer('SELECT DISTINCT Id
                                 FROM SessieTbl'));
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