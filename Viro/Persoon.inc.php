<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3847, file "VIRO.adl"
    SERVICE Persoon : I[Persoon]
   = [ procedure(s) : eiser\/gedaagde\/gevoegde
        = [ nr : [Procedur]
          , zorgdragerOrgaan : zorgdrager
          , rechtsgebiedRechtsgebied : rechtsgebied
          , proceduresoortProceduresoort : proceduresoort
          ]
     , rol : vervult
     , gemachtigde van : door~
        = [ gemachtigde : gemachtigde~
          ]
     , DigID : digid~
     , Dossier : van~\/aan~
        = [ van : van
          , aan : aan
          , verzondenTijdstip : verzonden
          ]
     ]
   *********/
  
  class Persoon {
    protected $_id=false;
    protected $_new=true;
    private $_procedures;
    private $_rol;
    private $_gemachtigdevan;
    private $_DigID;
    private $_Dossier;
    function Persoon($id=null, $procedures=null, $rol=null, $gemachtigdevan=null, $DigID=null, $Dossier=null){
      $this->_id=$id;
      $this->_procedures=$procedures;
      $this->_rol=$rol;
      $this->_gemachtigdevan=$gemachtigdevan;
      $this->_DigID=$DigID;
      $this->_Dossier=$Dossier;
      if(!isset($procedures) && isset($id)){
        // get a Persoon based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPersoon` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPersoon`, `i`
                                  FROM `persoon`
                              ) AS fst
                          WHERE fst.`AttPersoon` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['procedure(s)']=(DB_doquer("SELECT DISTINCT `f1`.`procedur` AS `id`
                                            FROM `persoon`
                                            JOIN  ( 
                                                         (SELECT DISTINCT persoon, procedur
                                                               FROM `eiser`
                                                         ) UNION (SELECT DISTINCT persoon, procedur
                                                               FROM `gedaagde`
                                                         ) UNION (SELECT DISTINCT persoon, procedur
                                                               FROM `gevoegde`
                                                         
                                                         
                                                         )
                                                       ) AS f1
                                              ON `f1`.`persoon`='".addslashes($id)."'
                                           WHERE `persoon`.`i`='".addslashes($id)."'"));
          $me['rol']=firstCol(DB_doquer("SELECT DISTINCT `vervult`.`rol`
                                           FROM `vervult`
                                          WHERE `vervult`.`persoon`='".addslashes($id)."'"));
          $me['gemachtigde van']=(DB_doquer("SELECT DISTINCT `machtiging`.`i` AS `id`
                                               FROM `machtiging`
                                              WHERE `machtiging`.`door`='".addslashes($id)."'"));
          $me['DigID']=firstCol(DB_doquer("SELECT DISTINCT `digid`.`i` AS `DigID`
                                             FROM `digid`
                                            WHERE `digid`.`digid`='".addslashes($id)."'"));
          $me['Dossier']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                       FROM `persoon`
                                       JOIN  ( 
                                                    (SELECT DISTINCT van, i
                                                          FROM `document`
                                                    ) UNION (SELECT DISTINCT persoon AS `van`, document AS `i`
                                                          FROM `aan`
                                                    
                                                    )
                                                  ) AS f1
                                         ON `f1`.`van`='".addslashes($id)."'
                                      WHERE `persoon`.`i`='".addslashes($id)."'"));
          foreach($me['procedure(s)'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`zorgdrager` AS `zorgdragerOrgaan`
                                         , `f4`.`rechtsgebied` AS `rechtsgebiedRechtsgebied`
                                         , `f5`.`proceduresoort` AS `proceduresoortProceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['gemachtigde van'] as $i0=>&$v0){
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['Dossier'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`van`
                                         , `f3`.`verzonden` AS `verzondenTijdstip`
                                      FROM `document`
                                      LEFT JOIN `document` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['aan']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `aan`
                                             FROM `document`
                                             JOIN `aan` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                            WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_procedures($me['procedure(s)']);
          $this->set_rol($me['rol']);
          $this->set_gemachtigdevan($me['gemachtigde van']);
          $this->set_DigID($me['DigID']);
          $this->set_Dossier($me['Dossier']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPersoon` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPersoon`, `i`
                                  FROM `persoon`
                              ) AS fst
                          WHERE fst.`AttPersoon` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "procedure(s)" => $this->_procedures, "rol" => $this->_rol, "gemachtigde van" => $this->_gemachtigdevan, "DigID" => $this->_DigID, "Dossier" => $this->_Dossier);
      foreach($me['Dossier'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `van`='".addslashes($v0['van'])."', `verzonden`='".addslashes($v0['verzondenTijdstip'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`zorgdrager`,`rechtsgebied`,`proceduresoort`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zorgdragerOrgaan'])."', '".addslashes($v0['rechtsgebiedRechtsgebied'])."', '".addslashes($v0['proceduresoortProceduresoort'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in procedur
      DB_doquer("DELETE FROM `machtiging` WHERE `door`='".addslashes($me['id'])."'",5);
      // no code for gemachtigde van,i in machtiging
      foreach  ($me['gemachtigde van'] as $gemachtigdevan){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($gemachtigdevan['id'])."', '".addslashes($me['id'])."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      DB_doquer("DELETE FROM `digid` WHERE `digid`='".addslashes($me['id'])."'",5);
      // no code for DigID,i in digid
      foreach  ($me['DigID'] as $DigID){
        $res=DB_doquer("INSERT IGNORE INTO `digid` (`i`,`digid`) VALUES ('".addslashes($DigID)."', '".addslashes($me['id'])."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdragerOrgaan'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdragerOrgaan'])."')", 5);
      }
      foreach($me['gemachtigde van'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        foreach($v0['aan'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['gemachtigde van'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Dossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['van'])."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        foreach($v0['aan'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebiedRechtsgebied'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebiedRechtsgebied'])."')", 5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoortProceduresoort'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoortProceduresoort'])."')", 5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzondenTijdstip'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['verzondenTijdstip'])."')", 5);
      }
      // no code for procedure(s),procedur in eiser
      // no code for nr,procedur in eiser
      foreach($me['gemachtigde van'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gemachtigde van'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($me['id'])."'",5);
      foreach  ($me['rol'] as $rol){
        $res=DB_doquer("INSERT IGNORE INTO `vervult` (`rol`,`persoon`) VALUES ('".addslashes($rol)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `aan` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        foreach  ($v0['aan'] as $aan){
          $res=DB_doquer("INSERT IGNORE INTO `aan` (`document`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($aan)."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"Elke sessie behoort geautoriseerd te zijn op basis van de juiste DigID\"';
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule66()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule70()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
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
      $me=array("id"=>$this->getId(), "procedure(s)" => $this->_procedures, "rol" => $this->_rol, "gemachtigde van" => $this->_gemachtigdevan, "DigID" => $this->_DigID, "Dossier" => $this->_Dossier);
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `machtiging` WHERE `door`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `digid` WHERE `digid`='".addslashes($me['id'])."'",5);
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdragerOrgaan'])."'",5);
      }
      foreach($me['gemachtigde van'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        foreach($v0['aan'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebiedRechtsgebied'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoortProceduresoort'])."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['verzondenTijdstip'])."'",5);
      }
      foreach($me['gemachtigde van'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `vervult` WHERE `persoon`='".addslashes($me['id'])."'",5);
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `aan` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"Elke sessie behoort geautoriseerd te zijn op basis van de juiste DigID\"';
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule66()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule70()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_procedures($val){
      $this->_procedures=$val;
    }
    function get_procedures(){
      if(!isset($this->_procedures)) return array();
      return $this->_procedures;
    }
    function set_rol($val){
      $this->_rol=$val;
    }
    function get_rol(){
      if(!isset($this->_rol)) return array();
      return $this->_rol;
    }
    function set_gemachtigdevan($val){
      $this->_gemachtigdevan=$val;
    }
    function get_gemachtigdevan(){
      if(!isset($this->_gemachtigdevan)) return array();
      return $this->_gemachtigdevan;
    }
    function set_DigID($val){
      $this->_DigID=$val;
    }
    function get_DigID(){
      if(!isset($this->_DigID)) return array();
      return $this->_DigID;
    }
    function set_Dossier($val){
      $this->_Dossier=$val;
    }
    function get_Dossier(){
      if(!isset($this->_Dossier)) return array();
      return $this->_Dossier;
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

  function getEachPersoon(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `persoon`'));
  }

  function readPersoon($id){
      // check existence of $id
      $obj = new Persoon($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPersoon($id){
    $tobeDeleted = new Persoon($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>