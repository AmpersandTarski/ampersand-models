<?php // generated with ADL vs. 1.1-632
  
  /********* on line 281, file "src/atlas/atlas.adl"
    SERVICE Populatie : I[Relation]
   = [ voorbeeld : example;display
     , uitleg : description;display
     , populatie : contains;display
     ]
   *********/
  
  class Populatie {
    protected $id=false;
    protected $_new=true;
    private $_voorbeeld;
    private $_uitleg;
    private $_populatie;
    function Populatie($id=null, $_voorbeeld=null, $_uitleg=null, $_populatie=null){
      $this->id=$id;
      $this->_voorbeeld=$_voorbeeld;
      $this->_uitleg=$_uitleg;
      $this->_populatie=$_populatie;
      if(!isset($_voorbeeld) && isset($id)){
        // get a Populatie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `relation`.`i` AS `id`
                                       , `f1`.`display` AS `voorbeeld`
                                       , `f2`.`display` AS `uitleg`
                                    FROM `relation`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `relation` AS F0, `pragmaexample` AS F1
                                                  WHERE F0.`example`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `relation` AS F0, `explanation` AS F1
                                                  WHERE F0.`description`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
                                   WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['populatie']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `populatie`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                FROM `contains` AS F0, `pair` AS F1
                                                               WHERE F0.`pair`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $this->set_voorbeeld($me['voorbeeld']);
          $this->set_uitleg($me['uitleg']);
          $this->set_populatie($me['populatie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "voorbeeld" => $this->_voorbeeld, "uitleg" => $this->_uitleg, "populatie" => $this->_populatie);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['voorbeeld'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['voorbeeld'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      foreach($me['populatie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "voorbeeld" => $this->_voorbeeld, "uitleg" => $this->_uitleg, "populatie" => $this->_populatie);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['voorbeeld'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_voorbeeld($val){
      $this->_voorbeeld=$val;
    }
    function get_voorbeeld(){
      return $this->_voorbeeld;
    }
    function set_uitleg($val){
      $this->_uitleg=$val;
    }
    function get_uitleg(){
      return $this->_uitleg;
    }
    function set_populatie($val){
      $this->_populatie=$val;
    }
    function get_populatie(){
      if(!isset($this->_populatie)) return array();
      return $this->_populatie;
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

  function getEachPopulatie(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `relation`'));
  }

  function readPopulatie($id){
      // check existence of $id
      $obj = new Populatie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPopulatie($id){
    $tobeDeleted = new Populatie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>