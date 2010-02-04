<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 578, file "VIRO.adl"
    SERVICE Fase : I[Fase]
   = [ fase Handeling : fase~;use_case
        = [ Handeling : [Handeling]
          , door : handeling~;orgaan
          , prio : use_case~;prio
          , usecase : use_case~
          , rol : mag
          ]
     ]
   *********/
  
  class Fase {
    protected $_id=false;
    protected $_new=true;
    private $_faseHandeling;
    function Fase($id=null, $faseHandeling=null){
      $this->_id=$id;
      $this->_faseHandeling=$faseHandeling;
      if(!isset($faseHandeling) && isset($id)){
        // get a Fase based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttFase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttFase`, `i`
                                  FROM `fase`
                              ) AS fst
                          WHERE fst.`AttFase` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['fase Handeling']=(DB_doquer("SELECT DISTINCT `f1`.`Handeling` AS `id`
                                              FROM `fase`
                                              JOIN  ( SELECT DISTINCT F0.`Fase`, F1.`Handeling`
                                                             FROM `faseusecase` AS F0, `use_case` AS F1
                                                            WHERE F0.`usecase`=F1.`usecase`
                                                         ) AS f1
                                                ON `f1`.`Fase`='".addslashes($id)."'
                                             WHERE `fase`.`i`='".addslashes($id)."'"));
          foreach($me['fase Handeling'] as $i0=>&$v0){
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
          $this->set_faseHandeling($me['fase Handeling']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttFase` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttFase`, `i`
                                  FROM `fase`
                              ) AS fst
                          WHERE fst.`AttFase` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "fase Handeling" => $this->_faseHandeling);
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['Handeling'])."')", 5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
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
      $me=array("id"=>$this->getId(), "fase Handeling" => $this->_faseHandeling);
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['Handeling'])."'",5);
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['fase Handeling'] as $i0=>$v0){
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
    function set_faseHandeling($val){
      $this->_faseHandeling=$val;
    }
    function get_faseHandeling(){
      if(!isset($this->_faseHandeling)) return array();
      return $this->_faseHandeling;
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

  function getEachFase(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `fase`'));
  }

  function readFase($id){
      // check existence of $id
      $obj = new Fase($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delFase($id){
    $tobeDeleted = new Fase($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>