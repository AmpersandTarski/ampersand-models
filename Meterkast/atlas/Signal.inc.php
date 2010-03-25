<?php // generated with ADL vs. 1.1-646
  
  /********* on line 217, file "src/atlas/atlas.adl"
    SERVICE Signal : I[Signal]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , relations {"DISPLAY=Relation.display"} : morphisms
     , explanation : explanation;display
     , previous {"DISPLAY=Signal.display"} : previous
     , next {"DISPLAY=Signal.display"} : next
     , pattern {"DISPLAY=Pattern.display"} : pattern
     , contains : contains;display
     ]
   *********/
  
  class Signal {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_relations;
    private $_explanation;
    private $_previous;
    private $_next;
    private $_pattern;
    private $_contains;
    function Signal($id=null, $_source=null, $_target=null, $_relations=null, $_explanation=null, $_previous=null, $_next=null, $_pattern=null, $_contains=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_relations=$_relations;
      $this->_explanation=$_explanation;
      $this->_previous=$_previous;
      $this->_next=$_next;
      $this->_pattern=$_pattern;
      $this->_contains=$_contains;
      if(!isset($_source) && isset($id)){
        // get a Signal based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSignal` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttSignal`, `I`
                                  FROM `Signal`
                              ) AS fst
                          WHERE fst.`AttSignal` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Signal`.`I` AS `id`
                                       , `Signal`.`previous`
                                       , `Signal`.`next`
                                       , `Signal`.`pattern`
                                       , `f1`.`source`
                                       , `f2`.`target`
                                       , `f3`.`display` AS `explanation`
                                    FROM `Signal`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`source`
                                                   FROM `Signal` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`target`
                                                   FROM `Signal` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `Signal` AS F0, `Explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`I`
                                               ) AS f3
                                      ON `f3`.`I`='".addslashes($id)."'
                                   WHERE `Signal`.`I`='".addslashes($id)."'"));
          $me['relations']=firstCol(DB_doquer("SELECT DISTINCT `morphisms2`.`Relation` AS `relations`
                                                 FROM `Signal`
                                                 JOIN `morphisms2` ON `morphisms2`.`Signal`='".addslashes($id)."'
                                                WHERE `Signal`.`I`='".addslashes($id)."'"));
          $me['contains']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `contains`
                                                FROM `Signal`
                                                JOIN  ( SELECT DISTINCT F0.`Signal`, F1.`display`
                                                               FROM `contains3` AS F0, `Pair` AS F1
                                                              WHERE F0.`Pair`=F1.`I`
                                                           ) AS f1
                                                  ON `f1`.`Signal`='".addslashes($id)."'
                                               WHERE `Signal`.`I`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_relations($me['relations']);
          $this->set_explanation($me['explanation']);
          $this->set_previous($me['previous']);
          $this->set_next($me['next']);
          $this->set_pattern($me['pattern']);
          $this->set_contains($me['contains']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSignal` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttSignal`, `I`
                                  FROM `Signal`
                              ) AS fst
                          WHERE fst.`AttSignal` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "explanation" => $this->_explanation, "previous" => $this->_previous, "next" => $this->_next, "pattern" => $this->_pattern, "contains" => $this->_contains);
      // no code for previous,I in Signal
      if(isset($me['id']))
        DB_doquer("UPDATE `Signal` SET `previous`='".addslashes($me['previous'])."', `next`='".addslashes($me['next'])."', `pattern`='".addslashes($me['pattern'])."' WHERE `I`='".addslashes($me['id'])."'", 5);
      // no code for next,I in Signal
      // no code for relations,I in Relation
      // no code for source,I in Concept
      // no code for target,I in Concept
      // no code for pattern,I in Pattern
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['explanation'])."'",5);
      foreach($me['contains'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['explanation'])."')", 5);
      foreach($me['contains'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `morphisms2` WHERE `Signal`='".addslashes($me['id'])."'",5);
      if(count($me['relations'])==0) $me['relations'][] = null;
      foreach  ($me['relations'] as $relations){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms2` (`Relation`,`Signal`) VALUES (".((null!=$relations)?"'".addslashes($relations)."'":"NULL").", ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "explanation" => $this->_explanation, "previous" => $this->_previous, "next" => $this->_next, "pattern" => $this->_pattern, "contains" => $this->_contains);
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['explanation'])."'",5);
      foreach($me['contains'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `morphisms2` WHERE `Signal`='".addslashes($me['id'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_source($val){
      $this->_source=$val;
    }
    function get_source(){
      return $this->_source;
    }
    function set_target($val){
      $this->_target=$val;
    }
    function get_target(){
      return $this->_target;
    }
    function set_relations($val){
      $this->_relations=$val;
    }
    function get_relations(){
      if(!isset($this->_relations)) return array();
      return $this->_relations;
    }
    function set_explanation($val){
      $this->_explanation=$val;
    }
    function get_explanation(){
      return $this->_explanation;
    }
    function set_previous($val){
      $this->_previous=$val;
    }
    function get_previous(){
      return $this->_previous;
    }
    function set_next($val){
      $this->_next=$val;
    }
    function get_next(){
      return $this->_next;
    }
    function set_pattern($val){
      $this->_pattern=$val;
    }
    function get_pattern(){
      return $this->_pattern;
    }
    function set_contains($val){
      $this->_contains=$val;
    }
    function get_contains(){
      if(!isset($this->_contains)) return array();
      return $this->_contains;
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

  function getEachSignal(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Signal`'));
  }

  function readSignal($id){
      // check existence of $id
      $obj = new Signal($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSignal($id){
    $tobeDeleted = new Signal($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>