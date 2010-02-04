<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3625, file "VIRO.adl"
    SERVICE Cluster : I[Cluster]
   = [ naam : naam
     , grond : grond
     , Procedure_of_cluster : cluster~
        = [ zorgdragerOrgaan : zorgdrager
          , rechtsgebiedRechtsgebied : rechtsgebied
          , proceduresoortProceduresoort : proceduresoort
          ]
     ]
   *********/
  
  class Cluster {
    protected $_id=false;
    protected $_new=true;
    private $_naam;
    private $_grond;
    private $_Procedureofcluster;
    function Cluster($id=null, $naam=null, $grond=null, $Procedureofcluster=null){
      $this->_id=$id;
      $this->_naam=$naam;
      $this->_grond=$grond;
      $this->_Procedureofcluster=$Procedureofcluster;
      if(!isset($naam) && isset($id)){
        // get a Cluster based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCluster` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCluster`, `i`
                                  FROM `cluster`
                              ) AS fst
                          WHERE fst.`AttCluster` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `grond`.`cluster` AS `id`
                                       , `cluster`.`naam`
                                    FROM `grond`
                                    LEFT JOIN `cluster` ON `cluster`.`i`='".addslashes($id)."'
                                   WHERE `grond`.`cluster`='".addslashes($id)."'"));
          $me['grond']=firstCol(DB_doquer("SELECT DISTINCT `grond`.`tekst` AS `grond`
                                             FROM `grond`
                                            WHERE `grond`.`cluster`='".addslashes($id)."'"));
          $me['Procedure_of_cluster']=(DB_doquer("SELECT DISTINCT `f1`.`procedur` AS `id`
                                                    FROM `cluster`
                                                    JOIN `clusterprocedur` AS f1 ON `f1`.`Cluster`='".addslashes($id)."'
                                                   WHERE `cluster`.`i`='".addslashes($id)."'"));
          foreach($me['Procedure_of_cluster'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`zorgdrager` AS `zorgdragerOrgaan`
                                         , `f3`.`rechtsgebied` AS `rechtsgebiedRechtsgebied`
                                         , `f4`.`proceduresoort` AS `proceduresoortProceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_naam($me['naam']);
          $this->set_grond($me['grond']);
          $this->set_Procedureofcluster($me['Procedure_of_cluster']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCluster` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCluster`, `i`
                                  FROM `cluster`
                              ) AS fst
                          WHERE fst.`AttCluster` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "grond" => $this->_grond, "Procedure_of_cluster" => $this->_Procedureofcluster);
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`zorgdrager`,`rechtsgebied`,`proceduresoort`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zorgdragerOrgaan'])."', '".addslashes($v0['rechtsgebiedRechtsgebied'])."', '".addslashes($v0['proceduresoortProceduresoort'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `cluster` (`naam`,`i`) VALUES ('".addslashes($me['naam'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdragerOrgaan'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdragerOrgaan'])."')", 5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebiedRechtsgebied'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebiedRechtsgebied'])."')", 5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoortProceduresoort'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoortProceduresoort'])."')", 5);
      }
      DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($me['naam'])."'",5);
      foreach($me['grond'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($me['naam'])."')", 5);
      foreach($me['grond'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for Procedure_of_cluster,procedur in eiser
      DB_doquer("DELETE FROM `grond` WHERE `cluster`='".addslashes($me['id'])."'",5);
      foreach  ($me['grond'] as $grond){
        $res=DB_doquer("INSERT IGNORE INTO `grond` (`tekst`,`cluster`) VALUES ('".addslashes($grond)."', '".addslashes($me['id'])."')", 5);
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
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
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
      $me=array("id"=>$this->getId(), "naam" => $this->_naam, "grond" => $this->_grond, "Procedure_of_cluster" => $this->_Procedureofcluster);
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdragerOrgaan'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebiedRechtsgebied'])."'",5);
      }
      foreach($me['Procedure_of_cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoortProceduresoort'])."'",5);
      }
      DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($me['naam'])."'",5);
      foreach($me['grond'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `grond` WHERE `cluster`='".addslashes($me['id'])."'",5);
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
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
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
    function set_naam($val){
      $this->_naam=$val;
    }
    function get_naam(){
      return $this->_naam;
    }
    function set_grond($val){
      $this->_grond=$val;
    }
    function get_grond(){
      if(!isset($this->_grond)) return array();
      return $this->_grond;
    }
    function set_Procedureofcluster($val){
      $this->_Procedureofcluster=$val;
    }
    function get_Procedureofcluster(){
      if(!isset($this->_Procedureofcluster)) return array();
      return $this->_Procedureofcluster;
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

  function getEachCluster(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `cluster`'));
  }

  function readCluster($id){
      // check existence of $id
      $obj = new Cluster($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCluster($id){
    $tobeDeleted = new Cluster($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>