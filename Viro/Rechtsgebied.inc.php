<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3896, file "VIRO.adl"
    SERVICE Rechtsgebied : I[Rechtsgebied]
   = [ Procedures : rechtsgebied~
        = [ Procedure : [Procedur]
          , proceduresoort : proceduresoort
          , zorgdrager dossier : zorgdrager
          ]
     ]
   *********/
  
  class Rechtsgebied {
    protected $_id=false;
    protected $_new=true;
    private $_Procedures;
    function Rechtsgebied($id=null, $Procedures=null){
      $this->_id=$id;
      $this->_Procedures=$Procedures;
      if(!isset($Procedures) && isset($id)){
        // get a Rechtsgebied based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRechtsgebied` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRechtsgebied`, `i`
                                  FROM `rechtsgebied`
                              ) AS fst
                          WHERE fst.`AttRechtsgebied` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Procedures']=(DB_doquer("SELECT DISTINCT `procedur`.`i` AS `id`
                                          FROM `procedur`
                                         WHERE `procedur`.`rechtsgebied`='".addslashes($id)."'"));
          foreach($me['Procedures'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Procedure`
                                         , `f3`.`proceduresoort`
                                         , `f4`.`zorgdrager` AS `zorgdrager dossier`
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
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRechtsgebied` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRechtsgebied`, `i`
                                  FROM `rechtsgebied`
                              ) AS fst
                          WHERE fst.`AttRechtsgebied` = \''.addSlashes($id).'\'');
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
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['id'])."', `proceduresoort`='".addslashes($v0['proceduresoort'])."', `zorgdrager`='".addslashes($v0['zorgdrager dossier'])."' WHERE `i`='".addslashes($v0['Procedure'])."'", 5);
      }
      foreach  ($me['Procedures'] as $Procedures){
        if(isset($me['id']))
          DB_doquer("UPDATE `procedur` SET `rechtsgebied`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Procedures['id'])."'", 5);
      }
      // no code for Procedure,i in procedur
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager dossier'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdrager dossier'])."')", 5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      // no code for Procedures,procedur in eiser
      // no code for Procedure,procedur in eiser
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
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager dossier'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
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

  function getEachRechtsgebied(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `rechtsgebied`'));
  }

  function readRechtsgebied($id){
      // check existence of $id
      $obj = new Rechtsgebied($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRechtsgebied($id){
    $tobeDeleted = new Rechtsgebied($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>