<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3948, file "VIRO.adl"
    SERVICE Belanghebbende : I[Persoon]
   = [ procedure(s) : eiser\/gedaagde\/gevoegde
        = [ nr : [Procedur]
          , zorgdrager voor dossier : zorgdrager
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          ]
     , Dossier : van~\/aan~
        = [ van : van
          , aan : aan
          , kenmerk : kenmerkVan
          , datum : verzonden
          ]
     ]
   *********/
  
  class Belanghebbende {
    protected $_id=false;
    protected $_new=true;
    private $_procedures;
    private $_Dossier;
    function Belanghebbende($id=null, $procedures=null, $Dossier=null){
      $this->_id=$id;
      $this->_procedures=$procedures;
      $this->_Dossier=$Dossier;
      if(!isset($procedures) && isset($id)){
        // get a Belanghebbende based on its identifier
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
                                         , `f3`.`zorgdrager` AS `zorgdrager voor dossier`
                                         , `f4`.`rechtsgebied`
                                         , `f5`.`proceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['Dossier'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`van`
                                         , `f3`.`kenmerkvan` AS `kenmerk`
                                         , `f4`.`verzonden` AS `datum`
                                      FROM `document`
                                      LEFT JOIN `document` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['aan']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `aan`
                                             FROM `document`
                                             JOIN `aan` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                            WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_procedures($me['procedure(s)']);
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
      $me=array("id"=>$this->getId(), "procedure(s)" => $this->_procedures, "Dossier" => $this->_Dossier);
      foreach($me['Dossier'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `van`='".addslashes($v0['van'])."', `kenmerkvan`='".addslashes($v0['kenmerk'])."', `verzonden`='".addslashes($v0['datum'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`zorgdrager`,`rechtsgebied`,`proceduresoort`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zorgdrager voor dossier'])."', '".addslashes($v0['rechtsgebied'])."', '".addslashes($v0['proceduresoort'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in procedur
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager voor dossier'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdrager voor dossier'])."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['van'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        foreach($v0['aan'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
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
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['kenmerk'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['kenmerk'])."')", 5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['datum'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($v0['datum'])."')", 5);
      }
      // no code for procedure(s),procedur in eiser
      // no code for nr,procedur in eiser
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
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
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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
      $me=array("id"=>$this->getId(), "procedure(s)" => $this->_procedures, "Dossier" => $this->_Dossier);
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager voor dossier'])."'",5);
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
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['procedure(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['kenmerk'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($v0['datum'])."'",5);
      }
      foreach($me['Dossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `aan` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
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
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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

  function getEachBelanghebbende(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `persoon`'));
  }

  function readBelanghebbende($id){
      // check existence of $id
      $obj = new Belanghebbende($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delBelanghebbende($id){
    $tobeDeleted = new Belanghebbende($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>