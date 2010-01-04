<?php // generated with ADL vs. 0.8.10-515
  
  /********* on line 168, file "comp/PWO_gmi/171.adl"
    SERVICE Rule1 : I[UserRule]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , relations {"DISPLAY=Relation.display"} : morphisms
     , violations : violates~;display
     , explanation : explanation;display
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
    function Rule1($id=null, $_source=null, $_target=null, $_relations=null, $_violations=null, $_explanation=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_relations=$_relations;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "violations" => $this->_violations, "explanation" => $this->_explanation);
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
      if (!checkRule3()){
        $DB_err='\"source[Type*Concept] is univalent\"';
      } else
      if (!checkRule4()){
        $DB_err='\"source[Type*Concept] is total\"';
      } else
      if (!checkRule5()){
        $DB_err='\"target[Type*Concept] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"target[Type*Concept] is total\"';
      } else
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule21()){
        $DB_err='\"type[UserRule*Type] is univalent\"';
      } else
      if (!checkRule22()){
        $DB_err='\"type[UserRule*Type] is total\"';
      } else
      if (!checkRule29()){
        $DB_err='\"explanation[UserRule*Explanation] is univalent\"';
      } else
      if (!checkRule30()){
        $DB_err='\"explanation[UserRule*Explanation] is total\"';
      } else
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule56()){
        $DB_err='\"user[UserRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule84()){
        $DB_err='\"script[UserRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
      } else
      if (!checkRule94()){
        $DB_err='\"display[Relation*String] is total\"';
      } else
      if (!checkRule95()){
        $DB_err='\"display[Type*String] is univalent\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
      } else
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
      } else
      if (!checkRule101()){
        $DB_err='\"display[Atom*String] is univalent\"';
      } else
      if (!checkRule103()){
        $DB_err='\"display[IsaRelation*String] is univalent\"';
      } else
      if (!checkRule105()){
        $DB_err='\"display[MultiplicityRule*String] is univalent\"';
      } else
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule112()){
        $DB_err='\"display[UserRule*String] is total\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
      } else
      if (!checkRule116()){
        $DB_err='\"display[Violation*String] is total\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if (!checkRule118()){
        $DB_err='\"display[Explanation*String] is total\"';
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "relations" => $this->_relations, "violations" => $this->_violations, "explanation" => $this->_explanation);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      DB_doquer("DELETE FROM `morphisms` WHERE `userrule`='".addslashes($me['id'])."'",5);
      if (!checkRule3()){
        $DB_err='\"source[Type*Concept] is univalent\"';
      } else
      if (!checkRule4()){
        $DB_err='\"source[Type*Concept] is total\"';
      } else
      if (!checkRule5()){
        $DB_err='\"target[Type*Concept] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"target[Type*Concept] is total\"';
      } else
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule21()){
        $DB_err='\"type[UserRule*Type] is univalent\"';
      } else
      if (!checkRule22()){
        $DB_err='\"type[UserRule*Type] is total\"';
      } else
      if (!checkRule29()){
        $DB_err='\"explanation[UserRule*Explanation] is univalent\"';
      } else
      if (!checkRule30()){
        $DB_err='\"explanation[UserRule*Explanation] is total\"';
      } else
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule56()){
        $DB_err='\"user[UserRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule84()){
        $DB_err='\"script[UserRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
      } else
      if (!checkRule94()){
        $DB_err='\"display[Relation*String] is total\"';
      } else
      if (!checkRule95()){
        $DB_err='\"display[Type*String] is univalent\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
      } else
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
      } else
      if (!checkRule101()){
        $DB_err='\"display[Atom*String] is univalent\"';
      } else
      if (!checkRule103()){
        $DB_err='\"display[IsaRelation*String] is univalent\"';
      } else
      if (!checkRule105()){
        $DB_err='\"display[MultiplicityRule*String] is univalent\"';
      } else
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule112()){
        $DB_err='\"display[UserRule*String] is total\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
      } else
      if (!checkRule116()){
        $DB_err='\"display[Violation*String] is total\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if (!checkRule118()){
        $DB_err='\"display[Explanation*String] is total\"';
      } else
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