<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 485, file "VIRO.adl"
    SERVICE Documenttype : I[Documenttype]
   = [ type Document : type~
        = [ Document : [Document]
          , type : type
          ]
     ]
   *********/
  
  class Documenttype {
    protected $_id=false;
    protected $_new=true;
    private $_typeDocument;
    function Documenttype($id=null, $typeDocument=null){
      $this->_id=$id;
      $this->_typeDocument=$typeDocument;
      if(!isset($typeDocument) && isset($id)){
        // get a Documenttype based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocumenttype` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocumenttype`, `i`
                                  FROM `documenttype`
                              ) AS fst
                          WHERE fst.`AttDocumenttype` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['type Document']=(DB_doquer("SELECT DISTINCT `document`.`i` AS `id`
                                             FROM `document`
                                            WHERE `document`.`type`='".addslashes($id)."'"));
          foreach($me['type Document'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Document`
                                         , `f3`.`type`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_typeDocument($me['type Document']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocumenttype` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocumenttype`, `i`
                                  FROM `documenttype`
                              ) AS fst
                          WHERE fst.`AttDocumenttype` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "type Document" => $this->_typeDocument);
      foreach($me['type Document'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `type`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      foreach  ($me['type Document'] as $typeDocument){
        if(isset($me['id']))
          DB_doquer("UPDATE `document` SET `type`='".addslashes($me['id'])."' WHERE `i`='".addslashes($typeDocument['id'])."'", 5);
      }
      // no code for Document,i in document
      foreach($me['type Document'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['type Document'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      // no code for type Document,document in aan
      // no code for Document,document in aan
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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
      $me=array("id"=>$this->getId(), "type Document" => $this->_typeDocument);
      foreach($me['type Document'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_typeDocument($val){
      $this->_typeDocument=$val;
    }
    function get_typeDocument(){
      if(!isset($this->_typeDocument)) return array();
      return $this->_typeDocument;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id===null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachDocumenttype(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `documenttype`'));
  }

  function readDocumenttype($id){
      // check existence of $id
      $obj = new Documenttype($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delDocumenttype($id){
    $tobeDeleted = new Documenttype($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>