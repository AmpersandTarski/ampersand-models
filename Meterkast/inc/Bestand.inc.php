<?php // generated with ADL vs. 0.8.10-593
  
  /********* on line 101, file "apps/meterkast/meterkast.adl"
    SERVICE Bestand : I[Bestand]
   = [ path : path
     , filesession : session
     , compilations : object~
        = [ id : [Actie]
          , operatie : type
          ]
     ]
   *********/
  
  class Bestand {
    protected $id=false;
    protected $_new=true;
    private $_path;
    private $_filesession;
    private $_compilations;
    function Bestand($id=null, $_path=null, $_filesession=null, $_compilations=null){
      $this->id=$id;
      $this->_path=$_path;
      $this->_filesession=$_filesession;
      $this->_compilations=$_compilations;
      if(!isset($_path) && isset($id)){
        // get a Bestand based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBestand` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttBestand`, `id`
                                  FROM `bestandtbl`
                              ) AS fst
                          WHERE fst.`AttBestand` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `sessietbl`.`id` AS `filesession`
                                       , `bestandtbl`.`id`
                                       , `bestandtbl`.`path`
                                    FROM `bestandtbl`
                                    LEFT JOIN `sessietbl` ON `sessietbl`.`bestand`='".addslashes($id)."'
                                   WHERE `bestandtbl`.`id`='".addslashes($id)."'"));
          $me['compilations']=(DB_doquer("SELECT DISTINCT `actietbl`.`id`
                                            FROM `actietbl`
                                           WHERE `actietbl`.`object`='".addslashes($id)."'"));
          foreach($me['compilations'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `id`
                                         , `f3`.`type` AS `operatie`
                                      FROM `actietbl`
                                      LEFT JOIN `actietbl` AS f3 ON `f3`.`id`='".addslashes($v0['id'])."'
                                     WHERE `actietbl`.`id`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_path($me['path']);
          $this->set_filesession($me['filesession']);
          $this->set_compilations($me['compilations']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBestand` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttBestand`, `id`
                                  FROM `bestandtbl`
                              ) AS fst
                          WHERE fst.`AttBestand` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "path" => $this->_path, "filesession" => $this->_filesession, "compilations" => $this->_compilations);
      // no code for operatie,id in operationtbl
      foreach($me['compilations'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `actietbl` SET `id`='".addslashes($v0['id'])."', `type`='".addslashes($v0['operatie'])."' WHERE `id`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['compilations'] as $compilations){
        if(isset($me['id']))
          DB_doquer("UPDATE `actietbl` SET `object`='".addslashes($me['id'])."' WHERE `id`='".addslashes($compilations['id'])."'", 5);
      }
      // no code for id,id in actietbl
      DB_doquer("DELETE FROM `bestandtbl` WHERE `id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `bestandtbl` (`path`,`id`) VALUES ('".addslashes($me['path'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for filesession,id in sessietbl
      if(isset($me['id'])) DB_doquer("UPDATE `sessietbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['id'])."'",5);
      if(isset($me['id']))
        DB_doquer("UPDATE `sessietbl` SET `bestand`='".addslashes($me['id'])."' WHERE `id`='".addslashes($me['filesession'])."'", 5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['path'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['path'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "path" => $this->_path, "filesession" => $this->_filesession, "compilations" => $this->_compilations);
      DB_doquer("DELETE FROM `bestandtbl` WHERE `id`='".addslashes($me['id'])."'",5);
      if(isset($me['id'])) DB_doquer("UPDATE `sessietbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['path'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_path($val){
      $this->_path=$val;
    }
    function get_path(){
      return $this->_path;
    }
    function set_filesession($val){
      $this->_filesession=$val;
    }
    function get_filesession(){
      return $this->_filesession;
    }
    function set_compilations($val){
      $this->_compilations=$val;
    }
    function get_compilations(){
      if(!isset($this->_compilations)) return array();
      return $this->_compilations;
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

  function getEachBestand(){
    return firstCol(DB_doquer('SELECT DISTINCT `id`
                                 FROM `bestandtbl`'));
  }

  function readBestand($id){
      // check existence of $id
      $obj = new Bestand($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delBestand($id){
    $tobeDeleted = new Bestand($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>