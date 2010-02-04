<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 534, file "VIRO.adl"
    SERVICE Actie : I[Actie]
   = [ actor : subject
     , object : object
        = [ object : [Ding]
          , type : type
          ]
     , uitgevoerd namens (Orgaan) : als
     , type Handeling : type
     ]
   *********/
  
  class Actie {
    protected $_id=false;
    protected $_new=true;
    private $_actor;
    private $_object;
    private $_uitgevoerdnamensOrgaan;
    private $_typeHandeling;
    function Actie($id=null, $actor=null, $object=null, $uitgevoerdnamensOrgaan=null, $typeHandeling=null){
      $this->_id=$id;
      $this->_actor=$actor;
      $this->_object=$object;
      $this->_uitgevoerdnamensOrgaan=$uitgevoerdnamensOrgaan;
      $this->_typeHandeling=$typeHandeling;
      if(!isset($actor) && isset($id)){
        // get a Actie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttActie`, `i`
                                  FROM `actie`
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `actie`.`i` AS `id`
                                       , `actie`.`subject` AS `actor`
                                       , `actie`.`type` AS `type Handeling`
                                    FROM `actie`
                                   WHERE `actie`.`i`='".addslashes($id)."'"));
          $me['object']=(DB_doquer("SELECT DISTINCT `objectactie`.`ding` AS `id`
                                      FROM `objectactie`
                                     WHERE `objectactie`.`actie`='".addslashes($id)."'"));
          $me['uitgevoerd namens (Orgaan)']=firstCol(DB_doquer("SELECT DISTINCT `als`.`orgaan` AS `uitgevoerd namens (Orgaan)`
                                                                  FROM `als`
                                                                 WHERE `als`.`actie`='".addslashes($id)."'"));
          foreach($me['object'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `object`
                                      FROM `ding`
                                     WHERE `ding`.`i`='".addslashes($v0['id'])."'"));
            $v0['type']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Objecttype` AS `type`
                                              FROM `ding`
                                              JOIN `type` AS f1 ON `f1`.`ding`='".addslashes($v0['id'])."'
                                             WHERE `ding`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_actor($me['actor']);
          $this->set_object($me['object']);
          $this->set_uitgevoerdnamensOrgaan($me['uitgevoerd namens (Orgaan)']);
          $this->set_typeHandeling($me['type Handeling']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttActie`, `i`
                                  FROM `actie`
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "actor" => $this->_actor, "object" => $this->_object, "uitgevoerd namens (Orgaan)" => $this->_uitgevoerdnamensOrgaan, "type Handeling" => $this->_typeHandeling);
      DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `actie` (`subject`,`type`,`i`) VALUES ('".addslashes($me['actor'])."', '".addslashes($me['type Handeling'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['uitgevoerd namens (Orgaan)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['uitgevoerd namens (Orgaan)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['actor'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['actor'])."')", 5);
      DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($me['type Handeling'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($me['type Handeling'])."')", 5);
      foreach($me['object'] as $i0=>$v0){
        foreach($v0['type'] as $i1=>$v1){
          DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object'] as $i0=>$v0){
        foreach($v0['type'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0['object'])."'",5);
      }
      foreach($me['object'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `ding` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['object'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `ding` (`i`) VALUES ('".addslashes($v0['object'])."')", 5);
      }
      DB_doquer("DELETE FROM `objectactie` WHERE `actie`='".addslashes($me['id'])."'",5);
      foreach  ($me['object'] as $object){
        $res=DB_doquer("INSERT IGNORE INTO `objectactie` (`ding`,`actie`) VALUES ('".addslashes($object['id'])."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `als` WHERE `actie`='".addslashes($me['id'])."'",5);
      foreach  ($me['uitgevoerd namens (Orgaan)'] as $uitgevoerdnamensOrgaan){
        $res=DB_doquer("INSERT IGNORE INTO `als` (`orgaan`,`actie`) VALUES ('".addslashes($uitgevoerdnamensOrgaan)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `type` WHERE `ding`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object'] as $i0=>$v0){
        foreach  ($v0['type'] as $type){
          $res=DB_doquer("INSERT IGNORE INTO `type` (`objecttype`,`ding`) VALUES ('".addslashes($type)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
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
      $me=array("id"=>$this->getId(), "actor" => $this->_actor, "object" => $this->_object, "uitgevoerd namens (Orgaan)" => $this->_uitgevoerdnamensOrgaan, "type Handeling" => $this->_typeHandeling);
      DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['uitgevoerd namens (Orgaan)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['actor'])."'",5);
      DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($me['type Handeling'])."'",5);
      foreach($me['object'] as $i0=>$v0){
        foreach($v0['type'] as $i1=>$v1){
          DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0['object'])."'",5);
      }
      DB_doquer("DELETE FROM `objectactie` WHERE `actie`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `als` WHERE `actie`='".addslashes($me['id'])."'",5);
      foreach($me['object'] as $i0=>$v0){
        DB_doquer("DELETE FROM `type` WHERE `ding`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
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
    function set_actor($val){
      $this->_actor=$val;
    }
    function get_actor(){
      return $this->_actor;
    }
    function set_object($val){
      $this->_object=$val;
    }
    function get_object(){
      if(!isset($this->_object)) return array();
      return $this->_object;
    }
    function set_uitgevoerdnamensOrgaan($val){
      $this->_uitgevoerdnamensOrgaan=$val;
    }
    function get_uitgevoerdnamensOrgaan(){
      if(!isset($this->_uitgevoerdnamensOrgaan)) return array();
      return $this->_uitgevoerdnamensOrgaan;
    }
    function set_typeHandeling($val){
      $this->_typeHandeling=$val;
    }
    function get_typeHandeling(){
      return $this->_typeHandeling;
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

  function getEachActie(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `actie`'));
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