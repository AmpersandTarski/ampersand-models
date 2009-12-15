<?php // generated with ADL vs. 0.8.10-485
  
  /********* on line 71, file "meterkast.adl"
    SERVICE Actie : I[Actie]
   = [ file : object
     , operatie : type
     ]
   *********/
  
  class Actie {
    protected $id=false;
    protected $_new=true;
    private $_file;
    private $_operatie;
    function Actie($id=null, $_file=null, $_operatie=null){
      $this->id=$id;
      $this->_file=$_file;
      $this->_operatie=$_operatie;
      if(!isset($_file) && isset($id)){
        // get a Actie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttActie`, `id`
                                  FROM `actietbl`
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `actietbl`.`id`
                                       , `actietbl`.`object` AS `file`
                                       , `actietbl`.`type` AS `operatie`
                                    FROM `actietbl`
                                   WHERE `actietbl`.`id`='".addslashes($id)."'"));
          $this->set_file($me['file']);
          $this->set_operatie($me['operatie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttActie`, `id`
                                  FROM `actietbl`
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
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie);
      // no code for operatie,id in operationtbl
      DB_doquer("DELETE FROM `actietbl` WHERE `id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `actietbl` (`object`,`type`,`id`) VALUES ('".addslashes($me['file'])."', '".addslashes($me['operatie'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,id in bestandtbl
      // no code for file,bestand in sessietbl
      if (!checkRule2()){
        $DB_err='\"path[Bestand*Text] is total\"';
      } else
      if (!checkRule3()){
        $DB_err='\"session[Bestand*Session] is injective\"';
      } else
      if (!checkRule5()){
        $DB_err='\"session[Bestand*Session] is total\"';
      } else
      if (!checkRule8()){
        $DB_err='\"object[Actie*Bestand] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"object[Actie*Bestand] is total\"';
      } else
      if (!checkRule10()){
        $DB_err='\"type[Actie*Operation] is univalent\"';
      } else
      if (!checkRule11()){
        $DB_err='\"type[Actie*Operation] is total\"';
      } else
      if (!checkRule12()){
        $DB_err='\"name[Operation*Text] is injective\"';
      } else
      if (!checkRule14()){
        $DB_err='\"name[Operation*Text] is total\"';
      } else
      if (!checkRule16()){
        $DB_err='\"call[Operation*Text] is total\"';
      } else
      if (!checkRule18()){
        $DB_err='\"outputtype[Operation*OutputType] is total\"';
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
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie);
      DB_doquer("DELETE FROM `actietbl` WHERE `id`='".addslashes($me['id'])."'",5);
      if(isset($me['file'])) DB_doquer("UPDATE `sessietbl` SET `bestand`=NULL WHERE `bestand`='".addslashes($me['file'])."'",5);
      if (!checkRule2()){
        $DB_err='\"path[Bestand*Text] is total\"';
      } else
      if (!checkRule3()){
        $DB_err='\"session[Bestand*Session] is injective\"';
      } else
      if (!checkRule5()){
        $DB_err='\"session[Bestand*Session] is total\"';
      } else
      if (!checkRule8()){
        $DB_err='\"object[Actie*Bestand] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"object[Actie*Bestand] is total\"';
      } else
      if (!checkRule10()){
        $DB_err='\"type[Actie*Operation] is univalent\"';
      } else
      if (!checkRule11()){
        $DB_err='\"type[Actie*Operation] is total\"';
      } else
      if (!checkRule12()){
        $DB_err='\"name[Operation*Text] is injective\"';
      } else
      if (!checkRule14()){
        $DB_err='\"name[Operation*Text] is total\"';
      } else
      if (!checkRule16()){
        $DB_err='\"call[Operation*Text] is total\"';
      } else
      if (!checkRule18()){
        $DB_err='\"outputtype[Operation*OutputType] is total\"';
      } else
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
    return firstCol(DB_doquer('SELECT DISTINCT `id`
                                 FROM `actietbl`'));
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