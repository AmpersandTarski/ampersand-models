<?php // generated with ADL vs. 0.8.10-558
  
  /********* on line 267, file "comp/PWO_gmi/434.adl"
    SERVICE Population : I[Relation]
   = [ example : example;display
     , explanation : description;display
     , population : contains;display
     ]
   *********/
  
  class Population {
    protected $id=false;
    protected $_new=true;
    private $_example;
    private $_explanation;
    private $_population;
    function Population($id=null, $_example=null, $_explanation=null, $_population=null){
      $this->id=$id;
      $this->_example=$_example;
      $this->_explanation=$_explanation;
      $this->_population=$_population;
      if(!isset($_example) && isset($id)){
        // get a Population based on its identifier
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
                                       , `f1`.`display` AS `example`
                                       , `f2`.`display` AS `explanation`
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
          $me['population']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `population`
                                                  FROM `relation`
                                                  JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                 FROM `contains` AS F0, `pair` AS F1
                                                                WHERE F0.`Pair`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`relation`='".addslashes($id)."'
                                                 WHERE `relation`.`i`='".addslashes($id)."'"));
          $this->set_example($me['example']);
          $this->set_explanation($me['explanation']);
          $this->set_population($me['population']);
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
      $me=array("id"=>$this->getId(), "example" => $this->_example, "explanation" => $this->_explanation, "population" => $this->_population);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['example'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['example'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['explanation'])."')", 5);
      foreach($me['population'] as $i0=>$v0){
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
      $me=array("id"=>$this->getId(), "example" => $this->_example, "explanation" => $this->_explanation, "population" => $this->_population);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['example'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_example($val){
      $this->_example=$val;
    }
    function get_example(){
      return $this->_example;
    }
    function set_explanation($val){
      $this->_explanation=$val;
    }
    function get_explanation(){
      return $this->_explanation;
    }
    function set_population($val){
      $this->_population=$val;
    }
    function get_population(){
      if(!isset($this->_population)) return array();
      return $this->_population;
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

  function getEachPopulation(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `relation`'));
  }

  function readPopulation($id){
      // check existence of $id
      $obj = new Population($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPopulation($id){
    $tobeDeleted = new Population($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>