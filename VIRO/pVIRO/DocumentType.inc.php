<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 184, file "VIROENG.adl"
    SERVICE DocumentType : I[DocumentType]
   = [ type Document : documentType~
        = [ nr : [Document]
          ]
     ]
   *********/
  
  class DocumentType {
    protected $_id=false;
    protected $_new=true;
    private $_typeDocument;
    function DocumentType($id=null, $typeDocument=null){
      $this->_id=$id;
      $this->_typeDocument=$typeDocument;
      if(!isset($typeDocument) && isset($id)){
        // get a DocumentType based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocumentType` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocumentType`, `i`
                                  FROM `documenttype`
                              ) AS fst
                          WHERE fst.`AttDocumentType` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['type Document']=(DB_doquer("SELECT DISTINCT `document`.`i` AS `id`
                                             FROM `document`
                                            WHERE `document`.`documenttype`='".addslashes($id)."'"));
          foreach($me['type Document'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                      FROM `document`
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_typeDocument($me['type Document']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocumentType` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocumentType`, `i`
                                  FROM `documenttype`
                              ) AS fst
                          WHERE fst.`AttDocumentType` = \''.addSlashes($id).'\'');
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
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['type Document'] as $typeDocument){
        DB_doquer("INSERT IGNORE INTO `document` (`i`,`documenttype`) VALUES ('".addslashes($typeDocument['id'])."', '".addslashes($me['id'])."')", 5);
        if(mysql_affected_rows()==0 && $me['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `document` SET `documenttype`='".addslashes($me['id'])."' WHERE `i`='".addslashes($typeDocument['id'])."'", 5);
        }
      }
      // no code for nr,i in document
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
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
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
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

  function getEachDocumentType(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `documenttype`'));
  }

  function readDocumentType($id){
      // check existence of $id
      $obj = new DocumentType($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delDocumentType($id){
    $tobeDeleted = new DocumentType($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>