<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 329, file "VIRO.adl"
    SERVICE Sessie : I[Sessie]
   = [ persoon : login~
     , DigID : digid
     , startTijdstip : start
     , rol : rol
     ]
   *********/
  
  class Sessie {
    protected $_id=false;
    protected $_new=true;
    private $_persoon;
    private $_DigID;
    private $_startTijdstip;
    private $_rol;
    function Sessie($id=null, $persoon=null, $DigID=null, $startTijdstip=null, $rol=null){
      $this->_id=$id;
      $this->_persoon=$persoon;
      $this->_DigID=$DigID;
      $this->_startTijdstip=$startTijdstip;
      $this->_rol=$rol;
      if(!isset($persoon) && isset($id)){
        // get a Sessie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSessie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSessie`, `i`
                                  FROM `sessie`
                              ) AS fst
                          WHERE fst.`AttSessie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `sessie`.`i` AS `id`
                                       , `sessie`.`login` AS `persoon`
                                       , `sessie`.`digid` AS `DigID`
                                       , `sessie`.`start` AS `startTijdstip`
                                       , `sessie`.`rol`
                                    FROM `sessie`
                                   WHERE `sessie`.`i`='".addslashes($id)."'"));
          $this->set_persoon($me['persoon']);
          $this->set_DigID($me['DigID']);
          $this->set_startTijdstip($me['startTijdstip']);
          $this->set_rol($me['rol']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSessie` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSessie`, `i`
                                  FROM `sessie`
                              ) AS fst
                          WHERE fst.`AttSessie` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "persoon" => $this->_persoon, "DigID" => $this->_DigID, "startTijdstip" => $this->_startTijdstip, "rol" => $this->_rol);
      DB_doquer("INSERT IGNORE INTO `sessie` (`login`,`digid`,`start`,`rol`,`i`) VALUES ('".addslashes($me['persoon'])."', '".addslashes($me['DigID'])."', '".addslashes($me['startTijdstip'])."', '".addslashes($me['rol'])."', '".addslashes($me['id'])."')", 5);
      if(mysql_affected_rows()==0 && $me['id']!=null){
        //nothing inserted, try updating:
        DB_doquer("UPDATE `sessie` SET `login`='".addslashes($me['persoon'])."', `digid`='".addslashes($me['DigID'])."', `start`='".addslashes($me['startTijdstip'])."', `rol`='".addslashes($me['rol'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      }
      // no code for DigID,i in digid
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['persoon'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['persoon'])."')", 5);
      DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($me['rol'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($me['rol'])."')", 5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['startTijdstip'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `tijdstip` (`i`) VALUES ('".addslashes($me['startTijdstip'])."')", 5);
      if (!checkRule8()){
        $DB_err='\"Elke sessie behoort geautoriseerd te zijn op basis van de juiste DigID\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient een rol te krijgen die hij of zij conform autorisatie van de Rechtbank mag vervullen.\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule62()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule65()){
        $DB_err='\"\"';
      } else
      if (!checkRule66()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule68()){
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
      if (!checkRule72()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
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
      $me=array("id"=>$this->getId(), "persoon" => $this->_persoon, "DigID" => $this->_DigID, "startTijdstip" => $this->_startTijdstip, "rol" => $this->_rol);
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['persoon'])."'",5);
      DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($me['rol'])."'",5);
      DB_doquer("DELETE FROM `tijdstip` WHERE `i`='".addslashes($me['startTijdstip'])."'",5);
      if (!checkRule8()){
        $DB_err='\"Elke sessie behoort geautoriseerd te zijn op basis van de juiste DigID\"';
      } else
      if (!checkRule9()){
        $DB_err='\"De gebruiker in deze sessie dient een rol te krijgen die hij of zij conform autorisatie van de Rechtbank mag vervullen.\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule62()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule65()){
        $DB_err='\"\"';
      } else
      if (!checkRule66()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule68()){
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
      if (!checkRule72()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_persoon($val){
      $this->_persoon=$val;
    }
    function get_persoon(){
      return $this->_persoon;
    }
    function set_DigID($val){
      $this->_DigID=$val;
    }
    function get_DigID(){
      return $this->_DigID;
    }
    function set_startTijdstip($val){
      $this->_startTijdstip=$val;
    }
    function get_startTijdstip(){
      return $this->_startTijdstip;
    }
    function set_rol($val){
      $this->_rol=$val;
    }
    function get_rol(){
      return $this->_rol;
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

  function getEachSessie(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `sessie`'));
  }

  function readSessie($id){
      // check existence of $id
      $obj = new Sessie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSessie($id){
    $tobeDeleted = new Sessie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>