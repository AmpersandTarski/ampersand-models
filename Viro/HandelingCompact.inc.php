<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 449, file "VIRO.adl"
    SERVICE HandelingCompact : I[Handeling]
   = [ object Objecttype : object
     , werkwoord : werkwoord
     , usecase : use_case~
        = [ omschrijving : omschrijving
          ]
     , rol : mag
     , grondslag : handeling~
        = [ artikel : [Artikel]
          , tekst : wetstekst
          ]
     ]
   *********/
  
  class HandelingCompact {
    protected $_id=false;
    protected $_new=true;
    private $_objectObjecttype;
    private $_werkwoord;
    private $_usecase;
    private $_rol;
    private $_grondslag;
    function HandelingCompact($id=null, $objectObjecttype=null, $werkwoord=null, $usecase=null, $rol=null, $grondslag=null){
      $this->_id=$id;
      $this->_objectObjecttype=$objectObjecttype;
      $this->_werkwoord=$werkwoord;
      $this->_usecase=$usecase;
      $this->_rol=$rol;
      $this->_grondslag=$grondslag;
      if(!isset($objectObjecttype) && isset($id)){
        // get a HandelingCompact based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHandeling`, `i`
                                  FROM `handeling`
                              ) AS fst
                          WHERE fst.`AttHandeling` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['object Objecttype']=firstCol(DB_doquer("SELECT DISTINCT `object`.`objecttype` AS `object Objecttype`
                                                         FROM `object`
                                                        WHERE `object`.`handeling`='".addslashes($id)."'"));
          $me['werkwoord']=firstCol(DB_doquer("SELECT DISTINCT `werkwoordhandeling`.`werkwoord`
                                                 FROM `werkwoordhandeling`
                                                WHERE `werkwoordhandeling`.`handeling`='".addslashes($id)."'"));
          $me['usecase']=(DB_doquer("SELECT DISTINCT `f1`.`usecase` AS `id`
                                       FROM `handeling`
                                       JOIN `use_case` AS f1 ON `f1`.`Handeling`='".addslashes($id)."'
                                      WHERE `handeling`.`i`='".addslashes($id)."'"));
          $me['rol']=firstCol(DB_doquer("SELECT DISTINCT `mag`.`rol`
                                           FROM `mag`
                                          WHERE `mag`.`handeling`='".addslashes($id)."'"));
          $me['grondslag']=(DB_doquer("SELECT DISTINCT `f1`.`artikel` AS `id`
                                         FROM `handeling`
                                         JOIN `handelingartikel` AS f1 ON `f1`.`Handeling`='".addslashes($id)."'
                                        WHERE `handeling`.`i`='".addslashes($id)."'"));
          foreach($me['usecase'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`omschrijving`
                                      FROM `usecase`
                                      LEFT JOIN `usecase` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `usecase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['grondslag'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `artikel`
                                      FROM `artikel`
                                     WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
            $v0['tekst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Tekst` AS `tekst`
                                               FROM `artikel`
                                               JOIN `wetstekst` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                              WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_objectObjecttype($me['object Objecttype']);
          $this->set_werkwoord($me['werkwoord']);
          $this->set_usecase($me['usecase']);
          $this->set_rol($me['rol']);
          $this->set_grondslag($me['grondslag']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHandeling`, `i`
                                  FROM `handeling`
                              ) AS fst
                          WHERE fst.`AttHandeling` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "object Objecttype" => $this->_objectObjecttype, "werkwoord" => $this->_werkwoord, "usecase" => $this->_usecase, "rol" => $this->_rol, "grondslag" => $this->_grondslag);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `usecase` (`i`,`omschrijving`) VALUES ('".addslashes($v0['id'])."', ".((null!=$v0['omschrijving'])?"'".addslashes($v0['omschrijving'])."'":"NULL").")", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `usecase` SET `omschrijving`=".((null!=$v0['omschrijving'])?"'".addslashes($v0['omschrijving'])."'":"NULL")." WHERE `i`='".addslashes($v0['id'])."'", 5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['omschrijving'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['omschrijving'])."')", 5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['artikel'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['grondslag'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['artikel'])."')", 5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoord` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach  ($v0['tekst'] as $tekst){
          $res=DB_doquer("INSERT IGNORE INTO `wetstekst` (`tekst`,`artikel`) VALUES ('".addslashes($tekst)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      DB_doquer("DELETE FROM `object` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['object Objecttype'] as $objectObjecttype){
        $res=DB_doquer("INSERT IGNORE INTO `object` (`objecttype`,`handeling`) VALUES ('".addslashes($objectObjecttype)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `werkwoordhandeling` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['werkwoord'] as $werkwoord){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoordhandeling` (`werkwoord`,`handeling`) VALUES ('".addslashes($werkwoord)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['rol'] as $rol){
        $res=DB_doquer("INSERT IGNORE INTO `mag` (`rol`,`handeling`) VALUES ('".addslashes($rol)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
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
      $me=array("id"=>$this->getId(), "object Objecttype" => $this->_objectObjecttype, "werkwoord" => $this->_werkwoord, "usecase" => $this->_usecase, "rol" => $this->_rol, "grondslag" => $this->_grondslag);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['omschrijving'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['artikel'])."'",5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `object` WHERE `handeling`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `werkwoordhandeling` WHERE `handeling`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($me['id'])."'",5);
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
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
    function set_objectObjecttype($val){
      $this->_objectObjecttype=$val;
    }
    function get_objectObjecttype(){
      if(!isset($this->_objectObjecttype)) return array();
      return $this->_objectObjecttype;
    }
    function set_werkwoord($val){
      $this->_werkwoord=$val;
    }
    function get_werkwoord(){
      if(!isset($this->_werkwoord)) return array();
      return $this->_werkwoord;
    }
    function set_usecase($val){
      $this->_usecase=$val;
    }
    function get_usecase(){
      if(!isset($this->_usecase)) return array();
      return $this->_usecase;
    }
    function set_rol($val){
      $this->_rol=$val;
    }
    function get_rol(){
      if(!isset($this->_rol)) return array();
      return $this->_rol;
    }
    function set_grondslag($val){
      $this->_grondslag=$val;
    }
    function get_grondslag(){
      if(!isset($this->_grondslag)) return array();
      return $this->_grondslag;
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

  function getEachHandelingCompact(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `handeling`'));
  }

  function readHandelingCompact($id){
      // check existence of $id
      $obj = new HandelingCompact($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delHandelingCompact($id){
    $tobeDeleted = new HandelingCompact($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>