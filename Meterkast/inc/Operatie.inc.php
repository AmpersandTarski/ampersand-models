<?php // generated with ADL vs. 0.8.10-488
  
  /********* on line 88, file "meterkast.adl"
    SERVICE Operatie : I[Operation]
   = [ naam : name
     , call : call
     , outputURL : output
     ]
   *********/
  
  class Operatie {
    protected $id=false;
    protected $_new=true;
    private $_naam;
    private $_call;
    private $_outputURL;
    function Operatie($id=null, $_naam=null, $_call=null, $_outputURL=null){
      $this->id=$id;
      $this->_naam=$_naam;
      $this->_call=$_call;
      $this->_outputURL=$_outputURL;
      if(!isset($_naam) && isset($id)){
        // get a Operatie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttOperation`, `id`
                                  FROM `operationtbl`
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `operationtbl`.`id`
                                       , `operationtbl`.`name` AS `naam`
                                       , `operationtbl`.`call`
                                       , `operationtbl`.`output` AS `outputURL`
                                    FROM `operationtbl`
                                   WHERE `operationtbl`.`id`='".addslashes($id)."'"));
          $this->set_naam($me['naam']);
          $this->set_call($me['call']);
          $this->set_outputURL($me['outputURL']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOperation` AS `id`
                           FROM 
                              ( SELECT DISTINCT `id` AS `AttOperation`, `id`
                                  FROM `operationtbl`
                              ) AS fst
                          WHERE fst.`AttOperation` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call, "outputURL" => $this->_outputURL);
      DB_doquer("DELETE FROM `operationtbl` WHERE `id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `operationtbl` (`name`,`call`,`output`,`id`) VALUES ('".addslashes($me['naam'])."', '".addslashes($me['call'])."', '".addslashes($me['outputURL'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['call'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['naam'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['call'])."')", 5);
      DB_doquer("DELETE FROM `compilation` WHERE `i`='".addslashes($me['outputURL'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `compilation` (`i`) VALUES ('".addslashes($me['outputURL'])."')", 5);
      if (!checkRule1()){
        $DB_err='\"path[Bestand*Text] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"ip[Session*Text] is univalent\"';
      } else
      if (!checkRule10()){
        $DB_err='\"type[Actie*Operation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"name[Operation*Text] is injective\"';
      } else
      if (!checkRule15()){
        $DB_err='\"name[Operation*Text] is univalent\"';
      } else
      if (!checkRule16()){
        $DB_err='\"name[Operation*Text] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"call[Operation*Text] is univalent\"';
      } else
      if (!checkRule18()){
        $DB_err='\"call[Operation*Text] is total\"';
      } else
      if (!checkRule19()){
        $DB_err='\"output[Operation*Compilation] is univalent\"';
      } else
      if (!checkRule20()){
        $DB_err='\"output[Operation*Compilation] is total\"';
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
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "call" => $this->_call, "outputURL" => $this->_outputURL);
      DB_doquer("DELETE FROM `operationtbl` WHERE `id`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['naam'])."'",5);
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['call'])."'",5);
      DB_doquer("DELETE FROM `compilation` WHERE `i`='".addslashes($me['outputURL'])."'",5);
      if (!checkRule1()){
        $DB_err='\"path[Bestand*Text] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"ip[Session*Text] is univalent\"';
      } else
      if (!checkRule10()){
        $DB_err='\"type[Actie*Operation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"name[Operation*Text] is injective\"';
      } else
      if (!checkRule15()){
        $DB_err='\"name[Operation*Text] is univalent\"';
      } else
      if (!checkRule16()){
        $DB_err='\"name[Operation*Text] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"call[Operation*Text] is univalent\"';
      } else
      if (!checkRule18()){
        $DB_err='\"call[Operation*Text] is total\"';
      } else
      if (!checkRule19()){
        $DB_err='\"output[Operation*Compilation] is univalent\"';
      } else
      if (!checkRule20()){
        $DB_err='\"output[Operation*Compilation] is total\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_naam($val){
      $this->_naam=$val;
    }
    function get_naam(){
      return $this->_naam;
    }
    function set_call($val){
      $this->_call=$val;
    }
    function get_call(){
      return $this->_call;
    }
    function set_outputURL($val){
      $this->_outputURL=$val;
    }
    function get_outputURL(){
      return $this->_outputURL;
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

  function getEachOperatie(){
    return firstCol(DB_doquer('SELECT DISTINCT `id`
                                 FROM `operationtbl`'));
  }

  function readOperatie($id){
      // check existence of $id
      $obj = new Operatie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delOperatie($id){
    $tobeDeleted = new Operatie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>