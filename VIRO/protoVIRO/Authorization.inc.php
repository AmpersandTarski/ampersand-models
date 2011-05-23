<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 948, file "VIRO453ENG.adl"
    SERVICE Authorization : I[Authorization]
   = [ authorization : [Authorization]
     , for : for
     , by : by
     , representative : authorizedRepresentative~
     , legal authorization : authorization~
        = [ Document : [Document]
          , type : documentType
          ]
     ]
   *********/
  
  class Authorization {
    protected $_id=false;
    protected $_new=true;
    private $_authorization;
    private $_for;
    private $_by;
    private $_representative;
    private $_legalauthorization;
    function Authorization($id=null, $authorization=null, $for=null, $by=null, $representative=null, $legalauthorization=null){
      $this->_id=$id;
      $this->_authorization=$authorization;
      $this->_for=$for;
      $this->_by=$by;
      $this->_representative=$representative;
      $this->_legalauthorization=$legalauthorization;
      if(!isset($authorization) && isset($id)){
        // get a Authorization based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttAuthorization` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttAuthorization`, `i`
                                  FROM `authorization`
                              ) AS fst
                          WHERE fst.`AttAuthorization` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `authorizedrepresentative`.`authorization` AS `id`
                                       , `authorizedrepresentative`.`authorization`
                                       , `authorization`.`i` AS `authorization`
                                       , `authorization`.`by`
                                    FROM `authorizedrepresentative`
                                    LEFT JOIN `authorization` ON `authorization`.`i`='".addslashes($id)."'
                                   WHERE `authorizedrepresentative`.`authorization`='".addslashes($id)."'"));
          $me['for']=firstCol(DB_doquer("SELECT DISTINCT `for`.`case` AS `for`
                                           FROM `for`
                                          WHERE `for`.`authorization`='".addslashes($id)."'"));
          $me['representative']=firstCol(DB_doquer("SELECT DISTINCT `authorizedrepresentative`.`party` AS `representative`
                                                      FROM `authorizedrepresentative`
                                                     WHERE `authorizedrepresentative`.`authorization`='".addslashes($id)."'"));
          $me['legal authorization']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                                   FROM `authorization`
                                                   JOIN `authorizationdocument` AS f1 ON `f1`.`Authorization`='".addslashes($id)."'
                                                  WHERE `authorization`.`i`='".addslashes($id)."'"));
          foreach($me['legal authorization'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Document`
                                         , `f3`.`documenttype` AS `type`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_authorization($me['authorization']);
          $this->set_for($me['for']);
          $this->set_by($me['by']);
          $this->set_representative($me['representative']);
          $this->set_legalauthorization($me['legal authorization']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttAuthorization` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttAuthorization`, `i`
                                  FROM `authorization`
                              ) AS fst
                          WHERE fst.`AttAuthorization` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "authorization" => $this->_authorization, "for" => $this->_for, "by" => $this->_by, "representative" => $this->_representative, "legal authorization" => $this->_legalauthorization);
      foreach($me['legal authorization'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      // no code for for,i in case
      DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($me['id'])."'",5);
      // no code for authorization,i in authorization
      $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($me['authorization'])."', '".addslashes($me['by'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['legal authorization'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['legal authorization'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['by'])."'",5);
      foreach($me['representative'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($me['by'])."')", 5);
      foreach($me['representative'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for for,case in plaintiff
      DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($me['id'])."'",5);
      // no code for authorization,authorization in authorizedrepresentative
      foreach  ($me['representative'] as $representative){
        $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($me['authorization'])."', '".addslashes($representative)."')", 5);
      }
      DB_doquer("DELETE FROM `for` WHERE `authorization`='".addslashes($me['id'])."'",5);
      foreach  ($me['for'] as $for){
        $res=DB_doquer("INSERT IGNORE INTO `for` (`case`,`authorization`) VALUES ('".addslashes($for)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for legal authorization,document in to
      // no code for Document,document in to
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
      $me=array("id"=>$this->getId(), "authorization" => $this->_authorization, "for" => $this->_for, "by" => $this->_by, "representative" => $this->_representative, "legal authorization" => $this->_legalauthorization);
      DB_doquer("DELETE FROM `authorization` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['legal authorization'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['by'])."'",5);
      foreach($me['representative'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `for` WHERE `authorization`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
      } else
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
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
    function set_authorization($val){
      $this->_authorization=$val;
    }
    function get_authorization(){
      return $this->_authorization;
    }
    function set_for($val){
      $this->_for=$val;
    }
    function get_for(){
      if(!isset($this->_for)) return array();
      return $this->_for;
    }
    function set_by($val){
      $this->_by=$val;
    }
    function get_by(){
      return $this->_by;
    }
    function set_representative($val){
      $this->_representative=$val;
    }
    function get_representative(){
      if(!isset($this->_representative)) return array();
      return $this->_representative;
    }
    function set_legalauthorization($val){
      $this->_legalauthorization=$val;
    }
    function get_legalauthorization(){
      if(!isset($this->_legalauthorization)) return array();
      return $this->_legalauthorization;
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

  function getEachAuthorization(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `authorization`'));
  }

  function readAuthorization($id){
      // check existence of $id
      $obj = new Authorization($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAuthorization($id){
    $tobeDeleted = new Authorization($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>