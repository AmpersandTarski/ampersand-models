<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 528, file "VIRO.adl"
    SERVICE Werkwoord : I[Werkwoord]
   = [ artikel : werkwoord~
        = [ Artikel : [Artikel]
          , tekst : wetstekst
          ]
     , handeling : werkwoord~
     ]
   *********/
  
  class Werkwoord {
    protected $_id=false;
    protected $_new=true;
    private $_artikel;
    private $_handeling;
    function Werkwoord($id=null, $artikel=null, $handeling=null){
      $this->_id=$id;
      $this->_artikel=$artikel;
      $this->_handeling=$handeling;
      if(!isset($artikel) && isset($id)){
        // get a Werkwoord based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttWerkwoord` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttWerkwoord`, `i`
                                  FROM `werkwoord`
                              ) AS fst
                          WHERE fst.`AttWerkwoord` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['artikel']=(DB_doquer("SELECT DISTINCT `f1`.`artikel` AS `id`
                                       FROM `werkwoord`
                                       JOIN `werkwoordartikel` AS f1 ON `f1`.`Werkwoord`='".addslashes($id)."'
                                      WHERE `werkwoord`.`i`='".addslashes($id)."'"));
          $me['handeling']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`handeling`
                                                 FROM `werkwoord`
                                                 JOIN `werkwoordhandeling` AS f1 ON `f1`.`Werkwoord`='".addslashes($id)."'
                                                WHERE `werkwoord`.`i`='".addslashes($id)."'"));
          foreach($me['artikel'] as $i0=>&$v0){
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
          $this->set_artikel($me['artikel']);
          $this->set_handeling($me['handeling']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttWerkwoord` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttWerkwoord`, `i`
                                  FROM `werkwoord`
                              ) AS fst
                          WHERE fst.`AttWerkwoord` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "artikel" => $this->_artikel, "handeling" => $this->_handeling);
      foreach($me['artikel'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['artikel'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['Artikel'])."'",5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['artikel'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['Artikel'])."')", 5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        foreach  ($v0['tekst'] as $tekst){
          $res=DB_doquer("INSERT IGNORE INTO `wetstekst` (`tekst`,`artikel`) VALUES ('".addslashes($tekst)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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
      $me=array("id"=>$this->getId(), "artikel" => $this->_artikel, "handeling" => $this->_handeling);
      foreach($me['artikel'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['Artikel'])."'",5);
      }
      foreach($me['handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['artikel'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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
    function set_artikel($val){
      $this->_artikel=$val;
    }
    function get_artikel(){
      if(!isset($this->_artikel)) return array();
      return $this->_artikel;
    }
    function set_handeling($val){
      $this->_handeling=$val;
    }
    function get_handeling(){
      if(!isset($this->_handeling)) return array();
      return $this->_handeling;
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

  function getEachWerkwoord(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `werkwoord`'));
  }

  function readWerkwoord($id){
      // check existence of $id
      $obj = new Werkwoord($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delWerkwoord($id){
    $tobeDeleted = new Werkwoord($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>