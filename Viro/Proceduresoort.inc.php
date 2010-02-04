<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3989, file "VIRO.adl"
    SERVICE Proceduresoort : I[Proceduresoort]
   = [ Procedures : proceduresoort~
        = [ Procedure : [Procedur]
          , rechtsgebied : rechtsgebied
          , zorgdrager voor dossier : zorgdrager
          ]
     ]
   *********/
  
  class Proceduresoort {
    protected $_id=false;
    protected $_new=true;
    private $_Procedures;
    function Proceduresoort($id=null, $Procedures=null){
      $this->_id=$id;
      $this->_Procedures=$Procedures;
      if(!isset($Procedures) && isset($id)){
        // get a Proceduresoort based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProceduresoort` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProceduresoort`, `i`
                                  FROM `proceduresoort`
                              ) AS fst
                          WHERE fst.`AttProceduresoort` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Procedures']=(DB_doquer("SELECT DISTINCT `procedur`.`i` AS `id`
                                          FROM `procedur`
                                         WHERE `procedur`.`proceduresoort`='".addslashes($id)."'"));
          foreach($me['Procedures'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Procedure`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`zorgdrager` AS `zorgdrager voor dossier`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Procedures($me['Procedures']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProceduresoort` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProceduresoort`, `i`
                                  FROM `proceduresoort`
                              ) AS fst
                          WHERE fst.`AttProceduresoort` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "Procedures" => $this->_Procedures);
      foreach($me['Procedures'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['id'])."', `rechtsgebied`='".addslashes($v0['rechtsgebied'])."', `zorgdrager`='".addslashes($v0['zorgdrager voor dossier'])."' WHERE `i`='".addslashes($v0['Procedure'])."'", 5);
      }
      foreach  ($me['Procedures'] as $Procedures){
        if(isset($me['id']))
          DB_doquer("UPDATE `procedur` SET `proceduresoort`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Procedures['id'])."'", 5);
      }
      // no code for Procedure,i in procedur
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager voor dossier'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdrager voor dossier'])."')", 5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      // no code for Procedures,procedur in eiser
      // no code for Procedure,procedur in eiser
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule28()){
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
      $me=array("id"=>$this->getId(), "Procedures" => $this->_Procedures);
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager voor dossier'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Procedures($val){
      $this->_Procedures=$val;
    }
    function get_Procedures(){
      if(!isset($this->_Procedures)) return array();
      return $this->_Procedures;
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

  function getEachProceduresoort(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `proceduresoort`'));
  }

  function readProceduresoort($id){
      // check existence of $id
      $obj = new Proceduresoort($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delProceduresoort($id){
    $tobeDeleted = new Proceduresoort($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>