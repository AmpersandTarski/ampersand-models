<?php // generated with ADL vs. 0.8.10-529
  
  /********* on line 179, file "comp/PWO_gmi/20.adl"
    SERVICE Rule1 : I[UserRule]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , relations {"DISPLAY=Relation.display"} : morphisms
     , violations : violates~;display
     , explanation : explanation;display
     , previous {"DISPLAY=UserRule.display"} : previous
     , next {"DISPLAY=UserRule.display"} : next
     ]
   *********/
  
  class Rule1 {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_relations;
    private $_violations;
    private $_explanation;
    private $_previous;
    private $_next;
    function Rule1($id=null, $_source=null, $_target=null, $_relations=null, $_violations=null, $_explanation=null, $_previous=null, $_next=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_relations=$_relations;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      $this->_previous=$_previous;
      $this->_next=$_next;
      if(!isset($_source) && isset($id)){
        // get a Rule1 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttUserRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttUserRule`, `i`
                                  FROM `userrule`
                              ) AS fst
                          WHERE fst.`AttUserRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `userrule`.`i` AS `id`
                                       , `userrule`.`previous`
                                       , `userrule`.`next`
                                       , `f1`.`source`
                                       , `f2`.`target`
                                       , `f3`.`display` AS `explanation`
                                    FROM `userrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`source`
                                                   FROM `userrule` AS F0, `type` AS F1
                                                  WHERE F0.`type`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`target`
                                                   FROM `userrule` AS F0, `type` AS F1
                                                  WHERE F0.`type`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `userrule` AS F0, `explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($id)."'
                                   WHERE `userrule`.`i`='".addslashes($id)."'"));
          $me['relations']=firstCol(DB_doquer("SELECT DISTINCT `morphisms`.`relation` AS `relations`
                                                 FROM `userrule`
                                                 JOIN `morphisms` ON `morphisms`.`userrule`='".addslashes($id)."'
                                                WHERE `userrule`.`i`='".addslashes($id)."'"));
          $me['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `userrule`
                                                  JOIN  ( SELECT DISTINCT F0.`UserRule`, F1.`display`
                                                                 FROM `violatesviolation` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`UserRule`='".addslashes($id)."'
                                                 WHERE `userrule`.`i`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_relations($me['relations']);
          $this->set_violations($me['violations']);
          $this->set_explanation($me['explanation']);
          $this->set_previous($me['previous']);
          $this->set_next($me['next']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttUserRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttUserRule`, `i`
                                  FROM `userrule`
                              ) AS fst
                          WHERE fst.`AttUserRule` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "violations" => $this->_violations, "explanation" => $this->_explanation, "previous" => $this->_previous, "next" => $this->_next);
      // no code for previous,i in userrule
      if(isset($me['id']))
        DB_doquer("UPDATE `userrule` SET `previous`='".addslashes($me['previous'])."', `next`='".addslashes($me['next'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for next,i in userrule
      // no code for relations,i in relation
      // no code for source,i in concept
      // no code for target,i in concept
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      foreach($me['violations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['explanation'])."')", 5);
      DB_doquer("DELETE FROM `morphisms` WHERE `userrule`='".addslashes($me['id'])."'",5);
      if(count($me['relations'])==0) $me['relations'][] = null;
      foreach  ($me['relations'] as $relations){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`relation`,`userrule`) VALUES (".((null!=$relations)?"'".addslashes($relations)."'":"NULL").", ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "violations" => $this->_violations, "explanation" => $this->_explanation, "previous" => $this->_previous, "next" => $this->_next);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      DB_doquer("DELETE FROM `morphisms` WHERE `userrule`='".addslashes($me['id'])."'",5);
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
    function set_violations($val){
      $this->_violations=$val;
    }
    function get_violations(){
      if(!isset($this->_violations)) return array();
      return $this->_violations;
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

  function getEachRule1(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `userrule`'));
  }

  function readRule1($id){
      // check existence of $id
      $obj = new Rule1($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRule1($id){
    $tobeDeleted = new Rule1($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>