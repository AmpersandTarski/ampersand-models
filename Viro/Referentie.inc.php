<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 618, file "VIRO.adl"
    SERVICE Referentie : I[Referentie]
   = [ bron Handeling : bron~;use_case
        = [ Handeling : [Handeling]
          , door : handeling~;orgaan
          , prio : use_case~;prio
          , usecase : use_case~
          , rol : mag
          ]
     ]
   *********/
  
  class Referentie {
    protected $_id=false;
    protected $_new=true;
    private $_bronHandeling;
    function Referentie($id=null, $bronHandeling=null){
      $this->_id=$id;
      $this->_bronHandeling=$bronHandeling;
      if(!isset($bronHandeling) && isset($id)){
        // get a Referentie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttReferentie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttReferentie`, `i`
                                  FROM `referentie`
                              ) AS fst
                          WHERE fst.`AttReferentie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['bron Handeling']=(DB_doquer("SELECT DISTINCT `f1`.`Handeling` AS `id`
                                              FROM `referentie`
                                              JOIN  ( SELECT DISTINCT F0.`bron`, F1.`Handeling`
                                                             FROM `usecase` AS F0, `use_case` AS F1
                                                            WHERE F0.`i`=F1.`usecase`
                                                         ) AS f1
                                                ON `f1`.`bron`='".addslashes($id)."'
                                             WHERE `referentie`.`i`='".addslashes($id)."'"));
          foreach($me['bron Handeling'] as $i0=>&$v0){
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
          $this->set_bronHandeling($me['bron Handeling']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttReferentie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttReferentie`, `i`
                                  FROM `referentie`
                              ) AS fst
                          WHERE fst.`AttReferentie` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "bron Handeling" => $this->_bronHandeling);
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['Handeling'])."')", 5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
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
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
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
      $me=array("id"=>$this->getId(), "bron Handeling" => $this->_bronHandeling);
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['bron Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
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
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_bronHandeling($val){
      $this->_bronHandeling=$val;
    }
    function get_bronHandeling(){
      if(!isset($this->_bronHandeling)) return array();
      return $this->_bronHandeling;
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

  function getEachReferentie(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `referentie`'));
  }

  function readReferentie($id){
      // check existence of $id
      $obj = new Referentie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delReferentie($id){
    $tobeDeleted = new Referentie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>