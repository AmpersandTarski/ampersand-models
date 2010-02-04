<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 549, file "VIRO.adl"
    SERVICE Ding : I[Ding]
   = [ type Objecttype : type
     , object Actie : object~
        = [ Actie : [Actie]
          , subject : subject
          , type : type
          ]
     ]
   *********/
  
  class Ding {
    protected $_id=false;
    protected $_new=true;
    private $_typeObjecttype;
    private $_objectActie;
    function Ding($id=null, $typeObjecttype=null, $objectActie=null){
      $this->_id=$id;
      $this->_typeObjecttype=$typeObjecttype;
      $this->_objectActie=$objectActie;
      if(!isset($typeObjecttype) && isset($id)){
        // get a Ding based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDing` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDing`, `i`
                                  FROM `ding`
                              ) AS fst
                          WHERE fst.`AttDing` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['type Objecttype']=firstCol(DB_doquer("SELECT DISTINCT `type`.`objecttype` AS `type Objecttype`
                                                       FROM `type`
                                                      WHERE `type`.`ding`='".addslashes($id)."'"));
          $me['object Actie']=(DB_doquer("SELECT DISTINCT `f1`.`actie` AS `id`
                                            FROM `ding`
                                            JOIN `objectactie` AS f1 ON `f1`.`Ding`='".addslashes($id)."'
                                           WHERE `ding`.`i`='".addslashes($id)."'"));
          foreach($me['object Actie'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Actie`
                                         , `f3`.`subject`
                                         , `f4`.`type`
                                      FROM `actie`
                                      LEFT JOIN `actie` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `actie` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `actie`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_typeObjecttype($me['type Objecttype']);
          $this->set_objectActie($me['object Actie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDing` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDing`, `i`
                                  FROM `ding`
                              ) AS fst
                          WHERE fst.`AttDing` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "type Objecttype" => $this->_typeObjecttype, "object Actie" => $this->_objectActie);
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `actie` (`i`,`subject`,`type`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['subject'])."', '".addslashes($v0['type'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for Actie,i in actie
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['subject'])."')", 5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['type Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['type Objecttype'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `type` WHERE `ding`='".addslashes($me['id'])."'",5);
      foreach  ($me['type Objecttype'] as $typeObjecttype){
        $res=DB_doquer("INSERT IGNORE INTO `type` (`objecttype`,`ding`) VALUES ('".addslashes($typeObjecttype)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
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
      $me=array("id"=>$this->getId(), "type Objecttype" => $this->_typeObjecttype, "object Actie" => $this->_objectActie);
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['object Actie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['type Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `type` WHERE `ding`='".addslashes($me['id'])."'",5);
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_typeObjecttype($val){
      $this->_typeObjecttype=$val;
    }
    function get_typeObjecttype(){
      if(!isset($this->_typeObjecttype)) return array();
      return $this->_typeObjecttype;
    }
    function set_objectActie($val){
      $this->_objectActie=$val;
    }
    function get_objectActie(){
      if(!isset($this->_objectActie)) return array();
      return $this->_objectActie;
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

  function getEachDing(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `ding`'));
  }

  function readDing($id){
      // check existence of $id
      $obj = new Ding($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delDing($id){
    $tobeDeleted = new Ding($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>