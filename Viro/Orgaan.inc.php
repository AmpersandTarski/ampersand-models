<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 496, file "VIRO.adl"
    SERVICE Orgaan : I[Orgaan]
   = [ Handelingen door dit orgaan : orgaan~;handeling
        = [ handeling : [Handeling]
          , prio : use_case~;prio
          , usecase : use_case~
          , rol : mag
          ]
     , Acties : als~
        = [ actie : [Actie]
          , subject : subject
          , type : type
          ]
     , Dossiers : zorgdrager~
        = [ procedure : [Procedur]
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          ]
     ]
   *********/
  
  class Orgaan {
    protected $_id=false;
    protected $_new=true;
    private $_Handelingendoorditorgaan;
    private $_Acties;
    private $_Dossiers;
    function Orgaan($id=null, $Handelingendoorditorgaan=null, $Acties=null, $Dossiers=null){
      $this->_id=$id;
      $this->_Handelingendoorditorgaan=$Handelingendoorditorgaan;
      $this->_Acties=$Acties;
      $this->_Dossiers=$Dossiers;
      if(!isset($Handelingendoorditorgaan) && isset($id)){
        // get a Orgaan based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOrgaan` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttOrgaan`, `i`
                                  FROM `orgaan`
                              ) AS fst
                          WHERE fst.`AttOrgaan` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Handelingen door dit orgaan']=(DB_doquer("SELECT DISTINCT `f1`.`Handeling` AS `id`
                                                           FROM `orgaan`
                                                           JOIN  ( SELECT DISTINCT F0.`Orgaan`, F1.`Handeling`
                                                                          FROM `orgaanartikel` AS F0, `handelingartikel` AS F1
                                                                         WHERE F0.`artikel`=F1.`artikel`
                                                                      ) AS f1
                                                             ON `f1`.`Orgaan`='".addslashes($id)."'
                                                          WHERE `orgaan`.`i`='".addslashes($id)."'"));
          $me['Acties']=(DB_doquer("SELECT DISTINCT `f1`.`actie` AS `id`
                                      FROM `orgaan`
                                      JOIN `als` AS f1 ON `f1`.`Orgaan`='".addslashes($id)."'
                                     WHERE `orgaan`.`i`='".addslashes($id)."'"));
          $me['Dossiers']=(DB_doquer("SELECT DISTINCT `procedur`.`i` AS `id`
                                        FROM `procedur`
                                       WHERE `procedur`.`zorgdrager`='".addslashes($id)."'"));
          foreach($me['Handelingen door dit orgaan'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `handeling`
                                      FROM `handeling`
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
          foreach($me['Acties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `actie`
                                         , `f3`.`subject`
                                         , `f4`.`type`
                                      FROM `actie`
                                      LEFT JOIN `actie` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `actie` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `actie`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['Dossiers'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `procedure`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Handelingendoorditorgaan($me['Handelingen door dit orgaan']);
          $this->set_Acties($me['Acties']);
          $this->set_Dossiers($me['Dossiers']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttOrgaan` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttOrgaan`, `i`
                                  FROM `orgaan`
                              ) AS fst
                          WHERE fst.`AttOrgaan` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "Handelingen door dit orgaan" => $this->_Handelingendoorditorgaan, "Acties" => $this->_Acties, "Dossiers" => $this->_Dossiers);
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['usecase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['id'])."', `rechtsgebied`='".addslashes($v0['rechtsgebied'])."', `proceduresoort`='".addslashes($v0['proceduresoort'])."' WHERE `i`='".addslashes($v0['procedure'])."'", 5);
      }
      foreach  ($me['Dossiers'] as $Dossiers){
        if(isset($me['id']))
          DB_doquer("UPDATE `procedur` SET `zorgdrager`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Dossiers['id'])."'", 5);
      }
      // no code for procedure,i in procedur
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `actie` (`i`,`subject`,`type`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['subject'])."', '".addslashes($v0['type'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for actie,i in actie
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['subject'])."')", 5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['handeling'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['handeling'])."')", 5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for Dossiers,procedur in eiser
      // no code for procedure,procedur in eiser
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach  ($v0['rol'] as $rol){
          $res=DB_doquer("INSERT IGNORE INTO `mag` (`rol`,`handeling`) VALUES ('".addslashes($rol)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
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
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
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
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
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
      $me=array("id"=>$this->getId(), "Handelingen door dit orgaan" => $this->_Handelingendoorditorgaan, "Acties" => $this->_Acties, "Dossiers" => $this->_Dossiers);
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['subject'])."'",5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['Dossiers'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['handeling'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['rol'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        foreach($v0['prio'] as $i1=>$v1){
          DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Handelingen door dit orgaan'] as $i0=>$v0){
        DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
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
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
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
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
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
    function set_Handelingendoorditorgaan($val){
      $this->_Handelingendoorditorgaan=$val;
    }
    function get_Handelingendoorditorgaan(){
      if(!isset($this->_Handelingendoorditorgaan)) return array();
      return $this->_Handelingendoorditorgaan;
    }
    function set_Acties($val){
      $this->_Acties=$val;
    }
    function get_Acties(){
      if(!isset($this->_Acties)) return array();
      return $this->_Acties;
    }
    function set_Dossiers($val){
      $this->_Dossiers=$val;
    }
    function get_Dossiers(){
      if(!isset($this->_Dossiers)) return array();
      return $this->_Dossiers;
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

  function getEachOrgaan(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `orgaan`'));
  }

  function readOrgaan($id){
      // check existence of $id
      $obj = new Orgaan($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delOrgaan($id){
    $tobeDeleted = new Orgaan($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>