<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 316, file "VIRO453ENG.adl"
    SERVICE Document : I[Document]
   = [ type : documentType
     , case : caseFile
        = [ caretaker of case file : caretaker
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     ]
   *********/
  
  class Document {
    protected $_id=false;
    protected $_new=true;
    private $_type;
    private $_case;
    function Document($id=null, $type=null, $case=null){
      $this->_id=$id;
      $this->_type=$type;
      $this->_case=$case;
      if(!isset($type) && isset($id)){
        // get a Document based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `to`.`document` AS `id`
                                       , `document`.`documenttype` AS `type`
                                    FROM `to`
                                    LEFT JOIN `document` ON `document`.`i`='".addslashes($id)."'
                                   WHERE `to`.`document`='".addslashes($id)."'"));
          $me['case']=(DB_doquer("SELECT DISTINCT `casefile`.`case` AS `id`
                                    FROM `casefile`
                                   WHERE `casefile`.`document`='".addslashes($id)."'"));
          foreach($me['case'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`caretaker` AS `caretaker of case file`
                                         , `f3`.`areaoflaw` AS `area of law`
                                         , `f4`.`casetype` AS `type of case`
                                      FROM `case`
                                      LEFT JOIN `case` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_type($me['type']);
          $this->set_case($me['case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "case" => $this->_case);
      if(isset($me['id']))
        DB_doquer("UPDATE `document` SET `documenttype`='".addslashes($me['type'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `case` (`i`,`caretaker`,`areaoflaw`,`casetype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['caretaker of case file'])."', '".addslashes($v0['area of law'])."', '".addslashes($v0['type of case'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0['caretaker of case file'])."')", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0['type of case'])."')", 5);
      }
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['case'] as $case){
        $res=DB_doquer("INSERT IGNORE INTO `casefile` (`case`,`document`) VALUES ('".addslashes($case['id'])."', '".addslashes($me['id'])."')", 5);
      }
      // no code for case,case in plaintiff
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "case" => $this->_case);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_type($val){
      $this->_type=$val;
    }
    function get_type(){
      return $this->_type;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
      if(!isset($this->_case)) return array();
      return $this->_case;
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

  function getEachDocument(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `document`'));
  }

  function readDocument($id){
      // check existence of $id
      $obj = new Document($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delDocument($id){
    $tobeDeleted = new Document($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>