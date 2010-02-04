<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 515, file "VIRO.adl"
    SERVICE Objecttype : I[Objecttype]
   = [ object Handeling : object~
        = [ Handeling : [Handeling]
          , door : handeling~;orgaan
          , prio : use_case~;prio
          , usecase : use_case~
          , rol : mag
          ]
     , wet : objecttype~
        = [ Artikel : [Artikel]
          , tekst : wetstekst
          ]
     , type Ding : type~
     ]
   *********/
  
  class Objecttype {
    protected $_id=false;
    protected $_new=true;
    private $_objectHandeling;
    private $_wet;
    private $_typeDing;
    function Objecttype($id=null, $objectHandeling=null, $wet=null, $typeDing=null){
      $this->_id=$id;
      $this->_objectHandeling=$objectHandeling;
      $this->_wet=$wet;
      $this->_typeDing=$typeDing;
      if(!isset($objectHandeling) && isset($id)){
        // get a Objecttype based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttObjecttype` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttObjecttype`, `i`
                                  FROM `objecttype`
                              ) AS fst
                          WHERE fst.`AttObjecttype` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['object Handeling']=(DB_doquer("SELECT DISTINCT `f1`.`handeling` AS `id`
                                                FROM `objecttype`
                                                JOIN `object` AS f1 ON `f1`.`Objecttype`='".addslashes($id)."'
                                               WHERE `objecttype`.`i`='".addslashes($id)."'"));
          $me['wet']=(DB_doquer("SELECT DISTINCT `f1`.`artikel` AS `id`
                                   FROM `objecttype`
                                   JOIN `objecttypeartikel` AS f1 ON `f1`.`Objecttype`='".addslashes($id)."'
                                  WHERE `objecttype`.`i`='".addslashes($id)."'"));
          $me['type Ding']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`ding` AS `type Ding`
                                                 FROM `objecttype`
                                                 JOIN `type` AS f1 ON `f1`.`Objecttype`='".addslashes($id)."'
                                                WHERE `objecttype`.`i`='".addslashes($id)."'"));
          foreach($me['object Handeling'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Handeling`
                                      FROM `handeling`
                                     WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
            $v0['door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Orgaan` AS `door`
                                              FROM `handeling`
                                              JOIN  ( SELECT DISTINCT F0.`Handeling`, F1.`Orgaan`
                                                             FROM `handelingartikel` AS F0, `orgaanartikel` AS F1
                                                            WHERE F0.`artikel`=F1.`artikel`
                                                         ) AS f1
                                                ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                             WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
            $v0['prio']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`prio`
                                              FROM `handeling`
                                              JOIN  ( SELECT DISTINCT F0.`Handeling`, F1.`prio`
                                                             FROM `use_case` AS F0, `usecase` AS F1
                                                            WHERE F0.`usecase`=F1.`i`
                                                         ) AS f1
                                                ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                             WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
            $v0['usecase']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`usecase`
                                                 FROM `handeling`
                                                 JOIN `use_case` AS f1 ON `f1`.`Handeling`='".addslashes($v0['id'])."'
                                                WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
            $v0['rol']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Rol` AS `rol`
                                             FROM `handeling`
                                             JOIN `mag` AS f1 ON `f1`.`handeling`='".addslashes($v0['id'])."'
                                            WHERE `handeling`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['wet'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Artikel`
                                      FROM `artikel`
                                     WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
            $v0['tekst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Tekst` AS `tekst`
                                               FROM `artikel`
                                               JOIN `wetstekst` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                              WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_objectHandeling($me['object Handeling']);
          $this->set_wet($me['wet']);
          $this->set_typeDing($me['type Ding']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttObjecttype` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttObjecttype`, `i`
                                  FROM `objecttype`
                              ) AS fst
                          WHERE fst.`AttObjecttype` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "object Handeling" => $this->_objectHandeling, "wet" => $this->_wet, "type Ding" => $this->_typeDing);
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['Artikel'])."'",5);
      }
      foreach($me['wet'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['wet'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['Artikel'])."')", 5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['Handeling'])."')", 5);
      }
      foreach($me['type Ding'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['type Ding'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `ding` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['wet'] as $i0=>$v0){
        foreach  ($v0['tekst'] as $tekst){
          $res=DB_doquer("INSERT IGNORE INTO `wetstekst` (`tekst`,`artikel`) VALUES ('".addslashes($tekst)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `mag` (`rol`,`handeling`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
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
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
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
      $me=array("id"=>$this->getId(), "object Handeling" => $this->_objectHandeling, "wet" => $this->_wet, "type Ding" => $this->_typeDing);
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['Artikel'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['type Ding'] as $i0=>$v0){
        DB_doquer("DELETE FROM `ding` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['wet'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['object Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
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
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_objectHandeling($val){
      $this->_objectHandeling=$val;
    }
    function get_objectHandeling(){
      if(!isset($this->_objectHandeling)) return array();
      return $this->_objectHandeling;
    }
    function set_wet($val){
      $this->_wet=$val;
    }
    function get_wet(){
      if(!isset($this->_wet)) return array();
      return $this->_wet;
    }
    function set_typeDing($val){
      $this->_typeDing=$val;
    }
    function get_typeDing(){
      if(!isset($this->_typeDing)) return array();
      return $this->_typeDing;
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

  function getEachObjecttype(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `objecttype`'));
  }

  function readObjecttype($id){
      // check existence of $id
      $obj = new Objecttype($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delObjecttype($id){
    $tobeDeleted = new Objecttype($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>