<?php // generated with ADL vs. 1.1-632
  
  /********* on line 287, file "src/atlas/atlas.adl"
    SERVICE Concept : I[Concept]
   = [ beschrijving : description;display
     , populatie : contains;display
     , Conceptueel diagram {PICTURE} : picture;display
     ]
   *********/
  
  class Concept {
    protected $id=false;
    protected $_new=true;
    private $_beschrijving;
    private $_populatie;
    private $_Conceptueeldiagram;
    function Concept($id=null, $_beschrijving=null, $_populatie=null, $_Conceptueeldiagram=null){
      $this->id=$id;
      $this->_beschrijving=$_beschrijving;
      $this->_populatie=$_populatie;
      $this->_Conceptueeldiagram=$_Conceptueeldiagram;
      if(!isset($_beschrijving) && isset($id)){
        // get a Concept based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttConcept` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttConcept`, `i`
                                  FROM `concept`
                              ) AS fst
                          WHERE fst.`AttConcept` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `concept`.`i` AS `id`
                                       , `f1`.`display` AS `beschrijving`
                                       , `f2`.`display` AS `Conceptueel diagram`
                                    FROM `concept`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `concept` AS F0, `explanation` AS F1
                                                  WHERE F0.`description`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `concept` AS F0, `picture` AS F1
                                                  WHERE F0.`picture`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
                                   WHERE `concept`.`i`='".addslashes($id)."'"));
          $me['populatie']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `populatie`
                                                 FROM `concept`
                                                 JOIN  ( SELECT DISTINCT F0.`concept`, F1.`display`
                                                                FROM `containsconcept` AS F0, `atom` AS F1
                                                               WHERE F0.`atom`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`concept`='".addslashes($id)."'
                                                WHERE `concept`.`i`='".addslashes($id)."'"));
          $this->set_beschrijving($me['beschrijving']);
          $this->set_populatie($me['populatie']);
          $this->set_Conceptueeldiagram($me['Conceptueel diagram']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttConcept` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttConcept`, `i`
                                  FROM `concept`
                              ) AS fst
                          WHERE fst.`AttConcept` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "beschrijving" => $this->_beschrijving, "populatie" => $this->_populatie, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['beschrijving'])."'",5);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptueel diagram'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['beschrijving'])."')", 5);
      foreach($me['populatie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['Conceptueel diagram'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "beschrijving" => $this->_beschrijving, "populatie" => $this->_populatie, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['beschrijving'])."'",5);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptueel diagram'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_beschrijving($val){
      $this->_beschrijving=$val;
    }
    function get_beschrijving(){
      return $this->_beschrijving;
    }
    function set_populatie($val){
      $this->_populatie=$val;
    }
    function get_populatie(){
      if(!isset($this->_populatie)) return array();
      return $this->_populatie;
    }
    function set_Conceptueeldiagram($val){
      $this->_Conceptueeldiagram=$val;
    }
    function get_Conceptueeldiagram(){
      return $this->_Conceptueeldiagram;
    }
    function setId($id){
      $this->id=$id;
      return $this->id;
    }
    function getId(){
      if($this->id===null) return false;
      return $this->id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachConcept(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `concept`'));
  }

  function readConcept($id){
      // check existence of $id
      $obj = new Concept($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delConcept($id){
    $tobeDeleted = new Concept($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>